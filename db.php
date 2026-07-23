<?php
/*
 
## epizy
$servername = "sql105.epizy.com";
$dbname = "epiz_28768808_javabo";
$username = "epiz_28768808";
$password = "jEWDSrJkJi15f";


$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "hit2";

 DB_NAME', 'linkpro_wordpress' );

  'DB_USER', 'linkpro' );
 DB_PASSWORD', 'linkpro' );

 'DB_HOST', 'linkprotechcom.ipagemysql.com' );

*/




/* JavaBo
$servername = "sql301.epizy.com";
$dbname = "epiz_32875882_javabo";
$username = "epiz_32875882";
$password = "AF6tE0XjpZUX";
*/

//mizDb
$servername = "68.178.135.125";
$dbname = "testdb";
$username = "testdb";
$password = "testdb";

 


// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
	echo "<h1> Database Connection failed. </h1>";
    die("Connection failed: " . mysqli_connect_error());
}else{
	//echo "<h1> Connection Success. </h1>";
	
	// Silent Automated Migration Runner with local file cache check (0ms overhead on subsequent hits)
	$migratedLock = __DIR__ . '/db/migrations/.migrated';
	if (!defined('PHINX_CONFIG_LOADED') && !defined('MIGRATING_DB') && !file_exists($migratedLock)) {
		define('MIGRATING_DB', true);
		
		$runMigrate = false;
		$resTab = @mysqli_query($conn, "SHOW TABLES LIKE 'schema_version'");
		if (!$resTab || mysqli_num_rows($resTab) == 0) {
			$runMigrate = true;
		} else {
			$migDir = __DIR__ . '/db/migrations';
			$localVersions = [];
			if (is_dir($migDir)) {
				$files = glob($migDir . '/*.php');
				if ($files !== false) {
					foreach ($files as $f) {
						$base = basename($f);
						if (preg_match('/^(\d+)_/', $base, $matches)) {
							$localVersions[] = $matches[1];
						}
					}
				}
			}
			
			$dbVersions = [];
			$resVer = @mysqli_query($conn, "SELECT version FROM schema_version");
			if ($resVer) {
				while ($row = mysqli_fetch_assoc($resVer)) {
					$dbVersions[] = (string)$row['version'];
				}
			}
			
			foreach ($localVersions as $lv) {
				if (!in_array($lv, $dbVersions)) {
					$runMigrate = true;
					break;
				}
			}
		}
		
		if ($runMigrate) {
			require_once __DIR__ . '/vendor/autoload.php';
			try {
				$app = new \Phinx\Console\PhinxApplication();
				$app->setAutoExit(false);
				$app->run(new \Symfony\Component\Console\Input\StringInput('migrate'), new \Symfony\Component\Console\Output\NullOutput());
				@touch($migratedLock);
			} catch (\Exception $e) {
				error_log("Auto Migration Failed: " . $e->getMessage());
			}
		} else {
			@touch($migratedLock);
		}
	}
}
