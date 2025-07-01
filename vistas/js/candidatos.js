 /* ===================
  Tabla de Candidatos
  =======================*/
 $('.T_Candidatos').DataTable({
  "ajax": "../../ajax/candidatos.ajax.php",
        "deferRender": true,
        "retrieve": true,
        "processing": true,
        "language": {

            
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }

        }
    });

/*============================
 Guardar Candidato 
 =============================*/
 
$("#btnGuardarReclutamiento").click(function(){
    var nombreProspecto = $('#nombreProspecto').val();
    var correo = $('#correo').val();
    var fechaRegistro = $('#fechaRegistro').val();
    // var notas = $('#notas').val(); 
    // var reclutamiento = $('#reclutado').val(); 

    // 1. VALIDACIÓN FRONTEnd: Campos Obligatorios y Formato de Correo
    if (nombreProspecto.trim() === '' || correo.trim() === '' || fechaRegistro.trim() === '') {
        Swal.fire({
            title: "Campos Incompletos",
            text: "Por favor, rellena todos los campos obligatorios (Nombre, Correo, Fecha de Registro).",
            icon: "warning",
            confirmButtonText: "Aceptar"
        });
        return; // Detiene la ejecución si hay campos vacíos
    }

    // Validación de formato de correo electrónico
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(correo)) {
        Swal.fire({
            title: "Correo Inválido",
            text: "Por favor, introduce un formato de correo electrónico válido.",
            icon: "warning",
            confirmButtonText: "Aceptar"
        });
        return; // Detiene la ejecución si el correo es inválido
    }

    // Creamos un objeto FormData para enviar los datos
    var datos = new FormData();
    datos.append("nombreProspecto", nombreProspecto);
    datos.append("correo", correo);
    datos.append("fechaRegistro", fechaRegistro);
    // datos.append("notas", notas); 
    // datos.append("reclutamiento", reclutamiento); 
    datos.append("InsertarCandidato", "true"); 

    $.ajax({
        url: "/modelos/candidatos.modelo.php", 
        method: "POST",
        data: datos,
        cache: false,
        contentType: false, 
        processData: false, 
        dataType: "json", 

        success: function(respuesta) {
            handleServerResponse(respuesta, "Guardado Exitoso", "Los datos se han guardado correctamente.", "Error al Guardar");
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error en la petición AJAX:", textStatus, errorThrown);
            console.error("Respuesta del servidor:", jqXHR.responseText);
            Swal.fire("Error", "Ocurrió un error en la comunicación con el servidor: " + textStatus, "error");
        }
    });
});

/* ===============================
   Ver Datos del Modal Editar Candidato
================================== */
$(".T_Candidatos").on("click", ".btnEditarCandidato", function(){
    var idCandidato = $(this).attr("idCandidato");

    var datos = new FormData();
    datos.append("idCandidato", idCandidato);
    datos.append("EditarCandidato", "true");
    $.ajax({
        url: "/modelos/candidatos.modelo.php", 
        method: "POST",
        data: datos,
        cache: false,
        contentType: false, 
        processData: false, 
        dataType: "json", 

        success: function(respuesta) { 
            $('#idCandidatoEdit').val(respuesta.id);
            $('#nombreProspectoEdit').val(respuesta.nombre);
            $('#correoEdit').val(respuesta.correo);
            $('#fechaRegistroEdit').val(respuesta.fecha_registro);
            $('#notasEdit').val(respuesta.notas);
            $('#reclutadoEdit').val(respuesta.reclutamiento);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error en la petición AJAX:", textStatus, errorThrown);
            console.error("Respuesta del servidor:", jqXHR.responseText); 
            swal("Error", "Ocurrió un error al cargar los datos del candidato.", "error");
        }
    });
});
 
/* =========================================
MODAL PARA EDITAR CANDIDATO
============================================*/

$("#btnGuardarCandidatoEdit").click(function(){
    var idCandidatoEdit = $('#idCandidatoEdit').val(); 
    var nombreProspectoEdit = $('#nombreProspectoEdit').val();
    var correoEdit = $('#correoEdit').val();
    var fechaRegistroEdit = $('#fechaRegistroEdit').val();

    // 1. VALIDACIÓN FRONTEnd: Campos Obligatorios y Formato de Correo
    if (nombreProspectoEdit.trim() === '' || correoEdit.trim() === '' || fechaRegistroEdit.trim() === '') {
        Swal.fire({
            title: "Campos Incompletos",
            text: "Por favor, rellena todos los campos obligatorios (Nombre, Correo, Fecha de Registro).",
            icon: "warning",
            confirmButtonText: "Aceptar"
        });
        return; // Detiene la ejecución si hay campos vacíos
    }

    // Validación de formato de correo electrónico simple
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(correoEdit)) {
        Swal.fire({
            title: "Correo Inválido",
            text: "Por favor, introduce un formato de correo electrónico válido.",
            icon: "warning",
            confirmButtonText: "Aceptar"
        });
        return; // Detiene la ejecución si el correo es inválido
    }

    var datos = new FormData();
    datos.append("idCandidatoEdit", idCandidatoEdit); 
    datos.append("nombreProspectoEdit", nombreProspectoEdit); 
    datos.append("correoEdit", correoEdit);
    datos.append("fechaRegistroEdit", fechaRegistroEdit);
    datos.append("ModificarCandidato", "true");

    $.ajax({
        url: "/modelos/candidatos.modelo.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false, 
        processData: false, 
        dataType: "json",

        success: function(respuesta) {
            handleServerResponse(respuesta, "Modificacion Exitosa", "Los datos del candidato han sido actualizados correctamente.", "Error al Modificar");

        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error en la petición AJAX:", textStatus, errorThrown);
            console.error("Respuesta del servidor:", jqXHR.responseText);
            Swal.fire("Error", "Ocurrió un error en la comunicación con el servidor: " + textStatus, "error");
        }
    });
});

/* ===================
   Eliminar Candidato
======================*/
$(".T_Candidatos").on("click", ".btnBorrarCandidato", function(){

    var idCandidato = $(this).attr("idborrarCandidato"); 

    Swal.fire({
        title: '¿Está seguro de borrar el candidato?',
        text: "¡Si no lo está puede cancelar la acción!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí, borrar candidato!'
    }).then((result) => {
        if (result.isConfirmed) {
            
            var datos = new FormData();
            datos.append("idBorrarCandidato", idCandidato); 

            $.ajax({
                url: "/modelos/candidatos.modelo.php", 
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json", 
                success: function(respuesta){
                    // console.log("Respuesta del servidor al borrar:", respuesta); 

                    if(respuesta == "ok"){
                        Swal.fire(
                            '¡Borrado!',
                            'El candidato ha sido borrado correctamente.',
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload(); 
                            }
                        });
                    } else {
                        // Si la respuesta no es "ok", muestra un error
                        handleServerResponse(respuesta, null, null, "Error al Borrar");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Error en la petición AJAX de borrar:", textStatus, errorThrown);
                    console.error("Respuesta del servidor (borrar):", jqXHR.responseText);
                    Swal.fire({
                        title: "Error",
                        text: "Ocurrió un error en la comunicación con el servidor al borrar: " + textStatus,
                        icon: "error",
                        confirmButtonText: "Entendido"
                    });
                }
            });
        }
    });
});

/* ===================
Funcion para manejar la respuesta del servidor
======================*/

function handleServerResponse(respuesta, successTitle, successText, errorTitle) {
    if (respuesta === "ok") {
        Swal.fire({
            title: successTitle,
            text: successText,
            icon: "success",
            confirmButtonText: "Aceptar"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.reload();
            }
        });
    } else {
        let errorMessage = "Ocurrió un error inesperado.";
        if (respuesta === "error_datos_vacios") {
            errorMessage = "Por favor, rellena todos los campos obligatorios.";
        } else if (respuesta === "error_correo_invalido") {
            errorMessage = "El formato del correo electrónico es inválido.";
        } else if (respuesta === "error_correo_duplicado") { 
            errorMessage = "El correo electrónico ya existe, favor verificar.";
        } else if (respuesta === "no_cambios_o_id_inexistente") {
            errorMessage = "El registro no se encontró o no hubo cambios para guardar.";
        } else if (respuesta === "no_encontrado_para_borrar") {
            errorMessage = "El registro a borrar no fue encontrado.";
        } else if (respuesta === "error_generico") {
            errorMessage = "Ocurrió un problema en el servidor. Por favor, inténtalo de nuevo o contacta al soporte técnico.";
        } else {
             errorMessage = "El servidor respondió: " + respuesta;
        }

        Swal.fire({
            title: errorTitle,
            text: errorMessage,
            icon: "error",
            confirmButtonText: "Entendido"
        });
    }
}


