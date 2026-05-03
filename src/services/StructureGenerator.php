<?php
require_once __DIR__ . '/TemplateService.php';

class StructureGenerator {
    
    /**
     * Generates the directory structure and files for the API based on the provided data.
     * @param  array $data Associative array containing the necessary information to generate the structure (e.g., API name, class name, etc.)
     * @return void
     */
    public function generate($data) {
        $dirRoot = 'api' . $data["nomAPI"];

        $this->createDir($dirRoot);
        $this->createDir("$dirRoot/funciones");
        $this->createDir("$dirRoot/html");
        $this->createDir("$dirRoot/js");
        $this->createDir("$dirRoot/public");
        $this->createDir("$dirRoot/rutas");

        $this->createFunciones($dirRoot, $data);
        $this->createHtml($dirRoot, $data);
        $this->createJS($dirRoot, $data);
        $this->createRoutes($dirRoot, $data);
        $this->createPublic($dirRoot, $data);
    }    
    /**
     * Creates a directory if it does not already exist.
     * @param  string $path Directory path to create
     * @return void
     */
    private function createDir($path) {
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
    }
    private function createFunciones($path, $data) {
        $templateService = new TemplateService();

        //Directorio Funciones
        $dirFunciones = $path . '/' . "funciones";

        //Nombre de la Clase
        $clase = $data["nomClase"];
        $nombreClase = 'cls' . $clase;

        //Archivo Funciones
        $contenido = $templateService->render(
            __DIR__ . '/../templates/funciones.tpl.php',
            [
                'ClassName' => $nombreClase
            ]
        );
        file_put_contents($dirFunciones . '/funciones.class.php', $contenido);
    }
    private function createHtml($path, $data) {
        $templateService = new TemplateService();

        $nombreFront = $data["nomFront"];

        //Directorio HTML
        $dirHtml = $path . '/' . "html";

        $contenido = $templateService->render(
            __DIR__ . '/../templates/html.tpl.php',
            [
                'ModuleName' => $data['nomModulo'],
                'FrontName' => $nombreFront,
                'Path' => $path
            ]
        );

        file_put_contents("$dirHtml/$nombreFront.html", $contenido);
    }
    private function createJS($path, $data) {
        $templateService = new TemplateService();

        $nombreFront = $data["nomFront"];
        //Directorio JS
        $dirJs = $path . '/' . "js";
        
        //Archivo JS
        $contenidoJs = $templateService->render(
            __DIR__ . '/../templates/js.tpl.php'
        );

        file_put_contents("$dirJs/$nombreFront.js", $contenidoJs);

        //Archivo Services.js
        $contenidoServices = $templateService->render(
            __DIR__ . '/../templates/services.tpl.php',
            [
                'ApiPath' => $path
            ]
        );

        file_put_contents("$dirJs/services.js", $contenidoServices);
    }
    private function createRoutes($path, $data) {
        $templateService = new TemplateService();

        //Directorio Rutas
        $dirRutas = $path . '/' . "rutas";

        //Nombre de la Clase
        $clase = $data["nomClase"];
        $nombreClase = 'cls' . $clase;
        
        //Archivo Rutas
        $contenido = $templateService->render(
            __DIR__ . '/../templates/rutas.tpl.php',
            [
                'Class' => $clase,
                'ClassName' => $nombreClase
            ]
        );

        file_put_contents($dirRutas . '/rutas.php', $contenido);
    }
    private function createPublic($path, $data) {
        $templateService = new TemplateService();

        //Directorio Public
        $dirPublic = $path . '/' . "public";
        
        //Archivo .HTACCESS
        $contenidoHtaccess = $templateService->render(
            __DIR__ . '/../templates/htaccess.tpl.php'
        );

        file_put_contents("$dirPublic/.htaccess", $contenidoHtaccess);
        
        //Archivo INDEX.PHP
        $pathRoot = isset($data['nomDirPadre']) ? ('/' . $data['nomDirPadre'] . '/') : '';
        $basePath = $pathRoot . $path . '/public';

        $contenidoIndex = $templateService->render(
            __DIR__ . '/../templates/public_index.tpl.php',
            [
                'BasePath' => $basePath
            ]
        );

        file_put_contents("$dirPublic/index.php", $contenidoIndex);
    }
}