<?php
require_once __DIR__ . '/env.php';

$servername = env('DB_HOST');
$dbname = env('DB_NAME');
$username = env('DB_USER');
$password = env('DB_PASS');

if ($servername === null || $dbname === null || $username === null || $password === null) {
	die("Database configuration missing. Copy .env.example to .env and fill in real values.");
}

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
