<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config/conexion.php';
session_start();

$controller = $_GET['controller'] ?? null;

if ($controller) {
    $controllerClass = 'C' . ucfirst($controller);
    $controllerFile = "controlador/{$controllerClass}.php";

    if (file_exists($controllerFile)) {
        require_once $controllerFile;
        $controllerInstance = new $controllerClass();
        if ($controller !== 'auth') {
            require_once 'controlador/AuthProxy.php';
            $controllerInstance = new AuthProxy($controllerInstance);
        }
        $controllerInstance->handleRequest();
        exit; // Detiene aquí para evitar que cargue el HTML debajo
    } else {
        die("❌ Controlador no encontrado: $controllerClass");
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Sistema de Gestión Iglesia</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="recursos/estilos.css">
</head>

<body>

    <!-- Navegación unificada -->
    <?php require_once __DIR__ . '/vista/componentes/navbar.php'; ?>

    <!-- Dashboard -->
    <div class="container mt-4">
        <h1 class="mb-4">Bienvenido al Sistema de Gestión de Iglesia</h1>
        <div class="row">
            <!-- Congregación -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Módulo Congregación</h5>
                        <div class="list-group mt-2">
                            <a href="index.php?controller=miembro&action=listarMiembro" class="list-group-item list-group-item-action">
                                <i class="bi bi-person-lines-fill"></i> Gestionar Miembros
                            </a>
                            <a href="index.php?controller=ministerio&action=listarMinisterio" class="list-group-item list-group-item-action">
                                <i class="bi bi-people-fill"></i> Gestionar Ministerios
                            </a>
                            <a href="index.php?controller=cargo&action=listarCargo" class="list-group-item list-group-item-action">
                                <i class="bi bi-person-badge"></i> Gestionar Cargos
                            </a>
                            <a href="index.php?controller=asignacion_ministerio&action=listarAsignaciones" class="list-group-item list-group-item-action">
                                <i class="bi bi-link-45deg"></i> Gestionar Asignación Ministerio
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Eventos -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Módulo Eventos</h5>
                        <div class="list-group mt-2">
                            <a href="index.php?controller=categoria_evento&action=listarCategoria_evento" class="list-group-item list-group-item-action">
                                <i class="bi bi-calendar-event-fill"></i> Gestionar Categorías
                            </a>
                            <a href="index.php?controller=evento&action=listarEvento" class="list-group-item list-group-item-action">
                                <i class="bi bi-calendar-check-fill"></i> Gestionar Eventos
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Contribuciones -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Módulo Contribuciones</h5>
                        <div class="list-group mt-2">
                            <a href="index.php?controller=contribucion&action=listarContribucion" class="list-group-item list-group-item-action">
                                <i class="bi bi-cash-coin"></i> Gestionar Contribuciones
                            </a>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>