<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //Memanggil fungsi session Codeigniter
class Home extends CI_Controller {

		function __construct()
  		{
    		parent::__construct();
			//$this->output->enable_profiler(TRUE);
		
  		}

		function index()
  		{
			if($this->session->userdata('language'))
   	 		{
				$this->load->view('menu');	
			}
			else{
				$sess_array = array(
					  'language' => 1
					);
				$this->session->set_userdata($sess_array);	
				$this->load->view('menu');
			}
			
		}
		function search(){
			$search = $_POST['search_text'];	
			$this->load->model('m_admin');
			$srch = $this->m_admin->get_search($search);
			$table='';
			$table.='
				<script type="text/javascript">
					function get_content(id){
						
					}
				</script>
			';
			foreach($srch as $sr):
				$table.='
					<div style="border-color:black" onclick="get_content(\''.$sr->id_menu.'\')">
						<label for="title">'.$sr->menu_name.'</label>
						'.$sr->isi_menu.'
					</div>
				';
			endforeach;
		}
		function logout(){
			$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
			$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
			$this->output->set_header('Pragma: no-cache');
			$this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
			$this->session->unset_userdata('dashsession');
   			session_destroy();
			redirect('login', 'refresh');
		}
		function menu(){
			$this->load->view('sub_menu');
		}
		function reload(){
			redirect('home', 'refresh');
		}
		function test(){
			$this->load->model('user');
			$res=$this->user->test();
			if($res){
				echo 'sukses';	
			}	
			else{
				echo 'gagal';
			}
		}	
		function send(){
			if($this->session->userdata('level')=='Admin'){
				$this->load->view('header_admin');
				$this->load->view('v_send');
				$this->load->view('footer');	
			}
			else{
				redirect('home', 'refresh');		
			}
		}
		function export(){
			if($this->session->userdata('level')=='Admin'){
				$this->load->view('header_admin');
				$this->load->view('v_export');
				$this->load->view('footer');	
			}
			else{
				redirect('home', 'refresh');		
			}	
		}
		
		function rules(){
			$this->load->view('header_admin');
			$this->load->view('v_rules');
			$this->load->view('footer');		
		}
		function about(){
			$this->load->view('header_super');
			$this->load->view('about');
			$this->load->view('footer');
		}
		
		
 }
	
	
?>