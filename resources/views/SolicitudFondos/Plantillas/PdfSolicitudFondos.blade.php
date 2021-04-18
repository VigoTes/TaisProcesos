<!DOCTYPE html>
<html lang="en">
<head>

    <title>Solicitud de Fondos {{$solicitud->codigoCedepas}}</title>
    <meta charset="UTF-8">
    
    {{-- <link rel="stylesheet" 
            href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" 
            integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
            crossorigin="anonymous">
     --}}

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        html {
            /* Arriba | Derecha | Abajo | Izquierda */
            margin: 50pt 60pt 50pt 69pt;
            font-family: Candara, Calibri, Segoe, "Segoe UI", Optima, Arial, sans-serif;
        }
        #principal { 
            /*background-color: rgb(161, 51, 51);*/
            word-wrap: break-word;/* para que el texto no salga del div*/
        }
        thead {
            font-size: large;
        }
        tbody{
            font-size: 13px;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 3px;  
        }
    </style>
    
</head>
<body>
    <div id="principal" style="width: 635px; height: 750px">
        <table style="width:100%">
            <thead style="width:100%">
                <tr>
                    <th style="height: 70px;  " colspan="2">
                        <div style="height: 5px"></div>
                        
                        <img src="{{App\Configuracion::getRutaImagenCedepasPNG()}}" height="100%">
                    </th>
                    <th style="text-align: center" colspan="2">N° {{$solicitud->codigoCedepas}}</th>
                </tr>
                <tr>
                    <th colspan="4" style="text-align: center; background-color: rgb(0, 102, 205); color: white">SOLICITUD DE FONDOS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="width: 170px; font-weight: bold;">Proyecto:</td>
                    <td colspan="3">{{$solicitud->getNombreProyecto()}}</td>
                </tr>
                
                <tr>
                    <td style="font-weight: bold;">Fecha:</td>
                    <td colspan="3">{{$solicitud->getFechaHoraEmision()}}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Código del/a Colaborador/a:</td>
                    <td colspan="3">{{$solicitud->getEmpleadoSolicitante()->codigoCedepas}}</td>
                </tr>
            </tbody>

        </table>
        <div style="width: 100%; height: 8px;"></div>
        <table style="width:100%">
            <tbody style="width:100%">
                <tr style="font-weight: bold">
                    <td style="width: 40px; text-align: center;">Ítem</td>
                    <td style="text-align: center;">Concepto</td>
                    <td style="width: 80px; text-align: center;">Importe {{$solicitud->getMoneda()->simbolo}}</td>
                    <td style="width: 90px; text-align: center;">Código Presupuestal</td>
                </tr>

                @foreach($listaItems as $item)
                    <tr>
                        <td style="text-align: center"> {{$item->nroItem}} </td>
                        <td>{{$item->concepto}}</td>
                        <td style="text-align: right">{{number_format($item->importe,2)}}</td>
                        <td>{{$item->codigoPresupuestal}}</td>
                    </tr>
                @endforeach

                
                
                
                
                <tr>
                    <td colspan="2" style="text-align: center">Son : {{$solicitud->escribirTotalSolicitado()}}  {{$solicitud->getMoneda()->nombre}}</td>
                    
                    <td style="text-align: right">{{$solicitud->getMoneda()->simbolo}} {{number_format($solicitud->totalSolicitado,2)}}</td>
                    <td></td>
                </tr>



            </tbody>
        </table>
        <div style="width: 100%; height: 8px;"></div>
        <table style="width:100%">
            <tbody style="width:100%">
                <tr>
                    <td style="width: 120px;">Girar a la orden de:</td>
                    <td>{{$solicitud->girarAOrdenDe}}</td>
                </tr>
                
                <tr>
                    <td>Cuenta N°:</td>
                    <td>{{$solicitud->numeroCuentaBanco}}</td>
                </tr>
                <tr>
                    <td>Banco:</td>
                    <td>{{$solicitud->getNombreBanco()}}</td>
                </tr>
            </tbody>
        </table>
        <div style="width: 100%; height: 8px;"></div>
        <table style="width:100%">
            <tbody style="width:100%">
                <tr>
                    <td style="width: 110px; font-weight: bold;">JUSTIFICACIÓN
                        DE LA
                        SOLICITUD:</td>
                    <td >{{$solicitud->justificacion}}</td>
                </tr>
            </tbody>
        </table>

        <div style="width: 100%; height: 70px;"></div>

        <!--FIRMAS-->
        <div style="width: 33%; height: 30px; float: left;">
            <p style="text-align: center; font-size: 13px;"><b>
                {{$solicitud->getEmpleadoSolicitante()->getNombreCompleto()}}
                _________________________<br>
                SOLICITADO POR<br>
                
            </b></p>
        </div>
        <div style="width: 33%; height: 30px; float: left;">
            <p style="text-align: center; font-size: 13px;"><b>
                {{$solicitud->getNombreEvaluador()}}
                ___________________________<br>
                V°B° GERENTE DE PROYECTO
            </b></p>
        </div>
        <div style="width: 33%; height: 30px; float: left;">
            <p style="text-align: center; font-size: 13px;"><b>
                <br>
                _________________________<br>
                V°B° DIRECCIÓN
            </b></p>
        </div>

    </div>
</body>

</html>