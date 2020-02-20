<?php
include "config.php";
include "utils.php";
include('myAfip.php');

//header('content-type: form-data; charset=utf-8');

$method = $_SERVER['REQUEST_METHOD'];
if($method == "OPTIONS") {
    die();
}

$dbConn =  connect($db);
$postdata = file_get_contents("php://input");

// Crear un nuevo comprobante
if (isset($postdata) && !empty($postdata))
{
    $request = json_decode($postdata);
    echo $request->punto_venta;

    $punto_venta        = $request->punto_venta;
    $tipo_factura       = $request->tipo_factura;
    $concepto           = $request->concepto;
    $tipo_documento     = $request->tipo_documento;
    $numero_documento   = $request->numero_documento;
    $importe_gravado    = $request->importe_gravado;
    $importe_exento_iva = $request->importe_exento_iva;
    $importe_iva        = $request->importe_iva;
    $cuit               = $request->cuit;

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
            VALUES ($punto_venta, $tipo_factura, $concepto, $tipo_documento, $numero_documento, $importe_gravado, $importe_exento_iva, $importe_iva, $cuit, $CAE, $vencimiento)";
    
    $statement = $dbConn->prepare($sql);
    bindAllValues($statement, $input);
    $statement->execute();
    $postId = $dbConn->lastInsertId();
    echo 'id: '+ $postId;
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