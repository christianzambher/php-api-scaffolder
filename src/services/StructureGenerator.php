<?php
require_once __DIR__ . '/TemplateService.php';

class StructureGenerator {

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
        $nombreFront = $data["nomFront"];
        //Directorio HTML
        $dirHtml = $path . '/' . "html";

        //Archivo HTML
        $fileHtml = $nombreFront . ".html";
        $fileHtmlDir = fopen($dirHtml . '/' . $fileHtml, "w");
        $dataHtml = '<div class="row">
        <div class="col-lg-12">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <span class="kt-portlet__head-icon">
                            <i class="flaticon-map-location"></i>
                        </span>
                        <h3 class="kt-portlet__head-title">
                            ' . $data['nomModulo'] . '
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                        
                </div>
            </div>
        </div>
        </div>
        <script src="' . $path . '/js/services.js"></script>
        <script src="' . $path . '/js/' . $nombreFront . '.js"></script>';
        fwrite($fileHtmlDir, $dataHtml);
    }
    private function createJS($path, $data) {
        $nombreFront = $data["nomFront"];
        //Directorio JS
        $dirJs = $path . '/' . "js";
        
        //Archivo JS
        $fileJs = $nombreFront . ".js";
        $fileJsDir = fopen($dirJs . '/' . $fileJs, "w");
        $dataJs = '$(document).ready(function () {

        });

        //#region Eventos

        //#endregion

        //#region Variables
        var servicios = new Servicios(); //TODO Objeto de Servicios
        //#endregion

        //#region Funciones

        //#endregion';
        fwrite($fileJsDir, $dataJs);

        //Archivo Services.js
        $fileServices = "services.js";
        $fileServicesDir = fopen($dirJs . '/' . $fileServices, "w");
        $dataServices = 'var Servicios = function () {
            var apiUrl = "' . $path . '/public/"; //TODO URL de los servicios Web
            var activeAjaxRequests = 0; //TODO Cantidad de Petición de AJAX

            this.fnGet = function(callback){
                if (apiUrl) {
                    $.ajax({
                        url: apiUrl + "Get",
                        beforeSend: function () {
                            activeAjaxRequests++;
                            if (activeAjaxRequests === 1) {
                                Swal.fire({
                                    title: "Por favor, espere",
                                    html: ' . "'" . '<strong>Cargando...</strong>\
                                        <div class="text-center">\
                                            <div class="spinner-border" role="status">\
                                                <span class="sr-only">Loading...</span>\
                                            </div>\
                                        </div>' . "'" . ',
                                    timerProgressBar: true,
                                    allowOutsideClick: false,
                                    showConfirmButton: false
                                });
                            }
                        },
                        complete: function () {
                            activeAjaxRequests--;
                            if (activeAjaxRequests === 0) {
                                swal.close();
                            }
                        },
                        success: function (result, status, xhr) {
                            if (typeof callback == "function") {
                                callback(result, status, xhr);
                            }
                        }, error: function () {
                            swal.close();
                        }
                    });
                }
            }

            this.fnGetById = function(id,callback){
                if (apiUrl) {
                    $.ajax({
                        url: apiUrl + "getById/"+id,
                        beforeSend: function () {
                            activeAjaxRequests++;
                            if (activeAjaxRequests === 1) {
                                Swal.fire({
                                    title: "Por favor, espere",
                                    html: ' . "'" . '<strong>Cargando...</strong>\
                                        <div class="text-center">\
                                            <div class="spinner-border" role="status">\
                                                <span class="sr-only">Loading...</span>\
                                            </div>\
                                        </div>' . "'" . ',
                                    timerProgressBar: true,
                                    allowOutsideClick: false,
                                    showConfirmButton: false
                                });
                            }
                        },
                        complete: function () {
                            activeAjaxRequests--;
                            if (activeAjaxRequests === 0) {
                                swal.close();
                            }
                        },
                        success: function (result, status, xhr) {
                            if (typeof callback == "function") {
                                callback(result, status, xhr);
                            }
                        }, error: function () {
                            swal.close();
                        }
                    });
                }
            }

            this.fnPost = function(data,callback){
                if (apiUrl) {
                    $.ajax({
                        url: apiUrl + "Post",
                        type: "POST",
                        data: { data },
                        beforeSend: function () {
                            activeAjaxRequests++;
                            if (activeAjaxRequests === 1) {
                                Swal.fire({
                                    title: "Por favor, espere",
                                    html: ' . "'" . '<strong>Cargando...</strong>\
                                        <div class="text-center">\
                                            <div class="spinner-border" role="status">\
                                                <span class="sr-only">Loading...</span>\
                                            </div>\
                                        </div>' . "'" . ',
                                    timerProgressBar: true,
                                    allowOutsideClick: false,
                                    showConfirmButton: false
                                });
                            }
                        },
                        complete: function () {
                            activeAjaxRequests--;
                            if (activeAjaxRequests === 0) {
                                swal.close();
                            }
                        },
                        success: function (result, status, xhr) {
                            if (typeof callback == "function") {
                                callback(result, status, xhr);
                            }
                        }, error: function () {
                            swal.close();
                        }
                    });
                }
            }
        }';
        fwrite($fileServicesDir, $dataServices);
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
        //Directorio Public
        $dirPublic = $path . '/' . "public";
        
        //Archivo .HTACCESS
        $fileHtaccess = ".htaccess";
        $fileHtaccessDir = fopen($dirPublic . '/' . $fileHtaccess, "w");
        $dataHtaccess = "RewriteEngine ON
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule ^ index.php [QSA,L]";
        fwrite($fileHtaccessDir, $dataHtaccess);
        //Archivo INDEX.PHP
        $fileIndex = "index.php";
        $fileIndexDir = fopen($dirPublic . '/' . $fileIndex, "w");
        $dataIndex = "<?php
        use Slim\Factory\AppFactory;
        
        ini_set('display_errors', 1);
        session_start();
        require __DIR__ . '/../../vendor/autoload.php';
        $" . "app = AppFactory::create();
        $" . "app->setBasePath('/sistema/" . $path . "/public');
        $" . "app->addRoutingMiddleware();
        $" . "app->addErrorMiddleware(true, true, true);
        require __DIR__ . '/../rutas/rutas.php';
        $" . "app->run();";
        fwrite($fileIndexDir, $dataIndex);
    }
}