<?php
header('Content-Type: text/html; charset=utf-8');
require_once 'db.php';

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'pending';
$tab = isset($_GET['tab']) ? $_GET['tab'] : '';

error_log("FILTER_DEBUG: tab=$tab filter=$filter");

$debug_output = [];

$rangeQ = @mysqli_query($conn, "SELECT MAX(rid) AS max_page FROM tolly_ready_for_shoot");
$rangeRow = mysqli_fetch_assoc($rangeQ);
$oriid = intval($rangeRow["max_page"]);
$minid = floor($oriid/100)*100;
$maxid = ceil($oriid/100)*100;

$personStatus = [];
$flopResults = ['Flop','Below Average','Average'];

$rangeTypes = [
    ['cols'=>['did','d2','d3'], 'table'=>'tolly_director', 'pk'=>'director_id'],
    ['cols'=>['aid','a2','a3'], 'table'=>'tolly_actor', 'pk'=>'actor_id'],
    ['cols'=>['acid','ac2','ac3'], 'table'=>'tolly_actress', 'pk'=>'actress_id'],
    ['cols'=>['wid','w2','w3'], 'table'=>'tolly_writer', 'pk'=>'writer_id'],
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

if ($tab === 'director') {
    $sql = "SELECT d.*, COALESCE(m.movie_count, 0) as movie_count, COALESCE(m.total_pl, 0) as pl
            FROM tolly_director d
            LEFT JOIN (
                SELECT director_id, COUNT(DISTINCT rid) as movie_count, SUM(collection - budget) as total_pl
                FROM (
                    SELECT did as director_id, rid, collection, budget FROM tolly_ready_for_shoot WHERE status = 'out'
                    UNION ALL
                    SELECT d2 as director_id, rid, collection, budget FROM tolly_ready_for_shoot WHERE status = 'out' AND d2 > 0
                    UNION ALL
                    SELECT d3 as director_id, rid, collection, budget FROM tolly_ready_for_shoot WHERE status = 'out' AND d3 > 0
                ) t
                GROUP BY director_id
            ) m ON d.director_id = m.director_id";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $dir_id = $row["director_id"];
            $dir_name = $row["director_name"];
            $dir_rate = $row["director_rate"];
            $dir_pic = $row["director_pic"];
            $dir_id_raw = $dir_id;
            $dir_cr = round(($dir_rate/10000000),2);
            $dir_id = $dir_id.'#'.$dir_name.'$'.$dir_rate.'^'.$dir_pic;
            $dir_movie_count = $row["movie_count"];
            $pl_val = floatval($row["pl"]);
            $pl_cr = round(($pl_val/10000000),2);
            $pl_class = ($pl_val >= 0) ? 'text-success' : 'text-danger';
            $dir_status = $personStatus['tolly_director'][$dir_id_raw] ?? 'pending';
            if (!shouldShow($filter, $dir_status)) continue;
            echo "<tr data-filter='$dir_status'>";
            echo "<td><label class='btn btn-primary btn-rounded' ><input type='checkbox' width='4em' height='4em' class='r_dir' name='r_dir' value='".$dir_id."' /><b>".$dir_name."</b></label></td>";
            echo "<td><b>".$dir_cr." CRORES</b>";
            echo "<td>".$row["director_rating"]."</td>";
            echo "<td class='$pl_class'><b>".$pl_cr." CR</b></td>";
            echo "<td><b>".$dir_movie_count."</b></td>";
            echo "<td style='display: none;'>".$dir_pic."</td>";
            echo "</tr>";
        }
    }
} elseif ($tab === 'actor') {
    $sql = "SELECT a.*, COALESCE(m.movie_count, 0) as movie_count, COALESCE(m.total_pl, 0) as pl
            FROM tolly_actor a
            LEFT JOIN (
                SELECT actor_id, COUNT(DISTINCT rid) as movie_count, SUM(collection - budget) as total_pl
                FROM (
                    SELECT aid as actor_id, rid, collection, budget FROM tolly_ready_for_shoot WHERE status = 'out'
                    UNION ALL
                    SELECT a2 as actor_id, rid, collection, budget FROM tolly_ready_for_shoot WHERE status = 'out' AND a2 > 0
                    UNION ALL
                    SELECT a3 as actor_id, rid, collection, budget FROM tolly_ready_for_shoot WHERE status = 'out' AND a3 > 0
                ) t
                GROUP BY actor_id
            ) m ON a.actor_id = m.actor_id";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $act_id = $row["actor_id"];
            $act_name = $row["actor_name"];
            $act_rate = $row["actor_rate"];
            $a_pic = $row["actor_pic"];
            $act_id_raw = $act_id;
            $act_id = $act_id.'#'.$act_name.'$'.$act_rate.'^'.$a_pic;
            $dir_cr = round(($act_rate/10000000),2);
            $act_movie_count = $row["movie_count"];
            $pl_val = floatval($row["pl"]);
            $pl_cr = round(($pl_val/10000000),2);
            $pl_class = ($pl_val >= 0) ? 'text-success' : 'text-danger';
            $act_status = $personStatus['tolly_actor'][$act_id_raw] ?? 'pending';
            if (!shouldShow($filter, $act_status)) continue;
            echo "<tr data-filter='$act_status'>";
            echo "<td><label class='btn btn-primary btn-rounded' ><input type='checkbox' class='r_act' name='r_act' value='".$act_id."' />".$act_name."</b></label></td>";
            echo "<td><b>".$dir_cr." CRORES</b>";
            echo "<td>".$row["actor_rating"]."</td>";
            echo "<td class='$pl_class'><b>".$pl_cr." CR</b></td>";
            echo "<td><b>".$act_movie_count."</b></td>";
            echo "</tr>";
        }
    }
} elseif ($tab === 'actress') {
    $sql = "SELECT a.*, COALESCE(m.movie_count, 0) as movie_count, COALESCE(m.total_pl, 0) as pl
            FROM tolly_actress a
            LEFT JOIN (
                SELECT actress_id, COUNT(DISTINCT rid) as movie_count, SUM(collection - budget) as total_pl
                FROM (
                    SELECT acid as actress_id, rid, collection, budget FROM tolly_ready_for_shoot WHERE status = 'out'
                    UNION ALL
                    SELECT ac2 as actress_id, rid, collection, budget FROM tolly_ready_for_shoot WHERE status = 'out' AND ac2 > 0
                    UNION ALL
                    SELECT ac3 as actress_id, rid, collection, budget FROM tolly_ready_for_shoot WHERE status = 'out' AND ac3 > 0
                ) t
                GROUP BY actress_id
            ) m ON a.actress_id = m.actress_id";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $dir_id = $row["actress_id"];
            $dir_name = $row["actress_name"];
            $dir_rate = $row["actress_rate"];
            $ac_pic = $row["actress_pic"];
            $actress_id_raw = $dir_id;
            $dir_cr = round(($dir_rate/10000000),2);
            $dir_id = $dir_id.'#'.$dir_name.'$'.$dir_rate.'^'.$ac_pic;
            $actress_movie_count = $row["movie_count"];
            $pl_val = floatval($row["pl"]);
            $pl_cr = round(($pl_val/10000000),2);
            $pl_class = ($pl_val >= 0) ? 'text-success' : 'text-danger';
            $acs_status = $personStatus['tolly_actress'][$actress_id_raw] ?? 'pending';
            if (!shouldShow($filter, $acs_status)) continue;
            echo "<tr data-filter='$acs_status'>";
            echo "<td><label class='btn btn-primary btn-rounded' ><input type='checkbox' class='r_actress' name='r_actress' value='".$dir_id."' />".$dir_name."</b></label></td>";
            echo "<td><b>".$dir_cr." CRORES</b>";
            echo "<td>".$row["actress_rating"]."</td>";
            echo "<td class='$pl_class'><b>".$pl_cr." CR</b></td>";
            echo "<td><b>".$actress_movie_count."</b></td>";
            echo "</tr>";
        }
    }
} elseif ($tab === 'writer') {
    $sql = "SELECT w.*, COALESCE(m.movie_count, 0) as movie_count, COALESCE(m.total_pl, 0) as pl
            FROM tolly_writer w
            LEFT JOIN (
                SELECT writer_id, COUNT(DISTINCT rid) as movie_count, SUM(collection - budget) as total_pl
                FROM (
                    SELECT wid as writer_id, rid, collection, budget FROM tolly_ready_for_shoot WHERE status = 'out'
                    UNION ALL
                    SELECT w2 as writer_id, rid, collection, budget FROM tolly_ready_for_shoot WHERE status = 'out' AND w2 > 0
                    UNION ALL
                    SELECT w3 as writer_id, rid, collection, budget FROM tolly_ready_for_shoot WHERE status = 'out' AND w3 > 0
                ) t
                GROUP BY writer_id
            ) m ON w.writer_id = m.writer_id";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $dir_id = $row["writer_id"];
            $dir_name = $row["writer_name"];
            $dir_rate = $row["writer_rate"];
            $ac_pic = $row["writer_pic"];
            $writer_id_raw = $dir_id;
            $dir_cr = round(($dir_rate/10000000),2);
            $dir_id = $dir_id.'#'.$dir_name.'$'.$dir_rate.'^'.$ac_pic;
            $writer_movie_count = $row["movie_count"];
            $pl_val = floatval($row["pl"]);
            $pl_cr = round(($pl_val/10000000),2);
            $pl_class = ($pl_val >= 0) ? 'text-success' : 'text-danger';
            $wri_status = $personStatus['tolly_writer'][$writer_id_raw] ?? 'pending';
            if (!shouldShow($filter, $wri_status)) continue;
            echo "<tr data-filter='$wri_status'>";
            echo "<td><label class='btn btn-primary btn-rounded' ><input type='checkbox' class='r_writer' name='r_writer' value='".$dir_id."' /><b>".$dir_name."</b></label></td>";
            echo "<td><b>".$dir_cr." CR</b>";
            echo "<td></td>";
            echo "<td>".$row["writer_rating"]."</td>";
            echo "<td class='$pl_class'><b>".$pl_cr." CR</b></td>";
            echo "<td><b>".$writer_movie_count."</b></td>";
            echo "</tr>";
        }
    }
}

$output = ob_get_clean();
error_log("FILTER_DEBUG: output length=" . strlen($output) . " chars, tab=$tab, filter=$filter");
if (strlen($output) < 200) {
    error_log("FILTER_DEBUG: output=$output");
}
echo $output;
mysqli_close($conn);
