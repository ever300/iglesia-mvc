<?php
require_once __DIR__ . '/../modelo/MAsignacion_Ministerio.php';
require_once __DIR__ . '/../modelo/MMiembro.php';
require_once __DIR__ . '/../modelo/MMinisterio.php';
require_once __DIR__ . '/../vista/congregacion/VAsignacion_Ministerio.php';

class CAsignacion_Ministerio
{
    private $modelo;
    private $miembroModel;
    private $ministerioModel;
    private $vista;

    public function __construct()
    {
        $this->modelo = new MAsignacion_Ministerio();
        $this->miembroModel = new MMiembro();
        $this->ministerioModel = new MMinisterio();
        $this->vista = new VAsignacion_Ministerio();
    }

    public function handleRequest()
    {
        $action = $_GET['action'] ?? 'listarAsignaciones';
        switch ($action) {
            case 'crearAsignacion':
                $this->crearAsignacion();
                break;
            case 'editarAsignacion':
                $this->editarAsignacion();
                break;
            case 'eliminarAsignacion':
                $this->eliminarAsignacion();
                break;
            case 'listarAsignaciones':
            default:
                $this->listarAsignaciones();
                break;
        }
    }

    private function crearAsignacion()
    {
        $asignaciones = $this->modelo->listarAsignaciones();
        $miembros = $this->miembroModel->listarMiembro();
        $ministerios = $this->ministerioModel->listarMinisterio();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->modelo->crearAsignacion(
                $_POST['miembro_id'],
                $_POST['ministerio_id'],
                $_POST['fecha_inicio'],
                $_POST['fecha_final'],
                isset($_POST['estado']) ? 1 : 0
            );
            header('Location: index.php?controller=asignacion_ministerio&action=listarAsignaciones');
            exit;
        }
        $asignacionEditar = null;
        $this->vista->render($asignaciones, $miembros, $ministerios, $asignacionEditar);
    }

    private function editarAsignacion()
    {
        $asignaciones = $this->modelo->listarAsignaciones();
        $miembros = $this->miembroModel->listarMiembro();
        $ministerios = $this->ministerioModel->listarMinisterio();
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['miembro_id'], $_GET['ministerio_id'])) {
            $asignacionEditar = $this->modelo->obtenerAsignacion($_GET['miembro_id'], $_GET['ministerio_id']);
            $this->vista->render($asignaciones, $miembros, $ministerios, $asignacionEditar);
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['miembro_id'], $_POST['ministerio_id'])) {
            $this->modelo->actualizarAsignacion(
                $_POST['miembro_id'],
                $_POST['ministerio_id'],
                $_POST['fecha_inicio'],
                $_POST['fecha_final'],
                isset($_POST['estado']) ? 1 : 0
            );
            header('Location: index.php?controller=asignacion_ministerio&action=listarAsignaciones');
            exit;
        }
    }

    private function eliminarAsignacion()
    {
        if (isset($_GET['miembro_id'], $_GET['ministerio_id'])) {
            $this->modelo->eliminarAsignacion($_GET['miembro_id'], $_GET['ministerio_id']);
            header('Location: index.php?controller=asignacion_ministerio&action=listarAsignaciones');
            exit;
        }
    }

    private function listarAsignaciones()
    {
        $asignaciones = $this->modelo->listarAsignaciones();
        $miembros = $this->miembroModel->listarMiembro();
        $ministerios = $this->ministerioModel->listarMinisterio();
        $asignacionEditar = null;
        $this->vista->render($asignaciones, $miembros, $ministerios, $asignacionEditar);
    }
}
