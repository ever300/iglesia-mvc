<?php
require_once __DIR__ . '/IController.php';

class AuthProxy implements IController {
    private $controller;

    public function __construct(IController $controller) {
        $this->controller = $controller;
    }

    public function handleRequest() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (isset($_SESSION['usuario'])) {
            $this->controller->handleRequest();
        } else {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }
    }
}
?>
