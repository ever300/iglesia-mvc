<?php
require_once __DIR__ . '/../VistaBase.php';

class VLogin extends VistaBase {
    public function render($error = '') {
        $this->pageTitle = 'Iniciar Sesión';
        parent::render($error);
    }

    protected function contenido($error = '') {
        ?>
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="text-center mb-4">Iniciar Sesión</h1>
                            <?php if ($error): ?>
                                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                            <?php endif; ?>
                            <form action="index.php?controller=auth&action=login" method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Usuario</label>
                                    <input type="text" name="username" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Contraseña</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Entrar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
?>
