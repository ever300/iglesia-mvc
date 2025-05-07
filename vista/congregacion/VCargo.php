<?php
class VCargo {
    public function render($cargos = [], $cargoEditar = null) {
        $isEditing = isset($cargoEditar);
        $pageTitle = $isEditing ? 'Editar Cargo' : 'Registrar Cargo';
        require_once __DIR__ . '/../componentes/header.php';
        require_once __DIR__ . '/../componentes/navbar.php';
        ?>
        <div class="container mt-4">
            <h1><?= $pageTitle ?></h1>
            <!-- Formulario CRUD -->
            <div class="form-container">
                <form action="index.php?controller=cargo&action=<?= $isEditing ? 'editarCargo&id=' . htmlspecialchars($cargoEditar['id']) : 'crearCargo' ?>" method="POST">
                    <?php if ($isEditing): ?>
                        <input type="hidden" name="id" value="<?= htmlspecialchars($cargoEditar['id']) ?>">
                    <?php endif; ?>
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="nombre"
                            value="<?= $isEditing ? htmlspecialchars($cargoEditar['nombre']) : '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea class="form-control" name="descripcion" rows="3"><?= $isEditing ? htmlspecialchars($cargoEditar['descripcion']) : '' ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <?= $isEditing ? 'Actualizar' : 'Guardar' ?>
                    </button>
                    <?php if ($isEditing): ?>
                        <a href="index.php?controller=cargo&action=listarCargo" class="btn btn-secondary">Cancelar</a>
                    <?php endif; ?>
                </form>
            </div>
            <!-- Listado de cargos -->
            <h2 class="mt-4">Listado de Cargos</h2>
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($cargos)): ?>
                            <?php foreach ($cargos as $cargo): ?>
                                <tr>
                                    <td><?= htmlspecialchars($cargo['id']) ?></td>
                                    <td><?= htmlspecialchars($cargo['nombre']) ?></td>
                                    <td><?= htmlspecialchars($cargo['descripcion']) ?></td>
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
        require_once __DIR__ . '/../componentes/footer.php';
    }
}
