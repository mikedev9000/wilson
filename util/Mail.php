<?php

/**
 * Depends on li3_swift to send email messages.
 *
 * @author michael wilson (michael1.cis@gmail.com)
 */
namespace wilson\util;

use swift\mailer\Transports;
use swift\mailer\Message;

class Mail {
    public static function send(){
        $mailer = Transports::adapter('default');
        $message = Message::newInstance()
                          ->setSubject( $subject )
                          ->setFrom(array( $from ))
                          ->setTo( $to )
                          ->setBody( $body );
        return $mailer->send($message);
    }
}

?>
