<?php
session_start();
$cookie_lifetime = 48 * 60 * 60;
ini_set('session.gc_maxlifetime', $cookie_lifetime);
session_set_cookie_params($cookie_lifetime);
error_reporting(E_ERROR);

if (!isset($_SESSION['s_uid'])) {
	header("Location: ../login.php");
	exit;
}

include __DIR__ . '/../db.php';

$base = __DIR__;
@mkdir($base . '/done', 0755, true);

$sql = "SELECT r.rid, r.`50d_cen`, r.`75d_cen`, r.`100d_cen`, r.`150d_cen`, r.`175d_cen`, r.`25d_cen`,
               s.title, s.dname, s.aname, s.acname, s.cinename, s.ediname, s.musname, s.wriname,
               s.a2_name, s.a3_name, s.ac2_name, s.ac3_name, s.d2_name, s.d3_name,
               s.m2_name, s.m3_name, s.w2_name, s.w3_name
        FROM tolly_release r
        JOIN tolly_ready_for_shoot s ON s.rid = r.rid
        ORDER BY r.rid DESC";
$result = mysqli_query($conn, $sql);

$total = mysqli_num_rows($result);
$done = 0;
$failed = 0;

echo "<h2>Regenerating All Posters</h2>";
echo "<p>Total movies: $total</p><hr>";

if ($total > 0) {
	while ($row = mysqli_fetch_assoc($result)) {
		$rid = $row['rid'];
		$title = $row['title'];
		$upp = strtoupper($title . $rid);
		$file_path = $base . '/done/' . $upp . '.jpeg';

		$_GET['rid']  = $rid;
		$_GET['tit']  = $upp;
		$_GET['b']    = $_SESSION['s_banner'] ?? '';
		$_GET['p']    = $_SESSION['s_user'] ?? '';
		$_GET['d']    = $row['dname'];
		$_GET['a']    = $row['aname'];
		$_GET['ac']   = $row['acname'];
		$_GET['c']    = $row['cinename'];
		$_GET['e']    = $row['ediname'];
		$_GET['m']    = $row['musname'];
		$_GET['w']    = $row['wriname'];
		$_GET['fif']  = intval($row['50d_cen'] ?? 0);
		$_GET['hun']  = intval($row['100d_cen'] ?? 0);
		$_GET['fiv']  = intval($row['175d_cen'] ?? 0);
		$_GET['t5']   = intval($row['25d_cen'] ?? 0);
		$_GET['sev']  = intval($row['75d_cen'] ?? 0);
		$_GET['onf']  = intval($row['150d_cen'] ?? 0);
		$_GET['a2']   = $row['a2_name'] ?? '';
		$_GET['a3']   = $row['a3_name'] ?? '';
		$_GET['ac2']  = $row['ac2_name'] ?? '';
		$_GET['ac3']  = $row['ac3_name'] ?? '';
		$_GET['d2']   = $row['d2_name'] ?? '';
		$_GET['d3']   = $row['d3_name'] ?? '';
		$_GET['m2']   = $row['m2_name'] ?? '';
		$_GET['m3']   = $row['m3_name'] ?? '';
		$_GET['w2']   = $row['w2_name'] ?? '';
		$_GET['w3']   = $row['w3_name'] ?? '';

		ob_start();
		include __DIR__ . '/poster-v2.php';
		ob_end_clean();

		if (file_exists($file_path)) {
			$done++;
			echo "<p style='color:green'>OK</p> #$rid - $title";
		} else {
			$failed++;
			echo "<p style='color:red'>FAIL</p> #$rid - $title";
		}
		flush();
	}
}

echo "<hr><h3>Done: $done / $total | Failed: $failed</h3>";

if ($conn != null) {
	mysqli_close($conn);
}
?>
