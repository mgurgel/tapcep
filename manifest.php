<?php

// Built upon example code from
// Building iPhone Apps with HTML, CSS, and JavaScript by Jonathan Stark. Copyright 2010 O’Reilly Media, Inc., 978-0-596-80579-1.
// http://building-iphone-apps.labs.oreilly.com/

$dir = new RecursiveDirectoryIterator(".");
$hashes = "";
$ignore = array(
								"db_connect.php",
								"db_connect.sample.php",
								"LICENSE",
								"LICENSE.txt",
								"README",
								"README.mdown",
								"ajax_cep.php"
								);
$network = array(
									"*"
								);
								
$hashes .= serialize($network);

header('Content-Type: text/cache-manifest');
echo "CACHE MANIFEST\n";

foreach(new RecursiveIteratorIterator($dir) as $file) {
        if ($file->IsFile() &&
        $file != "./manifest.php" &&
        substr($file->getFilename(), 0, 1) != "." &&
        substr($file, 0, 9) != "./archive" &&
        strpos($file, "/.svn") === false  &&
        strpos($file, "/.git") === false &&
        array_search($file->getFilename(), $ignore) === false) {
                echo $file . "\n";
                $hashes .= md5_file($file);
        }
}

echo "\nNETWORK:\n";
foreach($network as $file) {
		echo $file . "\n";
}

echo "\n# Hash: " . md5($hashes) . "\n";
?>