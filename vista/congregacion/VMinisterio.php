<?php
require_once __DIR__ . '/../VistaBase.php';

class VMinisterio extends VistaBase {
    public function render(...$params) {
        $ministerioEditar = $params[1] ?? null;
        $this->pageTitle = isset($ministerioEditar) ? 'Editar Ministerio' : 'Registrar Ministerio';
        parent::render(...$params);
    }

    protected function contenido(...$params) {
        $ministerios = $params[0] ?? [];
        $ministerioEditar = $params[1] ?? null;
        $isEditing = isset($ministerioEditar);
        ?>
        <div class="container mt-4">
            <h1><?= $this->pageTitle ?></h1>

            <!-- Formulario -->
            <form action="index.php?controller=ministerio&action=<?= $isEditing ? 'editarMinisterio&id=' . htmlspecialchars($ministerioEditar['id']) : 'crearMinisterio' ?>" method="POST">
                <?php if ($isEditing): ?>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($ministerioEditar['id']) ?>">
                <?php endif; ?>

                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="nombre" value="<?= $isEditing ? htmlspecialchars($ministerioEditar['nombre']) : '' ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">
                    <?= $isEditing ? 'Actualizar' : 'Guardar' ?>
                </button>
                <?php if ($isEditing): ?>
                    <a href="index.php?controller=ministerio&action=listarMinisterio" class="btn btn-secondary">Cancelar</a>
                <?php endif; ?>
            </form>

            <!-- Listado -->
            <h2>Listado de Ministerios</h2>
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
                        <?php if (!empty($ministerios)): ?>
                            <?php foreach ($ministerios as $ministerio): ?>
                                <tr>
                                    <td><?= htmlspecialchars($ministerio['id']) ?></td>
                                    <td><?= htmlspecialchars($ministerio['nombre']) ?></td>
                                    <td>
                                        <a href="index.php?controller=ministerio&action=editarMinisterio&id=<?= $ministerio['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                        <a href="index.php?controller=ministerio&action=eliminarMinisterio&id=<?= $ministerio['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este ministerio?')">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">No hay ministerios registrados.</td>
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
