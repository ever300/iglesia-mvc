<?php
require_once __DIR__ . '/../modelo/MMinisterio.php';
require_once __DIR__ . '/../vista/congregacion/VMinisterio.php';
require_once __DIR__ . '/IController.php';

class CMinisterio implements IController {
    private $modelo;
    private $vista;

    public function __construct() {
        $this->modelo = new MMinisterio();
        $this->vista = new VMinisterio();
    }

    public function handleRequest() {
        $action = $_GET['action'] ?? 'listarMinisterio';

        switch ($action) {
            case 'crearMinisterio':
                $this->crearMinisterio();
                break;
            case 'editarMinisterio':
                $this->editarMinisterio();
                break;
            case 'eliminarMinisterio':
                $this->eliminarMinisterio();
                break;
            case 'listarMinisterio':
            default:
                $this->listarMinisterio();
                break;
        }
    }

    private function crearMinisterio() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->modelo->crearMinisterio($_POST['nombre'], $_POST['descripcion'] ?? '');
            header('Location: index.php?controller=ministerio&action=listarMinisterio');
            exit;
        }
    }

    private function editarMinisterio() {
        $id = $_GET['id'] ?? null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
            $this->modelo->actualizarMinisterio(
                $id,
                $_POST['nombre'],
                $_POST['descripcion'] ?? ''
            );
            header('Location: index.php?controller=ministerio&action=listarMinisterio');
            exit;
        }

        if ($id) {
            $ministerioEditar = $this->modelo->obtenerMinisterioPorId($id);
            $ministerios = $this->modelo->listarMinisterio();
            $this->vista->render($ministerios, $ministerioEditar);
        } else {
            header('Location: index.php?controller=ministerio&action=listarMinisterio');
        }
        exit;
    }

    private function eliminarMinisterio() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->modelo->eliminarMinisterio($id);
        }
        header('Location: index.php?controller=ministerio&action=listarMinisterio');
        exit;
    }

    private function listarMinisterio() {
        $ministerios = $this->modelo->listarMinisterio();
        $this->vista->render($ministerios);
    }
}
