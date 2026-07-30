<?php
include 'sessionCheck.php';
include 'db.php';

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';
$uid = (int)$_SESSION['s_uid'];
$amount_cr = floatval($_POST['amount'] ?? 0);
$amount_raw = $amount_cr * 10000000;

if ($amount_cr <= 0) {
    echo json_encode(['status' => 'error', 'msg' => 'Amount must be greater than 0']);
    exit;
}

$result = mysqli_query($conn, "SELECT bal, debt FROM tolly_user WHERE uid = $uid");
$row = mysqli_fetch_assoc($result);
$bal = (float)$row['bal'];
$debt = (float)$row['debt'];

if ($action === 'take_loan') {
    $max_debt = 500 * 10000000;
    if (($debt + $amount_raw) > $max_debt) {
        echo json_encode(['status' => 'error', 'msg' => 'Debt cannot exceed 500 Cr. Current debt: ' . round($debt / 10000000, 2) . ' Cr']);
        exit;
    }
    $new_bal = $bal + $amount_raw;
    $new_debt = $debt + $amount_raw;
    $update = mysqli_query($conn, "UPDATE tolly_user SET bal = $new_bal, debt = $new_debt WHERE uid = $uid");
    if ($update) {
        ob_start(); include 'balance.php'; ob_end_clean();
        error_log("[LOAN] uid=$uid take_loan amount={$amount_cr}Cr new_bal=" . round($new_bal / 10000000, 2) . "Cr new_debt=" . round($new_debt / 10000000, 2) . "Cr");
        echo json_encode(['status' => 'ok', 'msg' => "Loan of $amount_cr Cr added", 'new_bal' => $_SESSION['s_rs'], 'new_debt' => $_SESSION['s_debt_rs']]);
    } else {
        echo json_encode(['status' => 'error', 'msg' => 'DB error: ' . mysqli_error($conn)]);
    }

} elseif ($action === 'clear_debt') {
    if ($amount_raw > $bal) {
        echo json_encode(['status' => 'error', 'msg' => 'Insufficient balance. Available: ' . round($bal / 10000000, 2) . ' Cr']);
        exit;
    }
    if ($amount_raw > $debt) {
        echo json_encode(['status' => 'error', 'msg' => 'Clear amount exceeds current debt of ' . round($debt / 10000000, 2) . ' Cr']);
        exit;
    }
    $new_bal = $bal - $amount_raw;
    $new_debt = $debt - $amount_raw;
    $update = mysqli_query($conn, "UPDATE tolly_user SET bal = $new_bal, debt = $new_debt WHERE uid = $uid");
    if ($update) {
        ob_start(); include 'balance.php'; ob_end_clean();
        error_log("[LOAN] uid=$uid clear_debt amount={$amount_cr}Cr new_bal=" . round($new_bal / 10000000, 2) . "Cr new_debt=" . round($new_debt / 10000000, 2) . "Cr");
        echo json_encode(['status' => 'ok', 'msg' => "Debt cleared by $amount_cr Cr", 'new_bal' => $_SESSION['s_rs'], 'new_debt' => $_SESSION['s_debt_rs']]);
    } else {
        echo json_encode(['status' => 'error', 'msg' => 'DB error: ' . mysqli_error($conn)]);
    }

} else {
    echo json_encode(['status' => 'error', 'msg' => 'Invalid action']);
}

mysqli_close($conn);
?>