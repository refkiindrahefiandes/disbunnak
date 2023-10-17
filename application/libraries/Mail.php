<?php
/**
 * PHPMailer for Codeigniter
 *
 * @package        	CodeIgniter
 * @category    	Libraries
 * @porting author	Masriadi
 *
 * @version		1.0
 */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail
{
	public function send_mail($params = array()) {
		// Instantiation and passing `true` enables exceptions
		$mail = new PHPMailer(TRUE);

		try {
		    //Server settings
		    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
		    $mail->isSMTP();
		    $mail->Host       = 'ssl://mail.kuansing.go.id';
		    $mail->SMTPAuth   = TRUE;
		    $mail->Username   = 'helpdesk.dpmptsptk@kuansing.go.id';
		    $mail->Password   = 'm.?ykXpNe3Z0';
		    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
		    $mail->Port       = 465;

		    //Recipients
		    $mail->setFrom('helpdesk.dpmptsptk@kuansing.go.id', 'DPMPTSPTK Kab. Kuansing');
		    $mail->addAddress($params['to']);

		    // Content
		    $mail->isHTML(TRUE);
		    $mail->Subject = $params['subject'];
		    $mail->Body    = $params['message'];

		    $mail->send();
		    return TRUE;
		} catch (Exception $e) {
		    log_message('error', $mail->ErrorInfo);
		    return FALSE;
		}
	}
}
