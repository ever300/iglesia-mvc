<?php
class VAsignacion_Ministerio
{
    public function render($asignaciones, $miembros, $ministerios, $asignacionEditar = null)
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        $isEditing = isset($asignacionEditar);
        $pageTitle = $isEditing ? 'Editar Asignación Ministerio' : 'Registrar Asignación Ministerio';
        require_once __DIR__ . '/../../vista/componentes/header.php';
?>

        <body>
            <?php require_once __DIR__ . '/../../vista/componentes/navbar.php'; ?>
            <div class="container mt-4">
                <h1><?= $isEditing ? 'Editar Asignación Ministerio' : 'Registrar Asignación Ministerio' ?></h1>
                <!-- Formulario CRUD -->
                <div class="form-container">
                    <form action="index.php?controller=asignacion_ministerio&action=<?= $isEditing ? 'editarAsignacion' : 'crearAsignacion' ?>" method="POST">
                        <?php if ($isEditing): ?>
                            <input type="hidden" name="miembro_id" value="<?= htmlspecialchars($asignacionEditar['miembro_id']) ?>">
                            <input type="hidden" name="ministerio_id" value="<?= htmlspecialchars($asignacionEditar['ministerio_id']) ?>">
                        <?php endif; ?>
                        <div class="mb-3">
                            <label class="form-label">Miembro</label>
                            <select class="form-control" name="miembro_id" <?= $isEditing ? 'disabled' : '' ?> required>
                                <option value="">Seleccione un miembro</option>
                                <?php foreach ($miembros as $miembro): ?>
                                    <option value="<?= $miembro['id'] ?>" <?= $isEditing && $asignacionEditar['miembro_id'] == $miembro['id'] ? 'selected' : '' ?>><?= htmlspecialchars($miembro['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ministerio</label>
                            <select class="form-control" name="ministerio_id" <?= $isEditing ? 'disabled' : '' ?> required>
                                <option value="">Seleccione un ministerio</option>
                                <?php foreach ($ministerios as $ministerio): ?>
                                    <option value="<?= $ministerio['id'] ?>" <?= $isEditing && $asignacionEditar['ministerio_id'] == $ministerio['id'] ? 'selected' : '' ?>><?= htmlspecialchars($ministerio['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fecha Inicio</label>
                            <input type="date" class="form-control" name="fecha_inicio" value="<?= $isEditing ? htmlspecialchars($asignacionEditar['fecha_inicio']) : '' ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fecha Final</label>
                            <input type="date" class="form-control" name="fecha_final" value="<?= $isEditing ? htmlspecialchars($asignacionEditar['fecha_final']) : '' ?>">
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" name="estado" id="estado" value="1" <?= $isEditing && $asignacionEditar['estado'] ? 'checked' : '' ?> <?= !$isEditing ? 'checked' : '' ?>>
                            <label class="form-check-label" for="estado">Activo</label>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <?= $isEditing ? 'Actualizar' : 'Guardar' ?>
                        </button>
                        <?php if ($isEditing): ?>
                            <a href="index.php?controller=asignacion_ministerio&action=listarAsignaciones" class="btn btn-secondary">Cancelar</a>
                        <?php endif; ?>
                    </form>
                </div>
                <!-- Listado de asignaciones -->
                <h2 class="mt-4">Listado de Asignaciones de Ministerio</h2>
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
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
                                        <td><?= htmlspecialchars($asignacion['miembro_id']) ?></td>
                                        <td><?= htmlspecialchars($asignacion['miembro_nombre'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($asignacion['ministerio_nombre'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($asignacion['fecha_inicio'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($asignacion['fecha_final'] ?? '') ?></td>
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
            <?php require_once __DIR__ . '/../../vista/componentes/footer.php'; ?>
        </body>
<?php
    }
}
