<?php
require_once __DIR__ . '/../modelo/MEvento.php';
require_once __DIR__ . '/../modelo/MCategoria_evento.php';
require_once __DIR__ . '/../modelo/MMiembro.php';
require_once __DIR__ . '/../modelo/MCargo.php';
require_once __DIR__ . '/../modelo/MAsistencia_Evento.php';
require_once __DIR__ . '/../vista/eventos/VEvento.php';

class CEvento {
    private $vista;

    private $modelo;
    private $modeloCategoria;

    public function __construct() {
        $this->modelo = new MEvento();
        $this->modeloCategoria = new MCategoria_evento();
        $this->vista = new VEvento();
    }

    public function handleRequest() {
        session_start();
        $action = $_GET['action'] ?? 'listarEvento';
        switch ($action) {
            case 'crearEvento':
                $this->crearEvento();
                break;
            case 'eliminarAsistenteTemp':
                $this->eliminarAsistenteTemp();
                break;
            case 'editarEvento':
                $this->editarEvento();
                break;
            case 'eliminarEvento':
                $this->eliminarEvento();
                break;
            case 'listarEvento':
            default:
                $this->listarEvento();
                break;
        }
    }

    private function crearEvento() {
        $eventos = $this->modelo->listarEvento();
        $categorias = $this->modeloCategoria->listarCategoria_evento();
        $miembros = (new MMiembro())->listarMiembro();
        $cargos = (new MCargo())->listarCargo();
        $modeloAsistencia = new MAsistencia_Evento();
        if (!isset($_SESSION['asistentes_evento'])) {
            $_SESSION['asistentes_evento'] = [];
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Si se presiona 'agregar_asistente'
            if (isset($_POST['agregar_asistente'])) {
                $miembro_id = $_POST['miembro_id'];
                $cargo_id = $_POST['cargo_id'];
                $_SESSION['form_evento'] = [
                    'categoria_id' => $_POST['categoria_id'] ?? '',
                    'nombre' => $_POST['nombre'] ?? '',
                    'fecha_inicio' => $_POST['fecha_inicio'] ?? '',
                    'fecha_final' => $_POST['fecha_final'] ?? '',
                    'lugar' => $_POST['lugar'] ?? ''
                ];
                $miembro_nombre = '';
                $cargo_nombre = '';
                foreach ($miembros as $m) {
                    if ($m['id'] == $miembro_id) {
                        $miembro_nombre = $m['nombre'];
                        break;
                    }
                }
                foreach ($cargos as $c) {
                    if ($c['id'] == $cargo_id) {
                        $cargo_nombre = $c['nombre'];
                        break;
                    }
                }
                $nuevo = [
                    'miembro_id' => $miembro_id,
                    'miembro_nombre' => $miembro_nombre,
                    'cargo_id' => $cargo_id,
                    'cargo_nombre' => $cargo_nombre
                ];
                $_SESSION['asistentes_evento'][] = $nuevo;
                header('Location: index.php?controller=evento&action=crearEvento');
                exit;
            }
            // Si se presiona 'guardar_evento'
            if (isset($_POST['guardar_evento'])) {
                $evento_id = $this->modelo->crearEvento(
                    $_POST['categoria_id'],
                    $_POST['nombre'],
                    $_POST['fecha_inicio'],
                    $_POST['fecha_final'],
                    $_POST['lugar'] ?? ''
                );
                foreach ($_SESSION['asistentes_evento'] as $asistente) {
                    $modeloAsistencia->agregarAsistente(
                        $evento_id,
                        $asistente['miembro_id'],
                        $asistente['cargo_id']
                    );
                }
                $_SESSION['asistentes_evento'] = [];
                $_SESSION['form_evento'] = [];
                header('Location: index.php?controller=evento&action=listarEvento');
                exit;
            }
        }
        $form_evento = $_SESSION['form_evento'] ?? [];
        $this->vista->render($eventos, $categorias, $form_evento, null, $miembros, $cargos, $_SESSION['asistentes_evento']);
    }

    private function eliminarAsistenteTemp() {
        // Si estamos en modo edición, redirigir correctamente y eliminar de la base de datos
        if (isset($_GET['evento_id']) && isset($_GET['miembro_id'])) {
            (new MAsistencia_Evento())->eliminarAsistente($_GET['evento_id'], $_GET['miembro_id']);
            header('Location: index.php?controller=evento&action=editarEvento&id=' . intval($_GET['evento_id']));
            exit;
        }
        // Si es modo creación (temporal)
        if (isset($_GET['index'])) {
            array_splice($_SESSION['asistentes_evento'], $_GET['index'], 1);
            header('Location: index.php?controller=evento&action=crearEvento');
            exit;
        }
        // fallback
        header('Location: index.php?controller=evento&action=listarEvento');
        exit;
    }

    private function editarEvento() {
        $eventos = $this->modelo->listarEvento();
        $categorias = $this->modeloCategoria->listarCategoria_evento();
        $miembros = (new MMiembro())->listarMiembro();
        $cargos = (new MCargo())->listarCargo();
        $id = $_GET['id'] ?? null;
        $modeloAsistencia = new MAsistencia_Evento();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            // Agregar asistente en edición
            if (isset($_POST['agregar_asistente'])) {
                $miembro_id = $_POST['miembro_id'];
                $cargo_id = $_POST['cargo_id'];
                $modeloAsistencia->agregarAsistente($id, $miembro_id, $cargo_id);
                header('Location: index.php?controller=evento&action=editarEvento&id=' . $id);
                exit;
            }
            // Guardar cambios del evento
            $this->modelo->actualizarEvento(
                $_POST['id'],
                $_POST['categoria_id'],
                $_POST['nombre'],
                $_POST['fecha_inicio'],
                $_POST['fecha_final'],
                $_POST['lugar'] ?? ''
            );
            header('Location: index.php?controller=evento&action=listarEvento');
            exit;
        } elseif ($id) {
            $eventoEditar = $this->modelo->obtenerEventoPorId($id);
            $asistentes_evento = $modeloAsistencia->listarAsistentes($id);
            $this->vista->render($eventos, $categorias, [], $eventoEditar, $miembros, $cargos, $asistentes_evento);
            exit;
        } else {
            header('Location: index.php?controller=evento&action=listarEvento');
            exit;
        }
    }

    private function eliminarEvento() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->modelo->eliminarEvento($id);
        }
        header('Location: index.php?controller=evento&action=listarEvento');
        exit;
    }

    private function listarEvento() {
        $eventos = $this->modelo->listarEvento();
        $categorias = $this->modeloCategoria->listarCategoria_evento();
        $miembros = (new MMiembro())->listarMiembro();
        $cargos = (new MCargo())->listarCargo();
        $form_evento = [];
        if (!isset($_SESSION['asistentes_evento'])) {
            $_SESSION['asistentes_evento'] = [];
        }
        $this->vista->render($eventos, $categorias, $form_evento, null, $miembros, $cargos, $_SESSION['asistentes_evento']);
    }
}
