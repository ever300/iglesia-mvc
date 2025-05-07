<?php
class VMinisterio {
    public function render($ministerios = [], $ministerioEditar = null) {
        $isEditing = isset($ministerioEditar);
        $pageTitle = $isEditing ? 'Editar Ministerio' : 'Registrar Ministerio';

        require_once __DIR__ . '/../componentes/header.php';
        require_once __DIR__ . '/../componentes/navbar.php';
        ?>

        <div class="container mt-4">
            <h1><?= $pageTitle ?></h1>

            <!-- Formulario -->
            <form action="index.php?controller=ministerio&action=<?= $isEditing ? 'editarMinisterio&id=' . htmlspecialchars($ministerioEditar['id']) : 'crearMinisterio' ?>" method="POST">
                <?php if ($isEditing): ?>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($ministerioEditar['id']) ?>">
                <?php endif; ?>

                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="nombre"
                        value="<?= $isEditing ? htmlspecialchars($ministerioEditar['nombre']) : '' ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea class="form-control" name="descripcion" rows="3"><?= $isEditing ? htmlspecialchars($ministerioEditar['descripcion']) : '' ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    <?= $isEditing ? 'Actualizar' : 'Guardar' ?>
                </button>

                <?php if ($isEditing): ?>
                    <a href="index.php?controller=ministerio&action=listarMinisterio" class="btn btn-secondary">Cancelar</a>
                <?php endif; ?>
            </form>

            <!-- Listado -->
            <h2 class="mt-4">Listado de Ministerios</h2>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Fecha Creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($ministerios)): ?>
                        <?php foreach ($ministerios as $ministerio): ?>
                            <tr>
                                <td><?= htmlspecialchars($ministerio['id']) ?></td>
                                <td><?= htmlspecialchars($ministerio['nombre']) ?></td>
                                <td><?= htmlspecialchars($ministerio['descripcion']) ?></td>
                                <td><?= htmlspecialchars($ministerio['fecha_creacion']) ?></td>
                                <td>
                                    <a href="index.php?controller=ministerio&action=editarMinisterio&id=<?= $ministerio['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                    <a href="index.php?controller=ministerio&action=eliminarMinisterio&id=<?= $ministerio['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este ministerio?')">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center">No hay ministerios registrados.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php
        require_once __DIR__ . '/../componentes/footer.php';
    }
}
