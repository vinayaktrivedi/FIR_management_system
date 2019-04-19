<?php
$dir = new DirectoryIterator('users');
foreach ($dir as $fileinfo) {
    if (!$fileinfo->isDot()) {
        echo($fileinfo->getFilename());
    }
}

?>
