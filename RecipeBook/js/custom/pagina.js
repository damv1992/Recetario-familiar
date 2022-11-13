var site_url = $(".site_url").val();

$(".iconoPagina").change(function() {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#verIcono').show();
            $('#verIcono').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    } else {
        $('#verIcono').hide();
    }
});

$(".logoPagina").change(function() {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#verLogo').show();
            $('#verLogo').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    } else {
        $('#verLogo').hide();
    }
});

$('.btnGuardarConfiguracion').click(function () {
    let nombre = $('.nombrePagina').val();
    let logo = $(".logoPagina").prop('files')[0];
    let icono = $(".iconoPagina").prop('files')[0];
    let sobre = $('.sobrePagina').val();
    sobre = toHTML(sobre);
    let datos = new FormData();
    datos.append('nombre', nombre);
    datos.append('logo', logo);
    datos.append('icono', icono);
    datos.append('sobre', sobre);
    $.ajax({
        url: site_url + '/pagina/validar',
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
                    url: site_url + '/pagina/guardar',
                    method: 'post',
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(respuesta) {
                        let mensaje;
                        if (respuesta === 'success') location.href = site_url;
                        else mensaje = 'Algo falló al guardar la configuración.';
                        $('.mensajeConfiguracion').append(
                            '<div class="nk-info-box text-' + respuesta + '">'+ mensaje +
                            '<div class="nk-info-box-close nk-info-box-close-btn"><i class="ion-close-round"></i></div></div>');
                    }
                });
            }
        }
    });
});

let sobre = $('.sobrePagina').val();
sobre = toText(sobre);
$('.sobrePagina').val(sobre);

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