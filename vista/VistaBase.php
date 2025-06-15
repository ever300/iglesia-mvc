<?php
abstract class VistaBase {
    protected $pageTitle = 'Sistema de Gestión Iglesia';

    public function render(...$params) {
        $pageTitle = $this->pageTitle;
        require_once __DIR__ . '/componentes/header.php';
        ?>
        <body>
            <?php require_once __DIR__ . '/componentes/navbar.php'; ?>
            <?php $this->contenido(...$params); ?>
            <?php require_once __DIR__ . '/componentes/footer.php'; ?>
        <?php
    }

    abstract protected function contenido(...$params);
}
?>
