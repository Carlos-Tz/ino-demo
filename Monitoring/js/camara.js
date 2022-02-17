Webcam.set({
    width: 250,
    height: 250,
    image_format: 'jpeg',
    jpeg_quality: 100
});

function setup() {
    Webcam.reset();
    Webcam.attach('#my_camera');
}

function take_snapshot() {
    if ($("#id_tipoHallazgoFoto option:selected").text() != 'Seleccione...') {
        // take snapshot and get image data
        Webcam.snap(function (data_uri) {
            // display results in page
            let idHallazgo = $("#id_tipoHallazgoFoto option:selected").val();
            $.ajax({
                data: data_uri,
                type: 'POST',
                dataType: 'json',
                url: 'index.php?event=10001&id_TipoHallaz=' + idHallazgo + '&id=' + $("#id_monitoreo").val(),
                contentType: false,
                processData: false,
                beforeSend: function () {
                    //$('#btn-saveFoto').attr('disabled', true).html('<i class="fa fa-clock-o"></i>Guardando...');
                },
                success: function (data) {
                    $("#results").html('');
                    var type_alert = 'success';
                    if (false == data[0]) { //Hubo error
                        type_alert = 'warning';
                    }
                    swal({
                        title:  data[1],
                        text:   data[2],
                        type:   type_alert,
                        icon:   type_alert,
                        button: true
                    });
                    setTimeout(function () {
                        swal.close();
                    }, 1000);

                }
            });
        });
    } else {
        $("#results").html('<div class="alert alert-dismissable alert-warning"><a href="#" class="close" data-dismiss="alert">&times;</a>' +
            '<strong>ERROR!</strong> Favor de Seleccionar un Tipo de Hallazgo.'+$("#id_tipoHallazgoFoto option:selected").text()+'</div>');

    }
}