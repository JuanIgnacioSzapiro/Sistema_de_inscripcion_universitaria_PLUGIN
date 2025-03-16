<?php
class Mailing
{
    private $email, $subject, $message, $headers;

    // Getters
    public function get_email()
    {
        return $this->email;
    }

    public function get_subject()
    {
        return $this->subject;
    }

    public function get_message()
    {
        return $this->message;
    }

    public function get_headers()
    {
        return $this->headers;
    }

    // Setters
    public function set_email($email)
    {
        $this->email = $email;
    }

    public function set_subject($subject)
    {
        $this->subject = $subject;
    }

    public function set_message($message)
    {
        $this->message = $message;
    }

    public function set_headers($headers)
    {
        $this->headers = $headers;
    }

    function __construct($email, $subject, $message, $headers = [])
    {
        $this->set_email($email);
        $this->set_subject($subject);
        $this->set_message($message);
        $this->set_headers($headers);

        add_action('phpmailer_init', array($this, 'configurar_smtp'));
    }

    function configurar_smtp($phpmailer)
    {
        $phpmailer->isSMTP();
        $phpmailer->Host = 'localhost'; // MailHog
        $phpmailer->Port = 1025; // Puerto de MailHog
        $phpmailer->SMTPAuth = false; // No requiere autenticación

        // Si usas un SMTP externo (ej: Gmail):
        if (defined($GLOBALS['smtp_host'])) {
            // Configuración para producción
            $phpmailer->isSMTP();
            $phpmailer->Host = $GLOBALS['smtp_host']; // Ej: smtp.gmail.com
            $phpmailer->Port = $GLOBALS['smtp_puerto']; // 587
            $phpmailer->SMTPAuth = true;
            $phpmailer->Username = $GLOBALS['mail'];
            $phpmailer->Password = $GLOBALS['clave'];
            $phpmailer->SMTPSecure = $GLOBALS['smtp_secure']; // tls
        }

        $phpmailer->SMTPDebug = 2; // Nivel de depuración
        error_log(print_r($phpmailer, true)); // Log en debug.log
    }

    function mandar_mail()
    {
        return wp_mail(
            $this->get_email(),
            $this->get_subject(),
            $this->get_message(),
            $this->get_headers()
        );
    }
}