<?php
require_once __DIR__ . '/../modelo/MContribucion.php';
require_once __DIR__ . '/../modelo/MEvento.php';
require_once __DIR__ . '/../modelo/MMiembro.php';
require_once __DIR__ . '/../vista/contribuciones/VContribucion.php';

class CContribucion {
    private $vista;

    private $modelo;
    private $modeloEvento;
    private $modeloMiembro;

    public function __construct() {
        $this->modelo = new MContribucion();
        $this->modeloEvento = new MEvento();
        $this->modeloMiembro = new MMiembro();
        $this->vista = new VContribucion();
    }

    public function handleRequest() {
        $action = $_GET['action'] ?? 'listarContribucion';
        switch ($action) {
            case 'crearContribucion':
                $this->crearContribucion();
                break;
            case 'editarContribucion':
                $this->editarContribucion();
                break;
            case 'eliminarContribucion':
                $this->eliminarContribucion();
                break;
            case 'listarContribucion':
            default:
                $this->listarContribucion();
                break;
        }
    }

    private function crearContribucion() {
        $contribuciones = $this->modelo->listarContribucion();
        $eventos = $this->modeloEvento->listarEvento();
        $miembros = $this->modeloMiembro->listarMiembro();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->modelo->crearContribucion(
                $_POST['evento_id'] ?? null,
                $_POST['miembro_id'],
                $_POST['tipo'],
                $_POST['monto'],
                $_POST['fecha_registro'] ?? null
            );
            header('Location: index.php?controller=contribucion&action=listarContribucion');
            exit;
        }
        $this->vista->render($contribuciones, $miembros, $eventos);
    }

    private function editarContribucion() {
        $contribuciones = $this->modelo->listarContribucion();
        $eventos = $this->modeloEvento->listarEvento();
        $miembros = $this->modeloMiembro->listarMiembro();
        $id = $_GET['id'] ?? null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $this->modelo->actualizarContribucion(
                $_POST['id'],
                $_POST['evento_id'] ?? null,
                $_POST['miembro_id'],
                $_POST['tipo'],
                $_POST['monto'],
                $_POST['fecha_registro'] ?? null
            );
            header('Location: index.php?controller=contribucion&action=listarContribucion');
            exit;
        } elseif ($id) {
            $contribucionEditar = $this->modelo->obtenerContribucionPorId($id);
            $this->vista->render($contribuciones, $miembros, $eventos, $contribucionEditar);
            exit;
        } else {
            header('Location: index.php?controller=contribucion&action=listarContribucion');
            exit;
        }
    }

    private function eliminarContribucion() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->modelo->eliminarContribucion($id);
        }
        header('Location: index.php?controller=contribucion&action=listarContribucion');
        exit;
    }

    private function listarContribucion() {
        $contribuciones = $this->modelo->listarContribucion();
        $eventos = $this->modeloEvento->listarEvento();
        $miembros = $this->modeloMiembro->listarMiembro();
        $this->vista->render($contribuciones, $miembros, $eventos);
    }

}
