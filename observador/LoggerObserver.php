<?php
require_once __DIR__ . '/EventoObserver.php';

class LoggerObserver implements EventoObserver {
    private $file;

    public function __construct($file = __DIR__ . '/../logs/evento.log') {
        $this->file = $file;
    }

    public function update(int $eventoId, array $data) {
        $mensaje = date('Y-m-d H:i:s') . " Evento $eventoId: " . json_encode($data) . PHP_EOL;
        file_put_contents($this->file, $mensaje, FILE_APPEND);
    }
}
?>
