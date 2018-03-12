<?php
require_once(dirname(__FILE__).'/src/Exception.php');
require_once(dirname(__FILE__).'/src/PHPMailer.php');
require_once(dirname(__FILE__).'/src/SMTP.php');

use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\Exception;

class php_mail {
    public $subject   = '';
    public $body      = '';
    public $is_html   = true;
    public $error     = false;
    public $error_msg = '';

    private $to      = [];
    private $mail    = null;

    #Email does not exist
    private $from = [
        'name'  => 'RealtorHeart',
        'email' => 'realtor@realtorheart.com',
    ];

    #Email does not exist
    private $reply_to = [
        'name'  => 'RealtorHeart',
        'email' => 'realtor@realtorheart.com',
    ];
    private $cc = [
        'name'  => '',
        'email' => '',
    ];
    private $bcc = [
        'name'  => '',
        'email' => '',
    ];

    private $attachment = [
        'has_attachment' => false,
    ];

    public function __construct($exceptions=null){
        $this->mail = new PHPMailer($exceptions);

        return $this;
    }

    public function from($address, $name=''){
        if(is_null($address)) return;

        if(is_array($address) && isset($address['email']) && is_string($address['email'])){
            $address = $address['email'];
            $name    = isset($address['name']) ? $address['name'] : '';
        }

        if(!is_string($address)) return $this;

        $this->from = [
            'name'  => $name,
            'email' => $address,
        ];

        return $this;
    }

    public function reply_to($address, $name=''){
        $this->reply_to = [
            'name'  => $name,
            'email' => $address,
        ];

        return $this;
    }

    public function cc($address, $name=''){
        $this->cc = [
            'name'  => $name,
            'email' => $address,
        ];

        return $this;
    }

    public function bcc($address, $name=''){
        $this->bcc = [
            'name'  => $name,
            'email' => $address,
        ];

        return $this;
    }

    public function addAddress($address, $name=''){
        if(is_null($address)) return;

        if(is_array($address) && isset($address['email']) && is_string($address['email'])){
            $address = $address['email'];
            $name    = isset($address['name']) ? $address['name'] : '';
        }

        if(is_array($address) && isset($address[0])){
            foreach($address as $list) {
                if(!isset($list['email']) || !is_string($list['email'])) continue;

                $this->to[] = [
                    'name'  => isset($list['name']) ? $list['name'] : '',
                    'email' => $list['email'],
                ];
            }
        }

        if(!is_string($address)) return $this;

        $this->to[] = [
            'name'  => $name,
            'email' => $address,
        ];

        return $this;
    }

    public function addAttachment($path, $name = '', $encoding = 'base64', $type = '', $disposition = 'attachment'){
        $this->$attachment = [
            'has_attachment' => true,
            'path'           => $path,
            'name'           => $name,
            'encoding'       => $encoding,
            'type'           => $type,
            'disposition'    => $disposition,
        ];

        //$mail->addAttachment($path, $name, $encoding, $type, $disposition);

        return $this;
    }

    public static function create(){
        return new php_mail();
    }

    public static function send($to, string $subject, string $body, $from=null){
        $mail = new php_mail();

        return $mail->mail($to, $subject, $body, $from);
    }

    public function mail($to=null, $subject=null, $body=null, $from=null){
        $this->from($from);
        $this->addAddress($to);

        if(is_string($subject)){
            $this->subject = $subject;
        }

        if(is_string($body)){
            $this->body = $body;
        }

        try {
            $this->mail->setFrom($this->from['email'], $this->from['name']);
            $this->mail->isHTML($this->is_html);

            $this->mail->Subject = $this->subject;
            $this->mail->Body    = $this->body;

            foreach ($this->to as $to) {
                $this->mail->addAddress($to['email'], $to['name']);
            }

            if(is_string($this->reply_to['email']) && $this->reply_to['email'] != ''){
                $this->mail->addReplyTo($this->reply_to['email'], $this->reply_to['name']);
            }

            if(is_string($this->cc['email']) && $this->cc['email'] != ''){
                $this->mail->addCC($this->cc['email'], $this->cc['name']);
            }

            if(is_string($this->bcc['email']) && $this->bcc['email'] != ''){
                $this->mail->addBCC($this->bcc['email'], $this->bcc['name']);
            }

            if($this->attachment['has_attachment'] == true){
                $this->mail->addAttachment(
                    $this->$attachment['path'],
                    $this->$attachment['name'],
                    $this->$attachment['encoding'],
                    $this->$attachment['type'],
                    $this->$attachment['disposition']
                );
            }

            $this->mail->send();

            return true;
        } catch (Exception $e) {
            $this->$error = true;
            $this->$error_msg = $this->mail->ErrorInfo;

            return false;
        }
    }
}
?>
