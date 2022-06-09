<?php

namespace App\Libraries;

use App\Controllers\BaseController;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class Email extends BaseController
{
    public function correoInformacion($persona, $programa, $url)
    {
        // $message = $this->CI->load->view('correo/send_certificate', $this->data, TRUE);
        try {
            $mail = new PHPMailer(true);
            $mail->IsSMTP();
            $mail->isHTML(true);
            $mail->SMTPDebug = 0;
            $mail->SMTPAuth = true;
            // $mail->SMTPSecure = "tls";
            $mail->SMTPSecure = "ssl";
            // $mail->Host = "smtp.mailtrap.io";
            $mail->Host = "smtp.gmail.com";
            // $mail->Port = 2525;
            $mail->Port = 465;
            // $mail->Username = "c177e9965bd0d9";
            $mail->Username = "psg.upea@gmail.com";
            // $mail->Password = "76499092bb5e36";
            $nombrePrograma = utf8_decode($programa['nombre_programa']);
            $versionPrograma = utf8_decode($programa['numero_version']);
            $sedePrograma = utf8_decode($programa['sede']);
            $mail->Password = "Psg2020#";
            $mail->setFrom('posgrado@upea.bo', 'POSGRADO UPEA');
            $mail->addReplyTo('posgrado@upea.bo', 'POSGRADO UPEA');
            $mail->addCC('psg.upea@gmail.com', 'PSG UPEA');
            $mail->addAddress($persona['correo'], "{$persona['nombre']} {$persona['paterno']} {$persona['materno']}");
            $mail->Subject = "Detalle: {$nombrePrograma}";
            $mail->Body = "Entre al siguiente enlace para ver el detalle del Programa {$url}";
            $mail->AltBody = "DETALLES DEL PROGRAMA: {$nombrePrograma}, {$versionPrograma}, {$sedePrograma}";
            $mail->send();
            return true;
        } catch (Exception $e) {
            echo 'Error: ' . $mail->ErrorInfo;
            return false;
        }
    }
}
