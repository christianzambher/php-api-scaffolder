<?php
$baseDir = realpath(__DIR__ . '/../../'); // raíz del proyecto
deleteGenerated($baseDir);

function deleteGenerated($dir)
{
    $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
    $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);

    foreach ($files as $file) {

        $path = $file->getRealPath();

        // 🔥 SOLO borrar carpetas generadas (apiX)
        if ($file->isDir() && preg_match('/api.*/', basename($path))) {
            deleteDir($path);
        }
    }
}

function deleteDir($dir)
{
    $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
    $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);

    foreach ($files as $file) {
        if ($file->isDir()) {
            rmdir($file->getRealPath());
        } else {
            unlink($file->getRealPath());
        }
    }

    rmdir($dir);
}
// $dir = __DIR__;
// deleteAll($dir);

// function deleteAll($dir)
// {
//     $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
//     $files = new RecursiveIteratorIterator(
//         $it,
//         RecursiveIteratorIterator::CHILD_FIRST
//     );

//     $excludeFiles = [
//         realpath(__DIR__ . '/index.php'),
//         realpath(__DIR__ . '/deleteFilesZip.php'),
//         realpath(__DIR__ . '/deleteFoldersApi.php'),
//         realpath(__DIR__ . '/ZipService.php'),
//         realpath(__DIR__ . '/StructureGenerator.php'),
//     ];
    
//     foreach ($files as $file) {
//         $fileName = $file->getRealPath();

//         if (in_array($fileName, $excludeFiles)) {
//             continue;
//         }

//         if ($file->isDir()) {
//             rmdir($file->getRealPath());
//         } else {
//             unlink($file->getRealPath());
//         }
//         // }
//     }
// }