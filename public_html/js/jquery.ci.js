$(document).ready(function(){
    /* LOGIN */
    $('#login').validate({       
        errorPlacement: function(){
            return true;
        }
    });
    /* FORMULARIO */
    $('#formulario').validate({       
        errorPlacement: function(){
            return true;
        }
    });   
    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy',
        weekStart: 1
    });
});