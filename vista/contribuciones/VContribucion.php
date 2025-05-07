<?php
class VContribucion {
    public function render($contribuciones, $miembros, $eventos, $contribucionEditar = null) {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        $isEditing = isset($contribucionEditar);
        $pageTitle = $isEditing ? 'Editar Contribución' : 'Registrar Contribución';
        require_once __DIR__ . '/../../vista/componentes/header.php';
?>

<body>
    <?php require_once __DIR__ . '/../../vista/componentes/navbar.php'; ?>

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
                    <select name="miembro_id" class="form-control" required>
                        <option value="">Seleccione un miembro</option>
                        <?php foreach ($miembros as $m): ?>
                            <option value="<?= $m['id'] ?>" <?= $isEditing && $contribucionEditar['miembro_id'] == $m['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($m['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Evento (opcional)</label>
                    <select name="evento_id" class="form-control">
                        <option value="">Sin evento</option>
                        <?php foreach ($eventos as $e): ?>
                            <option value="<?= $e['id'] ?>" <?= $isEditing && $contribucionEditar['evento_id'] == $e['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($e['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tipo</label>
                    <select name="tipo" class="form-control" required>
                        <option value="">Seleccione tipo</option>
                        <option value="Diezmo" <?= $isEditing && $contribucionEditar['tipo'] == 'Diezmo' ? 'selected' : '' ?>>Diezmo</option>
                        <option value="Ofrenda" <?= $isEditing && $contribucionEditar['tipo'] == 'Ofrenda' ? 'selected' : '' ?>>Ofrenda</option>
                        <option value="Donacion" <?= $isEditing && $contribucionEditar['tipo'] == 'Donacion' ? 'selected' : '' ?>>Donación</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Monto</label>
                    <input type="number" class="form-control" name="monto" step="0.01" min="0.01" required value="<?= $isEditing ? htmlspecialchars($contribucionEditar['monto']) : '' ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Fecha de Registro</label>
                    <input type="date" class="form-control" name="fecha_registro" value="<?= $isEditing ? htmlspecialchars($contribucionEditar['fecha_registro']) : '' ?>">
                </div>

                <button type="submit" class="btn btn-primary">
                    <?= $isEditing ? 'Actualizar' : 'Guardar' ?>
                </button>

                <?php if ($isEditing): ?>
                    <a href="index.php?controller=contribucion&action=listarContribucion" class="btn btn-secondary">Cancelar</a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Listado de Contribuciones -->
        <h2>Listado de Contribuciones</h2>
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Miembro</th>
                        <th>Evento</th>
                        <th>Tipo</th>
                        <th>Monto</th>
                        <th>Fecha Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($contribuciones)): ?>
                        <?php foreach ($contribuciones as $c): ?>
                            <tr>
                                <td><?= htmlspecialchars($c['id']) ?></td>
                                <td><?= htmlspecialchars($c['miembro_nombre']) ?></td>
                                <td><?= htmlspecialchars($c['evento_nombre'] ?? '') ?></td>
                                <td><?= htmlspecialchars($c['tipo']) ?></td>
                                <td><?= htmlspecialchars($c['monto']) ?></td>
                                <td><?= htmlspecialchars($c['fecha_registro']) ?></td>
                                <td>
                                    <a href="index.php?controller=contribucion&action=editarContribucion&id=<?= $c['id'] ?>"
                                        class="btn btn-warning btn-sm">Editar</a>
                                    <a href="index.php?controller=contribucion&action=eliminarContribucion&id=<?= $c['id'] ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('¿Eliminar esta contribución?')">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No hay contribuciones registradas.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php require_once __DIR__ . '/../../vista/componentes/footer.php'; ?>
<?php
    }
}
