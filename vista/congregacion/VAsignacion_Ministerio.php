<?php
require_once __DIR__ . '/../VistaBase.php';

class VAsignacion_Ministerio extends VistaBase {
    public function render($asignaciones, $miembros, $ministerios, $asignacionEditar = null) {
        $this->pageTitle = isset($asignacionEditar) ? 'Editar Asignación Ministerio' : 'Registrar Asignación Ministerio';
        parent::render($asignaciones, $miembros, $ministerios, $asignacionEditar);
    }

    protected function contenido($asignaciones, $miembros, $ministerios, $asignacionEditar = null) {
        $isEditing = isset($asignacionEditar);
        ?>
        <div class="container mt-4">
            <h1><?= $this->pageTitle ?></h1>
            <!-- Formulario CRUD -->
            <div class="form-container">
                <form action="index.php?controller=asignacion_ministerio&action=<?= $isEditing ? 'editarAsignacion' : 'crearAsignacion' ?>" method="POST">
                    <?php if ($isEditing): ?>
                        <input type="hidden" name="id" value="<?= htmlspecialchars($asignacionEditar['id']) ?>">
                    <?php endif; ?>
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
                            <th>ID</th>
                            <th>Miembro</th>
                            <th>Ministerio</th>
                            <th>Fecha Asignación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($asignaciones)): ?>
                            <?php foreach ($asignaciones as $asignacion): ?>
                                <tr>
                                    <td><?= htmlspecialchars($asignacion['id']) ?></td>
                                    <td><?= htmlspecialchars($asignacion['miembro_nombre']) ?></td>
                                    <td><?= htmlspecialchars($asignacion['ministerio_nombre']) ?></td>
                                    <td><?= htmlspecialchars($asignacion['fecha_asignacion']) ?></td>
                                    <td>
                                        <a href="index.php?controller=asignacion_ministerio&action=editarAsignacion&id=<?= $asignacion['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                        <a href="index.php?controller=asignacion_ministerio&action=eliminarAsignacion&id=<?= $asignacion['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta asignación?')">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">No hay asignaciones registradas.</td>
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
