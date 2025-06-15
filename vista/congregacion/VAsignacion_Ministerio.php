<?php
require_once __DIR__ . '/../VistaBase.php';

class VAsignacion_Ministerio extends VistaBase {
    public function render(...$params) {
        $asignacionEditar = $params[3] ?? null;
        $this->pageTitle = isset($asignacionEditar) ? 'Editar Asignación Ministerio' : 'Registrar Asignación Ministerio';
        parent::render(...$params);
    }

    protected function contenido(...$params) {
        $asignaciones = $params[0] ?? [];
        $miembros = $params[1] ?? [];
        $ministerios = $params[2] ?? [];
        $asignacionEditar = $params[3] ?? null;
        $isEditing = isset($asignacionEditar);
        ?>
        <div class="container mt-4">
            <h1><?= $this->pageTitle ?></h1>
            <!-- Formulario CRUD -->
            <div class="form-container">
                <form action="index.php?controller=asignacion_ministerio&action=<?= $isEditing ? 'editarAsignacion' : 'crearAsignacion' ?>" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Miembro</label>
                        <select class="form-select" name="miembro_id" required>
                            <option value="">Seleccione un miembro</option>
                            <?php foreach ($miembros as $miembro): ?>
                                <option value="<?= $miembro['id'] ?>" <?= $isEditing && $miembro['id'] == $asignacionEditar['miembro_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($miembro['nombre_completo']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ministerio</label>
                        <select class="form-select" name="ministerio_id" required>
                            <option value="">Seleccione un ministerio</option>
                            <?php foreach ($ministerios as $ministerio): ?>
                                <option value="<?= $ministerio['id'] ?>" <?= $isEditing && $ministerio['id'] == $asignacionEditar['ministerio_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($ministerio['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <?= $isEditing ? 'Actualizar' : 'Guardar' ?>
                    </button>
                    <?php if ($isEditing): ?>
                        <a href="index.php?controller=asignacion_ministerio&action=listarAsignaciones" class="btn btn-secondary">Cancelar</a>
                    <?php endif; ?>
                </form>
            </div>
            <!-- Listado -->
            <h2>Asignaciones</h2>
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Miembro</th>
                            <th>Ministerio</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Final</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($asignaciones)): ?>
                            <?php foreach ($asignaciones as $asignacion): ?>
                                <tr>
                                    <td><?= htmlspecialchars($asignacion['miembro_nombre']) ?></td>
                                    <td><?= htmlspecialchars($asignacion['ministerio_nombre']) ?></td>
                                    <td><?= htmlspecialchars($asignacion['fecha_inicio']) ?></td>
                                    <td><?= htmlspecialchars($asignacion['fecha_final']) ?></td>
                                    <td><?= $asignacion['estado'] ? 'Activo' : 'Inactivo' ?></td>
                                    <td>
                                        <a href="index.php?controller=asignacion_ministerio&action=editarAsignacion&miembro_id=<?= $asignacion['miembro_id'] ?>&ministerio_id=<?= $asignacion['ministerio_id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                        <a href="index.php?controller=asignacion_ministerio&action=eliminarAsignacion&miembro_id=<?= $asignacion['miembro_id'] ?>&ministerio_id=<?= $asignacion['ministerio_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta asignación?')">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">No hay asignaciones registradas.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
    }
}
?>
