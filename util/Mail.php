<?php

/**
 * Depends on li3_swift to send email messages.
 *
 * @author michael wilson (michael1.cis@gmail.com)
 */
namespace wilson\util;

use swift\mailer\Transports;
use swift\mailer\Message;

class Mail extends \lithium\core\StaticObject {
    
    /**
     * Sends an email when given from, to, subject, and body.
     * @param array $options
     * @return bool 
     */
    public static function send( $options = array() ){
        
        $defaults = array(
          'to' => array( 'test@wilsonfreelance.com' => 'No Name- Test' ),
          'from' => array( 'test@wilsonfreelance.com' => 'No Name - Test' ),
          'subject' => '',
          'body' => '',            
        );
        
        $options += $defaults;
        
        $params = array( 'options' => $options );
        
        return static::_filter(__FUNCTION__, $params, function($self, $params) {
            $mailer = Transports::adapter('default');

            $message = Message::newInstance()
                              ->setSubject( $params['options']['subject'] )
                              ->setFrom( $params['options']['from'] )
                              ->setTo( $params['options']['to'] )
                              ->setBody( $params['options']['body'] );

            return $mailer->send($message);
        });
    }
}

/**
 * Example:
 * Always send email from the same address.
 *
Mail::applyFilter('send', function( $self, $params, $chain){
    
    if ( !isset( $params['options']['from'] ) )
        $params['options']['from'] = 'system@proofer.wilsonfreelance.com';
    
    return $chain->next( $self, $params, $chain );
});
 */

?>
