<?php
include 'sessionCheck.php';
include 'db.php';
header('Content-Type: application/json');

$action = $_POST['action'] ?? '';
$uid = (int)$_SESSION['s_uid'];
$cr = floatval($_POST['amount'] ?? 0);
$raw = $cr * 10000000;

if ($cr <= 0) {
    echo json_encode(['status'=>'error','msg'=>'Enter valid amount']);
    exit;
}

$r = mysqli_query($conn, "SELECT bal, debt FROM tolly_user WHERE uid = $uid");
$u = mysqli_fetch_assoc($r);
$bal = (float)$u['bal'];
$debt = (float)$u['debt'];

if ($action === 'take_loan') {
    if (($debt + $raw) > 500 * 10000000) {
        echo json_encode(['status'=>'error','msg'=>'Debt max 500 Cr']);
        exit;
    }
    $new_bal = $bal + $raw;
    $new_debt = $debt + $raw;
    mysqli_query($conn, "UPDATE tolly_user SET bal = $new_bal, debt = $new_debt WHERE uid = $uid");
} elseif ($action === 'clear_debt') {
    if ($raw > $bal || $raw > $debt) {
        echo json_encode(['status'=>'error','msg'=>'Amount exceeds balance or debt']);
        exit;
    }
    $new_bal = $bal - $raw;
    $new_debt = $debt - $raw;
    mysqli_query($conn, "UPDATE tolly_user SET bal = $new_bal, debt = $new_debt WHERE uid = $uid");
} else {
    echo json_encode(['status'=>'error','msg'=>'Invalid action']);
    exit;
}

ob_start(); include 'balance.php'; ob_end_clean();
echo json_encode(['status'=>'ok','msg'=>'Done','new_bal'=>$_SESSION['s_rs'],'new_debt'=>$_SESSION['s_debt_rs']]);
mysqli_close($conn);
?>