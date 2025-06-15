<?php
require_once __DIR__ . '/../VistaBase.php';

class VCategoria_evento extends VistaBase {
    public function render(...$params) {
        $categoriaEditar = $params[1] ?? null;
        $this->pageTitle = isset($categoriaEditar) ? 'Editar Categoría de Evento' : 'Registrar Categoría de Evento';
        parent::render(...$params);
    }

    protected function contenido($categorias = [], $categoriaEditar = null) {
        $isEditing = isset($categoriaEditar);
        ?>
        <div class="container mt-4">
            <h1><?= $this->pageTitle ?></h1>
            <!-- Formulario CRUD -->
            <div class="form-container">
                <form action="index.php?controller=categoria_evento&action=<?= $isEditing ? 'editarCategoria_evento&id=' . htmlspecialchars($categoriaEditar['id']) : 'crearCategoria_evento' ?>" method="POST">
                    <?php if ($isEditing): ?>
                        <input type="hidden" name="id" value="<?= htmlspecialchars($categoriaEditar['id']) ?>">
                    <?php endif; ?>
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="nombre" value="<?= $isEditing ? htmlspecialchars($categoriaEditar['nombre']) : '' ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <?= $isEditing ? 'Actualizar' : 'Guardar' ?>
                    </button>
                    <?php if ($isEditing): ?>
                        <a href="index.php?controller=categoria_evento&action=listarCategoria_evento" class="btn btn-secondary">Cancelar</a>
                    <?php endif; ?>
                </form>
            </div>
            <!-- Listado -->
            <h2>Listado de Categorías de Evento</h2>
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
                        <?php if (!empty($categorias)): ?>
                            <?php foreach ($categorias as $categoria): ?>
                                <tr>
                                    <td><?= htmlspecialchars($categoria['id']) ?></td>
                                    <td><?= htmlspecialchars($categoria['nombre']) ?></td>
                                    <td>
                                        <a href="index.php?controller=categoria_evento&action=editarCategoria_evento&id=<?= $categoria['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                        <a href="index.php?controller=categoria_evento&action=eliminarCategoria_evento&id=<?= $categoria['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta categoría?')">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">No hay categorías registradas.</td>
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
