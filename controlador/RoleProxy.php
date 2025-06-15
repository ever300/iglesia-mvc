<?php
require_once __DIR__ . '/IController.php';

class RoleProxy implements IController {
    private $controller;
    private $roles;

    public function __construct(IController $controller, array $roles) {
        $this->controller = $controller;
        $this->roles = $roles;
    }

    public function handleRequest() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['usuario'])) {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }

        $rol = $_SESSION['usuario']['rol'] ?? null;
        if ($rol !== null && in_array($rol, $this->roles)) {
            $this->controller->handleRequest();
        } else {
            header('HTTP/1.1 403 Forbidden');
            echo 'Acceso no autorizado';
            exit;
        }
    }
}
?>
