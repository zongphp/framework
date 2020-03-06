<?php

namespace zongphp\mail\build;

use zongphp\config\Config;

/**
 * 邮箱发送
 * Class Base
 *
 * @package zongphp\mail\build
 */
class Base
{
    public function send($usermail, $username, $title, $body)
    {
        $mail = new \PHPMailer();
        $mail->isSMTP();
        $mail->CharSet = 'utf-8';
        // Specify main and backup SMTP servers
        $mail->Host = Config::get('mail.host');
        // Enable SMTP authentication
        $mail->SMTPAuth = true;
        // SMTP username
        $mail->Username = Config::get('mail.username');
        // SMTP password
        $mail->Password = Config::get('mail.password');
        if (Config::get('mail.ssl')) {
            $mail->SMTPSecure = 'tls';
        }
        $mail->Port = Config::get('mail.port');
        $mail->setFrom(
            Config::get('mail.frommail'),
            Config::get('mail.fromname')
        );
        // Add a recipient
        $mail->addAddress($usermail, $username);
        $mail->Subject = $title;
        if ($body instanceof \Closure) {
            $body = $body();
        }
        $mail->msgHTML($body);

        return $mail->send();
    }
}