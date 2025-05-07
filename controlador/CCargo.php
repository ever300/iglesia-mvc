<?php
require_once __DIR__ . '/../modelo/MCargo.php';
require_once __DIR__ . '/../vista/congregacion/VCargo.php';

class CCargo {
    private $modelo;
    private $vista;

    public function __construct() {
        $this->modelo = new MCargo();
        $this->vista = new VCargo();
    }

    public function handleRequest() {
        $action = $_GET['action'] ?? 'listarCargo';
        switch ($action) {
            case 'crearCargo':
                $this->crearCargo();
                break;
            case 'editarCargo':
                $this->editarCargo();
                break;
            case 'eliminarCargo':
                $this->eliminarCargo();
                break;
            case 'listarCargo':
            default:
                $this->listarCargo();
                break;
        }
    }

    private function crearCargo() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->modelo->crearCargo($_POST['nombre'], $_POST['descripcion'] ?? '');
            header('Location: index.php?controller=cargo&action=listarCargo');
            exit;
        }
    }

    private function editarCargo() {
        $id = $_GET['id'] ?? null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
            $this->modelo->actualizarCargo(
                $id,
                $_POST['nombre'],
                $_POST['descripcion'] ?? ''
            );
            header('Location: index.php?controller=cargo&action=listarCargo');
            exit;
        }
        if ($id) {
            $cargoEditar = $this->modelo->obtenerCargoPorId($id);
            $cargos = $this->modelo->listarCargo();
            $this->vista->render($cargos, $cargoEditar);
        } else {
            header('Location: index.php?controller=cargo&action=listarCargo');
        }
        exit;
    }

    private function eliminarCargo() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->modelo->eliminarCargo($id);
        }
        header('Location: index.php?controller=cargo&action=listarCargo');
        exit;
    }

    private function listarCargo() {
        $cargos = $this->modelo->listarCargo();
        $this->vista->render($cargos);
    }
}
