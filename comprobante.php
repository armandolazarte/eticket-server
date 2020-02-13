
<?php
include "config.php";
include "utils.php";
include('myAfip.php');

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
//header('content-type: application/json; charset=utf-8');
header('content-type: form-data; charset=utf-8');

$dbConn =  connect($db);

// Crear un nuevo comprobante
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $punto_venta        = $_POST['punto_venta'];
    $tipo_factura       = $_POST['tipo_factura'];
    $concepto           = $_POST['concepto'];
    $tipo_documento     = $_POST['tipo_documento'];
    $numero_documento   = $_POST['numero_documento'];
    $importe_gravado    = $_POST['importe_gravado'];
    $importe_exento_iva = $_POST['importe_exento_iva'];
    $importe_iva        = $_POST['importe_iva'];
    $cuit               = $_POST['cuit'];

    $res = CrearFactura( $punto_venta,              // Punto de venta
                         $tipo_factura,             // Tipo de factura 6 = Factura B
                         $concepto,                 // Concepto 1 = Productos
                         $tipo_documento,           // Tipo de documento 99 = Consumidor final
                         $numero_documento,         // Numero de documento
                         $importe_gravado,          // Importe gravado
                         $importe_exento_iva,       // Importe exento de iva
                         $importe_iva,              // Importe iva
                         $cuit                      // cuit
                    );
    
    $CAE = $res['CAE'];
    $vencimiento = $res['CAEFchVto'];

    $input = $_POST;
    $sql = "INSERT INTO comprobante ( punto_venta, tipo_factura, concepto, tipo_documento, numero_documento, importe_gravado, importe_exento_iva, importe_iva, cuit, CAE, vencimiento )
            VALUES (:punto_venta, :tipo_factura, :concepto, :tipo_documento, :numero_documento, :importe_gravado, :importe_exento_iva, :importe_iva, :cuit, $CAE, $vencimiento)";
    
    $statement = $dbConn->prepare($sql);
    bindAllValues($statement, $input);
    $statement->execute();
    $postId = $dbConn->lastInsertId();
    if($postId)
    {
      $input['id'] = $postId;
      header("HTTP/1.1 200 OK");
      echo json_encode($input);
      exit();
   }
}

//En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Bad Request");
?>