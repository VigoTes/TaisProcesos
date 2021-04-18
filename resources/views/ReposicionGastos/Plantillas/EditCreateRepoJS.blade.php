
<style>
    
    .hovered:hover{
        background-color:rgb(97, 170, 170);

    }
</style>

<script>





var codPresupProyecto = -1;
function actualizarCodPresupProyecto(){
    codProyecto = $('#codProyecto').val();
    $.get('/obtenerCodigoPresupuestalDeProyecto/'+codProyecto, 
        function(data)
        {   
            codPresupProyecto = data.substring(0,2); //Pa agarrarle solo los 2 digitos
            console.log('Se ha actualizado el codPresupuestal del proyecto:[' +codPresupProyecto+"]" );

            document.getElementById('codigoPresupuestal').placeholder = codPresupProyecto+"...";
        }
        );

}



function agregarDetalle(){


    // VALIDAMOS
    msjError = "";
    fecha = $("#fechaComprobante").val();    
    if (fecha=='') 
        msjError="Por favor ingrese la fecha del comprobante del gasto.";    
        
    
    tipo = $("#ComboBoxCDP").val();    
    if (tipo==-1) 
        msjError="Por favor ingrese el tipo de comprobante del gasto.";    
        

    ncbte= $("#ncbte").val();   
    if (ncbte==''){
        msjError=("Por favor ingrese el numero del comprobante del gasto.");    
    }else if(ncbte.length>{{App\Configuracion::tamañoMaximoNroComprobante}} ){
        msjError=("La longitud del CPD tiene que ser maximo de {{App\Configuracion::tamañoMaximoNroComprobante}} caracteres");  
    }  

        
    concepto=$("#concepto").val();    
    if(concepto==''){ 
        msjError=("Por favor ingrese el concepto");  
    }else if(concepto.length>{{App\Configuracion::tamañoMaximoConcepto}} ){
        msjError=("La longitud del concepto tiene que ser maximo de {{App\Configuracion::tamañoMaximoConcepto}} caracteres");  
    }
        

    codProyecto = $('#codProyecto').val().innerHTML;


    importe=$("#importe").val();    
    if (!(importe>0)) 
        msjError="Por favor ingrese un importe válido.";    
        

    codigoPresupuestal=$("#codigoPresupuestal").val();     //el que agregó el user
    if(codigoPresupuestal==''){ 
        msjError=("Por favor ingrese el codigo presupuestal");  
    }else if(codigoPresupuestal.length>{{App\Configuracion::tamañoMaximoCodigoPresupuestal}} ){
        msjError=("La longitud del codigo presupuestal tiene que ser maximo de {{App\Configuracion::tamañoMaximoCodigoPresupuestal}} caracteres");  
    } 
    
    if (importe==0)
        msjError="Por favor ingrese importe";    

    console.log('codigoPresupuestal=/'+ codigoPresupuestal +'/ codPresupProyecto=/'+codPresupProyecto + "/");
    console.log('startsWith : ' + codigoPresupuestal.startsWith(codPresupProyecto))

    if(!codigoPresupuestal.startsWith(codPresupProyecto) )
        msjError="El código presupuestal debe coincidir con el código del proyecto [" +  codPresupProyecto + "]";



    if( codPresupProyecto == -1  )
        msjError="Por favor seleccione un proyecto antes de añadir Items.";    
    

    if(msjError!=""){
        //alerta(msjError);
        alerta(msjError);
        return false;
    }

    // FIN DE VALIDACIONES

    detalleRepo.push({
        fecha:fecha,
        tipo:tipo,
        ncbte,ncbte,
        concepto:concepto,
        importe:importe,            
        codigoPresupuestal:codigoPresupuestal
    });        
    cont++;
    actualizarTabla();

    $('#fechaComprobante').val("");
    $('#ComboBoxCDP').val(0);
    $('#ncbte').val('');

    $('#concepto').val('');
    $('#importe').val('');
    $('#codigoPresupuestal').val('');
}

function editarDetalle(index){

    $('#fechaComprobante').val( detalleRepo[index].fecha );
    $('#ComboBoxCDP').val( detalleRepo[index].tipo );
    $('#ncbte').val( detalleRepo[index].ncbte );
    $('#concepto').val( detalleRepo[index].concepto );
    $('#importe').val( detalleRepo[index].importe );
    $('#codigoPresupuestal').val( detalleRepo[index].codigoPresupuestal );


    eliminardetalle(index);
}



/* Eliminar productos */
function eliminardetalle(index){
    detalleRepo.splice(index,1);
    console.log('BORRANDO LA FILA' + index);
    actualizarTabla();

}



function actualizarTabla(){
    //funcion para poner el contenido de detallesVenta en la tabla
    //tambien actualiza el total
    //$('#detalles')
    total=0;
    //vaciamos la tabla
    for (let index = 100; index >=0; index--) {
        $('#fila'+index).remove();
        //console.log('borrando index='+index);
    }
    
    //insertamos en la tabla los nuevos elementos
    for (let item = 0; item < detalleRepo.length; item++) {
        element = detalleRepo[item];
        cont = item+1;

        total=total +parseFloat(element.importe); 

        //importes.push(importe);
        //item = getUltimoIndex();
        var fila= `  <tr class="selected" id="fila`+item+`" name="fila` +item+`">          
                        <td style="text-align:center;">               
                            <input type="text" class="form-control" name="colFecha`+item+`" id="colFecha`+item+`" value="`+element.fecha+`" readonly>
                        </td>             
                    
                        <td style="text-align:center;">            
                            <input type="text" class="form-control" name="colTipo`+item+`" id="colTipo`+item+`" value="`+element.tipo+`" readonly>
                        </td>              
                        <td style="text-align:center;">               
                            <input type="text" class="form-control" name="colComprobante`+item+`" id="colComprobante`+item+`" value="`+element.ncbte+`" readonly>
                        </td>             
                        <td>

                            <input type="text" class="form-control" name="colConcepto`+item+`" id="colConcepto`+item+`" value="`+element.concepto+`" readonly>
                        </td>              
                    
                    

                        <td  style="text-align:right;">              
                            <input type="text" class="form-control" style="text-align:right" value="`+number_format(element.importe,2)+`" readonly>
                            <input type="hidden" class="form-control" name="colImporte`+item+`" id="colImporte`+item+`" value="`+(element.importe)+`" readonly>
                        </td>              
                        <td style="text-align:center;">              
                        <input type="text" class="form-control" name="colCodigoPresupuestal`+item+`" id="colCodigoPresupuestal`+item+`" value="`+element.codigoPresupuestal+`" readonly>
                        </td>              
                        <td style="text-align:center;">              
                            <button type="button" class="btn btn-danger btn-xs" onclick="eliminardetalle(`+item+`);">
                                <i class="fa fa-times" ></i>              
                            </button>             
                            <button type="button" class="btn btn-xs" onclick="editarDetalle(`+item+`);">
                                <i class="fas fa-pen"></i>            
                            </button> 
                            
                        </td>               
                    


                    </tr>                 `;


        $('#detalles').append(fila); 
    }

    $('#total').val(number_format(total,2));
    $('#cantElementos').val(cont);
    
}



var listaArchivos = '';
    
//se ejecuta cada vez que escogewmos un file
function cambio(){
    msjError = validarPesoArchivos();
    if(msjError!=""){
        alerta(msjError);
        return;
    }

    listaArchivos="";
    cantidadArchivos = document.getElementById('filenames').files.length;

    console.log('----- Cant archivos seleccionados:' + cantidadArchivos);
    for (let index = 0; index < cantidadArchivos; index++) {
        nombreAr = document.getElementById('filenames').files[index].name;
        console.log('Archivo ' + index + ': '+ nombreAr);
        listaArchivos = listaArchivos +', '+  nombreAr; 
    }
    listaArchivos = listaArchivos.slice(1, listaArchivos.length);
    document.getElementById("divFileImagenEnvio").innerHTML= listaArchivos;
    $('#nombresArchivos').val(listaArchivos);
}
        
function validarPesoArchivos(){
    cantidadArchivos = document.getElementById('filenames').files.length;
    
    msj="";
    for (let index = 0; index < cantidadArchivos; index++) {
        var imgsize = document.getElementById('filenames').files[index].size;
        nombre = document.getElementById('filenames').files[index].name;
        if(imgsize > {{App\Configuracion::pesoMaximoArchivoMB}}*1000*1000 ){
            msj=('El archivo '+nombre+' supera los  {{App\Configuracion::pesoMaximoArchivoMB}}Mb, porfavor ingrese uno más liviano o comprima.');
        }
    }
    

    return msj;

}

</script>
