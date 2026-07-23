<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

function db_prepare(string $sql): mysqli_stmt {
    global $conn;
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt === false) {
        throw new RuntimeException('Prepare failed: ' . mysqli_error($conn));
    }
    return $stmt;
}

function db_execute(mysqli_stmt $stmt, ?string $types = null, array $params = []): bool {
    if ($types !== null && $params !== []) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    return $stmt->affected_rows >= 0;
}

function db_execute_write(string $sql, ?string $types = null, array $params = []): bool {
    $stmt = db_prepare($sql);
    $ok = db_execute($stmt, $types, $params);
    $stmt->close();
    return $ok;
}

function db_fetch_one(mysqli_stmt $stmt): ?array {
    $result = $stmt->get_result();
    if ($result === false) {
        return null;
    }
    return $result->fetch_assoc();
}

function db_fetch_one_prepared(string $sql, ?string $types = null, array $params = []): ?array {
    $stmt = db_prepare($sql);
    db_execute($stmt, $types, $params);
    $row = db_fetch_one($stmt);
    $stmt->close();
    return $row;
}

function db_fetch_column(mysqli_stmt $stmt, string $column): mixed {
    $row = db_fetch_one($stmt);
    return $row[$column] ?? null;
}

function db_fetch_all(mysqli_stmt $stmt): array {
    $result = $stmt->get_result();
    if ($result === false) {
        return [];
    }
    return $result->fetch_all(MYSQLI_ASSOC);
}

function db_fetch_all_prepared(string $sql, ?string $types = null, array $params = []): array {
    $stmt = db_prepare($sql);
    db_execute($stmt, $types, $params);
    $rows = db_fetch_all($stmt);
    $stmt->close();
    return $rows;
}

function db_begin_transaction(): bool {
    global $conn;
    return mysqli_begin_transaction($conn);
}

function db_commit(): bool {
    global $conn;
    return mysqli_commit($conn);
}

function db_rollback(): bool {
    global $conn;
    return mysqli_rollback($conn);
}

/**
 * Run a callable inside a transaction. If it throws or returns false, rollback.
 */
function db_transaction(callable $fn): bool {
    db_begin_transaction();
    try {
        $result = $fn();
        if ($result === false) {
            db_rollback();
            return false;
        }
        db_commit();
        return true;
    } catch (\Throwable $e) {
        db_rollback();
        throw $e;
    }
}
