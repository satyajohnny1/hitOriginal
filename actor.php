<?php
include 'sessionCheck.php';
session_start();
error_reporting(E_ERROR);
$uid = $_SESSION['s_uid'];
$aid = $_GET['id'];
$nme = $_GET['name'];
?>
<!DOCTYPE html>
<html>

<head>
    <?php include 'css.php';?>
</head>

<body class="page-header-fixed">
    <div class="overlay"></div>
    <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s1">
        <h3><span class="pull-left">Chat</span><a href="javascript:void(0);" class="pull-right" id="closeRight"><i class="fa fa-times"></i></a></h3>
    </nav>
    <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s2">
        <h3><span class="pull-left">Sandra Smith</span> <a href="javascript:void(0);" class="pull-right" id="closeRight2"><i class="fa fa-angle-right"></i></a></h3>
    </nav>

    <main class="page-content content-wrap">
        <?php include 'navbar.php';?>
        <div class="page-sidebar sidebar">
            <?php include('sidemenu.php'); ?>
        </div>
        <div class="page-inner">
            <div id="main-wrapper">

                <?php include 'db.php';

                $actorSql = "SELECT actor_name, actor_rate, actor_grade, actor_status, actor_rating, actor_pic FROM tolly_actor WHERE actor_id = " . intval($aid);
                $actorResult = @mysqli_query($conn, $actorSql);
                $actorData = [];
                if ($actorResult && mysqli_num_rows($actorResult) > 0) {
                    $actorData = mysqli_fetch_assoc($actorResult);
                }
                $name  = $actorData['actor_name'] ?? '';
                $rate  = $actorData['actor_rate'] ?? '';
                $grade = $actorData['actor_grade'] ?? '';
                $status = $actorData['actor_status'] ?? '';
                $rating = $actorData['actor_rating'] ?? '';

                $moviesSql = "SELECT s.rid, s.title, s.dname, s.aname, s.result, s.collection, s.sofar, s.a2_name, s.a3_name, s.d2_name, s.d3_name
                    FROM tolly_ready_for_shoot s
                    WHERE (s.aid = " . intval($aid) . " OR s.a2 = " . intval($aid) . " OR s.a3 = " . intval($aid) . ") AND s.status = 'out'";
                $moviesResult = @mysqli_query($conn, $moviesSql);
                $movies = [];
                $totBud = 0;
                $totColl = 0;
                if ($moviesResult && mysqli_num_rows($moviesResult) > 0) {
                    while ($row = mysqli_fetch_assoc($moviesResult)) {
                        $rid = $row['rid'];
                        $collection = $row['collection'];
                        $budget = $row['sofar'];
                        $totColl += $collection;
                        $totBud += $budget;

                        $relSql = "SELECT `50d_cen`, `100d_cen`, `150d_cen`, `175d_cen`, max_days FROM tolly_release WHERE rid = " . intval($rid) . " AND status = 'out'";
                        $relResult = @mysqli_query($conn, $relSql);
                        $relRow = $relResult ? mysqli_fetch_assoc($relResult) : null;

                        $movies[] = [
                            'rid' => $rid,
                            'title' => $row['title'],
                            'dname' => $row['dname'] . '-' . $row['d2_name'] . '-' . $row['d3_name'],
                            'aname' => $row['aname'] . '-' . $row['a2_name'] . '-' . $row['a3_name'],
                            'result' => $row['result'],
                            'budget' => $budget,
                            'collection' => $collection,
                            'c50' => $relRow['50d_cen'] ?? '',
                            'c100' => $relRow['100d_cen'] ?? '',
                            'c150' => $relRow['150d_cen'] ?? '',
                            'c175' => $relRow['175d_cen'] ?? '',
                            'days' => $relRow['max_days'] ?? '',
                        ];
                    }
                }

                $pl = round(($totColl - $totBud) / 10000000, 2);
                @mysqli_query($conn, "UPDATE `tolly_actor` SET `pl`=" . $pl . " WHERE `actor_id`=" . intval($aid));

                $notesSql = "SELECT s.result, COUNT(*) AS `count` FROM `tolly_ready_for_shoot` s WHERE s.aid = " . intval($aid) . " OR s.a2 = " . intval($aid) . " OR s.a3 = " . intval($aid) . " GROUP BY s.result";
                $notesResult = @mysqli_query($conn, $notesSql);
                $notes = [];
                if ($notesResult) {
                    while ($row = mysqli_fetch_assoc($notesResult)) {
                        $notes[] = $row;
                    }
                }

                $chartSql = "SELECT COUNT(*) AS cnt, s.result FROM tolly_ready_for_shoot s WHERE (s.aid = " . intval($aid) . " OR s.a2 = " . intval($aid) . " OR s.a3 = " . intval($aid) . ") AND s.`status` = 'out' GROUP BY s.result";
                $chartResult = @mysqli_query($conn, $chartSql);
                $chartData = [];
                if ($chartResult && mysqli_num_rows($chartResult) > 0) {
                    while ($row = mysqli_fetch_assoc($chartResult)) {
                        $chartData[] = $row;
                    }
                }

                $gaugeSql = "SELECT x.tot, y.hit FROM
                    (SELECT COUNT(*) as tot FROM tolly_ready_for_shoot s WHERE (s.aid = " . intval($aid) . " OR s.a2 = " . intval($aid) . " OR s.a3 = " . intval($aid) . ")) as x,
                    (SELECT COUNT(*) as hit FROM tolly_ready_for_shoot sa WHERE (sa.aid = " . intval($aid) . " OR sa.a2 = " . intval($aid) . " OR sa.a3 = " . intval($aid) . ") AND sa.rating > 3) as y";
                $gaugeResult = @mysqli_query($conn, $gaugeSql);
                $gaugeRate = 0;
                if ($gaugeResult && mysqli_num_rows($gaugeResult) > 0) {
                    $gRow = mysqli_fetch_assoc($gaugeResult);
                    if ($gRow['tot'] > 0) {
                        $gaugeRate = round(($gRow['hit'] / $gRow['tot']) * 100);
                    }
                }

                $last5Sql = "SELECT s.title, s.rating FROM tolly_ready_for_shoot s WHERE (s.aid = " . intval($aid) . " OR s.a2 = " . intval($aid) . " OR s.a3 = " . intval($aid) . ") AND s.`status` = 'out' ORDER BY s.dt LIMIT 5";
                $last5Result = @mysqli_query($conn, $last5Sql);
                $last5Data = [];
                if ($last5Result && mysqli_num_rows($last5Result) > 0) {
                    while ($row = mysqli_fetch_assoc($last5Result)) {
                        $last5Data[] = $row;
                    }
                }
                ?>

                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div id="mymovieschart" style="width: 100%; height: 300px;"></div>
                    </div>
                    <div class="col-lg-3 col-md-6 panel">
                        <div id="successratechart" style="width: 100%; height: 300px;"></div>
                    </div>
                    <div class="col-lg-5 col-md-6">
                        <div id="last5" style="width: 100%; height: 300px;"></div>
                    </div>
                </div>

                <div class="panel panel-white">
                    <div class="panel-body">
                        <div role="tabpanel">
                            <ul class="nav nav-tabs nav-justified" role="tablist">
                                <li role="presentation" class="active"><a href="#tab21" role="tab" data-toggle="tab">About</a></li>
                                <li role="presentation"><a href="#tab22" role="tab" data-toggle="tab">Movies</a></li>
                                <li role="presentation"><a href="#tab33" role="tab" data-toggle="tab">Notes</a></li>
                            </ul>
                            <div class="tab-content">

                                <div role="tabpanel" class="tab-pane active fade in" id="tab21">
                                    <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-6">
                                            <div class="panel panel-white">
                                                <div class="panel-heading clearfix">
                                                    <h4 class="panel-title">Data</h4>
                                                </div>
                                                <div class="panel-body">
                                                    <form action="updateallpage.php" method="POST" enctype="multipart/form-data">
                                                        <div class="form-group">
                                                            <label>TABLE</label>
                                                            <input type="text" class="form-control" value="actor" name="table" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>ID</label>
                                                            <input type="text" class="form-control" value="<?php echo $aid ?>" name="aid" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>name</label>
                                                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($name) ?>" name="aname">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>rate</label>
                                                            <input type="number" class="form-control" value="<?php echo $rate ?>" name="arate">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Grade</label>
                                                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($grade) ?>" name="agrade">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>status</label>
                                                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($status) ?>" name="astatus">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>rating</label>
                                                            <input type="number" class="form-control" value="<?php echo $rating ?>" name="arating">
                                                        </div>
                                                        <?php if ($_SESSION['s_type'] == 'admin') { ?>
                                                            <button type="submit" class="btn btn-primary">Update</button>
                                                        <?php } ?>
                                                    </form>
                                                    <br>
                                                    <form action="deleteallpage.php" method="POST" enctype="multipart/form-data">
                                                        <input type="hidden" value="actor" name="table">
                                                        <input type="hidden" value="<?php echo $aid ?>" name="aid">
                                                        <?php if ($_SESSION['s_type'] == 'admin') { ?>
                                                            <button type="submit" class="btn btn-danger">DELETE</button>
                                                        <?php } ?>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div role="tabpanel" class="tab-pane fade" id="tab22">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="panel panel-white">
                                                <div class="panel-body">
                                                    <div class="table-responsive">
                                                        <table id="example" class="display table" style="width: 100%; cellspacing: 0;">
                                                            <thead>
                                                                <tr>
                                                                    <th>Sno</th>
                                                                    <th>Title</th>
                                                                    <th>Director</th>
                                                                    <th>Actors</th>
                                                                    <th>Result</th>
                                                                    <th>Budget</th>
                                                                    <th>Collection</th>
                                                                    <th>50'Cen</th>
                                                                    <th>100'Cen</th>
                                                                    <th>150'Cen</th>
                                                                    <th>175'Cen</th>
                                                                    <th>Days</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($movies as $m) { ?>
                                                                    <tr>
                                                                        <td><?php echo $m['rid']; ?></td>
                                                                        <td><a href="movie.php?rid=<?php echo $m['rid']; ?>" class="btn btn-danger btn-rounded"><?php echo htmlspecialchars($m['title']); ?></a></td>
                                                                        <td><b><?php echo htmlspecialchars($m['dname']); ?></b></td>
                                                                        <td><b><?php echo htmlspecialchars($m['aname']); ?></b></td>
                                                                        <td><button type="button" class="btn btn-info"><?php echo htmlspecialchars($m['result']); ?></button></td>
                                                                        <td><?php echo round($m['budget'] / 10000000, 2); ?></td>
                                                                        <td><?php echo round($m['collection'] / 10000000, 2); ?></td>
                                                                        <td><?php echo $m['c50']; ?></td>
                                                                        <td><?php echo $m['c100']; ?></td>
                                                                        <td><?php echo $m['c150']; ?></td>
                                                                        <td><?php echo $m['c175']; ?></td>
                                                                        <td><?php echo $m['days']; ?></td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div role="tabpanel" class="tab-pane fade" id="tab33">
                                    <div class="panel-body">
                                        <div class="col-md-6">
                                            <table class="table table-hover">
                                                <?php foreach ($notes as $n) { ?>
                                                    <tr>
                                                        <td><button type="button" class="btn btn-primary"><?php echo htmlspecialchars($n['result']); ?></button></td>
                                                        <td><button type="button" class="btn btn-success"><?php echo $n['count']; ?></button></td>
                                                    </tr>
                                                <?php } ?>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-primary btn-lg btn-block"><h3>Budget: <?php echo round($totBud / 10000000, 2) . " Cr."; ?></h3></button>
                                            <button type="button" class="btn btn-success btn-lg btn-block"><h3>Collec: <?php echo round($totColl / 10000000, 2) . " Cr."; ?></h3></button>
                                            <button type="button" class="btn btn-info btn-lg btn-block"><h2>P&L: <?php echo $pl . " Cr."; ?></h2></button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <?php include 'share.php';?>

                <div class="page-footer">
                    <p class="no-s">2015 &copy; HitandFut.com</p>
                </div>
            </div>
        </div>
    </main>

    <div class="cd-overlay"></div>

    <?php include 'js.php';?>

    <script src="https://www.google.com/jsapi"></script>
    <script>
        google.load("visualization", "1", { packages: ["corechart"] });
        google.load("visualization", "1.1", { packages: ["bar"] });
        google.setOnLoadCallback(drawChart);

        function drawChart() {
            var chartData = <?php echo json_encode($chartData); ?>;
            var pieRows = [['Task', 'Hours per Day']];
            chartData.forEach(function(r) { pieRows.push([r.result, parseInt(r.cnt)]); });
            pieRows.push(['Sleep', 0]);

            var chart1 = new google.visualization.PieChart(document.getElementById('mymovieschart'));
            chart1.draw(google.visualization.arrayToDataTable(pieRows), {
                title: 'Your Hits&Futs %',
                titleTextStyle: { color: 'black', fontName: 'Century Gothic', fontSize: 14 },
                is3D: true,
                legend: { position: 'bottom', textStyle: { color: 'blue', fontSize: 12 } }
            });

            var gaugeRows = [['Label', 'Value'], ['Success Rate', <?php echo $gaugeRate; ?>]];
            var chart2 = new google.visualization.Gauge(document.getElementById('successratechart'));
            chart2.draw(google.visualization.arrayToDataTable(gaugeRows), {
                animation: { duration: 1000, easing: 'inAndOut' },
                width: '100%', height: '200px',
                redFrom: 0, redTo: 35, yellowFrom: 36, yellowTo: 67, greenFrom: 68, greenTo: 100, minorTicks: 5
            });

            var last5Rows = [['Movie', 'Rating']];
            <?php foreach ($last5Data as $l5) { ?>
                last5Rows.push([<?php echo json_encode($l5['title']); ?>, <?php echo intval($l5['rating']); ?>]);
            <?php } ?>

            var chart3 = new google.charts.Bar(document.getElementById('last5'));
            chart3.draw(google.visualization.arrayToDataTable(last5Rows), {
                chart: { title: 'Last 5 Movies', titleTextStyle: { color: 'black', fontName: 'Century Gothic', fontSize: 14 } }
            });
        }
    </script>

</body>

</html>
<?php
if ($conn != null) {
    mysqli_close($conn);
}
?>
