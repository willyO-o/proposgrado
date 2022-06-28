<?php

namespace App\Libraries;

use App\Controllers\BaseController;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class Email extends BaseController
{
    public function correoInformacion($persona, $programa, $url, $message)
    {
        $message = view('correo/index', ['programa' => $programa, 'url' => $url, 'message' => $message], ['saveData' => TRUE]);
        // return var_dump($programa, $message);
        // try {
        //     $message = view('correo/index', ['programa' => $programa, 'url' => $url, 'message' => $message], ['saveData' => TRUE]);
        //     $mail = new PHPMailer();
        //     $mail->IsSMTP();
        //     $mail->isHTML(true);
        //     $mail->SMTPDebug = 0;
        //     $mail->Mailer = 'smtp';
        //     $mail->SMTPAuth = true;

        //     // $mail->SMTPSecure = "tls";
        //     // $mail->Host = "smtp.mailtrap.io";
        //     // $mail->Port = 2525;
        //     // $mail->Username = "c177e9965bd0d9";
        //     // $mail->Password = "76499092bb5e36";

        //     $mail->SMTPSecure = "ssl";
        //     $mail->Host = "smtp.gmail.com";
        //     $mail->Port = 465;
        //     $mail->Username = "psg.upea@gmail.com";
        //     $mail->Password = "Psg2020#";

        //     $nombrePrograma = utf8_decode($programa['nombre_programa']);
        //     $versionPrograma = utf8_decode($programa['numero_version']);
        //     $sedePrograma = utf8_decode($programa['sede']);
        //     $mail->setFrom('posgrado@upea.bo', 'POSGRADO UPEA');
        //     $mail->addReplyTo('posgrado@upea.bo', 'POSGRADO UPEA');
        //     $mail->addCC('psg.upea@gmail.com', 'PSG UPEA');
        //     $mail->addAddress($persona['correo'], "{$persona['nombre']} {$persona['paterno']} {$persona['materno']}");
        //     $mail->Subject = "Detalle: {$nombrePrograma}";
        //     $mail->Body = $message;
        //     $mail->AltBody = "DETALLES DEL PROGRAMA: {$nombrePrograma}, {$versionPrograma}, {$sedePrograma}";

        //     if ($mail->send()) {
        //         echo 'echo correo enviado';
        //         return true;
        //     } else {
        //         $data = $mail->printDebugger();
        //         print_r($data);
        //     }
        // } catch (Exception $e) {
        //     echo 'Error: ' . $mail->ErrorInfo;
        //     return false;
        // }

        // send email
        // try {
        //     $message  = "correo de prueba";
        //     $email = \Config\Services::email();
        //     $email->setFrom('posgrado@upea.bo', 'POSGRADO UPEA');
        //     $email->setTo($persona['correo'], "{$persona['nombre']} {$persona['paterno']} {$persona['materno']}");
        //     $email->setSubject('Detalle: {$nombrePrograma}');
        //     $email->setMessage($message);

        //     $email->SMTPSecure = "ssl";
        //     $email->Host = "smtp.gmail.com";
        //     $email->Port = 465;
        //     $email->Username = "psg.upea@gmail.com";
        //     $email->Password = "Psg2020#";

        //     $email->setCC('psg.upea@gmail.com', 'PSG UPEA');
        //     $email->setBCC('');
        //     $email->setMailType('html');
        //     if ($email->send()) {
        //         echo 'Email has been sent';
        //     } else {
        //         $data = $email->printDebugger(['headers']);
        //         print_r($data);
        //     }
        // } catch (Exception $e) {
        //     echo 'Error: ' . $e;
        //     return false;
        // }

        $email = \Config\Services::email();

        $email->setFrom('posgrado@upea.bo', 'POSGRADO UPEA');
        $email->setTo($persona['correo'], "{$persona['nombre']} {$persona['paterno']} {$persona['materno']}");

        $email->setSubject('Detalle: {$nombrePrograma}');
        $email->setMessage($message);

        if (!$email->send()) {
            echo "no se ha podido enviar el correo";
            echo $email->printDebugger(['headers']);
        } else {
            echo "correo enviado";
        }
        return true;
    }
}
