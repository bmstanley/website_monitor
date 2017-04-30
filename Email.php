<?php

require_once "vendor/autoload.php";

class Email
{
    /**
     * Secure protocol to be used to connect to email host
     * @var string
     */
    private $smtpProtocol = 'ssl';

    /**
     * Email host SMTP server
     * @var string
     */
    private $smtpHost = 'smtp.gmail.com';

    /**
     * Enable SMTP authentication
     * @var boolean
     */
    private $smtpAuth = true;

    /**
     * Email host SMTP port
     * @var integer
     */
    private $smtpPort = 465;

    /**
     * Email from address
     * @var string
     */
    private $from = 'email_address_goes_here';

    /**
     * Email from plain name
     * @var string
     */
    private $fromName = 'System Monitoring';

    /**
     * Email from password
     * @var string
     */
    private $password = 'top_secret_password';

    /**
     * Random call to action phrase for email body
     * @var [type]
     */
    private $emailBody = [
        'What are you waiting for? Go fix it!',
        'Sometimes, waiting for someone else to fix your problems works out for you. This, however, is not one of those times.',
        'I didn\'t send you this email just because I like you. I sent you this email so you can go fix the problem.',
        'You have been warned.'
    ];

    /**
     * Create and send an email
     * @param string|array $recipient One or more email recipients
     * @param string $customMessage Custom message to be inserted into the body of the email
     */
    public function __construct($recipient, $customMessage = null)
    {
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = $this->smtpHost;
        $mail->SMTPAuth = $this->smtpAuth;
        $mail->Username = $this->from;
        $mail->Password = $this->password;
        $mail->SMTPSecure = $this->smtpProtocol;
        $mail->Port = $this->smtpPort;

        $mail->From = $this->from;
        $mail->FromName = $this->fromName;

        if (!is_array($recipient)) {
            $recipient[] = $recipient;
        }
        foreach ($recipient as $email) {
            $mail->addAddress($email);
        }

        $mail->isHTML(true);

        $mail->Subject = "Website Unresponsive";
        $mail->Body = "<h1>Website Unresponsive</h1>";
        if (!is_null($customMessage)) {
            $mail->Body .= "<H3>".$customMessage."</H3>";
        }
        $mail->Body .= "<p>".$this->emailBody[array_rand($this->emailBody)]."</p>";

        if (!$mail->send()) {
            return false;
        }
        return true;
    }
}