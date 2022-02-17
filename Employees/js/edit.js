
$(document).ready(function () {
    load_cuadrilla($("#id_cuadrilla").val(), "cuadrilla_emp")

    var saliario = parseFloat($("#salario_diario").val())/8;
    $("#salariohora").val(saliario);

    $('#formEmployees').submit(function (e) {
        e.preventDefault();
        $(document).skylo('start');
        setTimeout(function () {
            $(document).skylo('set', 50);
        }, 150);
        var formData = $("#formEmployees").serializeArray();
        $.ajax({
            data: formData,
            type: 'POST',
            dataType: 'json',
            url: 'index.php?event=110',
            beforeSend: function () {
                $('#btn-save').attr('disabled', true).html('<i class="fa fa-clock-o"></i> Cargando..');
                $("html, body").animate({ scrollTop: "0" });
                $("#message").html('<div class="alert alert-dismissable alert-info"><a href="#" class="close" data-dismiss="alert">&times;</a><center><h5>Guardando, espere por favor...</h5></center></div>');
            },
            success: function (data) {
                $("#message").html('');
                var type_alert = 'success';
                if (true == data[0]) {
                    type_alert = 'warning';
                    swal({
                        title: data[1],
                        text: data[2],
                        icon: type_alert,
                        button: true
                    });
                    setTimeout(function () {
                        $("#message").html('');
                    }, 1000);
                } else {
                    swal({
                        title: data[1],
                        text: data[2],
                        icon: type_alert,
                        button: false
                    });
                    setTimeout(function () {
                        self.location = "index.php?event=10";
                    }, 1000);
                }
            },
            error: function (data) {
                $("#message").html('<div class="alert alert-dismissable alert-warning"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Warning!</strong> Ocurrio un Error, Por favor verifique su conexión e intente nuevamente.</div>');
            }
        });
        setTimeout(function () {
            $(document).skylo('end');
            $('#btn-save').attr('disabled', false).html('Guardar');
        }, 300);
    });
});



function load_cuadrilla(a,b) {
    $("#".b).empty();
    $.getJSON('index.php?event=1000', function(data) {
        for(let i = 0; i < data.length; i++){
            var opt = $('<option>').val(data[i].id).text(data[i].label);
            $(opt).appendTo($("#"+b));
        }
        $("#"+b).selectpicker('val', a);
        $("#"+b).selectpicker('refresh');
    });
}


$(document).on('change', '#salario_diario', function () {
    var saliario = parseFloat($(this).val())/8;
    $("#salariohora").val(saliario);
});