<?php

include('myAfip.php');


$res = CrearFactura( 1,             // Punto de venta
                     6,             // Tipo de factura 6 = Factura B
                     1,             // Concepto 1 = Productos
                     99,            // Tipo de documento 99 = Consumidor final
                     0,             //Numero de documento
                     100,           // Importe gravado
                     0,             // Importe exento de iva
                     21,            // Importe iva
                     20230173932    // cuit
                    );

/**
 * Mostramos por pantalla los datos de la nueva Factura 
 **/
var_dump(array(
	'cae' => $res['CAE'], //CAE asignado a la Factura
	'vencimiento' => $res['CAEFchVto'] //Fecha de vencimiento del CAE
));
