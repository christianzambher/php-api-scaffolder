<?php
ini_set('display_errors', 1);
require __DIR__ . '/../../model/connection/connection.class.php';

class {{ClassName}} extends Conexion {

    /**
     * conexionSQL
     * @var mixed
    */
    private $conexionSQL;
    private $stmnt;

    function get(){}
    function getById($id){}
    function post($data){}

    /**
     * Ejecuta una consulta en Base de datos (select,insert, update o delete)
     * @param int $" . "Cadena que contiene la consula a ejecutar
     * @param array $" . "Parametros array asociativo para pasar atributos a la cadena en consulta preparada
     * @param int $" . "id 1 o 0 dependiendo si requieres el ultimo id insertado de la consulta a ejecutar
     * @param int opcional $" . "respuesta parametro para indicar si debuelve o no un resultset
    */
    function ejecutarConsulta($consulta, $parametros, $id, $respuesta = null)
    {
        try {
            $this->conexionSQL = Conexion::getInstance()->obtenerConexion();
            $this->stmnt = $this->conexionSQL->prepare($consulta);

            if (sizeof($parametros) > 0) {
                foreach ($parametros as $indice => $valor):
                    $this->stmnt->bindValue(':' . $indice, $valor);
                endforeach;
            }

            $this->stmnt->execute();

            if ($id == 1) {
                return $this->conexionSQL->lastInsertId();
            } else {
                if (!is_null($respuesta)) {
                    return $this->stmnt->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    return ['error' => 1, 'mensaje' => 'Operacion exitosa'];
                }
            }

        } catch (PDOException $e) {
            return ['error' => 4, 'mensaje' => 'Error: ' . $e->getMessage()];
        } finally {
            Conexion::getInstance()->cerrarConexion();
            $this->conexionSQL = null;
            $this->stmnt = null;
        }
    }
}