<script>
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
            for (let item = 0; item < detalleSol.length; item++) {
                element = detalleSol[item];
                cont = item+1;
    
                total=total +parseFloat(element.importe); 
                itemMasUno = item+1;
                

                var fila=   `<tr class="selected" id="fila`+item+`" name="fila` +item+`">               
                                <td style="text-align:center;">              
                                   <input type="text" class="form-control" name="colItem`+item+`" id="colItem`+item+`" value="`+itemMasUno+`" readonly>
                                </td>             
                                <td> 
                                   <input type="text" class="form-control" name="colConcepto`+item+`" id="colConcepto`+item+`" value="`+element.concepto+`" readonly>
                                </td>               
                                <td  style="text-align:right;">
                                   <input type="text" style="text-align:right;" class="form-control" value = "`+number_format(element.importe,2)+`" readonly> 
                                   <input type="hidden" style="text-align:right;" class="form-control" name="colImporte`+item+`" id="colImporte`+item+`" value="`+ (element.importe)+`" readonly>
                                </td>               
                                <td style="text-align:center;">              
                                <input type="text" class="form-control" style="text-align:center;" name="colCodigoPresupuestal`+item+`" id="colCodigoPresupuestal`+item+`" value="`+element.codigoPresupuestal+`" readonly>
                                </td>              
                                <td style="text-align:center;">              
                                    <button type="button" class="btn btn-danger btn-xs" onclick="eliminardetalle(`+item+`);">
                                        <i class="fa fa-times" ></i>               
                                    </button>       
                                    <button type="button" class="btn btn-xs" onclick="editarDetalle(`+item+`);">
                                        <i class="fas fa-pen"></i>            
                                    </button>        
                                </td>               
                            </tr>         `;
    
    
                $('#detalles').append(fila); 
            }
            
            $('#totalMostrado').val(number_format(total,2));
            $('#total').val(total);
            
            
            $('#cantElementos').val(cont);
            $('#item').val(cont+1);
            
          
            //alerta('se termino de actualizar la tabla con cont='+cont);
}
    
var codPresupProyecto = -1;
function actualizarCodPresupProyecto(){
    codProyecto = $('#ComboBoxProyecto').val();
    $.get('/obtenerCodigoPresupuestalDeProyecto/'+codProyecto, 
        function(data)
        {   
            codPresupProyecto = data.substring(0,2); //Pa agarrarle solo los 2 digitos
            console.log('Se ha actualizado el codPresupuestal del proyecto:[' +codPresupProyecto+"]" );
            document.getElementById('codigoPresupuestal').placeholder = codPresupProyecto+"...";
        }
        );

}

function editarDetalle(index){
    $('#concepto').val( detalleSol[index].concepto );
    $('#importe').val( detalleSol[index].importe );
    $('#codigoPresupuestal').val( detalleSol[index].codigoPresupuestal );
    
    eliminardetalle(index);
}
        
function agregarDetalle(){
    msjError="";
    // VALIDAMOS 
    concepto=$("#concepto").val();    
    if(concepto==''){ 
        msjError=("Por favor ingrese el concepto");  
    }else if(concepto.length>{{App\Configuracion::tamañoMaximoConcepto}} ){
        msjError=("La longitud del concepto tiene que ser maximo de {{App\Configuracion::tamañoMaximoConcepto}} caracteres");  
    }


    codigoPresupuestal=$("#codigoPresupuestal").val();   

    console.log('codigoPresupuestal=/'+ codigoPresupuestal +'/ codPresupProyecto=/'+codPresupProyecto + "/");
    console.log('startsWith : ' + codigoPresupuestal.startsWith(codPresupProyecto))
    
    if(!codigoPresupuestal.startsWith(codPresupProyecto) )
        msjError="El código presupuestal debe coincidir con el código del proyecto [" +  codPresupProyecto + "]";



    importe=$("#importe").val();    
    if (!(importe>0)) 
    {
        msjError=("Por favor ingrese un importe válido.");    
        
    }    
    
    if(codigoPresupuestal==''){ 
        msjError=("Por favor ingrese el codigo presupuestal");  
    }else if(codigoPresupuestal.length>{{App\Configuracion::tamañoMaximoCodigoPresupuestal}} ){
        msjError=("La longitud del codigo presupuestal tiene que ser maximo de {{App\Configuracion::tamañoMaximoCodigoPresupuestal}} caracteres");  
    }

    if (importe==0)
    {
        msjError=("Por favor ingrese importe");    
        
    }  

    if( $('#ComboBoxProyecto').val()=='-1' )
        msjError="Debe seleccionar un proyecto antes de añadir items.";

    if(msjError!=""){
        alerta(msjError);
        return false;
    }


    // FIN DE VALIDACIONES

        item = cont+1;   
        detalleSol.push({
            item:item,
            concepto:concepto,
            importe:importe,            
            codigoPresupuestal:codigoPresupuestal
        });        
        cont++;
    actualizarTabla();
    //ACTUALIZAMOS LOS VALORES MOSTRADOS TOTALES    
    //$('#total').val(number_format(total,2)); //TOTAL INCLUIDO IGV
    $('#concepto').val('');
    $('#importe').val('');
    $('#codigoPresupuestal').val('');
    
}


/* Eliminar productos */
function eliminardetalle(index){
    //removemos 1 elemento desde la posicion index
    detalleSol.splice(index,1);
    console.log('BORRANDO LA FILA' + index);
    actualizarTabla();

}

</script>