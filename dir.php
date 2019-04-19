<?php
$dir = new DirectoryIterator(dirname('images'));
foreach ($dir as $fileinfo) {
    if (!$fileinfo->isDot()) {
        echo($fileinfo->getFilename());
    }
}

?>
