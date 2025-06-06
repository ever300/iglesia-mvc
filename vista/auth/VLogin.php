<?php
class VLogin {
    public function render($error = '') {
        $pageTitle = 'Iniciar Sesión';
        require_once __DIR__ . '/../componentes/header.php';
        require_once __DIR__ . '/../componentes/navbar.php';
        ?>
        <div class="container mt-4">
            <h1>Iniciar Sesión</h1>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <div class="form-container">
                <form action="index.php?controller=auth&action=login" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Usuario</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Entrar</button>
                </form>
            </div>
        </div>
        </body>
        </html>
        <?php
    }
}
?>
