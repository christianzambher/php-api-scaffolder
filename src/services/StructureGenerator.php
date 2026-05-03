<?php
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
        $dirFunciones = $path . '/' . "funciones";

        //Archivo funciones.class.php
        $clase = $data["nomClase"];
        $nombreClase = 'cls' . $clase;

        $fileFunciones = "funciones.class.php";
        $fileFuncionesDir = fopen($dirFunciones . '/' . $fileFunciones, "w");

        $dataFunciones = "<?php
        ini_set('display_errors', 1);
        require __DIR__ . '/../../model/connection/connection.class.php';

        class " . $nombreClase . " extends Conexion{
        /**
         * conexionSQL
         * @var mixed
         */
        private $" . "conexionSQL;
        private $" . "stmnt;

        function get(){}
        function getById($" . "id){}
        function post($" . "data){}

        /**
         * Ejecuta una consulta en Base de datos (select,insert, update o delete)
         * @param int $" . "Cadena que contiene la consula a ejecutar
         * @param array $" . "Parametros array asociativo para pasar atributos a la cadena en consulta preparada
         * @param int $" . "id 1 o 0 dependiendo si requieres el ultimo id insertado de la consulta a ejecutar
         * @param int opcional $" . "respuesta parametro para indicar si debuelve o no un resultset
         */
        function ejecutarConsulta($" . "consulta, $" . "parametros, $" . "id, $" . "respuesta = null)
        {
            try {
                $" . "this->conexionSQL = Conexion::getInstance()->obtenerConexion();
                $" . "this->stmnt = $" . "this->conexionSQL->prepare($" . "consulta);
                if (sizeof($" . "parametros) > 0) {

                    foreach ($" . "parametros as $" . "indice => $" . "valor) :
                        $" . "this->stmnt->bindValue(':' . $" . "indice, $" . "valor);

                    endforeach;
                }
                $" . "this->stmnt->execute();
                if ($" . "id == 1) {
                    return $" . "this->conexionSQL->lastInsertId();
                } else {
                    if (!is_null($" . "respuesta)) {
                        $" . "resultado = $" . "this->stmnt->fetchAll(PDO::FETCH_ASSOC);
                        return $" . "resultado;
                    } else {
                        $" . "resultado = array('error' => 1, 'mensaje' => 'Operacion exitosa');
                        return $" . "resultado;
                    }
                }
            } catch (PDOException $" . "e) {
                $" . "resultado = array('error' => 4, 'mensaje' => 'Error al ejecutar consulta, error:' . $" . "e->getMessage());
                return $" . "resultado;
            } finally {
                Conexion::getInstance()->cerrarConexion();
                $" . "this->conexionSQL = null;
                $" . "this->stmnt = null;
            }
        }
        }";
        fwrite($fileFuncionesDir, $dataFunciones);
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
        //Directorio Rutas
        $dirRutas = $path . '/' . "rutas";

        //Nombre de la Clase
        $clase = $data["nomClase"];
        $nombreClase = 'cls' . $clase;
        
        //Archivo Rutas
        $fileRutas = "rutas.php";
        $fileRutasDir = fopen($dirRutas . '/' . $fileRutas, "w");
        $dataRutas = '<?php
        ini_set("display_errors", 1);
        require __DIR__ . "/../funciones/funciones.class.php";
        
        $obj' . $clase . ' = new ' . $nombreClase . '();    
        
        $app->get("/get", function ($request, $response, $args) use ($obj' . $clase . ') {
            $resultado = $obj' . $clase . '->get();
            $response->getBody()->write((string)json_encode($resultado));
            $response = $response->withHeader("Content-Type", "application/json");
            return $response;
        });

        $app->get("/getById/{id}", function ($request, $response, $args) use ($obj' . $clase . ') {
            $id = $args["id"];
            $response->getBody()->write((string)json_encode($obj' . $clase . '->getById($id)));
            $response = $response->withHeader("Content-Type", "application/json");
            return $response;
        });

        $app->post("/post", function ($request, $response, $args) use ($obj' . $clase . ') {
            $data = $request->getParsedBody()["data"];
            $response->getBody()->write((string)json_encode($obj' . $clase . '->post($data)));
            $response = $response->withHeader("Content-Type", "application/json");
            return $response;
        });
        ';
        fwrite($fileRutasDir, $dataRutas);
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