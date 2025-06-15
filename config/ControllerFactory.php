<?php
require_once __DIR__ . '/../controlador/AuthProxy.php';
require_once __DIR__ . '/../controlador/RoleProxy.php';

class ControllerFactory {
    private static $roleMap = [
        'contribucion' => ['admin'],
        'cargo' => ['admin'],
        'evento' => ['admin'],
        'categoria_evento' => ['admin'],
        'asignacion_ministerio' => ['admin'],
    ];

    public static function create(string $controllerName) {
        $controllerClass = 'C' . ucfirst($controllerName);
        $controllerFile = __DIR__ . '/../controlador/' . $controllerClass . '.php';

        if (!file_exists($controllerFile)) {
            die("❌ Controlador no encontrado: $controllerClass");
        }

        require_once $controllerFile;
        $controller = new $controllerClass();

        if ($controllerName !== 'auth') {
            $controller = new AuthProxy($controller);
        }

        if (isset(self::$roleMap[$controllerName])) {
            $controller = new RoleProxy($controller, self::$roleMap[$controllerName]);
        }

        return $controller;
    }
}
?>
