<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestion De Reclutamiento</title>
  <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables CSS -->
 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.min.css"/>
 
</head>
<body>
   
  <div class="container mt-5">
    <h2 class="mb-4">Listado de Candidatos</h2>

    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#agregarCandidatoModal">
      Agregar Nuevo Candidato
    </button>

    <!-- TABLE -->
    <div class="table-responsive">
      <table class="table table-bordered table-striped dt-responsive T_Candidatos"  id="T_Candidatos" style="width: 100%">
        <thead>
         <tr>
           <th style="width:2px">#</th>
           <th style="width:5px">Nombre</th>
           <th style="width:5px">Correo</th>
           <th style="width:5px">Fecha Registro</th>
           <th style="width:5px">Acciones</th>    
         </tr>
        </thead>

          <tbody id='listCandidatos'>    
          </tbody>
        </table>
    </div>
  </div>

  
  <!-- Modal para agregar candidato -->
  <div class="modal fade" id="agregarCandidatoModal" tabindex="-1" aria-labelledby="agregarCandidatoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="agregarCandidatoModalLabel">Agregar Nuevo Candidato</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="reclutamientoForm">
            <div class="mb-3">
              <label for="nombreProspecto" class="form-label">Nombre del Candidato</label>
              <input type="text" class="form-control" id="nombreProspecto" name="nombreProspecto" required>
            </div>
            <div class="mb-3">
              <label for="nombreProspecto" class="form-label">Correo</label>
              <input type="email" class="form-control" id="correo" name="correo" required>
            </div>
            <div class="mb-3">
              <label for="fechaRegistro" class="form-label">Fecha de Registro</label>
              <input type="date" class="form-control" id="fechaRegistro" name="fechaRegistro" required>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" form="reclutamientoForm" class="btn btn-primary" id="btnGuardarReclutamiento">Guardar Prospecto</button>
        </div>
      </div>
    </div>
  </div>

<!-- Modal para Editar candidato -->
  <div class="modal fade" id="editarCandidatoModal" tabindex="-1" aria-labelledby="editarCandidatoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editarCandidatoModalLabel">Editar Candidato</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="reclutamientoForm">
            <div class="mb-3">
              <label for="nombreProspecto" class="form-label">Nombre del Candidato</label>
              <input type="text" class="form-control" id="nombreProspectoEdit" name="nombreProspectoEdit" required>
            </div>
            <div class="mb-3">
              <label for="nombreProspecto" class="form-label">Correo</label>
              <input type="email" class="form-control" id="correoEdit" name="correoEdit" required>
            </div>
            <div class="mb-3">
              <label for="fechaRegistro" class="form-label">Fecha de Registro</label>
              <input type="date" class="form-control" id="fechaRegistroEdit" name="fechaRegistroEdit" required>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" form="reclutamientoForm" class="btn btn-primary" id="btnGuardarCandidatoEdit">Guardar Prospecto</button>
        <input type="hidden" id="idCandidatoEdit" name="idCandidatoEdit">
      </div>
    </div>
  </div>
</div>

<!-- Modal Ver Candidato -->
<div class="modal fade" id="verCandidatoModal" tabindex="-1" aria-labelledby="verCandidatoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verCandidatoModalLabel">Ver Detalles del Candidato</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs mb-3" id="candidatoTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="entrevistas-tab" data-bs-toggle="tab" data-bs-target="#entrevistas-pane" type="button" role="tab" aria-controls="entrevistas-pane" aria-selected="true">Entrevistas</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="vacantes-tab" data-bs-toggle="tab" data-bs-target="#vacantes-pane" type="button" role="tab" aria-controls="vacantes-pane" aria-selected="false">Vacantes Disponibles</button>
                    </li>
                </ul>

                <div class="tab-content" id="candidatoTabContent">
                    <div class="tab-pane fade show active" id="entrevistas-pane" role="tabpanel" aria-labelledby="entrevistas-tab">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="h5 mb-0">Entrevistas Asociadas</h4>
                            <button type="button" class="btn btn-primary btn-sm btnProgramarNuevaEntrevista" data-bs-toggle='modal' data-bs-target='#modalGestionarEntrevista'  id="btnProgramarNuevaEntrevista">
                                <i class="fa fa-plus"></i> Programar Entrevista
                            </button>
                        </div>
                        <input type="hidden" id="currentCandidatoId" name="currentCandidatoId" value="">
                        <div class="table-responsive">
                          <!-- TABLA DE ENTREVISTAS -->
                            <table class="table table-bordered table-striped dt-responsive T_Entrevistas" id="T_Entrevistas" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Vacante (Área - Sueldo)</th>
                                        <th>Fecha de Entrevista</th>
                                        <th>Notas</th>
                                        <th>Reclutado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="listEntrevistasCandidato">
                                    </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="vacantes-pane" role="tabpanel" aria-labelledby="vacantes-tab">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="h5 mb-0">Vacantes Activas</h4>
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle='modal' data-bs-target='#modalGestionarVacante' id="btnCrearNuevaVacante">
                                <i class="fa fa-plus"></i> Nueva Vacante
                            </button>
                        </div>
                        <div class="table-responsive">
                          <!-- TABLA DE VACANTES -->
                            <table class="table table-bordered table-striped dt-responsive T_Vacantes" id="T_Vacantes" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Área</th>
                                        <th>Sueldo</th>
                                        <th>Activo</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="listVacantesDisponibles">
                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
        </div>
    </div>
</div>

<!-- Modal de Entrevista -->
<div class="modal fade" id="modalGestionarEntrevista" tabindex="-1" aria-labelledby="modalGestionarEntrevistaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalGestionarEntrevistaLabel">Programar/Editar Entrevista</h5>
                <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formGestionarEntrevista" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="idEntrevistaGestionar" name="idEntrevistaGestionar">
                    <input type="hidden" id="idCandidatoAsociado" name="idCandidatoAsociado">
                    <div class="mb-3">
                        <label for="selectVacanteEntrevista" class="form-label">Vacante</label>
                        <select class="form-select" id="selectVacanteEntrevista" name="selectVacanteEntrevista" required>
                            </select>
                    </div>
                    <div class="mb-3">
                        <label for="fechaEntrevistaGestionar" class="form-label">Fecha de Entrevista</label>
                        <input type="date" class="form-control" id="fechaEntrevistaGestionar" name="fechaEntrevistaGestionar" required>
                    </div>
                    <div class="mb-3">
                        <label for="notasEntrevistaGestionar" class="form-label">Notas</label>
                        <textarea class="form-control" id="notasEntrevistaGestionar" name="notasEntrevistaGestionar" rows="3" placeholder="Notas sobre la entrevista"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="reclutadoEntrevistaGestionar" class="form-label">¿Candidato Reclutado para esta Vacante?</label>
                        <select class="form-select" id="reclutadoEntrevistaGestionar" name="reclutadoEntrevistaGestionar" required>
                            <option value="0">No</option>
                            <option value="1">Sí</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btnGuardarEntrevista">Guardar Entrevista</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal de Vacante -->
<div class="modal fade" id="modalGestionarVacante" tabindex="-1" aria-labelledby="modalGestionarVacanteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalGestionarVacanteLabel">Crear/Editar Vacante</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formGestionarVacante" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="idVacanteGestionar" name="idVacanteGestionar">

                    <div class="mb-3">
                        <label for="areaVacanteGestionar" class="form-label">Área</label>
                        <input type="text" class="form-control" id="areaVacanteGestionar" name="areaVacanteGestionar" placeholder="Ej. Desarrollo Web" required>
                    </div>
                    <div class="mb-3">
                        <label for="sueldoVacanteGestionar" class="form-label">Sueldo</label>
                        <input type="number" step="0.01" class="form-control" id="sueldoVacanteGestionar" name="sueldoVacanteGestionar" placeholder="Ej. 1500.00" required>
                    </div>
                    <div class="mb-3">
                        <label for="activoVacanteGestionar" class="form-label">Activo</label>
                        <select class="form-select" id="activoVacanteGestionar" name="activoVacanteGestionar" required>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btnGuardarVacante">Guardar Vacante</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- DataTables -->
<script type="text/javascript" src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>

<!-- MI JS -->
<script src="../js/candidatos.js"></script>
<script src="../js/entrevistas.js"></script>
<script src="../js/vacantes.js"></script>

</body>

</html>



