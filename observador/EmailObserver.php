<?php
require_once __DIR__ . '/EventoObserver.php';

class EmailObserver implements EventoObserver {
    private $file;

    public function __construct($file = __DIR__ . '/../logs/email.log') {
        $this->file = $file;
    }

    public function update(int $eventoId, array $data) {
        $mensaje = date('Y-m-d H:i:s') . " Email enviado para evento $eventoId" . PHP_EOL;
        file_put_contents($this->file, $mensaje, FILE_APPEND);
    }
}
?>
