<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email_Library {

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    public function send_email($from,$from_name,$to,$cc,$bcc,$subject,$msg)
    {
        $this->CI->load->library('email');
		
		$config = array(
			/*'smtp_host'     => 'smtp-global.indo.net.id',
			'smtp_user'     => 'datascrip2012',
			'smtp_pass'     => 'indo2012',*/
			
			'smtp_host'     => '172.16.0.12',
			//'smtp_host'     => '127.0.0.1',
			'smtp_user'     => 'mis_admin@datascrip.co.id',
			'smtp_pass'     => 'mis4dm!n',
			'smpt_port'     => 25,
			'protocol'      => 'smtp', 
			'smtp_timeout'  => 20, 
			'crlf'          => "\r\n", 
			'newline'       => "\r\n", 
			'mailtype'      => "html"
		);
		
		$this->CI->email->initialize($config);
		
        $this->CI->email->from($from, $from_name);
        //$this->CI->email->to($to); 
		$this->CI->email->to($to);
		$this->CI->email->cc($cc); 
		$this->CI->email->bcc($bcc); 
        $this->CI->email->subject($subject);
        $this->CI->email->message($msg);    
		 
        //$this->CI->email->send();
		if($this->CI->email->send()) 
		{
		  return 'success';
		}
		else
		{
		  return 'failed to send email';	  
		}
	}

}
?>