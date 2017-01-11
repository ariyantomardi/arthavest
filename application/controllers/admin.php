<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //Memanggil fungsi session Codeigniter
class admin extends CI_Controller {

		function __construct()
  		{
    		parent::__construct();
			//$this->output->enable_profiler(TRUE);
  		}

		function index()
  		{
			if($this->session->userdata('arthasession'))
   	 		{
    			$session_data = $this->session->userdata('arthasession');
				$this->load->model('m_admin');
			$table='';
			$table.='
			<script type="text/javascript">
				function set_edit_home(type,id_parent){
					var dt_string = $(\'#f_edit_home\').serialize();
						$.post("'.base_url().'index.php/c_admin/set_edit_home", dt_string, 
						function(respon) 
						{
							if(respon.status=="Fail"){
								alert(respon.msg)
							}
							else{
								alert(respon.msg)
							}
						},
					\'json\');	
				}
			</script>
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">
						Home
					</h1>

				</div>
			</div>
			<!-- /.row -->
			'.form_open_multipart('c_admin/set_edit_home').'
			  	<div class="form-group">
				  <label for="exampleInputFile">Header Image <small>Best : 1200x315</small></label>
				  <input type="file" multiple name="userfile1" size="20" />
				  <input type="file" multiple name="userfile2" size="20" />
				  <input type="file" multiple name="userfile3" size="20" />
				</div>
				<div class="form-group">
				  <label for="exampleInputFile">Center Image <small>Best : 135x130</small></label>
				  <input type="file" multiple name="userfile4" size="20" />
				  <input type="file" multiple name="userfile5" size="20" />
				  <input type="file" multiple name="userfile6" size="20" />
				</div>
			';
			$get_content_home =  $this->m_admin->get_content_home($this->session->userdata('language'));
			$i=1;
			foreach($get_content_home as $gch):
			$table.='
			<div class="col-lg-4">
				<div class="form-group">
					<label for="title">Title '.$i.'</label>
					<input type="text" class="form-control" id="menu_name'.$i.'" name="menu_name'.$i.'" value="'.@$gch->head_title.'" >
					<input type="hidden" class="form-control" id="id_content'.$i.'" name="id_content'.$i.'" value="'.@$gch->id_content_home.'" >
				</div>
				<textarea class="ckeditor" cols="10" rows="40" id="isi'.$i.'" name="isi'.$i.'">'.@$gch->isi.'</textarea>
			</div>	
			';
			$i++;
			endforeach;
			$table.='
				
				<div class="save-button" style="padding-right:50px">
					<br/>
				  <button type="button"  class="btn btn-default">Cancel</button>
				  <button type="submit"  class="btn btn-primary">Save</button>
				</div>
			</form>	
			';
			$query=$this->m_admin->select_image_home($this->session->userdata('language'));
			$row1 = $query->row(0);
			$row2 = $query->row(1);
			$row3 = $query->row(2);
			$data['content']=$table;	
			
			$this->load->view('header_admin');
			$this->load->view('body_admin',$data);
			$this->load->view('footer_admin');
			}
			
			
			else
			{
				//Jika tidak ada session di kembalikan ke halaman login
				redirect('login', 'refresh');
			}
		}
		function upload(){
			$table='';
			$table.='
			<script>
				function delete_file(id){
					var ask = confirm("Are you sure to delete this ?");
					if(ask){
						$.post("'.base_url().'index.php/c_admin/delete_file/"+id, \'\', 
							function(respon) 
							{
								if(respon.status=="Fail"){
									alert(respon.msg)
								}
								else{
									alert(respon.msg)
									window.location.href = "'.base_url().'index.php/admin/upload";
								}
							},
						\'json\');	
					}	
				}
			</script>
				'.form_open_multipart('c_admin/set_upload_file').'
					<div class="form-group">
					  <label for="exampleInputFile">Upload File</label>
					  <input type="file"  name="userfile" id="userfile" size="20" />
					  <br/>
					  <input type="submit" value="Submit" class="btn btn-primary"/>	
					</div>
				</form>	
				<label for="exampleInputFile">Recent Upload</label>
				<table class="table">
					<thead>
						<th>No</th>
						<th>URL File</th>
						<th>File Name</th>
						<th>Action</th>
					</thead>
					<tbody>
						';
					$this->load->model('m_admin');
					$get_data = $this->m_admin->get_data_upload();
					$res = $get_data->result();
					$i=1;
					foreach($res as $row):
					 $table.='
					 	<tr>
							<td>'.@$i.'</td>
							<td>'.@$row->url_file.'</td>
							<td>'.@$row->file_name.'</td>
							<td align="center" style="cursor:pointer">
								<a onClick="delete_file(\''.@$row->id_upload.'\')" style="color:red"><i class="fa fa-trash"></i></a>&nbsp;&nbsp;
								<a href="'.@$row->url_file.'" style="color:black"><i class="fa fa-download"></i></a>	
							</td>
						</tr>
					 ';
					 $i++;
					endforeach;	
				$table.='		
					</tbody>
				</table>
			';
			$data['content']=$table;	
			
			$this->load->view('header_admin');
			$this->load->view('body_admin',$data);
			$this->load->view('footer_admin');
		}
		function logout(){
			$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
			$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
			$this->output->set_header('Pragma: no-cache');
			$this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
			$this->session->unset_userdata('arthasession');
   			session_destroy();
			redirect('login', 'refresh');
		}
		function cek(){
			$this->load->view('adm_menu');
		}
		function set_lang($lang){
			
			$sess_array = array(
				  'language' => $lang
				);
        	$this->session->set_userdata($sess_array);	
			echo json_encode(array('status' => 'success', 'msg' => "asd"));
		}
		function home(){
			if($this->session->userdata('arthasession'))
   	 		{
			$this->load->model('m_admin');
			$table='';
			$table.='
			<script type="text/javascript">
				function set_edit_home(type,id_parent){
					var dt_string = $(\'#f_edit_home\').serialize();
						$.post("'.base_url().'index.php/c_admin/set_edit_home", dt_string, 
						function(respon) 
						{
							if(respon.status=="Fail"){
								alert(respon.msg)
							}
							else{
								alert(respon.msg)
							}
						},
					\'json\');	
				}
			</script>
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">
						Home
					</h1>

				</div>
			</div>
			<!-- /.row -->
			'.form_open_multipart('c_admin/set_edit_home').'
			  	<div class="form-group">
				  <label for="exampleInputFile">Header Image <small>Best : 1200x315</small></label>
				  <input type="file" multiple name="userfile1" size="20" />
				  <input type="file" multiple name="userfile2" size="20" />
				  <input type="file" multiple name="userfile3" size="20" />
				  
				</div>
				<div class="form-group">
				  <label for="exampleInputFile">Center Image <small>Best : 135x130</small></label>
				  <input type="file" multiple name="userfile4" size="20" />
				  <input type="file" multiple name="userfile5" size="20" />
				  <input type="file" multiple name="userfile6" size="20" />
				</div>
			';
			$get_content_home =  $this->m_admin->get_content_home($this->session->userdata('language'));
			$i=1;
			foreach($get_content_home as $gch):
			$table.='
			<div class="col-lg-4">
				<div class="form-group">
					<label for="title">Title '.$i.'</label>
					<input type="text" class="form-control" id="menu_name'.$i.'" name="menu_name'.$i.'" value="'.@$gch->head_title.'" >
					<input type="hidden" class="form-control" id="id_content'.$i.'" name="id_content'.$i.'" value="'.@$gch->id_content_home.'" >
				</div>
				<textarea class="ckeditor" cols="10" rows="40" id="isi'.$i.'" name="isi'.$i.'">'.@$gch->isi.'</textarea>
			</div>	
			';
			$i++;
			endforeach;
			$table.='
				
				<div class="save-button" style="padding-right:50px">
					<br/>
				  <button type="button"  class="btn btn-default">Cancel</button>
				  <button type="submit"  class="btn btn-primary">Save</button>
				</div>
			</form>	
			';
			$query=$this->m_admin->select_image_home($this->session->userdata('language'));
			$row1 = $query->row(0);
			$row2 = $query->row(1);
			$row3 = $query->row(2);
			$data['content']=$table;	
			
			$this->load->view('header_admin');
			$this->load->view('body_admin',$data);
			$this->load->view('footer_admin');
			}
			
			
			else
			{
				//Jika tidak ada session di kembalikan ke halaman login
				redirect('login', 'refresh');
			}
		}
		
		
		function edit_menu($parent='',$lvl_menu='',$id_menu=''){
			if($this->session->userdata('arthasession'))
   	 		{
			$this->load->model('m_admin');
			$cekmenu=$this->m_admin->cek_exist(@$parent,@$lvl_menu,@$id_menu);
			if($cekmenu==0){
				$table= '<h3>Tidak Ada Data</h3>';	
			}
			else{
				$menuname=$this->m_admin->get_menu_name(@$id_menu);
				if(@$lvl_menu==1){
					$head='<h2>Edit Menu '.$menuname.'</h2>';	
				}
				else{
					$head='<h2>Edit Submenu '.$menuname.'</h2>';	
				}
				$table='';
				$table.='
				<script type="text/javascript">
					function delete_menu(id_menu){
						var ask = confirm("Are you sure to delete this ?");
						if(ask){
							$.post("'.base_url().'index.php/c_admin/delete_menu/"+id_menu, \'\', 
								function(respon) 
								{
									if(respon.status=="Fail"){
										alert(respon.msg)
									}
									else{
										alert(respon.msg)
										window.location.href = "'.base_url().'index.php/admin/home";
									}
								},
							\'json\');	
						}
					}
					function set_edit_menu(){
						var dt_string = $(\'#f_edit_menu\').serialize();
							$.post("'.base_url().'index.php/c_admin/set_edit_menu", dt_string, 
							function(respon) 
							{
								if(respon.status=="Fail"){
									alert(respon.msg)
								}
								else{
									alert(respon.msg)
								}
							},
						\'json\');	
					}
				</script>
					<br/>
					  <div class="save-button">';
					  $cek_child = $this->m_admin->cek_child(@$id_menu);
					 if($cek_child!=99){
					  	$table.='<button type="button" onclick="delete_menu(\''.@$id_menu.'\')"  class="btn btn-danger">Delete</button>';
					 }
				$table.='	  
					  </div>
					  <br><br>
						'.$head.'
						<br/>
						<div class="row">
						'.form_open_multipart('c_admin/set_edit_menu').'	
							<div class="col-lg-12">
							  <select class="form-control" id="lang" name="lang">
								';
								$get_language=$this->m_admin->get_lang_sel($id_menu);
								foreach($get_language as $gl):
									if($gl->id_language == 1){
										$table.='
											<option value="1">Indonesia</option>
											<option value="2">English</option>
										';	
									}
									else{
										$table.='
											<option value="2">English</option>
											<option value="1">Indonesia</option>
										';	
									}
								endforeach;
					$table.='			
							  </select>
							  <div class="form-group">
								  <label for="title">Title</label>
								  <input type="text" class="form-control" id="menu_name" name="menu_name" value="'.$this->m_admin->get_menu_name($id_menu).'" >
								  <input type="hidden" class="form-control" id="id_menu" name="id_menu" value="'.$id_menu.'" >
							  </div>
							  <div class="form-group">
								<label for="h_image">Header Image <small>Best : 1200x315</small></label>
								<input type="file" id="userfile" name="userfile" value=""> >< '.$this->m_admin->get_img_name($id_menu).'
							  </div>
							  <textarea class="ckeditor" cols="10" rows="40" id="isi" name="isi">'.$this->m_admin->get_isi($id_menu).'</textarea>
							  <br/>
								  
								<div class="form-group">
								  <label for="title">Embed</label>
								  <textarea class="form-control" id="embed" name="embed">'.$this->m_admin->get_embed($id_menu).'</textarea>
							  	</div>  
								<div id="exc_but">
									  <button type="button"  class="btn btn-default">Cancel</button>
									  <button type="submit"  class="btn btn-default">Save</button>   
								  </div>
							  </form>
							</div>
						</div>
						<!-- /.row -->
				';
			}
			$data['content']=$table;	
			
			$this->load->view('header_admin');
			$this->load->view('body_admin',$data);
			$this->load->view('footer_admin');
			}
			
			
			else
			{
				//Jika tidak ada session di kembalikan ke halaman login
				redirect('login', 'refresh');
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