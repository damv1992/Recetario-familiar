var site_url = $(".site_url").val();

let categoria = $('#idCategoria').val();
let receta = $('#idReceta').val();
if (receta) $('.verFotoReceta').show();
else $('.verFotoReceta').hide();

$(".tablaRecetas").DataTable({
    ajax: {
        method: "POST",
        dataType: 'json',
        cache: false,
        url: site_url + '/receta/listar/' + categoria
    },
    "pageLength" : 25,
    "responsive": true,
    "retrieve": true,
    "processing": true,
    "deferRender": false,
    "language": {
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ningún dato disponible en esta tabla",
        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix": "",
        "sSearch": "Buscar:",
        "sUrl": "",
        "sInfoThousands": ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Último",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
    }
});

$(".fotoReceta").change(function() {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('.verFotoReceta').show();
            $('.verFotoReceta').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    } else {
        $('.verFotoReceta').hide();
    }
});

$('.btnGuardarReceta').click(function () {
    let categoria = $('#idCategoria').val();
    let id = $('#idReceta').val();
    let nombre = $('.nombreReceta').val();
    let foto = $(".fotoReceta").prop('files')[0];
    let horas = $('.horasReceta').val();
    let minutos = $('.minutosReceta').val();
    let segundos = $('.segundosReceta').val();
    let dificultad = $('.dificultadReceta').val();
    let porciones = $('.porcionesReceta').val();
    let datos = new FormData();
    datos.append('categoria', categoria);
    datos.append('id', id);
    datos.append('nombre', nombre);
    datos.append('foto', foto);
    datos.append('horas', horas);
    datos.append('minutos', minutos);
    datos.append('segundos', segundos);
    datos.append('dificultad', dificultad);
    datos.append('porciones', porciones);
    $.ajax({
        url: site_url + '/receta/validar',
        method: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(json) {
            $('.text-danger').remove();
            if (json.contador > 0) {
                if ((json.campos) && (json.mensajes)) {
                    var camposs = json.campos.slice(0, -1).split(',');
                    var mensajess = json.mensajes.slice(0, -1).split(',');
                    for (var i = 0; i < camposs.length; i++) {
                        var elemento = $('.'+camposs[i]);
                        $(elemento).parent().before('<div class="text-danger">'+mensajess[i]+'</div>');
                    }
                }
				$('.text-danger').parent().parent().addClass('has-error');
            } else {
                $('.alert-dismissible, .text-success').remove();
                $('.alert-dismissible, .text-danger').remove();
                $('.form-group').removeClass('has-error');
                $.ajax({
                    url: site_url + '/receta/guardar',
                    method: 'post',
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(respuesta) {
                        let mensaje;
                        if (respuesta === 'success') location.href = site_url + '/categoria/recetas/' + categoria;
                        else mensaje = 'Algo falló al guardar la receta.';
                    }
                });
            }
        }
    });
});

$(".tablaRecetas tbody").on("click", ".btnBorrarReceta", function () {
    let id = $(this).attr("codigo");
    let datos = new FormData();
    datos.append("id", id);
    Swal.fire({
        icon: "warning",
        title: "Confirmar borrado",
        text: "¿Está seguro de borrar el registro?",
        showCancelButton: true,
        confirmButtonText: 'Borrar',
        cancelButtonText: 'Cancelar'
    }).then(function (resultado) {
        if (resultado.value) {
            $.ajax({
                url: site_url + "/receta/borrar",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (respuesta) {
                    if (respuesta === "ok") {
                        Swal.fire({
                            icon: "success",
                            title: "Completado",
                            text: "El registro ha sido borrado correctamente.",
                            showCancelButton: false,
                            confirmButtonText: "Cerrar"
                        }).then(function () {
                            $(".tablaRecetas").DataTable().ajax.reload();
                        });
                    } else {
                        let mensaje;
                        if (respuesta === "uso") mensaje = "No se puede borrar el registro, ya que esta en uso actualmente.";
                        else mensaje = "Ocurrio un error al borrar el registro "+id+"."
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: mensaje,
                            showCancelButton: false,
                            confirmButtonText: "Cerrar"
                        });
                    }
                }
            });
        }
    });
});