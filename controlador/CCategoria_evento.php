<?php
require_once __DIR__ . '/../modelo/MCategoria_evento.php';
require_once __DIR__ . '/../vista/eventos/VCategoria_evento.php';
require_once __DIR__ . '/IController.php';

class CCategoria_evento implements IController {
    private $modelo;
    private $vista;

    public function __construct() {
        $this->modelo = new MCategoria_evento();
        $this->vista = new VCategoria_evento();
    }

    public function handleRequest() {
        $action = $_GET['action'] ?? 'listarCategoria_evento';
        switch ($action) {
            case 'crearCategoria_evento':
                $this->crearCategoria_evento();
                break;
            case 'editarCategoria_evento':
                $this->editarCategoria_evento();
                break;
            case 'eliminarCategoria_evento':
                $this->eliminarCategoria_evento();
                break;
            case 'listarCategoria_evento':
            default:
                $this->listarCategoria_evento();
                break;
        }
    }

    private function crearCategoria_evento() {
        $categorias = $this->modelo->listarCategoria_evento();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->modelo->crearCategoria_evento(
                $_POST['nombre'],
                $_POST['descripcion'] ?? ''
            );
            header('Location: index.php?controller=categoria_evento&action=listarCategoria_evento');
            exit;
        }
        // Mostrar formulario vacío
        $this->vista->render($categorias);
    }

    private function editarCategoria_evento() {
        $categorias = $this->modelo->listarCategoria_evento();
        $id = $_GET['id'] ?? null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $this->modelo->actualizarCategoria_evento(
                $_POST['id'],
                $_POST['nombre'],
                $_POST['descripcion'] ?? ''
            );
            header('Location: index.php?controller=categoria_evento&action=listarCategoria_evento');
            exit;
        } elseif ($id) {
            $categoriaEditar = $this->modelo->obtenerCategoria_eventoPorId($id);
            $this->vista->render($categorias, $categoriaEditar);
            exit;
        } else {
            header('Location: index.php?controller=categoria_evento&action=listarCategoria_evento');
            exit;
        }
    }

    private function eliminarCategoria_evento() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->modelo->eliminarCategoria_evento($id);
        }
        header('Location: index.php?controller=categoria_evento&action=listarCategoria_evento');
        exit;
    }

    private function listarCategoria_evento() {
        $categorias = $this->modelo->listarCategoria_evento();
        $this->vista->render($categorias);
    }
}
