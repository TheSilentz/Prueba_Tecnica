/* ===================
  Tabla de Entrevistas
  =======================*/
 $('.T_Entrevistas').DataTable({
  "ajax": "../../ajax/entrevistas.ajax.php",
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


    /* ===================
      Botón Guardar Entrevista
      =======================*/


    /* ========================
    TRAER DATOS DEL SELECT VACANTES 
    =========================*/

    $("#selectVacanteEntrevista").ready(function() {
        $("#selectVacanteEntrevista").empty();
        $("#selectVacanteEntrevista").append('<option value="">Selecciona una Vacante</option>');
        $.ajax({
            url: "/modelos/entrevistas.modelo.php",
            method: "POST",
            dataType: "json",
            data: { "TraerDatosSelectVacantes": "listarVacantes" },
            success: function(respuesta) {
                respuesta.forEach(function(item) {
                     $("#selectVacanteEntrevista").append('<option value="' + item.id + '">' + item.area + ' - $' + item.sueldo + '</option>');
                });
            }
        });
    });
