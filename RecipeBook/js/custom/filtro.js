var site_url = $('.site_url').val();
filtrarRecetas();

function filtrarRecetas() {
    let busqueda = $('.txtBusqueda').val();
    let categoria = $('#txtCategoria').val();
    let pagina = $('#txtPagina').val();

    if (!pagina) pagina = 1;
    $.ajax({
        url: site_url + "/home/filtrarRecetas",
        method: "POST",
        dataType: 'json',
        data: {
            busqueda: busqueda,
            categoria: categoria,
            pagina: pagina
        },
        success: function(data) {
            $('.botonesFiltroRecetas').html(data.botonesFiltroRecetas);
            $('.resultadosFiltroRecetas').html(data.resultadosFiltroRecetas);
            $('.paginasFiltroRecetas').html(data.paginasFiltroRecetas);
            $('.txtBusqueda').focus();
        }
    })
}

function limpiarTodo() {
    $('.txtBusqueda').val("");
    $('#txtCategoria').val("");
    $('#txtPagina').val("");
    filtrarRecetas();
}

function categoria(categoria) {
    $('#txtCategoria').val(categoria);
    filtrarRecetas();
}
function limpiarCategoria() {
    $('#txtCategoria').val("");
    filtrarRecetas();
}

function paginaReceta(boton, pagina) {
    $('#txtPagina').val(pagina);
    filtrarRecetas();
}

function PaginaSiguienteReceta() {
    var siguiente = $('#txtPagina').val();
    siguiente += 10;
    $('#txtPagina').val(siguiente);
    filtrarRecetas();
}

function PaginaAnteriorReceta() {
    var anterior = $('#txtPagina').val();
    anterior -= 10;
    $('#txtPagina').val(anterior);
    filtrarRecetas();
}