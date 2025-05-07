<?php
require_once __DIR__ . '/../modelo/MMiembro.php';
require_once __DIR__ . '/../modelo/MCargo.php';
require_once __DIR__ . '/../vista/congregacion/VMiembro.php';

class CMiembro {
    private $modelo;
    private $cargoModel;
    private $vista;

    public function __construct() {
        $this->modelo = new MMiembro();
        $this->cargoModel = new MCargo();
        $this->vista = new VMiembro();
    }

    public function handleRequest() {
        $action = $_GET['action'] ?? 'listarMiembro';
        switch ($action) {
            case 'crearMiembro':
                $this->crearMiembro();
                break;
            case 'editarMiembro':
                $this->editarMiembro();
                break;
            case 'eliminarMiembro':
                $this->eliminarMiembro();
                break;
            case 'listarMiembro':
            default:
                $this->listarMiembro();
                break;
        }
    }

    private function crearMiembro() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre'], $_POST['apellido'], $_POST['cargo_id'])) {
            $this->modelo->crearMiembro(
                $_POST['nombre'],
                $_POST['apellido'],
                $_POST['fecha_nacimiento'] ?? null,
                $_POST['telefono'] ?? null,
                $_POST['cargo_id']
            );
            header('Location: index.php?controller=miembro&action=listarMiembro');
            exit;
        }
        // Si se requiere mostrar el formulario, obtener los cargos desde MCargo
        $cargos = $this->cargoModel->listarCargo();
        $this->vista->render([], $cargos);
    }

    private function editarMiembro() {
        $id = $_GET['id'] ?? null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
            $this->modelo->actualizarMiembro(
                $id,
                $_POST['nombre'],
                $_POST['apellido'],
                $_POST['fecha_nacimiento'] ?? null,
                $_POST['telefono'] ?? null,
                $_POST['cargo_id']
            );
            header('Location: index.php?controller=miembro&action=listarMiembro');
            exit;
        }
        if ($id) {
            $miembroEditar = $this->modelo->obtenerMiembroPorId($id);
            $miembros = $this->modelo->listarMiembro();
            $cargos = $this->cargoModel->listarCargo();
            $this->vista->render($miembros, $cargos, $miembroEditar);
        } else {
            header('Location: index.php?controller=miembro&action=listarMiembro');
        }
        exit;
    }

    private function eliminarMiembro() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->modelo->eliminarMiembro($id);
        }
        header('Location: index.php?controller=miembro&action=listarMiembro');
        exit;
    }

    private function listarMiembro() {
        $miembros = $this->modelo->listarMiembro();
        $cargos = $this->cargoModel->listarCargo();
        $this->vista->render($miembros, $cargos);
    }
}
