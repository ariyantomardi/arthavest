<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class verifyLogin extends CI_Controller {

  function __construct()
  {
    parent::__construct();
    $this->load->model('user','',TRUE);
	

  }

  function index()
  {
    //Aksi untuk melakukan validasi
    $this->load->library('form_validation');

    $this->form_validation->set_rules('Username', 'Username', 'trim|required|xss_clean|callback_check_database');
    
	
    if($this->form_validation->run() == FALSE)
    {
      //Jika validasi gagal user akan diarahkan kembali ke halaman login
      $this->load->view('adm_login');
    }
    else
    {
      //Jika berhasil user akan di arahkan ke private area 
      redirect('admin', 'refresh');
    }
    
  }
  
  function check_database($Username)
  {
    //validase field terhadap database 
    $Username = htmlspecialchars(@$this->input->post('Username'),ENT_QUOTES);
    $Password = htmlspecialchars(@$this->input->post('Password'),ENT_QUOTES);
    //query ke database
   	$this->load->model('user');
	//$adServer = "10.8.8.11";
	
    
    $username = htmlspecialchars(@$this->input->post('Username'),ENT_QUOTES);
    $password = htmlspecialchars(@$this->input->post('Password'),ENT_QUOTES);
	//$ldap = ldap_connect($adServer);
    //$ldaprdn = 'anabatic' . "\\" . $username;

    //ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
    //ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
	$Password=str_ireplace('&amp;','&',$Password);
	$password=str_ireplace('&amp;','&',$password);
	$Password=str_ireplace('&quot;','\"',$Password);
	$password=str_ireplace('&quot;','\'',$password);
	$Password=str_ireplace('&#039;','\'',$Password);
	$password=str_ireplace('&#039;','\'',$password);
	$Password=str_ireplace('&lt;','<',$Password);
	$password=str_ireplace('&lt;','<',$password);
	$Password=str_ireplace('&gt;','>',$Password);
	$password=str_ireplace('&gt;','>',$password);
    
    //$bind = @ldap_bind($ldap, $ldaprdn, $password);

		$msg='';
        //$filter="(sAMAccountName=$username)";
        //$result = ldap_search($ldap,"dc=MYDOMAIN,dc=COM",$filter);
        //ldap_sort($ldap,$result,"sn");
        //$info = ldap_get_entries($ldap, $result);
		@$cek_lg= $this->user->cek_admin($Username,$Password);
		if(@$cek_lg->username==$username && @$cek_lg->password==$password){
			$sess_array = array(
				  'username' => $cek_lg->username,
				  'language' => 1,
				  'arthasession' => '1'
				);
        	$this->session->set_userdata($sess_array);	
			return TRUE;
		}
		else {
		
			$this->form_validation->set_message('check_database', 'Invalid User Name Or Password ');
      		return false;	
      		
    	}
  }
}
?>