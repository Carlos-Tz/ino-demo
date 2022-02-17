$(document).ready(function () {
    load_subranchos();
    $("#guarda_lectura").click(function(){
        var formData     = $("#data_monitoring").serializeArray();
        $.ajax({
            data: formData,
            type: 'POST',
            dataType: 'json',
            url: 'index.php?event=1100',
            beforeSend: function () {
                $('#guarda_lectura').attr('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Guardando');
            },
            success: function (data) {
                var type_alert = 'success';
                if (true == data[0]) { //Hubo error
                    type_alert = 'warning';
                    swal({
                        title:  data[1],
                        text:   data[2],
                        type:   type_alert,
                        icon:   type_alert,
                        button: true
                    });
                } else {
                    load_tipos_hallazgos();
                    load_hallazgos();
                    $("#cantidad").val(0);
                    swal({
                        title:  data[1],
                        text:   data[2],
                        type:   type_alert,
                        icon:   type_alert,
                        button: false
                    });
                    setTimeout(function () {
                        swal.close();
                    }, 1000);
                }
            },
            error: function (data) {
                $("#message").html('<div class="alert alert-dismissable alert-warning"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Atención!</strong> Ocurrió un error, revise la información e intente nuevamente!</div>');
            }
        });
        setTimeout(function () {
            $('#guarda_lectura').attr('disabled', false).html('<span class="fas fa-bug"></span> Confirmar Hallazgo');
        }, 300);
    });
    $("#cond_met").change(function() {
        //$("#fenologia").removeClass('d-none', true);
        //load_fenology();
    });

    $("#etapa_fen").change(function() {
        $("#subrancho").removeClass('d-none', true);
       // load_subranchos();
        //$("#btn-save").click();
    });

    $("#num_subrancho").change(function() {
        $("#fenologia").removeClass('d-none', true);
        $("#sector").removeClass('d-none', true);
        $("#clima").removeClass('d-none', true);
        load_fenology();
        load_meteorology();
        load_sectores($(this).val());
    });

    $("#id_sector").change(function() {
        $("#tunel").removeClass('d-none', true);
        load_tuneles($(this).val());
    });

    $("#id_tunel").change(function() {
        $("#btn-save").removeClass('d-none', true);
        $("#plantas").removeClass('d-none', true);
    });


    $("#id_tipo_hallazgo").change(function() {
        load_hallazgos($(this).val());
    });

    $("#new").click(function() {
        window.location.href = "index.php?event=1";
    });
    $("#new_monito").click(function() {
        window.location.href = "index.php?event=1001";
    });

    $('#new_monitoring').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serializeArray();
        $.ajax({
            data: formData,
            type: 'POST',
            dataType: 'json',
            url: 'index.php?event=110',
            beforeSend: function () {
                $('#btn-save').attr('disabled', true).html('<i class="fa fa-clock-o"></i>Guardando...');
                $('html, body').animate({scrollTop: 0}, 'slow');
                $("#message").html('<div class="alert alert-dismissable alert-info"><center><h3>¡Guardando la información...!</h3></center></div>');
            },
            success: function (data) {
                $("#data_monitoring").prop('hidden',false);
                $("#message").html('');
                var type_alert = 'success';
                if (true == data[0]) { //Hubo error
                    type_alert = 'warning';
                    swal({
                        title:  data[1],
                        text:   data[2],
                        type:   type_alert,
                        icon:   type_alert,
                        button: true
                    });
                } else {
                    $("#id_monitoreo").val(data['id_monitoreo']);
                    $("#id_lectura_m").val(data['id_lectura_m']);
                    document.getElementById('num_subrancho').disabled= true;
                    document.getElementById('id_sector').disabled= true;
                    document.getElementById('id_tunel').disabled= true;
                    document.getElementById('num_plantas').disabled= true;
                    document.getElementById('cond_met').disabled= true;
                    document.getElementById('etapa_fen').disabled= true;
                    $("#btn-cambiar-tun").addClass('d-none')

                    $("#conteo_lecturas").html("<center>Lecturas del monitoreo actual: "+ 
                    "<span class='badge badge-info'>1</span>"+
                    " de <span class='badge badge-info'>"+data['num_plantas']+"</span></center>");
                    
                    $("#num_planta").val(data['num_lm']+1);
                    $("#num_planta").prop('readonly',true);
                    load_tipos_hallazgos();
                    load_hallazgos();
                    $("#cantidad").val(0);


                }
            },
            error: function (data) {
                $("#message").html('<div class="alert alert-dismissable alert-warning"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Atención!</strong> Ocurrió un error, revise la información e intente nuevamente!</div>');
            }
        });
        setTimeout(function () {
            $('#btn-save').attr('disabled', false).html('<i class="far fa-play-circle"></i> Iniciar Nuevo Monitoreo');
            if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
                $('#btn-capturar-foto').removeClass('d-none', true);
            }else{
                console.log('esto no es un mobil');
            }
        }, 2000);

    });

    $('#btn-cambiar-tun').click(function (e) {
        e.preventDefault();
        document.getElementById('num_subrancho').disabled= false;
        document.getElementById('id_sector').disabled= false;
        document.getElementById('id_tunel').disabled= false;
        document.getElementById('id_tunel').focus();
        document.getElementById('num_plantas').disabled= false;
        document.getElementById('cond_met').disabled= false;
        document.getElementById('etapa_fen').disabled= false;
    });

    $('#data_monitoring').submit(function (e) {
        e.preventDefault();
        var formData     = $(this).serializeArray();
        var id_monitoreo = $("#id_monitoreo").val();
        var num_plantas  = $("#num_plantas").val();

        formData.push({'name':'id_monitoreo','value':id_monitoreo});
        formData.push({'name':'num_plantas','value':num_plantas});
        $.ajax({
            data:     formData,
            type:     'POST',
            dataType: 'json',
            url:      'index.php?event=111',
            beforeSend: function () {
                $('#btn-save-2').attr('disabled', true).html('<i class="fa fa-clock-o"></i> Guardando...');
                $('html, body').animate({scrollTop: 0}, 'slow');
                $("#message").html('<div class="alert alert-dismissable alert-info"><center><h3>¡Guardando la información...!</h3></center></div>');
            },
            success: function (data) {
                $("#message").html('');
                var type_alert = 'success';
                if (true == data[0]) { //Hubo error
                    type_alert = 'warning';
                    swal({
                        title:  data[1],
                        text:   data[2],
                        type:   type_alert,
                        icon:   type_alert,
                        button: true
                    });
                } else {
                    $("#id_monitoreo").val(data['id_monitoreo']);
                    $("#id_lectura_m").val(data['id_lectura_m']);
                    $("#conteo_lecturas").html("Lecturas del monitoreo actual: "+ 
                    "<span class='badge badge-info'>"+data['num_lm']+"</span>"+
                    " de <span class='badge badge-info'>"+data['num_plantas']+"</span>");
                    swal({
                        title:  data[1],
                        text:   data[2],
                        type:   type_alert,
                        icon:   type_alert,
                        button: false
                    });
                    $("#num_planta").val(parseInt(data['num_lm'],10));
                    $("#num_planta").prop('readonly',true);
                    load_tipos_hallazgos();
                    load_hallazgos();
                    $("#cantidad").val(0);
                    $("#comentarios").val('');
                    setTimeout(function () {
                        swal.close();
                        if(parseInt(data['num_lm'],10) > parseInt(data['num_plantas'],10)){
                            var m_id = data['id_monitoreo'];
                            $("#conteo_lecturas").html("Lecturas del monitoreo actual: "+ 
                            "<span class='badge badge-info'>-</span>"+
                            " de <span class='badge badge-info'>-</span>");
                            $("#id_monitoreo").val('');
                            $("#id_lectura_m").val('');
                            $("#num_planta").val(0);
                            $("#num_planta").prop('readonly',true);
                            $("#id_tipo_hallazgo").empty();
                            $("#id_hallazgo").empty();
                            var msj  = "";
                            $.ajax({
                                data: {id:m_id},
                                type: 'POST',
                                dataType: 'json',
                                url: 'index.php?event=1110',
                                success: function (result) {
                                    $("#message").html('');
                                    var type_alert = 'success';
                                    if (true == data[0]) { //Hubo error
                                       msj = " Pero ocurrió un error: ".result[2];
                                    }
                                },
                            }); 
                            swal({
                                title:  data[1],
                                text:   'Haz concluido con el monitoreo' + msj,
                                type:   type_alert,
                                icon:   type_alert,
                                button: true,
                            });
                            $("#btn-cambiar-tun").removeClass('d-none', true);
                        }
                    }, 1000);
                }
            },
            error: function (data) {
                $("#message").html('<div class="alert alert-dismissable alert-warning"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Atención!</strong> Ocurrió un error, revise la información e intente nuevamente!</div>');
            }
        });
        setTimeout(function () {
            $('#btn-save-2').attr('disabled', false).html('Siguiente Planta/Concluir <i class="fas fa-arrow-alt-circle-right"></i>');
        }, 300);

    });
    
});

function load_subranchos() {
    $.ajax({
        type: "POST",
        url: 'index.php/?event=10',
        dataType: 'json',
        success: function (data, textStatus, xhr) {
            var opt1 = $('<option>').val('').text('Seleccione una opción');
            $(opt1).appendTo($('#num_subrancho'));
            opt1.attr("disabled",true);
            $.each(data, function (arrayID, group) {
                var opt = $('<option>').val(group.id).text(group.label);
                $(opt).appendTo($('#num_subrancho'));
            });
        },
        error: function () {
            console.log('Ocurrio un error al intentar cargar.');
        }
    });
}

function load_sectores(a) {
    $.ajax({
        type: "POST",
        url: 'index.php/?event=11',
        data:{"subrancho":a},
        dataType: 'json',
        success: function (data, textStatus, xhr) {
            $("#id_sector").empty();

            var opt1 = $('<option>').val('').text('Seleccione una opción');
            $(opt1).appendTo($('#id_sector'));
            opt1.attr("disabled",true);
            $.each(data, function (arrayID, group) {
                var opt = $('<option>').val(group.id).text(group.label);
                $(opt).appendTo($('#id_sector'));
            });
        },
        error: function () {
            console.log('Ocurrio un error al intentar cargar.');
        }
    });
}

function load_tuneles(b) {
    $.ajax({
        type: "POST",
        url: 'index.php/?event=100',
        data:{"id_sector":b},
        dataType: 'json',
        success: function (data, textStatus, xhr) {
            $("#id_tunel").empty();
            var opt1 = $('<option>').val('').text('Seleccione una opción');
            $(opt1).appendTo($('#id_tunel'));
            opt1.attr("disabled",true);
            $.each(data, function (arrayID, group) {
                var opt = $('<option>').val(group.id).text(group.label);
                $(opt).appendTo($('#id_tunel'));
            });
        },
        error: function () {
            console.log('Ocurrio un error al intentar cargar.');
        }
    });
}

function load_meteorology() {
    $.ajax({
        type: "POST",
        url: 'index.php/?event=101',
        data:{"catalog":'Meteorology'},
        dataType: 'json',
        success: function (data, textStatus, xhr) {
            $("#cond_met").empty();
            var opt1 = $('<option>').val('').text('Seleccione una opción');
            $(opt1).appendTo($('#cond_met'));
            opt1.attr("disabled",true);
            $.each(data, function (arrayID, group) {
                var opt = $('<option>').val(group.id).text(group.label);
                $(opt).appendTo($('#cond_met'));
            });
        },
        error: function () {
            console.log('Ocurrio un error al intentar cargar.');
        }
    });
}

function load_fenology() {
    $.ajax({
        type: "POST",
        url: 'index.php/?event=101',
        data:{"catalog":'Fenology'},
        dataType: 'json',
        success: function (data, textStatus, xhr) {
            $("#etapa_fen").empty();
            var opt1 = $('<option>').val('').text('Seleccione una opción');
            $(opt1).appendTo($('#etapa_fen'));
            opt1.attr("disabled",true);
            $.each(data, function (arrayID, group) {
                var opt = $('<option>').val(group.id).text(group.label);
                $(opt).appendTo($('#etapa_fen'));
            });
        },
        error: function () {
            console.log('Ocurrio un error al intentar cargar.');
        }
    });
}

function load_tipos_hallazgos() {
    $.ajax({
        type: "POST",
        url: 'index.php/?event=101',
        data:{"catalog":'Tipos_Hallazgos'},
        dataType: 'json',
        success: function (data, textStatus, xhr) {
            $("#id_tipo_hallazgo").empty();
            var opt1 = $('<option>').val('0').text('Seleccione...');
            $(opt1).appendTo($('#id_tipo_hallazgo'));
            opt1.attr("disabled",false);
            $.each(data, function (arrayID, group) {
                var opt = $('<option>').val(group.id).text(group.label);
                $(opt).appendTo($('#id_tipo_hallazgo'));
            });
        },
        error: function () {
            console.log('Ocurrio un error al intentar cargar.');
        }
    });
}

function load_hallazgos(tipo) {
    $('#listaHallazgos tbody').html('');
    $.ajax({
        type: "POST",
        url: 'index.php/?event=101',
        data:{"catalog":'Hallazgos', "id_tipo":tipo},
        dataType: 'json',
        success: function (data, textStatus, xhr) {
            $.each(data, function (arrayID, group) {
                var opt ='<tr><td>'+group.label+'</td><td><input class="form-control" type="number"  name="cantidad['+group.id+']" id="'+group.id+'" value="0" min="0" name=""></td></tr>';
                $('#listaHallazgos tbody').append(opt);
            });
            },
        error: function () {
            console.log('Ocurrio un error al intentar cargar.');
        }
    });
}


//funciones para foto

$(document).on('click','#btn-capturar-foto',function () {
    load_tipos_hallazgos_foto(1);
});
var countF=2;
$(document).on('click',"#agregarFormFoto", function () {
    $(".content-fotos").append('<div><div class="row d-flex justify-content-end"><button type="button" class="btn btn-danger btn-xs  btndelete-foto"><i class="fa fa-times" aria-hidden="true"></i></button></div>' +
        '<br><div class="row">\n' +
        '                        <div class="col-lg-4">\n' +
        '                            <label for="tipo_hallazgo">Tipo de Hallazgo:</label>\n' +
        '                            <select class="form-control" id="id_tipo_hallazgo_foto_'+countF+'" name="id_tipohallazgo[]" required>\n' +
        '                            </select>\n' +
        '                        </div>\n' +
        '                        <div class="col-lg-8">\n' +
        '                            <label for="tipo_hallazgo">Foto :</label>\n' +
        '                            <input class="form-control" type="file" accept="image/*" capture="environment" name="foto[]" required>\n' +
        '                        </div>\n' +
        '                    </div>\n' +
        '                    <br></div>');
    load_tipos_hallazgos_foto(countF);
    countF++;
});


$(document).on("click", ".btndelete-foto", function () {
    $(this).parent().parent().remove();
});

function load_tipos_hallazgos_foto() {
    $.ajax({
        type: "POST",
        url: 'index.php/?event=10000',
        data:{"catalog":'Tipos_Hallazgos'},
        dataType: 'json',
        success: function (data, textStatus, xhr) {
            $("#id_tipoHallazgoFoto").empty();
            $.each(data, function (arrayID, group) {
                var opt = $('<option>').val(group.id).text(group.label);
                $(opt).appendTo($('#id_tipoHallazgoFoto'));
            });
        },
        error: function () {
            console.log('Ocurrio un error al intentar cargar.');
        }
    });
}


/*
$('#saveFotosMoni').submit(function (e) {
    e.preventDefault();
    let id = $("#id_monitoreo").val();
    var formData = new FormData($(this)[0]);
    $.ajax({
        data: formData,
        type: 'POST',
        dataType: 'json',
        url: 'index.php?event=10001&id_m='+id,
        contentType: false,
        processData: false,
        beforeSend: function () {
            $('#btn-saveFoto').attr('disabled', true).html('<i class="fa fa-clock-o"></i>Guardando...');
        },
        success: function (data) {
            var type_alert = 'success';
            if (true == data[0]) { //Hubo error
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
                $('#exampleModal').modal('hide')
            }, 1000);
        }
    });
    setTimeout(function () {
        $('#btn-saveFoto').attr('disabled', false).html(' GUARDAR ');
    }, 2000);

});*/
