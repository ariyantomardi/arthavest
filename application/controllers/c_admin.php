<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class c_admin extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 var dt_string = $(\'#edit_detail_pegawai\').serialize();
							$.post("'.base_url().'index.php/c_set_edit/set_detail", dt_string, 
							function(respon) 
							{
								if(respon.status=="Fail"){
									alert(respon.msg)
								}
								else{
									window.location.href = "'.base_url().'index.php/home";
								}
							},
						\'json\');
	 
	 $update_menu=$this->m_admin->update_menu($id_menu,$menu_name);	
				if($update_menu){
					$update_body=$this->m_admin->update_body($id_menu,$text);	
					if($update_body){
						$update_img=$this->m_admin->update_img($id_menu,$files['userfile']['name'][$i]);	
						if($update_img){
							echo '
								<script type="text/javascript">
									alert(\'Upload Sukses\');
									window.location.href = "'.base_url().'index.php/admin/by_pass";
								</script>
							';
						}
					}
				}
	 
	 */
	function test_json(){
		
		$json=file_get_contents('http://kapanguekawin.com/get.php');
		$row=json_decode($json);
		echo $json;
		echo "
			<br/>
		";
		echo $row->excuse;
		
	} 
	function refresh_screen(){
		$this->load->model('m_admin');
		$itm = $this->m_admin->get_lang();
		// menjadikan objek menjadi JSON
		$data = json_encode($itm);
		// mengeluarkan JSON ke browser
		echo json_encode(array('data' => $itm));	
	}
	function get_isi($id_menu){
		$this->load->model('m_admin');
		$itm = $this->m_admin->get_isi($id_menu);
        echo json_encode(array('data' => $itm));	
	}
	function set_add_menu($lang,$type,$id_parent){
		$this->load->model('m_admin');
		$title=$_POST['menu_name'];
		if($type==1){
			$id_parent=$this->m_admin->get_max_parent()+1;
			$res=$this->m_admin->set_add_menu($id_parent,$title,$lang);
		}
		else{
			$lvl_menu=$type;
			$res=$this->m_admin->set_add_menu_sub($id_parent,$title,$lvl_menu,$lang);	
		}
		if($res){
			echo json_encode(array('status' => 'success', 'msg' => "Add Menu Success"));
		}
		else{
			echo json_encode(array('status' => 'Fail', 'msg' => "Add Menu Fail"));
		}	
	}
	function delete_menu($id_menu){
		$this->load->model('m_admin');
		$row=$this->m_admin->get_detail($id_menu);
		$id_parent = $row->id_parent;
		$lvl_menu = $row->lvl_menu;
		$res=$this->m_admin->del_menu($id_parent,$lvl_menu,$id_menu);	
		if($res){
			echo json_encode(array('status' => 'success', 'msg' => "Menu Has Deleted"));
		}
		else{
			echo json_encode(array('status' => 'Fail', 'msg' => "Delete Menu Fail"));
		}	
	}
	
	function delete_file($id){
		$this->load->model('m_admin');	
		@$get_data = $this->m_admin->get_data_upload_by("where id_upload = '".$id."'");
		@$get_image = $get_data->row();
		@$image = $get_image->file_name;
		$unlink = unlink('./plugins/uploaded/'.$image);	
		if($unlink){
			$res=$this->m_admin->del_file($id);
			if($res){
			echo json_encode(array('status' => 'success', 'msg' => "File Has Deleted"));
			}
			else{
				echo json_encode(array('status' => 'Fail', 'msg' => "Delete File Fail"));
			}	
		}
		else{
			echo json_encode(array('status' => 'Fail', 'msg' => "Delete File Fail"));
		}	
	}
	
	private function set_upload_options()
	{   
		//upload an image options
		$config = array();
		$config['upload_path'] = './plugins/img/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['overwrite']     = TRUE;
		return $config;
	}
	private function set_upload_file_options()
	{   
		//upload an image options
		$config = array();
		$config['upload_path'] = './plugins/uploaded/';
		$config['allowed_types'] = '*';
		$config['overwrite']     = TRUE;
		return $config;
	}
	function set_upload_file(){
		
		//Get the content of the image and then add slashes to it 
		/*$folder="/xampp/htdocs/images/";
		
		move_uploaded_file($_FILES[" myimage "][" tmp_name "], "$folder".$_FILES[" myimage "][" name "]);*/
		$this->load->library('upload');
		$this->load->model('m_admin');
				$files = $_FILES;
				$_FILES['userfile']['name']= $files['userfile']['name'];
				$_FILES['userfile']['type']= $files['userfile']['type'];
				$_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'];
				$_FILES['userfile']['error']= $files['userfile']['error'];
				$_FILES['userfile']['size']= $files['userfile']['size'];    
				
				$this->upload->initialize($this->set_upload_file_options());
				$cek=$this->upload->do_upload();
				if($cek){
					$set_upload_file = $this->m_admin->set_upload_file($files['userfile']['name']);	
					if($set_upload_file){
						$table = '
							<script type="text/javascript">
								alert(\'Upload Sukses\');
								window.location.href = "'.base_url().'index.php/admin/upload";
							</script>
						';
					}
					else{
						$table = '
							<script type="text/javascript">
								alert(\'Upload Sukses || Insert Image Fail \');
								window.location.href = "'.base_url().'index.php/admin/upload";
							</script>
						';	
					}
				}
				else{
					$table = '
						<script type="text/javascript">
							alert(\'Upload Sukses || Update Image Fail \');
							window.location.href = "'.base_url().'index.php/admin/upload";
						</script>
					';	
				}
		echo $table;
			
	}
	function set_edit_menu(){
		$id_menu = $_POST['id_menu'];
		$menu_name = $_POST['menu_name'];
		$text = $_POST['isi'];
		$lang = $_POST['lang'];
		$embed = $_POST['embed'];
		
		//Get the content of the image and then add slashes to it 
		/*$folder="/xampp/htdocs/images/";
		
		move_uploaded_file($_FILES[" myimage "][" tmp_name "], "$folder".$_FILES[" myimage "][" name "]);*/
		$this->load->library('upload');
		$this->load->model('m_admin');
			
				$set_isi = $this->m_admin->update_body($id_menu,$text,$embed);
				if($set_isi){
					$set_title = $this->m_admin->update_menu($id_menu,$menu_name);
					$set_lang = $this->m_admin->update_lang($id_menu,$lang);	
					if($set_title){
						$files = $_FILES;
		                 
						$_FILES['userfile']['name']= $files['userfile']['name'];
						$_FILES['userfile']['type']= $files['userfile']['type'];
						$_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'];
						$_FILES['userfile']['error']= $files['userfile']['error'];
						$_FILES['userfile']['size']= $files['userfile']['size'];    
				
						$this->upload->initialize($this->set_upload_options());
						$cek=$this->upload->do_upload();
						if($cek){
							$set_img = $this->m_admin->update_img($id_menu,$files['userfile']['name']);	
							if($set_img){
								$table = '
									<script type="text/javascript">
										alert(\'Upload Sukses\');
										window.location.href = "'.base_url().'index.php/admin/home";
									</script>
								';
							}
							else{
								$table = '
									<script type="text/javascript">
										alert(\'Upload Sukses || Insert Image Fail \');
										window.location.href = "'.base_url().'index.php/admin/home";
									</script>
								';	
							}
						}
						else{
							$table = '
								<script type="text/javascript">
									alert(\'Upload Sukses || Update Image Fail \');
									window.location.href = "'.base_url().'index.php/admin/home";
								</script>
							';	
						}
					}
					else{
						$table = '
								<script type="text/javascript">
									alert(\'Upload Sukses || Update Title Fail\');
									window.location.href = "'.base_url().'index.php/admin/home";
								</script>
							';	
					}
				}
				else{
					$table = '
							<script type="text/javascript">
								alert(\'Upload Sukses || Update Description Fail\');
								window.location.href = "'.base_url().'index.php/admin/home";
							</script>
						';	
				}
			
				echo $table;
			
	}
	
	function set_edit_home(){
		
		$this->load->model('m_admin');
		$this->load->library('upload');
		$query=$this->m_admin->select_image_home($this->session->userdata('language'));
		$query2=$this->m_admin->select_content_home($this->session->userdata('language'));
		$files = $_FILES;
		$b=1;
		for($x=1;$x<=3;$x++){
			$id_content = $_POST['id_content'.$x];
			$menu_name = $_POST['menu_name'.$x];
			$isi = $_POST['isi'.$x];
			$update_content=$this->m_admin->update_content($id_content,$menu_name,$isi);	
		}
		for($c=4; $c<=6; $c++)
		{             
			$b=$c-4;
			$brow = $query2->row($b); 
			$_FILES['userfile']['name']= $files['userfile'.$c]['name'];
			$_FILES['userfile']['type']= $files['userfile'.$c]['type'];
			$_FILES['userfile']['tmp_name']= $files['userfile'.$c]['tmp_name'];
			$_FILES['userfile']['error']= $files['userfile'.$c]['error'];
			$_FILES['userfile']['size']= $files['userfile'.$c]['size'];   
				
			$this->upload->initialize($this->set_upload_options());
			$cek=$this->upload->do_upload();
			
			if($cek){
				$res=$this->m_admin->insert_content_image($brow->id_content_home,1,$files['userfile'.$c]['name'],$this->session->userdata('language'));	
			}
		}
		for($i=1; $i<=3; $i++)
		{                    
			$_FILES['userfile']['name']= $files['userfile'.$i]['name'];
			$_FILES['userfile']['type']= $files['userfile'.$i]['type'];
			$_FILES['userfile']['tmp_name']= $files['userfile'.$i]['tmp_name'];
			$_FILES['userfile']['error']= $files['userfile'.$i]['error'];
			$_FILES['userfile']['size']= $files['userfile'.$i]['size'];   
				
			$this->upload->initialize($this->set_upload_options());
			$cek=$this->upload->do_upload();
			
			if($cek){
				$a=$i-1;
				$row = $query->row($a);
				$res=$this->m_admin->insert_image($row->id_img,1,$files['userfile'.$i]['name'],$this->session->userdata('language'));	
				if($res){
					echo '
						<script type="text/javascript">
							alert(\'Upload Sukses\');
							window.location.href = "'.base_url().'index.php/admin/home";
						</script>
					';	
				}
			}
			else{
				echo '
						<script type="text/javascript">
							alert(\'Update Data Sukses\');
							window.location.href = "'.base_url().'index.php/admin/home";
						</script>
					';
			}
		}
		
		
	}
	function get_content_home(){
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
                      <label for="exampleInputFile">Header Image</label>
                      <input type="file" multiple name="userfile[]" size="20" />
                    </div>

                    <div class="save-button">
                      <button type="button"  class="btn btn-default">Cancel</button>
                      <button type="submit"  class="btn btn-primary">Save</button>
                    </div>
				</form>	
		';
		
		echo json_encode(array('data' => $table));	
	}
	
	function set_lang($lang){
		
		$sess_array = array(
			  'language' => $lang
			);
		$this->session->set_userdata($sess_array);	
		echo json_encode(array('status' => 'success', 'msg' => "asd"));
	}
	
	function get_add_menu($lang,$type,$parent){
		$table='';
		$this->load->model('m_admin');
		if($type==1){
			$head='Add Menu';	
		}
		else{
			$parentname=$this->m_admin->get_parent_name($parent);
			$head='Add Submenu of '.$parentname;	
		}
		$table.='
				<script type="text/javascript">
					function set_add_menu(lang,type,id_parent){
						var dt_string = $(\'#f_add_menu\').serialize();
							$.post("'.base_url().'index.php/c_admin/set_add_menu/"+lang+"/"+type+"/"+id_parent, dt_string, 
							function(respon) 
							{
								if(respon.status=="Fail"){
									alert(respon.msg)
								}
								else{
									window.location.href = "'.base_url().'index.php/admin/home";
								}
							},
						\'json\');	
					}
				</script>
		
				<div class="modal-header">
				 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				 <h4 class="modal-title" id="myModalLabel">'.$head.'</h4>
			   	</div>
			   	<div class="modal-body">
				 <form id="f_add_menu" name="f_add_menu" method="post">
				   <div class="form-group">
					 <label for="menu_name">Title</label>
					 <input type="text" class="form-control" id="menu_name" name="menu_name" placeholder="Tile">
				   </div>
				 </form>
			   	</div>
			   	<div class="modal-footer">
				 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				 <button type="button" class="btn btn-primary" onclick="set_add_menu(\''.$lang.'\',\''.$type.'\',\''.$parent.'\')">Save changes</button>
			   	</div>
		';
		
		echo json_encode(array('data' => $table));	
	}
	function get_text_editor($id_menu){
		$table='';
		$table.='<textarea class="ckeditor" cols="10" rows="40" id="isi" name="isi"></textarea>';	
		echo json_encode(array('data' => $table));	
	}
	function get_content_menu($parent,$lvl_menu,$id_menu){
		$this->load->model('m_admin');
		$menuname=$this->m_admin->get_menu_name($id_menu);
		if($lvl_menu==1){
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
								window.location.href = "'.base_url().'index.php/admin/by_pass";
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
              <div class="save-button">
                <button type="button" onclick="delete_menu(\''.$id_menu.'\')"  class="btn btn-danger">Delete</button>
              </div>
              <br><br>
				'.$head.'
                <div class="row">
                    <div class="col-lg-12">
                      <select class="form-control" id="lang" name="lang">
                        ';
						$get_language=$this->m_admin->get_lang();
						foreach($get_language as $gl):
							$table.='
								<option value="'.$gl->id_language.'">'.$gl->language_name.'</option>
							';
						endforeach;
			$table.='			
                      </select>
                      <div class="form-group">
						  <label for="title">Title</label>
						  <input type="text" class="form-control" id="menu_name" name="menu_name" value="'.$this->m_admin->get_menu_name($id_menu).'" >
						  <input type="text" class="form-control" id="id_menu" name="id_menu" value="'.$id_menu.'" >
					  </div>

                    </div>
                </div>
                <!-- /.row -->
		';
		
		echo json_encode(array('data' => $table));	
	}
	function get_search(){
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
			if($srch->num_rows()==0){
				$table.='No Result';
			}
			else{
				
			foreach($srch->result() as $sr):
				$table.='
					<div style="border-color:black" onclick="get_content(\''.$sr->id_menu.'\')">
						<a onclick="get_menu(\''.$sr->id_menu.'\')" style="cursor:pointer">'.$sr->menu_name.'</a>
					</div>
				';
			endforeach;	
			}
		echo json_encode(array('data' => $table));	
		}
	function get_menu($id_menu){
		$this->load->model('m_admin');
		$get_menu = $this->m_admin->get_menu_name($id_menu);
		$get_img_name = $this->m_admin->get_img_name($id_menu);
		$get_isi = $this->m_admin->get_isi($id_menu);
		$get_embed = $this->m_admin->get_embed($id_menu);
		$get_child = $this->m_admin->get_child2($id_menu);
		$get_child1 = $this->m_admin->get_child3($id_menu);
		$get_c = @$get_child1->row();
		@$get_parent1 = $this->m_admin->get_parent3($id_menu);
		$table='';
		$table.='
			
				<img src="'.base_url().'plugins/img/'.$get_img_name.'" width="100%">
				<div class="sub">
					<div class="row">
						<div class="col-md-4 ">
			
						</div>
						<div class="col-md-5">
							<a style="cursor:pointer" href="'.base_url().'index.php/home"> Home</a>
						';
							$i=1;

								$table.='
									<span class="divi"> > </span> <a style="cursor:pointer" onClick="get_menu(\''.$get_parent1->id_menu.'\')">'.$get_parent1->menu_name.'</a>
								';
								if($get_child1->num_rows()!=0){
								$table.='
									<span class="divi"> > </span> <a style="cursor:pointer" onClick="get_menu(\''.$get_c->id_menu.'\')">'.$get_c->menu_name.'</a>
								';
								}
							
				$table.='	   
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 ">
						<div class="submenu">
							';
							foreach($get_child as $gc):
								$table.='
									<p onClick="get_menu(\''.$gc->id_menu.'\')">'.$gc->menu_name.'</p>
								';
							endforeach;
				$table.='			
						</div>
					</div>
					<div class="col-md-8">
						<h3 style="color:#FFC107">'.$get_menu.'</h3>
						<p >'.$get_isi.'<br/>'.$get_embed.'</p>
					</div>
				</div>
		';	
		echo json_encode(array('data' => $table));	
	}
	
	function replace_char_enc($chr){
		$result=str_replace("#","%10hash",$chr);
		$result=str_replace("/","%10slash",$result);
		$result=str_replace("'","%10kutip1",$result);
		$result=str_replace("@","%10ad",$result);
		$result=str_replace("!","%10seru",$result);
		$result=str_replace("\\","%10bslash",$result);
		$result=str_replace("\"","%10kutip2",$result);
		$result=str_replace("^","%10kuad",$result);
		$result=str_replace("&","%10and",$result);
		$result=str_replace("*","%10btg",$result);
		$result=str_replace("[","%10sk1",$result);
		$result=str_replace("]","%10sk2",$result);
		$result=str_replace("$","%10dollar",$result);
		$result=str_replace(";","%10tikom",$result);
		$result=str_replace(".","%10ttk",$result);
		$result=str_replace(",","%10koma",$result);
		$result=str_replace("~","%10alay",$result);
		$result=str_replace("?","%10tanya",$result);
		$result=str_replace("<","%10siku1",$result);
		$result=str_replace(">","%10siku2",$result);
		$result=str_replace("{","%10krwl1",$result);
		$result=str_replace("}","%10krwl2",$result);
		$result=str_replace("|","%10or",$result);
		$result=str_replace("`","%10uni",$result);
		$result=str_replace("+","%10plus",$result);
		$result=str_replace("=","%10sdgn",$result);
		$result=str_replace("(","%10bkrg",$result);
		$result=str_replace(")","%10tkrg",$result);
		$result=str_replace(":","%10bagi",$result);
		$result=str_replace(" ","%10spasi",$result);
		$result=str_replace("-","%10min",$result);
		return $result;
	}
	
	function replace_char_dec($chr){
		$result=str_replace("%10hash","#",$chr);
		$result=str_replace("%10slash","/",$result);
		$result=str_replace("%10kutip1","'",$result);
		$result=str_replace("%10ad","@",$result);
		$result=str_replace("%10seru","!",$result);
		$result=str_replace("%10bslash","\\",$result);
		$result=str_replace("%10kutip2","\"",$result);
		$result=str_replace("%10kuad","^",$result);
		$result=str_replace("%10and","&",$result);
		$result=str_replace("%10btg","*",$result);
		$result=str_replace("%10sk1","[",$result);
		$result=str_replace("%10sk2","]",$result);
		$result=str_replace("%10dollar","$",$result);
		$result=str_replace("%10tikom",";",$result);
		$result=str_replace("%10ttk",".",$result);
		$result=str_replace("%10koma",",",$result);
		$result=str_replace("%10alay","~",$result);
		$result=str_replace("%10tanya","?",$result);
		$result=str_replace("%10siku1","<",$result);
		$result=str_replace("%10siku2",">",$result);
		$result=str_replace("%10krwl1","{",$result);
		$result=str_replace("%10krwl2","}",$result);
		$result=str_replace("%10or","|",$result);
		$result=str_replace("%10uni","`",$result);
		$result=str_replace("%10plus","+",$result);
		$result=str_replace("%10sdgn","=",$result);
		$result=str_replace("%10bkrg","(",$result);
		$result=str_replace("%10tkrg",")",$result);
		$result=str_replace("%10bagi",":",$result);
		$result=str_replace("%10spasi"," ",$result);
		$result=str_replace("%10min","-",$result);
		return $result;
	}
	
}


        
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php 


*/

