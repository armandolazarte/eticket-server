<?php

include('./src/Afip.php');

function CrearFactura( $punto_de_venta,
    
                       $tipo_de_factura,
    
                       $concepto,
                      
                       $tipo_de_documento,
                    
                       $numero_de_documento,
                    
                       $importe_gravado,
                    
                       $importe_exento_iva,
                    
                       $importe_iva,
                       
                       $cuit

    ){
        
        $afip = new Afip(array('CUIT' => $cuit));

        /**
         * Número de la ultima Factura B
         **/
        $last_voucher = $afip->ElectronicBilling->GetLastVoucher($punto_de_venta, $tipo_de_factura);

        $numero_de_factura = $last_voucher+1;


        /**
         * Fecha de la factura en formato aaaa-mm-dd (hasta 10 dias antes y 10 dias despues)
         **/
        $fecha = date('Y-m-d');

        /**
         * Los siguientes campos solo son obligatorios para los conceptos 2 y 3
         **/
        if ($concepto === 2 || $concepto === 3) {
            /**
             * Fecha de inicio de servicio en formato aaaammdd
             **/
            $fecha_servicio_desde = intval(date('Ymd'));

            /**
             * Fecha de fin de servicio en formato aaaammdd
             **/
            $fecha_servicio_hasta = intval(date('Ymd'));

            /**
             * Fecha de vencimiento del pago en formato aaaammdd
             **/
            $fecha_vencimiento_pago = intval(date('Ymd'));
        }
        else {
            $fecha_servicio_desde = null;
            $fecha_servicio_hasta = null;
            $fecha_vencimiento_pago = null;
        }   
    
        $data = array(
            'CantReg' 	=> 1, // Cantidad de facturas a registrar
            'PtoVta' 	=> $punto_de_venta,
            'CbteTipo' 	=> $tipo_de_factura, 
            'Concepto' 	=> $concepto,
            'DocTipo' 	=> $tipo_de_documento,
            'DocNro' 	=> $numero_de_documento,
            'CbteDesde' => $numero_de_factura,
            'CbteHasta' => $numero_de_factura,
            'CbteFch' 	=> intval(str_replace('-', '', $fecha)),
            'FchServDesde'  => $fecha_servicio_desde,
            'FchServHasta'  => $fecha_servicio_hasta,
            'FchVtoPago'    => $fecha_vencimiento_pago,
            'ImpTotal' 	=> $importe_gravado + $importe_iva + $importe_exento_iva,
            'ImpTotConc'=> 0, // Importe neto no gravado
            'ImpNeto' 	=> $importe_gravado,
            'ImpOpEx' 	=> $importe_exento_iva,
            'ImpIVA' 	=> $importe_iva,
            'ImpTrib' 	=> 0, //Importe total de tributos
            'MonId' 	=> 'PES', //Tipo de moneda usada en la factura ('PES' = pesos argentinos) 
            'MonCotiz' 	=> 1, // Cotización de la moneda usada (1 para pesos argentinos)  
            'Iva' 		=> array(// Alícuotas asociadas al factura
                array(
                    'Id' 		=> 5, // Id del tipo de IVA (5 = 21%)
                    'BaseImp' 	=> $importe_gravado,
                    'Importe' 	=> $importe_iva 
                )
            ), 
        );
        
    /** 
     * Creamos la Factura 
     **/
    return $afip->ElectronicBilling->CreateVoucher($data);    

    }



