<?php
include 'sessionCheck.php';
include __DIR__ . '/session_init.php';
include 'db.php';

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';
$table = $_POST['table'] ?? '';

$crewMap = [
    'actor'    => ['tbl'=>'tolly_actor',    'id'=>'actor_id',    'name'=>'actor_name',    'rate'=>'actor_rate',    'grade'=>'actor_grade',    'status'=>'actor_status',    'rating'=>'actor_rating',    'pic'=>'actor_pic'],
    'actress'  => ['tbl'=>'tolly_actress',  'id'=>'actress_id',  'name'=>'actress_name',  'rate'=>'actress_rate',  'grade'=>'actress_grade',  'status'=>'actress_status',  'rating'=>'actress_rating',  'pic'=>'actress_pic'],
    'director' => ['tbl'=>'tolly_director', 'id'=>'director_id', 'name'=>'director_name', 'rate'=>'director_rate', 'grade'=>'director_grade', 'status'=>'director_status', 'rating'=>'director_rating', 'pic'=>'director_pic'],
    'writer'   => ['tbl'=>'tolly_writer',   'id'=>'writer_id',   'name'=>'writer_name',   'rate'=>'writer_rate',   'grade'=>'writer_grade',   'status'=>'writer_status',   'rating'=>'writer_rating',   'pic'=>'writer_pic'],
    'editor'   => ['tbl'=>'tolly_editor',   'id'=>'editor_id',   'name'=>'editor_name',   'rate'=>'editor_rate',   'grade'=>'editor_grade',   'status'=>'editor_status',   'rating'=>'editor_rating',   'pic'=>'editor_pic'],
    'music'    => ['tbl'=>'tolly_music',    'id'=>'music_id',    'name'=>'music_name',    'rate'=>'music_rate',    'grade'=>'music_grade',    'status'=>'music_status',    'rating'=>'music_rating',    'pic'=>'music_pic'],
    'cine'     => ['tbl'=>'tolly_cine',     'id'=>'cine_id',     'name'=>'cine_name',     'rate'=>'cine_rate',     'grade'=>'cine_grade',     'status'=>'cine_status',     'rating'=>'cine_rating',     'pic'=>'cine_pic'],
];

if ($table === 'user') {
    if ($action === 'update') {
        $id = intval($_POST['id']);
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $banner = mysqli_real_escape_string($conn, $_POST['banner'] ?? '');
        $sql = "UPDATE tolly_user SET username='$name', banner='$banner' WHERE uid=$id";
        $r = mysqli_query($conn, $sql);
        echo json_encode($r ? ['status'=>'ok','msg'=>'Updated'] : ['status'=>'error','msg'=>mysqli_error($conn)]);
    } elseif ($action === 'delete') {
        $id = intval($_POST['id']);
        $sql = "DELETE FROM tolly_user WHERE uid=$id";
        $r = mysqli_query($conn, $sql);
        echo json_encode($r ? ['status'=>'ok','msg'=>'Deleted'] : ['status'=>'error','msg'=>mysqli_error($conn)]);
    } elseif ($action === 'add_user') {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $banner = mysqli_real_escape_string($conn, $_POST['banner'] ?? '');
        $pic = 'pic/' . strtolower(str_replace(' ', '_', $name)) . '.png';
        $sql = "INSERT INTO tolly_user (username, email, password, banner, pic, bal) VALUES ('$name', '$email', '$password', '$banner', '$pic', 0)";
        $r = mysqli_query($conn, $sql);
        if ($r) {
            $newId = mysqli_insert_id($conn);
            echo json_encode(['status'=>'ok','msg'=>'Added','id'=>$newId,'pic'=>$pic]);
        } else {
            echo json_encode(['status'=>'error','msg'=>mysqli_error($conn)]);
        }
    } else {
        echo json_encode(['status'=>'error','msg'=>'Invalid action for user']);
    }
    mysqli_close($conn);
    exit;
}

if (!isset($crewMap[$table])) {
    echo json_encode(['status'=>'error','msg'=>'Invalid table']);
    exit;
}

$c = $crewMap[$table];

if ($action === 'update') {
    $id     = intval($_POST['id']);
    $name   = mysqli_real_escape_string($conn, $_POST['name']);
    $rate   = floatval($_POST['rate']);
    $grade  = mysqli_real_escape_string($conn, $_POST['grade']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $rating = floatval($_POST['rating']);

    $sql = "UPDATE {$c['tbl']} SET
            {$c['name']}='$name',
            {$c['rate']}=$rate,
            {$c['grade']}='$grade',
            {$c['status']}='$status',
            {$c['rating']}=$rating
            WHERE {$c['id']}=$id";
    $r = mysqli_query($conn, $sql);
    echo json_encode($r ? ['status'=>'ok','msg'=>'Updated'] : ['status'=>'error','msg'=>mysqli_error($conn)]);

} elseif ($action === 'delete') {
    $id = intval($_POST['id']);
    $sql = "DELETE FROM {$c['tbl']} WHERE {$c['id']}=$id";
    $r = mysqli_query($conn, $sql);
    echo json_encode($r ? ['status'=>'ok','msg'=>'Deleted'] : ['status'=>'error','msg'=>mysqli_error($conn)]);

} elseif ($action === 'add') {
    $name   = mysqli_real_escape_string($conn, $_POST['name']);
    $rate   = floatval($_POST['rate']);
    $grade  = mysqli_real_escape_string($conn, $_POST['grade']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $rating = floatval($_POST['rating']);
    $pic    = 'poster/' . strtolower(str_replace(' ', '_', $name)) . '.png';

    $sql = "INSERT INTO {$c['tbl']}
            ({$c['name']}, {$c['rate']}, {$c['grade']}, {$c['status']}, {$c['rating']}, {$c['pic']})
            VALUES ('$name', $rate, '$grade', '$status', $rating, '$pic')";
    $r = mysqli_query($conn, $sql);
    if ($r) {
        $newId = mysqli_insert_id($conn);
        echo json_encode(['status'=>'ok','msg'=>'Added','id'=>$newId,'pic'=>$pic]);
    } else {
        echo json_encode(['status'=>'error','msg'=>mysqli_error($conn)]);
    }

} else {
    echo json_encode(['status'=>'error','msg'=>'Invalid action']);
}

mysqli_close($conn);
?>
