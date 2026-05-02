<?php
$dir = '../services';
deleteAll($dir);

function deleteAll($dir)
{
    $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
    $files = new RecursiveIteratorIterator(
        $it,
        RecursiveIteratorIterator::CHILD_FIRST
    );
    foreach ($files as $file) {
        if (
            $file->getPathName() != '../services\index.php' &&
            $file->getPathName() != '../services\deleteFilesZip.php' &&
            $file->getPathName() != '../services\deleteFoldersApi.php' &&
            $file->getPathName() != '../services\zipfiles'
        ) {
            if ($file->isDir()) {
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
    }
}