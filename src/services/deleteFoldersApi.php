<?php
$dir = __DIR__;
deleteAll($dir);

function deleteAll($dir)
{
    $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
    $files = new RecursiveIteratorIterator(
        $it,
        RecursiveIteratorIterator::CHILD_FIRST
    );

    $excludeFiles = [
        realpath(__DIR__ . '/index.php'),
        realpath(__DIR__ . '/deleteFilesZip.php'),
        realpath(__DIR__ . '/deleteFoldersApi.php'),
        realpath(__DIR__ . '/ZipService.php'),
        realpath(__DIR__ . '/StructureGenerator.php'),
        realpath(__DIR__ . '/zipfiles'),
    ];
    
    foreach ($files as $file) {
        $fileName = $file->getRealPath();

        if (in_array($fileName, $excludeFiles)) {
            continue;
        }

        if ($file->isDir()) {
            rmdir($file->getRealPath());
        } else {
            unlink($file->getRealPath());
        }
        // }
    }
}