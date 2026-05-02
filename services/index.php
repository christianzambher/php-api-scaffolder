<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Cambiar de acuerdo la necesidad
    $nombreModulo = $_POST["nomModulo"];

    //Cambiar de acuerdo la necesidad
    $dirRoot = 'api' . $_POST["nomAPI"];
    if (is_dir($dirRoot) === false) {
        mkdir($dirRoot, 0777);
    }

    //Directorio de Funciones
    $dirFunciones = $dirRoot . '/' . "funciones";
    if (is_dir($dirFunciones) === false) {
        mkdir($dirFunciones, 0777);
    }
    //Archivo funciones.class.php
    $clase = $_POST["nomClase"];
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

    //Cambiar de acuerdo la necesidad, sirve para nombrar al JS y HTML
    $nombreFront = $_POST["nomFront"];

    //Directorio de HTML
    $dirHtml = $dirRoot . '/' . "html";
    if (is_dir($dirHtml) === false) {
        mkdir($dirHtml, 0777);
    }
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
                        ' . $nombreModulo . '
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                    
            </div>
        </div>
    </div>
    </div>
    <script src="' . $dirRoot . '/js/services.js"></script>
    <script src="' . $dirRoot . '/js/' . $nombreFront . '.js"></script>';
    fwrite($fileHtmlDir, $dataHtml);

    //Directorio JS
    $dirJs = $dirRoot . '/' . "js";
    if (is_dir($dirJs) === false) {
        mkdir($dirJs, 0777);
    }
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
        var apiUrl = "' . $dirRoot . '/public/"; //TODO URL de los servicios Web
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

    //Directorio Public
    $dirPublic = $dirRoot . '/' . "public";
    if (is_dir($dirPublic) === false) {
        mkdir($dirPublic, 0777);
    }
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
    $" . "app->setBasePath('/sistema/" . $dirRoot . "/public');
    $" . "app->addRoutingMiddleware();
    $" . "app->addErrorMiddleware(true, true, true);
    require __DIR__ . '/../rutas/rutas.php';
    $" . "app->run();";
    fwrite($fileIndexDir, $dataIndex);

    //Directorio Rutas
    $dirRutas = $dirRoot . '/' . "rutas";
    if (is_dir($dirRutas) === false) {
        mkdir($dirRutas, 0777);
    }
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

    $zip = new ZipArchive();

    $dir = $dirRoot . '/';

    $rutaFinal = "zipfiles";

    if (!file_exists($rutaFinal)) {
        mkdir($rutaFinal);
    }

    $archivoZip = $dirRoot . ".zip";

    if ($zip->open($archivoZip, ZIPARCHIVE::CREATE) === true) {
        agregar_zip($dir, $zip);
        $zip->close();

        rename($archivoZip, "$rutaFinal/$archivoZip");

        if (file_exists($rutaFinal . "/" . $archivoZip)) {
            echo json_encode(array("services/" . $rutaFinal . "/" . $archivoZip, $archivoZip));
            http_response_code(200);
        } else {
            // echo "Error, archivo zip no ha sido creado!!";
            http_response_code(404);
        }
    }

    exit;
}
http_response_code(404);
function agregar_zip($dir, $zip)
{
    //verificamos si $dir es un directorio
    if (is_dir($dir)) {
        //abrimos el directorio y lo asignamos a $da
        if ($da = opendir($dir)) {
            //leemos del directorio hasta que termine
            while (($archivo = readdir($da)) !== false) {
                /*Si es un directorio imprimimos la ruta
           * y llamamos recursivamente esta función
           * para que verifique dentro del nuevo directorio
           * por mas directorios o archivos
           */
                if (is_dir($dir . $archivo) && $archivo != "." && $archivo != "..") {
                    agregar_zip($dir . $archivo . "/", $zip);

                    /*si encuentra un archivo imprimimos la ruta donde se encuentra
             * y agregamos el archivo al zip junto con su ruta 
             */
                } elseif (is_file($dir . $archivo) && $archivo != "." && $archivo != "..") {
                    $zip->addFile($dir . $archivo, $dir . $archivo);
                }
            }
            //cerramos el directorio abierto en el momento
            closedir($da);
        }
    }
}
