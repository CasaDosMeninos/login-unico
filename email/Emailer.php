<?php
class Emailer
{
    var $recipients = array();
    var $EmailTemplate;
    var $EmailContents;

    public function __construct($to = false)
    {
        if($to !== false)
        {
            if(is_array($to))
            {
                foreach($to as $_to){ $this->recipients[$_to] = $_to; }
            }else
            {
                $this->recipients[$to] = $to; //1 Recip
            }
        }
    }

    function SetTemplate(EmailTemplate $EmailTemplate)
    {
        $this->EmailTemplate = $EmailTemplate;
    }

    function send()
    {
        require 'phpmailer/PHPMailerAutoload.php';

        $mail = new PHPMailer;

        $mail->SMTPDebug = 0;
        $mail->CharSet = 'UTF-8';

        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Port = SMTP_PORT;
        $mail->Username = SMTP_USER;
        $mail->Password = SMTP_PASSWORD;

        $mail->From = 'from@example.com';
        $mail->FromName = 'Mailer';
        foreach ($this->recipients as $to)
            $mail->addAddress($to);

        $mail->isHTML(true);

        $mail->Subject = 'Ativação de conta [CM]';
        $mail->Body    = $this->EmailTemplate->compile();

        if(!$mail->send())
            throw Exception('Message could not be sent. Mailer Error: ' . $mail->ErrorInfo);
    }
}
?>