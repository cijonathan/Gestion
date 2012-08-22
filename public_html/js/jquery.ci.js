$(document).ready(function(){
    /* LOGIN */
    $('#login').validate({       
        errorPlacement: function(){
            return true;
        }
    });
    /* FORMULARIO */
    $('#formulario').validate({       
        errorPlacement: function(){ return false; },
        highlight: function(element, errorClass){ $(element).parent().parent().addClass('error'); },
        unhighlight: function(element, errorClass){ $(element).parent().parent().removeClass('error'); }
    });   
    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy',
        weekStart: 1,        
    });

    $('.datepicker_valida').datepicker({
        format: 'dd-mm-yyyy',
        weekStart: 1
    }).on('changeDate', function(ev){        
        
         var fecha = new Date();        
        var fecha_actual = fecha.getTime();        
        if (ev.date.valueOf() < fecha_actual){            
            
            alert('La Fecha seleccionada debe ser mayor a la fecha actual.');            
            $('.datepicker_valida').datepicker('hide'); 
            $(this).val(getFechaHoy());                                      
            //
        }
        
      });

    

    $('.timepicker-default').timepicker({
        minuteStep: 5
    });
    

    //NUEVO BRIEF -----------------------------------    
    //muestra u oculta las subareas del area seleccionada
    $('.chk_area').click(function(){
        var value = $(this).val();
        if($(this).is(':checked'))
        {
            $('.subarea_'+value).each(function(){
                $(this).removeAttr('disabled');      
            })
        }
        else
        {
            $('.subarea_'+value).each(function(){
                $(this).removeAttr('checked');
                $(this).attr('disabled', 'disabled');             
            })
        }
    })

    //valida que a lo menos un area esté seleccionada
    var num_areas;
    $('.addBrief').click(function(){
        num_areas = 0;
        $('.chk_area').each(function(){
            if($(this).is(':checked'))
                num_areas++;
        })
        if(num_areas > 0)
            return true;
        alert('Debe asignar a lo menos un área.');
        return false;
    })

    //-----------------------------------------------

});

function getFechaHoy()
{
    var fecha = new Date();
    var dia = fecha.getDate();
    var mes = fecha.getMonth() + 1;   
    var anio = fecha.getFullYear();    
    if(dia.toString().length == 1)
        dia = "0"+dia;
    if(mes.toString().length == 1)
        mes = "0"+mes;
    return dia+"-"+mes+"-"+anio;
}