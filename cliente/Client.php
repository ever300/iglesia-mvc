<?php
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../controlador/AuthProxy.php';

class Client {
    public function handle() {
        $controller = $_GET['controller'] ?? null;
        if ($controller) {
            $controllerClass = 'C' . ucfirst($controller);
            $controllerFile = __DIR__ . '/../controlador/' . $controllerClass . '.php';

            if (file_exists($controllerFile)) {
                require_once $controllerFile;
                $controllerInstance = new $controllerClass();
                if ($controller !== 'auth') {
                    $controllerInstance = new AuthProxy($controllerInstance);
                }
                $controllerInstance->handleRequest();
                return true;
            } else {
                die("❌ Controlador no encontrado: $controllerClass");
            }
        }
        return false;
    }
}
?>
