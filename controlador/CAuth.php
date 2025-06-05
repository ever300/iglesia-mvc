<?php
require_once __DIR__ . '/IController.php';
require_once __DIR__ . '/../modelo/MUsuario.php';
require_once __DIR__ . '/../vista/auth/VLogin.php';

class CAuth implements IController {
    private $modelo;
    private $vista;

    public function __construct() {
        $this->modelo = new MUsuario();
        $this->vista = new VLogin();
    }

    public function handleRequest() {
        $action = $_GET['action'] ?? 'login';
        switch ($action) {
            case 'login':
                $this->login();
                break;
            case 'logout':
                $this->logout();
                break;
            default:
                $this->login();
                break;
        }
    }

    private function login() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $usuario = $this->modelo->obtenerUsuarioPorUsername($username);
            if ($usuario && password_verify($password, $usuario['password'])) {
                $_SESSION['usuario'] = $usuario;
                header('Location: index.php');
                exit;
            } else {
                $error = 'Credenciales inválidas';
            }
        }
        $this->vista->render($error);
    }

    private function logout() {
        session_destroy();
        header('Location: index.php');
        exit;
    }
}
?>
