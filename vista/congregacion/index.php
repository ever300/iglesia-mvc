<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$pageTitle = 'Gestión de Congregación';
require_once __DIR__ . '/../../vista/componentes/header.php';
?>

<body>
    <?php require_once __DIR__ . '/../../vista/componentes/navbar.php'; ?>

    <div class="container mt-4">
        <h1>Gestión de Congregación</h1>
        
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Miembros</h5>
                        <p class="card-text">Gestiona el registro de miembros de la iglesia.</p>
                        <a href="../../index.php?controller=miembro&action=listar" class="btn btn-primary">Gestionar Miembros</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ministerios</h5>
                        <p class="card-text">Administra los diferentes ministerios de la iglesia.</p>
                        <a href="../../index.php?controller=ministerio&action=listar" class="btn btn-primary">Gestionar Ministerios</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once __DIR__ . '/../../vista/componentes/footer.php'; ?>
</body>
</html>
