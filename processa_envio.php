<?php 

require 'bibliotecas/PHPMailer/Exception.php';
require 'bibliotecas/PHPMailer/OAuth.php';
require 'bibliotecas/PHPMailer/PHPMailer.php';
require 'bibliotecas/PHPMailer/POP3.php';
require 'bibliotecas/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mensagem {
    private $para = null;
    private $assunto = null;
    private $mensagem = null;

    public function __get($attr){
        return $this->$attr;
    }
    public function __set($attr, $value){
        return $this->$attr = $value;
    }
    public function mensagemValida() {
        if(empty($this->para) || empty($this->assunto) || empty($this->mensagem)) {
            return false;
        }

        return true;
    }


}

$mensagem = new Mensagem();

$mensagem->__set('para', $_POST['para']);
$mensagem->__set('assunto', $_POST['assunto']);
$mensagem->__set('mensagem', $_POST['mensagem']);

if(!$mensagem->mensagemValida()) {
    echo 'Mensagem inválida';
    die();
}

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'felipeclayton007@gmail.com';                     //SMTP username
    $mail->Password   = 'jzdtvrtkuydoyhje';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('felipeclayton007@gmail.com', 'email remetente');
    $mail->addAddress($mensagem->__get('para'), 'email destinatário');     //Add a recipient
    // $mail->addAddress('ellen@example.com');               //Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $mensagem->__get('assunto');
    $mail->Body    = $mensagem->__get('mensagem');
    $mail->AltBody = 'É necessário usar um client que suporte HMTL para acessar todo o conteúdo do email.';

    $mail->send();
    echo 'E-mail enviado com sucesso';
} catch (Exception $e) {
    echo 'Não foi possível enviar este e-mail! Por favor tente novamente mais tarde.';
    echo "Detelhes do erro: {$mail->ErrorInfo}";
}


?>