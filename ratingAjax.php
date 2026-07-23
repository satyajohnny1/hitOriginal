<?php
declare(strict_types=1);
error_reporting(0);
include 'db_helper.php';

session_start();

$sid = (int)($_GET["rid"] ?? 0);
$now = $_GET["now"] ?? '';
$sofar = 0;
$uid = (int)$_SESSION['s_uid'];
$s_bal = 0.0;
$a = 0.0;
$b = 0.0;
$progress = 0;

$chose = $now;

if (strpos($chose, '_c') !== false) {
    $rate = mt_rand(4 * 10, 10 * 10) / 10;
} else if (strpos($chose, '_b') !== false) {
    $rate = mt_rand(25, 100) / 10;
} else {
    $rate = mt_rand(1 * 10, 10 * 10) / 10;
}

$best = $rate;

$row = db_fetch_one_prepared(
    "SELECT TRIM(u.bal) AS bal FROM tolly_user u WHERE u.uid = ?",
    "i",
    [$uid]
);
if ($row !== null) {
    $s_bal = (float)$row["bal"];
    $_SESSION['s_bal'] = $s_bal;
}

$row = db_fetch_one_prepared(
    "SELECT sofar, progress FROM tolly_ready_for_shoot r WHERE r.uid = ? AND r.rid = ? LIMIT 1",
    "ii",
    [$uid, $sid]
);
if ($row !== null) {
    $sofar = (float)$row["sofar"];
    $progress = (int)$row["progress"];
}

$branch = match(true) {
    strcasecmp($now, 's1_a') === 0 => 's1_a',
    strcasecmp($now, 's1_b') === 0 => 's1_b',
    strcasecmp($now, 's1_c') === 0 => 's1_c',
    strcasecmp($now, 's2_a') === 0 => 's2_a',
    strcasecmp($now, 's2_b') === 0 => 's2_b',
    strcasecmp($now, 's2_c') === 0 => 's2_c',
    strcasecmp($now, 's3_a') === 0 => 's3_a',
    strcasecmp($now, 's3_b') === 0 => 's3_b',
    strcasecmp($now, 's3_c') === 0 => 's3_c',
    strcasecmp($now, 's4_a') === 0 => 's4_a',
    strcasecmp($now, 's4_b') === 0 => 's4_b',
    strcasecmp($now, 's4_c') === 0 => 's4_c',
    strcasecmp($now, 's5_a') === 0 => 's5_a',
    strcasecmp($now, 's5_b') === 0 => 's5_b',
    strcasecmp($now, 's5_c') === 0 => 's5_c',
    strcasecmp($now, 's6_a') === 0 => 's6_a',
    strcasecmp($now, 's6_b') === 0 => 's6_b',
    strcasecmp($now, 's6_c') === 0 => 's6_c',
    strcasecmp($now, 's7_a') === 0 => 's7_a',
    strcasecmp($now, 's7_b') === 0 => 's7_b',
    strcasecmp($now, 's7_c') === 0 => 's7_c',
    strcasecmp($now, 's8_a') === 0 => 's8_a',
    strcasecmp($now, 's8_b') === 0 => 's8_b',
    strcasecmp($now, 's8_c') === 0 => 's8_c',
    strcasecmp($now, 's9_a') === 0 => 's9_a',
    strcasecmp($now, 's9_b') === 0 => 's9_b',
    strcasecmp($now, 's9_c') === 0 => 's9_c',
    default => '',
};

if ($branch === '') {
    exit;
}

$sN = substr($branch, 0, 2);
$step = substr($branch, 3, 1);
$next = match($sN) {
    's1' => 's2_a', 's2' => 's3_a', 's3' => 's4_a',
    's4' => 's5_a', 's5' => 's6_a', 's6' => 's7_a',
    's7' => 's8_a', 's8' => 's9_a', 's9' => 's10_a',
    default => '',
};

$progressMap = [
    's1_a' => 40, 's1_b' => 40, 's1_c' => 20,
    's2_a' => 50, 's2_b' => 50, 's2_c' => 50,
    's3_a' => 60, 's3_b' => 60, 's3_c' => 65,
    's4_a' => 65, 's4_b' => 65, 's4_c' => 70,
    's5_a' => 70, 's5_b' => 70, 's5_c' => 75,
    's6_a' => 75, 's6_b' => 75, 's6_c' => 80,
    's7_a' => 80, 's7_b' => 80, 's7_c' => 80,
    's8_a' => 85, 's8_b' => 85, 's8_c' => 85,
    's9_a' => 90, 's9_b' => 95, 's9_c' => 95,
];

$new_progress = $progressMap[$branch] ?? 0;
$newsofar = (float)($_GET[$sN . '_' . $step . '_cost'] ?? 0) + $sofar;
$newbal = $s_bal - (float)($_GET[$sN . '_' . $step . '_cost'] ?? 0);

if ($step === 'a') {
    $status = $sN . '_b';
    $best = $rate;
} else if ($step === 'b') {
    $status = $sN . '_c';
    $a = (float)($_GET[$sN . '_a_rate'] ?? 0);
    if ($rate > $a && $rate > $b) {
        $best = $rate;
    } else if ($a > $b && $a > $rate) {
        $best = $a;
    } else {
        $best = $b;
    }
} else {
    $status = $next;
    $a = (float)($_GET[$sN . '_a_rate'] ?? 0);
    $b = (float)($_GET[$sN . '_b_rate'] ?? 0);
    if ($rate > $a && $rate > $b) {
        $best = $rate;
    } else if ($a > $b && $a > $rate) {
        $best = $a;
    } else {
        $best = $b;
    }
}

$rateField = $sN . '_' . $step . '_rate';
$bestField = $sN . '_best';
$sceneTable = 'tolly_' . $sN;

db_transaction(function () use ($uid, $sid, $newbal, $new_progress, $newsofar, $status, $rate, $best, $sN, $step, $rateField, $bestField, $sceneTable) {
    db_execute_write(
        "UPDATE tolly_user SET bal = ? WHERE uid = ?",
        "di",
        [$newbal, $uid]
    );

    db_execute_write(
        "UPDATE tolly_ready_for_shoot SET progress = ?, sofar = ?, s = ? WHERE rid = ? AND uid = ?",
        "idsii",
        [$new_progress, $newsofar, $status, $sid, $uid]
    );

    db_execute_write(
        "UPDATE " . $sceneTable . " SET " . $rateField . " = ?, " . $sN . "_status = ?, " . $bestField . " = ? WHERE sid = ? AND uid = ?",
        "sssii",
        [$rate, $status, $best, $sid, $uid]
    );
});

echo json_encode([
    'sofar' => $newsofar,
    'bal'   => $newbal,
    'status'=> $status,
    'rate'  => $rate,
]);
