<?php
class VCategoria_evento
{
    public function render($categorias = [], $categoriaEditar = null)
    {
        $isEditing = isset($categoriaEditar);
        $pageTitle = $isEditing ? 'Editar Categoría de Evento' : 'Registrar Categoría de Evento';
        require_once __DIR__ . '/../../vista/componentes/header.php';
        require_once __DIR__ . '/../../vista/componentes/navbar.php';
?>
        <div class="container mt-4">
            <h1><?= $pageTitle ?></h1>
            <!-- Formulario CRUD -->
            <div class="form-container">
                <form action="index.php?controller=categoria_evento&action=<?= $isEditing ? 'editarCategoria_evento&id=' . htmlspecialchars($categoriaEditar['id']) : 'crearCategoria_evento' ?>" method="POST">
                    <?php if ($isEditing): ?>
                        <input type="hidden" name="id" value="<?= htmlspecialchars($categoriaEditar['id']) ?>">
                    <?php endif; ?>
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="nombre"
                            value="<?= $isEditing ? htmlspecialchars($categoriaEditar['nombre']) : '' ?>" required maxlength="30">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea class="form-control" name="descripcion" rows="3" maxlength="200"><?= $isEditing ? htmlspecialchars($categoriaEditar['descripcion']) : '' ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <?= $isEditing ? 'Actualizar' : 'Guardar' ?>
                    </button>
                    <?php if ($isEditing): ?>
                        <a href="index.php?controller=categoria_evento&action=listarCategoria_evento" class="btn btn-secondary">Cancelar</a>
                    <?php endif; ?>
                </form>
            </div>
            <!-- Listado de Categorías de Evento -->
            <h2 class="mt-4">Listado de Categorías de Evento</h2>
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
                        <?php if (!empty($categorias)): ?>
                            <?php foreach ($categorias as $categoria): ?>
                                <tr>
                                    <td><?= htmlspecialchars($categoria['id']) ?></td>
                                    <td><?= htmlspecialchars($categoria['nombre']) ?></td>
                                    <td><?= htmlspecialchars($categoria['descripcion']) ?></td>
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
        require_once __DIR__ . '/../../vista/componentes/footer.php';
    }
}
