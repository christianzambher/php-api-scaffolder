<?php
require_once '../services/ZipService.php';
require_once '../services/StructureGenerator.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = $_POST;
    $generator = new StructureGenerator();
    $generator->generate($data);
    
    //Cambiar de acuerdo la necesidad
    $nombreModulo = $_POST["nomModulo"];

    //Cambiar de acuerdo la necesidad
    $dirRoot = 'api' . $_POST["nomAPI"];

    $dir = $dirRoot . '/';

    $rutaFinal = "zipfiles";

    if (!file_exists($rutaFinal)) {
        mkdir($rutaFinal);
    }

    $zipService = new ZipService();

    $archivoZip = $dirRoot . ".zip";

    $zipService->create($dirRoot . '/', $archivoZip);

    rename($archivoZip, "$rutaFinal/$archivoZip");

    $baseUrl = dirname($_SERVER['SCRIPT_NAME']); 
    $downloadUrl = $baseUrl . "/$rutaFinal/$archivoZip";

    if (file_exists($rutaFinal . "/" . $archivoZip)) {
        http_response_code(200);
        echo json_encode(array($downloadUrl, $archivoZip));
    } else {
        http_response_code(404);
        echo "Error, archivo zip no ha sido creado!!";
    }
    exit;
}
http_response_code(404);