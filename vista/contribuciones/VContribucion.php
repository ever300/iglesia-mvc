<?php
require_once __DIR__ . '/../VistaBase.php';

class VContribucion extends VistaBase {
    public function render(...$params) {
        $contribucionEditar = $params[3] ?? null;
        $this->pageTitle = isset($contribucionEditar) ? 'Editar Contribución' : 'Registrar Contribución';
        parent::render(...$params);
    }

    protected function contenido($contribuciones, $miembros, $eventos, $contribucionEditar = null) {
        $isEditing = isset($contribucionEditar);
        ?>
        <div class="container mt-4">
            <h1><?= $isEditing ? 'Editar Contribución' : 'Registrar Contribución' ?></h1>

            <!-- Formulario CRUD -->
            <div class="form-container">
                <form action="index.php?controller=contribucion&action=<?= $isEditing ? 'editarContribucion&id=' . htmlspecialchars($contribucionEditar['id']) : 'crearContribucion' ?>" method="POST">
                    <?php if ($isEditing): ?>
                        <input type="hidden" name="id" value="<?= htmlspecialchars($contribucionEditar['id']) ?>">
                    <?php endif; ?>
                    <div class="mb-3">
                        <label class="form-label">Miembro</label>
                        <select name="miembro_id" class="form-select" required>
                            <option value="">Seleccione un miembro</option>
                            <?php foreach ($miembros as $miembro): ?>
                                <option value="<?= $miembro['id'] ?>" <?= $isEditing && $miembro['id'] == $contribucionEditar['miembro_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($miembro['nombre_completo']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Evento</label>
                        <select name="evento_id" class="form-select">
                            <option value="">Seleccione un evento</option>
                            <?php foreach ($eventos as $evento): ?>
                                <option value="<?= $evento['id'] ?>" <?= $isEditing && $evento['id'] == $contribucionEditar['evento_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($evento['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Monto</label>
                        <input type="number" step="0.01" name="monto" class="form-control" value="<?= $isEditing ? htmlspecialchars($contribucionEditar['monto']) : '' ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <?= $isEditing ? 'Actualizar' : 'Guardar' ?>
                    </button>
                    <?php if ($isEditing): ?>
                        <a href="index.php?controller=contribucion&action=listarContribucion" class="btn btn-secondary">Cancelar</a>
                    <?php endif; ?>
                </form>
            </div>

            <!-- Listado -->
            <h2>Listado de Contribuciones</h2>
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Miembro</th>
                            <th>Evento</th>
                            <th>Monto</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($contribuciones)): ?>
                            <?php foreach ($contribuciones as $contribucion): ?>
                                <tr>
                                    <td><?= htmlspecialchars($contribucion['id']) ?></td>
                                    <td><?= htmlspecialchars($contribucion['miembro_nombre']) ?></td>
                                    <td><?= htmlspecialchars($contribucion['evento_nombre']) ?></td>
                                    <td><?= htmlspecialchars($contribucion['monto']) ?></td>
                                    <td><?= htmlspecialchars($contribucion['fecha']) ?></td>
                                    <td>
                                        <a href="index.php?controller=contribucion&action=editarContribucion&id=<?= $contribucion['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                        <a href="index.php?controller=contribucion&action=eliminarContribucion&id=<?= $contribucion['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta contribución?')">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">No hay contribuciones registradas.</td>
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
