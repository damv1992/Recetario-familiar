var site_url = $(".site_url").val();

let receta = $('#receta').val();

$(".tabla").DataTable({
    ajax: {
        method: "POST",
        dataType: 'json',
        cache: false,
        url: site_url + '/preparacion/listar/' + receta
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

$('.btnGuardar').click(function () {
    let id = $('#preparacion').val();
    let paso = $('.paso').val();
    let descripcion = $('.descripcion').val();
    descripcion = toHTML(descripcion);
    let datos = new FormData();
    datos.append('receta', receta);
    datos.append('id', id);
    datos.append('paso', paso);
    datos.append('descripcion', descripcion);
    $.ajax({
        url: site_url + '/preparacion/validar',
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
                        $(elemento).parent().append('<div class="text-danger">'+mensajess[i]+'</div>');
                    }
                }
				$('.text-danger').parent().parent().addClass('has-error');
            } else {
                $('.alert-dismissible, .text-success').remove();
                $('.alert-dismissible, .text-danger').remove();
                $('.form-group').removeClass('has-error');
                $.ajax({
                    url: site_url + '/preparacion/guardar',
                    method: 'post',
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(respuesta) {
                        let mensaje;
                        if (respuesta === 'success') location.href = site_url + '/receta/preparacion/' + receta;
                        else mensaje = 'Error al guardar.';
                    }
                });
            }
        }
    });
});

$(".tabla tbody").on("click", ".btnBorrar", function () {
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
                url: site_url + "/preparacion/borrar",
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
                            $(".tabla").DataTable().ajax.reload();
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

let descripcion = $('.descripcion').val();
descripcion = toText(descripcion);
$('.descripcion').val(descripcion);

function toHTML(descripcion) {
	var descripcion; //store input
	var text_input; //store input after beging trim()med
	var output_html=""; //store output
	var counter;	

	text_input = descripcion.trim(); //trim() input
	if (text_input.length > 0){
		output_html += "<p>"; //begin by creating paragraph
		for (counter = 0; counter < text_input.length; counter++) {
			switch (text_input[counter]){
				case '\n':
					if (text_input[counter+1]==='\n'){
						output_html+="</p>\n<p>";
						counter++;
					}
					else output_html+="<br>";			
					break;
				
				case ' ':
					if(text_input[counter-1] != ' ' && text_input[counter-1] != '\t')
						output_html+=" ";														
					break;
					
				case '\t':
					if(text_input[counter-1] != '\t')
						output_html+=" ";
					break;
				
				case '&':
					output_html+="&amp;";
					break;
				
				case '"':
					output_html+="&quot;";
					break;
				
				case '>':
					output_html+="&gt;";
					break;
				
				case '<':
					output_html+="&lt;";
					break;				
				
				default:
					output_html+=text_input[counter];
			}
					
		}
		output_html+="</p>"; //finally close paragraph
	}
	return output_html; // display output html	
}

function toText(html) {
    html = html.replace("<br>", "\n");
    html = html.replace("<p>", "");
    html = html.replace("</p>", "");
    return html;
}