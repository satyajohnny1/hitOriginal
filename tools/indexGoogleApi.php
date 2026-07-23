<?php
session_start();
$url_array = explode('?', 'http://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$url = $url_array[0];
echo 'URL IS :'.$url;


require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_DriveService.php';
$client = new Google_Client();
$client->setClientId('623163628428-utnfhs54h7aahhnrcs9kpo8ivv9fe3u1.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri($url);
$client->setScopes(array('https://www.googleapis.com/auth/drive'));
if (isset($_GET['code'])) {
    $_SESSION['accessToken'] = $client->authenticate($_GET['code']);
    header('location:'.$url);exit;
} elseif (!isset($_SESSION['accessToken'])) {
    $client->authenticate();
}
$files= array();
$dir = dir('BACKUP_DIR');
while ($file = $dir->read()) {
    if ($file != '.' && $file != '..') {
        $files[] = $file;
    }
}
$dir->close();
if (!empty($_POST)) {
try{
    $client->setAccessToken($_SESSION['accessToken']);
    $service = new Google_DriveService($client);
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $file = new Google_DriveFile();
    $parentId = '129G8m1NqZvGxCJRF-xXttZ17vwqS1mT2';
   
   //set Parent Folder
    $parent = new Google_ParentReference();
    $parent->setId($parentId);
    $file->setParents(array($parent));

 

    foreach ($files as $file_name) {
        $file_path = 'BACKUP_DIR/'.$file_name;
        $mime_type = finfo_file($finfo, $file_path);
        $file->setTitle($file_name);
        $file->setDescription('This is a '.$mime_type.' document');
        $file->setMimeType($mime_type);
        $service->files->insert(
            $file,
            array(
                'data' => file_get_contents($file_path),
                'mimeType' => $mime_type
   
            )
        );
    }
    finfo_close($finfo);
    header('location:'.$url);exit;
    } catch(Exception $e){
        echo 'An error ocurred : ' . $e->getMessage();
    }
}
include 'indexGoogleApiSubmit.php';
