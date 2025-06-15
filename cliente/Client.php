<?php
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/ControllerFactory.php';

class Client {
    private $factory;

    public function __construct() {
        $this->factory = new ControllerFactory();
    }

    public function handle() {
        $controller = $_GET['controller'] ?? null;
        if ($controller) {
            $controllerInstance = $this->factory->create($controller);
            $controllerInstance->handleRequest();
            return true;
        }
        return false;
    }
}
?>
