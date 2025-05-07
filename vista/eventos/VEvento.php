<?php
class VEvento {
    public function render(
        $eventos,
        $categorias,
        $form_evento = [],
        $eventoEditar = null,
        $miembros = [],
        $cargos = [],
        $asistentes_evento = []
    ) {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        $isEditing = isset($eventoEditar);
        $pageTitle = $isEditing ? 'Editar Evento' : 'Registrar Evento';
        require_once __DIR__ . '/../../vista/componentes/header.php';
?>

<body>
    <?php require_once __DIR__ . '/../../vista/componentes/navbar.php'; ?>

    <div class="container mt-4">
        <h1><?= $isEditing ? 'Editar Evento' : 'Registrar Evento' ?></h1>

        <!-- 1. Formulario: Datos del evento -->
        <div class="form-container mb-4">
            <form action="index.php?controller=evento&action=<?= $isEditing ? 'editarEvento&id=' . $eventoEditar['id'] : 'crearEvento' ?>" method="POST" class="row g-3 align-items-end mb-4">
                <?php if ($isEditing): ?>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($eventoEditar['id']) ?>">
                <?php endif; ?>
                <div class="mb-3">
                    <label class="form-label">Categoría</label>
                    <select name="categoria_id" class="form-control" required>
                        <option value="">Seleccione una categoría</option>
                        <?php
                        $categoria_selected = '';
                        if ($isEditing && isset($eventoEditar['categoria_id'])) {
                            $categoria_selected = $eventoEditar['categoria_id'];
                        } elseif (isset($form_evento['categoria_id'])) {
                            $categoria_selected = $form_evento['categoria_id'];
                        } elseif (isset($_POST['categoria_id'])) {
                            $categoria_selected = $_POST['categoria_id'];
                        }
                        foreach ($categorias as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= ($categoria_selected == $cat['id']) ? 'selected' : '' ?>> <?= htmlspecialchars($cat['nombre']) ?> </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="nombre" maxlength="100" required value="<?php
                        if ($isEditing && isset($eventoEditar['nombre'])) {
                            echo htmlspecialchars($eventoEditar['nombre']);
                        } elseif (isset($form_evento['nombre'])) {
                            echo htmlspecialchars($form_evento['nombre']);
                        } elseif (isset($_POST['nombre'])) {
                            echo htmlspecialchars($_POST['nombre']);
                        }
                    ?>">
                </div>
                <div class="mb-3 row">
                    <div class="col">
                        <label class="form-label">Fecha Inicio</label>
                        <input type="date" class="form-control" name="fecha_inicio" required value="<?php
                            if ($isEditing && isset($eventoEditar['fecha_inicio'])) {
                                echo htmlspecialchars($eventoEditar['fecha_inicio']);
                            } elseif (isset($form_evento['fecha_inicio'])) {
                                echo htmlspecialchars($form_evento['fecha_inicio']);
                            } elseif (isset($_POST['fecha_inicio'])) {
                                echo htmlspecialchars($_POST['fecha_inicio']);
                            }
                        ?>">
                    </div>
                    <div class="col">
                        <label class="form-label">Fecha Final</label>
                        <input type="date" class="form-control" name="fecha_final" value="<?php
                            if ($isEditing && isset($eventoEditar['fecha_final'])) {
                                echo htmlspecialchars($eventoEditar['fecha_final']);
                            } elseif (isset($form_evento['fecha_final'])) {
                                echo htmlspecialchars($form_evento['fecha_final']);
                            } elseif (isset($_POST['fecha_final'])) {
                                echo htmlspecialchars($_POST['fecha_final']);
                            }
                        ?>">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Lugar</label>
                    <input type="text" class="form-control" name="lugar" maxlength="100" value="<?php
                        if ($isEditing && isset($eventoEditar['lugar'])) {
                            echo htmlspecialchars($eventoEditar['lugar']);
                        } elseif (isset($form_evento['lugar'])) {
                            echo htmlspecialchars($form_evento['lugar']);
                        } elseif (isset($_POST['lugar'])) {
                            echo htmlspecialchars($_POST['lugar']);
                        }
                    ?>">
                </div>

                <!-- Sección para agregar asistentes -->
                <h5 class="mt-4">Agregar Asistente</h5>
                <div class="mb-3 row align-items-end">
                    <div class="col">
                        <label class="form-label">Miembro</label>
                        <select name="miembro_id" class="form-control">
                            <option value="">Seleccione un miembro</option>
                            <?php foreach ($miembros as $miembro): ?>
                                <option value="<?= $miembro['id'] ?>"><?= htmlspecialchars($miembro['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col">
                        <label class="form-label">Cargo</label>
                        <select name="cargo_id" class="form-control">
                            <option value="">Seleccione un cargo</option>
                            <?php foreach ($cargos as $cargo): ?>
                                <option value="<?= $cargo['id'] ?>"><?= htmlspecialchars($cargo['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-auto">
                        <button type="submit" name="agregar_asistente" class="btn btn-success"
                        <?php if ($isEditing): ?>
                            formaction="index.php?controller=evento&action=editarEvento&id=<?= $eventoEditar['id'] ?>"
                        <?php endif; ?>
                        >Agregar Asistente</button>
                    </div>
                </div>

                <!-- 3. Formulario: Lista de Asistentes -->
                <h5 class="mt-4">Lista de Asistentes</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Miembro</th>
                                <th>Cargo</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($asistentes_evento)): ?>
                                <?php foreach ($asistentes_evento as $idx => $asistente): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($asistente['miembro_nombre'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($asistente['cargo_nombre'] ?? '') ?></td>
                                        <td>
                                            <?php if ($isEditing): ?>
                                                <a href="index.php?controller=evento&action=eliminarAsistenteTemp&evento_id=<?= $eventoEditar['id'] ?>&miembro_id=<?= $asistente['miembro_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este asistente del evento?')">Eliminar</a>
                                            <?php else: ?>
                                                <a href="index.php?controller=evento&action=eliminarAsistenteTemp&index=<?= $idx ?>" class="btn btn-danger btn-sm">Eliminar</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="3" class="text-center">No hay asistentes agregados.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <!-- Botón para guardar todo -->
                <button type="submit" name="guardar_evento" class="btn btn-primary mt-3">
                    <?= $isEditing ? 'Actualizar Evento' : 'Guardar Evento y Asistentes' ?>
                </button>
            </form>

        </div>


        <!-- Listado de Eventos -->
        <h2>Listado de Eventos</h2>
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Categoría</th>
                        <th>Nombre</th>
                        <th>Fecha</th>
                        <th>Lugar</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($eventos)): ?>
                        <?php foreach ($eventos as $evento): ?>
                            <tr>
                                <td><?= htmlspecialchars($evento['id']) ?></td>
                                <td><?= htmlspecialchars($evento['categoria_nombre']) ?></td>
                                <td><?= htmlspecialchars($evento['nombre']) ?></td>
                                <td>
                                    <?php
                                        $fecha_inicio = isset($evento['fecha_inicio']) ? $evento['fecha_inicio'] : '';
                                        $fecha_final = isset($evento['fecha_final']) ? $evento['fecha_final'] : '';
                                        $fecha_mostrar = $fecha_inicio;
                                        if ($fecha_final && $fecha_final !== $fecha_inicio) {
                                            $fecha_mostrar .= ' al ' . $fecha_final;
                                        }
                                        echo htmlspecialchars($fecha_mostrar ?? '');
                                    ?>
                                </td>
                                <td><?= htmlspecialchars($evento['lugar']) ?></td>
                                <td>
                                    <a href="index.php?controller=evento&action=editarEvento&id=<?= $evento['id'] ?>"
                                        class="btn btn-warning btn-sm">Editar</a>
                                    <a href="index.php?controller=evento&action=eliminarEvento&id=<?= $evento['id'] ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('¿Eliminar este evento?')">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No hay eventos registrados.</td>
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
