<?php
require_once __DIR__ . '/../VistaBase.php';

class VCargo extends VistaBase {
    public function render(...$params) {
        $cargoEditar = $params[1] ?? null;
        $this->pageTitle = isset($cargoEditar) ? 'Editar Cargo' : 'Registrar Cargo';
        parent::render(...$params);
    }

    protected function contenido($cargos = [], $cargoEditar = null) {
        $isEditing = isset($cargoEditar);
        ?>
        <div class="container mt-4">
            <h1><?= $this->pageTitle ?></h1>
            <!-- Formulario CRUD -->
            <div class="form-container">
                <form action="index.php?controller=cargo&action=<?= $isEditing ? 'editarCargo&id=' . htmlspecialchars($cargoEditar['id']) : 'crearCargo' ?>" method="POST">
                    <?php if ($isEditing): ?>
                        <input type="hidden" name="id" value="<?= htmlspecialchars($cargoEditar['id']) ?>">
                    <?php endif; ?>
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="nombre" value="<?= $isEditing ? htmlspecialchars($cargoEditar['nombre']) : '' ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <?= $isEditing ? 'Actualizar' : 'Guardar' ?>
                    </button>
                    <?php if ($isEditing): ?>
                        <a href="index.php?controller=cargo&action=listarCargo" class="btn btn-secondary">Cancelar</a>
                    <?php endif; ?>
                </form>
            </div>
            <!-- Listado -->
            <h2>Listado de Cargos</h2>
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($cargos)): ?>
                            <?php foreach ($cargos as $cargo): ?>
                                <tr>
                                    <td><?= htmlspecialchars($cargo['id']) ?></td>
                                    <td><?= htmlspecialchars($cargo['nombre']) ?></td>
                                    <td>
                                        <a href="index.php?controller=cargo&action=editarCargo&id=<?= $cargo['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                        <a href="index.php?controller=cargo&action=eliminarCargo&id=<?= $cargo['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este cargo?')">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">No hay cargos registrados.</td>
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
