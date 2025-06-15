<?php
require_once __DIR__ . '/EventoObserver.php';
require_once __DIR__ . '/../modelo/MMiembro.php';
require_once __DIR__ . '/../config/twilio.php';

class WhatsAppObserver implements EventoObserver {
    private $sid;
    private $token;
    private $from;

    public function __construct($sid = null, $token = null, $from = null) {
        $this->sid = $sid ?? TwilioConfig::$sid;
        $this->token = $token ?? TwilioConfig::$token;
        $this->from = $from ?? TwilioConfig::$from;
    }

    public function update(int $eventoId, array $data) {
        if ($data['accion'] !== 'crear') {
            return;
        }
        if (empty($data['miembros_ids'])) {
            return;
        }
        $miembroModel = new MMiembro();
        foreach ($data['miembros_ids'] as $miembroId) {
            $miembro = $miembroModel->obtenerMiembroPorId($miembroId);
            if (!$miembro || empty($miembro['telefono'])) {
                continue;
            }
            $mensaje = 'Nuevo evento: ' . $data['datos']['nombre'];
            $this->enviarWhatsApp($miembro['telefono'], $mensaje);
        }
    }

    private function enviarWhatsApp($toNumber, $message) {
        $url = 'https://api.twilio.com/2010-04-01/Accounts/' . $this->sid . '/Messages.json';
        $postFields = http_build_query([
            'From' => 'whatsapp:' . $this->from,
            'To' => 'whatsapp:' . $toNumber,
            'Body' => $message
        ]);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_USERPWD, $this->sid . ':' . $this->token);
        curl_exec($ch);
        curl_close($ch);
    }
}
?>
