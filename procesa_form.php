<?php
require_once("conexion.php");

//Controlo que se este realizando un request a traves del metodo POST
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    //Obtengo los datos que vienen en el body del request
    $body_str  = file_get_contents("php://input");
    //Decodifico los datos para obtener un objeto JSON
    $datos     = json_decode($body_str, true);

    //Instancio la clase para la conexion a la BD
    $pdo = new Conexion;
    //Realizo la conexion
    $con = $pdo->conectar();
    //Preparo la sentencia para verificar si ya existe el DNI en la BD
    $stmt = $con->prepare("SELECT count(*) FROM contactos WHERE DNI = ?");
    //Ejecuto la sentencia y obtengo la cantidad de registros encontrados con el DNI cargado en el formulario
    $stmt->execute([$datos['dni']]);
    $count = $stmt->fetchColumn();


    if($count > 0){ //Si existe al menos un registro con ese DNI, devuelvo un error
        echo "ERR";
    }
    else{ //Si no existe, entonces lo inserto

        try{
            //Armo un array con los datos
            $data = [
                $datos['nombre'],
                $datos['apellido'],
                $datos['email'],
                $datos['dni'],
                $datos['mensaje']
            ];
            //Preparo la sentencia para insertar el registro
            $sql = "INSERT INTO contactos (nombre, apellido, email, dni, mensaje) VALUES (?,?,?,?,?)";
            $stmt = $con->prepare($sql);
            //Ejecuto la sentencia, pasando el array con los datos, y devuelvo OK si no hay ningun error
            $stmt->execute($data);
            echo "OK";
        } catch(PDOException $e) {
            //Si se produce un error, devuelvo el mensaje
            echo $e->getMessage();
        }

    }

}

?>