<?php
header('Content-Type: text/html; charset=utf-8');
require_once 'db.php';

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'pending';
$tab = isset($_GET['tab']) ? $_GET['tab'] : '';

$rangeQ = @mysqli_query($conn, "SELECT MAX(rid) AS max_page FROM tolly_ready_for_shoot");
$rangeRow = mysqli_fetch_assoc($rangeQ);
$oriid = intval($rangeRow["max_page"]);
$minid = floor($oriid/100)*100;
$maxid = ceil($oriid/100)*100;

$personStatus = [];
$flopResults = ['Flop','Below Average','Average'];

$rangeTypes = [
    ['cols'=>['mid','m2','m3'], 'table'=>'tolly_music', 'pk'=>'music_id'],
    ['cols'=>['cid'], 'table'=>'tolly_cine', 'pk'=>'cine_id'],
    ['cols'=>['eid'], 'table'=>'tolly_editor', 'pk'=>'editor_id'],
];
foreach ($rangeTypes as $rt) {
    $unionParts = [];
    foreach ($rt['cols'] as $ci => $col) {
        $unionParts[] = "SELECT $col AS pid, result FROM tolly_ready_for_shoot WHERE rid BETWEEN $minid AND $maxid AND status='out'" . ($ci > 0 ? " AND $col > 0" : "");
    }
    $rsql = "SELECT pid, GROUP_CONCAT(DISTINCT result) AS results FROM (" . implode(' UNION ALL ', $unionParts) . ") t GROUP BY pid";
    $rr = @mysqli_query($conn, $rsql);
    if ($rr) {
        while ($rw = mysqli_fetch_assoc($rr)) {
            $pid = intval($rw['pid']);
            $resList = array_map('trim', explode(',', $rw['results']));
            if (empty($resList[0])) {
                $personStatus[$rt['table']][$pid] = 'pending';
            } else {
                $allFlop = true;
                foreach ($resList as $rl) {
                    if (!in_array($rl, $flopResults)) { $allFlop = false; break; }
                }
                $personStatus[$rt['table']][$pid] = $allFlop ? 'flop' : 'active';
            }
        }
    }
    $allPeople = @mysqli_query($conn, "SELECT " . $rt['pk'] . " FROM " . $rt['table']);
    if ($allPeople) {
        while ($ap = mysqli_fetch_assoc($allPeople)) {
            $apid = intval($ap[$rt['pk']]);
            if (!isset($personStatus[$rt['table']][$apid])) {
                $personStatus[$rt['table']][$apid] = 'pending';
            }
        }
    }
}

function shouldShow($filter, $status) {
    if ($filter === 'all') return true;
    return $status === $filter;
}

ob_start();

if ($tab === 'music') {
    $sql = "SELECT mu.*, COALESCE(m.movie_count, 0) as movie_count, COALESCE(m.total_pl, 0) as pl
            FROM tolly_music mu
            LEFT JOIN (
                SELECT music_id, COUNT(DISTINCT rid) as movie_count, SUM(collection - budget) as total_pl
                FROM (
                    SELECT mid as music_id, rid, collection, budget FROM tolly_ready_for_shoot WHERE status = 'out'
                    UNION ALL
                    SELECT m2 as music_id, rid, collection, budget FROM tolly_ready_for_shoot WHERE status = 'out' AND m2 > 0
                    UNION ALL
                    SELECT m3 as music_id, rid, collection, budget FROM tolly_ready_for_shoot WHERE status = 'out' AND m3 > 0
                ) t
                GROUP BY music_id
            ) m ON mu.music_id = m.music_id";
    error_log("FILTER2_DEBUG: [music] MAIN_QUERY: $sql");
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $dir_id = $row["music_id"];
            $dir_name = $row["music_name"];
            $dir_rate = $row["music_rate"];
            $music_id_raw = $dir_id;
            $dir_id = $dir_id.'#'.$dir_name.'$'.$dir_rate;
            $dir_cr = round(($dir_rate/10000000),2);
            $music_movie_count = $row["movie_count"];
            $pl_val = floatval($row["pl"]);
            $pl_cr = round(($pl_val/10000000),2);
            $pl_class = ($pl_val >= 0) ? 'text-success' : 'text-danger';
            $fstatus = $personStatus['tolly_music'][$music_id_raw] ?? 'pending';
            if (!shouldShow($filter, $fstatus)) continue;
            echo "<tr data-filter='$fstatus'>";
            echo "<td><label class='btn btn-primary btn-rounded' ><input type='checkbox' class='r_mus' name='r_mus' value='".$dir_id."' />".$dir_name."</b></label></td>";
            echo "<td><b>".$dir_cr." CR</b></td>";
            echo "<td>".$row["music_rating"]."</td>";
            echo "<td class='$pl_class'><b>".$pl_cr." CR</b></td>";
            echo "<td><b>".$music_movie_count."</b></td>";
            echo "</tr>";
        }
    }
} elseif ($tab === 'cine') {
    $sql = "SELECT c.*, COALESCE(m.movie_count, 0) as movie_count, COALESCE(m.total_pl, 0) as pl
            FROM tolly_cine c
            LEFT JOIN (
                SELECT cid, COUNT(DISTINCT rid) as movie_count, SUM(collection - budget) as total_pl
                FROM tolly_ready_for_shoot
                WHERE status = 'out'
                GROUP BY cid
            ) m ON c.cine_id = m.cid";
    error_log("FILTER2_DEBUG: [cine] MAIN_QUERY: $sql");
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $dir_id = $row["cine_id"];
            $dir_name = $row["cine_name"];
            $dir_rate = $row["cine_rate"];
            $cine_id_raw = $dir_id;
            $dir_id = $dir_id.'#'.$dir_name.'$'.$dir_rate;
            $dir_cr = round(($dir_rate/10000000),2);
            $cine_movie_count = $row["movie_count"];
            $pl_val = floatval($row["pl"]);
            $pl_cr = round(($pl_val/10000000),2);
            $pl_class = ($pl_val >= 0) ? 'text-success' : 'text-danger';
            $fstatus = $personStatus['tolly_cine'][$cine_id_raw] ?? 'pending';
            if (!shouldShow($filter, $fstatus)) continue;
            echo "<tr data-filter='$fstatus'>";
            echo "<td><label class='btn btn-primary btn-rounded' ><input type='radio' class='r_cine' name='r_cine' value='".$dir_id."' />".$dir_name."</b></label></td>";
            echo "<td><b>".$dir_cr." CRORES</b></td>";
            echo "<td>".$row["cine_rating"]."</td>";
            echo "<td class='$pl_class'><b>".$pl_cr." CR</b></td>";
            echo "<td><b>".$cine_movie_count."</b></td>";
            echo "</tr>";
        }
    }
} elseif ($tab === 'editor') {
    $sql = "SELECT e.*, COALESCE(m.movie_count, 0) as movie_count, COALESCE(m.total_pl, 0) as pl
            FROM tolly_editor e
            LEFT JOIN (
                SELECT eid, COUNT(DISTINCT rid) as movie_count, SUM(collection - budget) as total_pl
                FROM tolly_ready_for_shoot
                WHERE status = 'out'
                GROUP BY eid
            ) m ON e.editor_id = m.eid";
    error_log("FILTER2_DEBUG: [editor] MAIN_QUERY: $sql");
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $dir_id = $row["editor_id"];
            $dir_name = $row["editor_name"];
            $dir_rate = $row["editor_rate"];
            $editor_id_raw = $dir_id;
            $dir_id = $dir_id.'#'.$dir_name.'$'.$dir_rate;
            $dir_cr = round(($dir_rate/10000000),2);
            $editor_movie_count = $row["movie_count"];
            $pl_val = floatval($row["pl"]);
            $pl_cr = round(($pl_val/10000000),2);
            $pl_class = ($pl_val >= 0) ? 'text-success' : 'text-danger';
            $fstatus = $personStatus['tolly_editor'][$editor_id_raw] ?? 'pending';
            if (!shouldShow($filter, $fstatus)) continue;
            echo "<tr data-filter='$fstatus'>";
            echo "<td><label class='btn btn-primary btn-rounded' ><input type='radio' class='r_edi' name='r_edi' value='".$dir_id."' />".$dir_name."</b></label></td>";
            echo "<td><b>".$dir_cr." CRORES</b></td>";
            echo "<td>".$row["editor_rating"]."</td>";
            echo "<td class='$pl_class'><b>".$pl_cr." CR</b></td>";
            echo "<td><b>".$editor_movie_count."</b></td>";
            echo "</tr>";
        }
    }
}

$output = ob_get_clean();
echo $output;
mysqli_close($conn);
