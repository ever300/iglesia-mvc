<?php
class VMiembro {
    public function render($miembros = [], $cargos = [], $miembroEditar = null) {
        $isEditing = isset($miembroEditar);
        $pageTitle = $isEditing ? 'Editar Miembro' : 'Registrar Miembro';
        require_once __DIR__ . '/../componentes/header.php';
        require_once __DIR__ . '/../componentes/navbar.php';
        ?>
        <div class="container mt-4">
            <h1><?= $pageTitle ?></h1>
            <!-- Formulario CRUD -->
            <div class="form-container">
                <form action="index.php?controller=miembro&action=<?= $isEditing ? 'editarMiembro&id=' . htmlspecialchars($miembroEditar['id']) : 'crearMiembro' ?>" method="POST">
                    <?php if ($isEditing): ?>
                        <input type="hidden" name="id" value="<?= htmlspecialchars($miembroEditar['id']) ?>">
                    <?php endif; ?>
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="nombre"
                            value="<?= $isEditing ? htmlspecialchars($miembroEditar['nombre']) : '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Apellido</label>
                        <input type="text" class="form-control" name="apellido"
                            value="<?= $isEditing ? htmlspecialchars($miembroEditar['apellido']) : '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha de Nacimiento</label>
                        <input type="date" class="form-control" name="fecha_nacimiento"
                            value="<?= $isEditing ? htmlspecialchars($miembroEditar['fecha_nacimiento']) : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" class="form-control" name="telefono"
                            value="<?= $isEditing ? htmlspecialchars($miembroEditar['telefono']) : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cargo</label>
                        <select class="form-select" name="cargo_id" required>
                            <option value="">Seleccione un cargo</option>
                            <?php foreach ($cargos as $cargo): ?>
                                <option value="<?= htmlspecialchars($cargo['id']) ?>"
                                    <?= $isEditing && $cargo['id'] == $miembroEditar['cargo_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cargo['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <?= $isEditing ? 'Actualizar' : 'Guardar' ?>
                    </button>
                    <?php if ($isEditing): ?>
                        <a href="index.php?controller=miembro&action=listarMiembro" class="btn btn-secondary">Cancelar</a>
                    <?php endif; ?>
                </form>
            </div>
            <!-- Listado de miembros -->
            <h2>Listado de Miembros</h2>
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Fecha Nacimiento</th>
                            <th>Teléfono</th>
                            <th>Cargo</th>
                            <th>Fecha Ingreso</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($miembros)): ?>
                            <?php foreach ($miembros as $miembro): ?>
                                <tr>
                                    <td><?= htmlspecialchars($miembro['id']) ?></td>
                                    <td><?= htmlspecialchars($miembro['nombre']) ?></td>
                                    <td><?= htmlspecialchars($miembro['apellido']) ?></td>
                                    <td><?= htmlspecialchars($miembro['fecha_nacimiento']) ?></td>
                                    <td><?= htmlspecialchars($miembro['telefono']) ?></td>
                                    <td><?= htmlspecialchars($miembro['cargo_nombre']) ?></td>
                                    <td><?= htmlspecialchars($miembro['fecha_ingreso']) ?></td>
                                    <td>
                                        <a href="index.php?controller=miembro&action=editarMiembro&id=<?= $miembro['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                        <a href="index.php?controller=miembro&action=eliminarMiembro&id=<?= $miembro['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este miembro?')">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">No hay miembros registrados.</td>
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
