<?php
require_once __DIR__ . '/../controlador/IController.php';
require_once __DIR__ . '/../controlador/AuthProxy.php';

class ControllerFactory {
    public function create(string $name): IController {
        $controllerClass = 'C' . ucfirst($name);
        $controllerFile = __DIR__ . '/../controlador/' . $controllerClass . '.php';

        if (!file_exists($controllerFile)) {
            die("\u274c Controlador no encontrado: $controllerClass");
        }

        require_once $controllerFile;

        if (!class_exists($controllerClass)) {
            die("\u274c Clase de controlador no existe: $controllerClass");
        }

        $instance = new $controllerClass();

        if ($name !== 'auth') {
            $instance = new AuthProxy($instance);
        }

        return $instance;
    }
}
?>
