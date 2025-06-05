<!-- Barra de navegación profesional unificada extraída del index principal -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="index.php">Sistema de Gestión Iglesia</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <!-- Congregación -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Módulo Congregación</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="index.php?controller=miembro&action=listarMiembro">Gestionar Miembros</a></li>
                        <li><a class="dropdown-item" href="index.php?controller=ministerio&action=listarMinisterio">Gestionar Ministerios</a></li>
                        <li><a class="dropdown-item" href="index.php?controller=cargo&action=listarCargo">Gestionar Cargos</a></li>
                        <li><a class="dropdown-item" href="index.php?controller=asignacion_ministerio&action=listarAsignaciones">Gestionar Asignación Ministerio</a></li>
                    </ul>
                </li>

                <!-- Eventos -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Módulo Eventos</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="index.php?controller=evento&action=listarEvento">Gestionar Eventos</a></li>
                        <li><a class="dropdown-item" href="index.php?controller=categoria_evento&action=listarCategoria_evento">Gestionar Categorías de Evento</a></li>
                    </ul>
                </li>

                <!-- Contribuciones (al final) -->
                <li class="nav-item">
                    <a class="nav-link" href="index.php?controller=contribucion&action=listarContribucion">Módulo Contribuciones</a>
                </li>
            </ul>
            <div class="navbar-text">
                <?php if (isset($_SESSION['usuario'])): ?>
                    <a href="index.php?controller=auth&action=logout" class="text-white">Cerrar Sesión</a>
                <?php else: ?>
                    <a href="index.php?controller=auth&action=login" class="text-white">Iniciar Sesión</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
