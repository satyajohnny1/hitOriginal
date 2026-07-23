<?php
declare(strict_types=1);

/**
 * Lightweight database migration runner for hitOriginal.
 *
 * Usage:
 *   php migrate.php              # Run all pending migrations
 *   php migrate.php status       # Show migration status
 *   php migrate.php up           # Run next pending migration only
 *   php migrate.php down         # Rollback last applied migration
 *
 * Migration files live in ./migrations/ as NNN_name.sql
 * where NNN is a zero-padded sequence number.
 */

define('MIGRATIONS_DIR', __DIR__ . '/migrations');

// ---------------------------------------------------------------------------
// DB connection
// ---------------------------------------------------------------------------
include __DIR__ . '/db.php';   // creates $conn (mysqli)

if (!$conn) {
    fwrite(STDERR, "Database connection failed.\n");
    exit(1);
}

// ---------------------------------------------------------------------------
// Ensure tracking table exists
// ---------------------------------------------------------------------------
$conn->query("
    CREATE TABLE IF NOT EXISTS `schema_version` (
        `version`  INT         NOT NULL,
        `name`     VARCHAR(255) NOT NULL,
        `applied`  DATETIME    NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`version`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
");

// ---------------------------------------------------------------------------
// Helpers
// ---------------------------------------------------------------------------
function getMigrationFiles(): array
{
    $files = glob(MIGRATIONS_DIR . '/*.sql');
    if ($files === false) {
        return [];
    }
    sort($files);
    return $files;
}

function parseMigration(string $filepath): array
{
    $basename = basename($filepath, '.sql');
    $parts    = explode('_', $basename, 2);
    $version  = (int)$parts[0];
    $name     = $parts[1] ?? $basename;
    return ['version' => $version, 'name' => $name, 'file' => $filepath];
}

function getApplied(mysqli $conn): array
{
    $res = $conn->query("SELECT version FROM schema_version ORDER BY version");
    $applied = [];
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $applied[] = (int)$row['version'];
        }
    }
    return $applied;
}

function applyMigration(mysqli $conn, array $migration): bool
{
    $sql = file_get_contents($migration['file']);
    if ($sql === false) {
        fwrite(STDERR, "  Failed to read: {$migration['file']}\n");
        return false;
    }

    echo "  Applying {$migration['name']} (v{$migration['version']})...";

    // Split by semicolons, filter empty, execute one by one
    $statements = array_filter(
        array_map('trim', explode(';', $sql)),
        fn($s) => $s !== '' && !str_starts_with($s, '--')
    );

    foreach ($statements as $stmt) {
        $result = $conn->query($stmt);
        if (!$result) {
            echo " FAILED\n";
            fwrite(STDERR, "    Error: " . $conn->error . "\n");
            fwrite(STDERR, "    Statement: " . substr($stmt, 0, 120) . "\n");
            return false;
        }
    }

    $conn->query(
        "INSERT INTO schema_version (version, name) VALUES ({$migration['version']}, '" .
        $conn->real_escape_string($migration['name']) . "')"
    );

    echo " OK\n";
    return true;
}

function rollbackMigration(mysqli $conn, array $migration): bool
{
    $rollbackFile = preg_replace('/\.sql$/', '.rollback.sql', $migration['file']);
    if (!file_exists($rollbackFile)) {
        echo "  No rollback file for {$migration['name']} — skipping.\n";
        return false;
    }

    $sql = file_get_contents($rollbackFile);
    echo "  Rolling back {$migration['name']} (v{$migration['version']})...";

    $statements = array_filter(
        array_map('trim', explode(';', $sql)),
        fn($s) => $s !== '' && !str_starts_with($s, '--')
    );

    foreach ($statements as $stmt) {
        $result = $conn->query($stmt);
        if (!$result) {
            echo " FAILED\n";
            fwrite(STDERR, "    Error: " . $conn->error . "\n");
            return false;
        }
    }

    $conn->query("DELETE FROM schema_version WHERE version = {$migration['version']}");
    echo " OK\n";
    return true;
}

// ---------------------------------------------------------------------------
// Commands
// ---------------------------------------------------------------------------
$command = $argv[1] ?? 'up';
$migrations = array_map('parseMigration', getMigrationFiles());
$applied   = getApplied($conn);
$pending   = array_values(array_filter($migrations, fn($m) => !in_array($m['version'], $applied)));

switch ($command) {
    case 'status':
        echo "Migration Status\n";
        echo str_repeat('-', 50) . "\n";
        foreach ($migrations as $m) {
            $status = in_array($m['version'], $applied) ? 'APPLIED' : 'PENDING';
            $marker = $status === 'APPLIED' ? '✓' : ' ';
            echo "  [{$marker}] v{$m['version']} — {$m['name']}  ($status)\n";
        }
        echo str_repeat('-', 50) . "\n";
        echo "Total: " . count($migrations) . " | Applied: " . count($applied) . " | Pending: " . count($pending) . "\n";
        break;

    case 'up':
        if (empty($pending)) {
            echo "Nothing to migrate — database is up to date.\n";
            break;
        }
        $m = $pending[0];
        echo "Running next migration...\n";
        applyMigration($conn, $m);
        break;

    case 'down':
        $lastApplied = array_reverse($applied);
        if (empty($lastApplied)) {
            echo "Nothing to roll back.\n";
            break;
        }
        $lastVersion = $lastApplied[0];
        $migration   = null;
        foreach ($migrations as $m) {
            if ($m['version'] === $lastVersion) {
                $migration = $m;
                break;
            }
        }
        if ($migration) {
            rollbackMigration($conn, $migration);
        }
        break;

    case 'migrate':  // default
        if (empty($pending)) {
            echo "Nothing to migrate — database is up to date.\n";
            break;
        }
        echo "Running " . count($pending) . " pending migration(s)...\n\n";
        $failed = false;
        foreach ($pending as $m) {
            if (!applyMigration($conn, $m)) {
                $failed = true;
                break;
            }
        }
        echo $failed ? "\nMigration stopped with errors.\n" : "\nAll migrations applied.\n";
        break;

    default:
        fwrite(STDERR, "Unknown command: $command\n");
        fwrite(STDERR, "Usage: php migrate.php [up|down|status|migrate]\n");
        exit(1);
}

$conn->close();
