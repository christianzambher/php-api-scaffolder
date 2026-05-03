<?php
require_once '../services/ZipService.php';
require_once '../services/StructureGenerator.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = $_POST;
    $generator = new StructureGenerator();
    $generator->generate($data);

    //Cambiar de acuerdo la necesidad
    $dirRoot = 'api' . $data["nomAPI"];

    $rutaFinal = realpath(__DIR__ . '/../../public/zipfiles');

    if (!$rutaFinal) {
        $rutaFinal = __DIR__ . '/../../public/zipfiles';
        mkdir($rutaFinal, 0777, true);
    }

    // limpiar zips viejos
    foreach (glob($rutaFinal . "/*.zip") as $oldZip) {
        unlink($oldZip);
    }

    $zipService = new ZipService();

    $archivoZip = $dirRoot . ".zip";

    $zipService->create($dirRoot . '/', $archivoZip);

    rename($archivoZip, "$rutaFinal/$archivoZip");

    $scriptPath = $_SERVER['SCRIPT_NAME'];
    $projectRoot = explode('/src/', $scriptPath)[0];
    $downloadUrl = $projectRoot . "/public/zipfiles/" . $archivoZip;

    if (file_exists($rutaFinal)) {
        http_response_code(200);
        echo json_encode(array($downloadUrl, $archivoZip));
    } else {
        http_response_code(404);
        echo "Error, archivo zip no ha sido creado!!";
    }
    exit;
}
http_response_code(404);