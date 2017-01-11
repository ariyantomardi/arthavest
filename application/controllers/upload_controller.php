<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Upload_Controller extends CI_Controller {    
public function __construct() {
    parent::__construct();   
	//header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	header("Cache-Control: no-store,no-cache, must-revalidate");
	$this->load->library('session');
		if ($this->session->userdata('dashsession') != "1")
		{
			redirect('home');
		}
	//$this->output->enable_profiler(TRUE);
}       
public function file_view(){
    $this->load->view('file_view', array('error' => ' ' ));    
}
public function do_upload(){
	@$id_cust=$_POST['id_cust_add'];
	@$nama_cust=$_POST['nama_add'];
	@$nama_cust=str_replace('/','.slash',@$nama_cust);
	@$nama_cust=str_replace('#','.hash',@$nama_cust);
	$this->load->model('m_admin');
	$id_trans=$this->m_admin->get_id_trans();
	$id_trf=$id_trans->tr;
     $config =  array(
                  'upload_path'     => "./excel/",
                  'allowed_types'   => "*",
				  'file_name'		=>	$this->session->userdata('initials'),
                  'overwrite'       => TRUE,
                  'max_size'        => "5048000",  // Can be set to particular file size
                   
                );    
				$this->load->library('upload', $config);
				$table='';
				if($this->upload->do_upload())
				{
					$status=$this->upload->data();
						
						if($status['file_ext']==".xls" || $status['file_ext']==".xlsx"){
							require_once APPPATH.'/libraries/phpexcel/PHPExcel/IOFactory.php';
							$objPHPExcel = PHPExcel_IOFactory::load('./excel/'.$this->session->userdata('initials').'.xlsx');
							$sheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
							$no = 1;
							$table.= '
							<script type="text/javascript">
							$(function() {
								$(\'#datatfile\').dataTable();
							});
							$(\'.pagination, .dataTables_info\').css({ "font-size" : "11px" });
							$(\'#datatfile_filter\').css({ "margin-right" : "5px" });
							
							</script>
							
							<form id="form_excel" name="form_excel" method="post" action="'.site_url('upload_controller/read_xls/').'">';
							
							$table.= '<table class="table table-hover" id="datatfile" width="80%" align="center">';
							$data['title']='Store : '.$nama_cust;
							$i=0;
							$a="a00001";
							foreach($sheet as $row):
								
								if($no==1){
									$table.= '<thead>
										<td width="5%" style="font-weight:800">No</td>
										<td width="23%" align="center" style="font-weight:800">'. @$row['A'] .'</td>
										<td width="30%" style="font-weight:800">'. @$row['B'] .'</td>
										<td width="5%" style="font-weight:800">'. @$row['C'] .'</td>
										<td width="22%" style="font-weight:800">'. @$row['D'] .'</td>
										<td width="15%" style="font-weight:800"><font style="visibility:hidden">aaaaaaa</font></td>
										</thead>
										<tbody>';
								}
								else{
										$table.= '<tr>';
										$table.= '<td><font size="0" style="visibility:hidden">'.$a .'</font><b>'.$i.'</b></td>';
										$table.= '<td align="center">'. $row['A'] .'</td>';
										$table.= '<td>'. @$row['B'].'</td>';
										$table.= '<td>'. @$row['C'].'</td>';
										$table.= '<td>'. @$row['D'].'</td>';
										if(is_null($row['A'])){
											$table.='<td><a><font size="1px" style="visibility:hidden">a</font><img src="'.base_url().'img/cross.png" height="20px" width="20px" height="20px"><font size="1px" style="visibility:hidden">a</font>Null RefCode </a></td>';
										}
										
										else if(is_null(($row['C']))){
												
											$table.='<td><a><font size="1px" style="visibility:hidden">a</font><img src="'.base_url().'img/cross.png" height="20px" width="20px" height="20px"><font size="1px" style="visibility:hidden">a</font>Null Stock</a></td>';
										}
										
										else if(!is_numeric($row['C'])){
												
											$table.='<td><a><font size="1px" valign="middle" align="center" style="visibility:hidden">a</font><img src="'.base_url().'img/cross.png" height="20px" width="20px" height="20px"><font size="1px" style="visibility:hidden">a</font>Wrong Type</a></td>';
										}
										else{
											$table.='<td valign="middle" align="center"><a><font size="1px" style="visibility:hidden">b</font><img src="'.base_url().'img/checked.jpg" height="20px" width="20px" height="20px"><font size="1px" style="visibility:hidden">b</font></a></td>';
										}
								}
								$table.= '</tr>';
							$no++;$a++;$i++;
							endforeach;
							$table.= '</tbody>';
							$table.= '</tfoot>';
							$table.= '</tfoot>';
							$table.= '</table>
							<div hidden="hide" style="visibility:hidden">';
							$no=1;
							foreach($sheet as $row):
								
								$table.= '<input type="hidden" id="col_A'.$no.'" name="col_A'.$no.'" value="'. @$row['A'] .'">';
								$table.= '<input type="hidden" id="col_B'.$no.'" name="col_B'.$no.'" value="'. htmlspecialchars(@$row['B'], ENT_QUOTES) .'">';
								$table.= '<input type="hidden" id="col_C'.$no.'" name="col_C'.$no.'" value="'. @$row['C'] .'">';
								$table.= '<input type="hidden" id="col_D'.$no.'" name="col_D'.$no.'" value="'. @$row['D'] .'">';		
							$no++;
							endforeach;
							
							$table.= '<input type="hidden" id="id_cust" name="id_cust" value="'. $id_cust .'">';
							$table.= '<input type="hidden" id="nama_cust" name="nama_cust" value="'. $nama_cust .'">';
							$table.= '<input type="hidden" id="id_trans" name="id_trans" value="'. $id_trf .'">';
							$table.= '<input type="hidden" id="jml" name="jml" value="'. $no .'">
							</div>
							';
							$table.= '<center><button type="button" class="btn btn-primary btn-sm" onclick="exe_trans(\''.$id_trf.'\',\''.$nama_cust.'\')">SUBMIT</button></center>';
							$table.= '';
							
							$table.= '</form>';	
							unlink('./excel/'.$status['file_name']);
							
						}
						else{
							$table= '<h2>Error ! ! !</h2>';
							$table.= '<h3>The File Type you are attempting to upload is not allowed. </h3>';
							unlink('./excel/'.$status['file_name']);	
						}	
					
				}
				else
				{
				$error = array('error' => $this->upload->display_errors());
				
				$data=$error;
				}  
				$data['main']=$table;
				$this->load->view('header_admin');
				$this->load->view('excel_view',$data);
				$this->load->view('footer');  
}
	function read_xls(){
		
		$a=0;
		$jml=$_POST['jml']-1;
		$this->load->model('m_admin');
		$id=$_POST['id_cust'];
		$id_trf=$_POST['id_trans'];
		$nama_cust=$_POST['nama_cust'];
		for($i=1;$i<=$jml;$i++){
			$col1=$_POST['col_A'.$i];
			$col2=$_POST['col_B'.$i];
			$col3=$_POST['col_C'.$i];
			$ket=$_POST['col_D'.$i];
			$cek_data=$this->m_admin->cek_item($id,$col1);
			
			if($col3<0){
				//echo "Ref_code ".$col1." gagal di tambah <br/> [ERROR] < 0 <br/>";
			}
			else if(is_null($col3)){
				//echo "Ref_code ".$col1." gagal di tambah <br/> [ERROR] NULL <br/>";
			}
			else if(!is_numeric($col3)){
				//echo "Ref_code ".$col1." gagal di tambah <br/> [ERROR] !Numeric <br/>";
			}
			else if($col1==''){
			
			}
			else if(!$cek_data && is_numeric($col3)){
				$res=$this->m_admin->new_stok_master($id,$col1,$col2,$col3);
				if($res){
					$ins=$this->m_admin->set_report_add($id,$col1,$col3,$id_trf,$ket);
					if($ins){
						$create=$this->m_admin->create_new_barang($id,$col1,$col2,$col3);
						$cek_list=$this->m_admin->cek_item_list($col1);
						if(!$cek_list){
							$create_list=$this->m_admin->create_item_list($col1,$col2);		
						}
						else{
							
						}
					}
					else{
						
					}
				}
				
				else{
					
				}
			}
			else{
				$cek_stock=$this->m_admin->stock_old($id,$col1);
				if($cek_stock){
					$res=$this->m_admin->stok_master($col1,$col3,$id);
				}
					if($res){
					
						$ins=$this->m_admin->set_report_upd($id,$col1,$col3,$cek_stock->quantity,$id_trf,$ket);
						if($ins){
							
						}
						else{
							
						}
					}
				
				else{
					
				}
			}
		}
		
	}
	
	
	
	public function do_upload_phk(){
     $config =  array(
                  'upload_path'     => "./excel/",
                  'allowed_types'   => "*",
				  'file_name'		=>	'ADMIN',
                  'overwrite'       => TRUE,
                  'max_size'        => "2048000",  // Can be set to particular file size
                   
                );    
				$this->load->library('upload', $config);
				$table='';
				if($this->upload->do_upload())
				{
					$status=$this->upload->data();
						
						if($status['file_ext']==".xls" || $status['file_ext']==".xlsx"){
							require_once APPPATH.'/libraries/phpexcel/PHPExcel/IOFactory.php';
							$objPHPExcel = PHPExcel_IOFactory::load('./excel/ADMIN.xlsx');
							$sheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
							$no = 1;
							$table.= '
							<script type="text/javascript">
							$(function() {
								$(\'#datatfile\').dataTable();
							});
							$(\'.pagination, .dataTables_info\').css({ "font-size" : "11px" });
							$(\'#datatfile_filter\').css({ "margin-right" : "5px" });
							
							</script>
							
							<form id="form_excel" name="form_excel" method="post" action="'.site_url('upload_controller/read_xls/').'">';
							
							$table.= '<table class="table table-hover" id="datatfile" width="100%" align="center">';
							$data['title']='Upload PHK';
							$i=0;
							$a="a00001";
							foreach($sheet as $row):
								
								if($no==1){
									$table.= '<thead>
										<td width="5%" style="font-weight:800">No</td>
										<td width="23%" align="center" style="font-weight:800">'. @$row['A'] .'</td>
										<td width="30%" style="font-weight:800">'. @$row['B'] .'</td>
										<td width="5%" style="font-weight:800">'. @$row['C'] .'</td>
										<td width="22%" style="font-weight:800">'. @$row['D'] .'</td>
										<td width="22%" style="font-weight:800">'. @$row['E'] .'</td>
										<td width="22%" style="font-weight:800">'. @$row['F'] .'</td>
										<td width="22%" style="font-weight:800">'. @$row['G'] .'</td>
										<td width="22%" style="font-weight:800">'. @$row['H'] .'</td>
										<td width="22%" style="font-weight:800">'. @$row['I'] .'</td>
										<td width="22%" style="font-weight:800">'. @$row['J'] .'</td>
										<td width="15%" style="font-weight:800"><font style="visibility:hidden">aaaaaaa</font></td>
										</thead>
										<tbody>';
								}
								else{
										$table.= '<tr>';
										$table.= '<td><font size="0" style="visibility:hidden">'.$a .'</font><b>'.$i.'</b></td>';
										$table.= '<td align="center">'. $row['A'] .'</td>';
										$table.= '<td>'. @$row['B'].'</td>';
										$table.= '<td>'. @$row['C'].'</td>';
										$table.= '<td>'. str_replace('/','-',@$row['D']).'</td>';
										$table.= '<td>'. str_replace('/','-',@$row['E']).'</td>';
										$table.= '<td>'. @$row['F'].'</td>';
										$table.= '<td>'. @$row['G'].'</td>';
										$table.= '<td>'. @$row['H'].'</td>';
										$table.= '<td>'. @$row['I'].'</td>';
										$table.= '<td>'. @$row['J'].'</td>';
										if(is_null($row['A'])){
											$table.='<td><a><font size="1px" style="visibility:hidden">a</font><img src="'.base_url().'img/cross.png" height="20px" width="20px" height="20px"><font size="1px" style="visibility:hidden">a</font>Null Outlet </a></td>';
										}
										
										else if(is_null(($row['E']))){
												
											$table.='<td><a><font size="1px" style="visibility:hidden">a</font><img src="'.base_url().'img/cross.png" height="20px" width="20px" height="20px"><font size="1px" style="visibility:hidden">a</font>Null Nama Toko</a></td>';
										}
										else if(is_null(($row['F']))){
												
											$table.='<td><a><font size="1px" style="visibility:hidden">a</font><img src="'.base_url().'img/cross.png" height="20px" width="20px" height="20px"><font size="1px" style="visibility:hidden">a</font>Null Lokasi</a></td>';
										}
										else{
											$table.='<td valign="middle" align="center"><a><font size="1px" style="visibility:hidden">b</font><img src="'.base_url().'img/checked.jpg" height="20px" width="20px" height="20px"><font size="1px" style="visibility:hidden">b</font></a></td>';
										}
								}
								$table.= '</tr>';
							$no++;$a++;$i++;
							endforeach;
							$table.= '</tbody>';
							$table.= '</tfoot>';
							$table.= '</tfoot>';
							$table.= '</table>
							<div hidden="hide" style="visibility:hidden">';
							$no=1;
							foreach($sheet as $row):
								
								$table.= '<input type="hidden" id="col_A'.$no.'" name="col_A'.$no.'" value="'. @$row['A'] .'">';
								$table.= '<input type="hidden" id="col_B'.$no.'" name="col_B'.$no.'" value="'. @$row['B'] .'">';
								$table.= '<input type="hidden" id="col_C'.$no.'" name="col_C'.$no.'" value="'. @$row['C'] .'">';
								$table.= '<input type="hidden" id="col_D'.$no.'" name="col_D'.$no.'" value="'. str_replace('/','-',@$row['D']) .'">';
								$table.= '<input type="hidden" id="col_E'.$no.'" name="col_E'.$no.'" value="'. str_replace('/','-',@$row['E']) .'">';
								$table.= '<input type="hidden" id="col_F'.$no.'" name="col_F'.$no.'" value="'. @$row['F'] .'">';
								$table.= '<input type="hidden" id="col_G'.$no.'" name="col_G'.$no.'" value="'. @$row['G'] .'">';
								$table.= '<input type="hidden" id="col_H'.$no.'" name="col_H'.$no.'" value="'. @$row['H'] .'">';
								$table.= '<input type="hidden" id="col_I'.$no.'" name="col_I'.$no.'" value="'. @$row['I'] .'">';
								$table.= '<input type="hidden" id="col_J'.$no.'" name="col_J'.$no.'" value="'. @$row['J'] .'"><br/>';
							$no++;
							endforeach;
							

							$table.= '<input type="hidden" id="jml" name="jml" value="'. $no .'">';
							$table.= '
							</div>
							<center><button type="button" class="btn btn-primary btn-sm" onclick="tambah_data_phk()">SUBMIT</button></center>';
							$table.= '';
							
							$table.= '</form>';	
							unlink('./excel/'.$status['file_name']);
							
						}
						else{
							$table= '<h2>Error ! ! !</h2>';
							$table.= '<h3>The File Type you are attempting to upload is not allowed. </h3>';
							unlink('./excel/'.$status['file_name']);	
						}	
					
				}
				else
				{
				$error = array('error' => $this->upload->display_errors());
				
				$data=$error;
				}  
				$data['main']=$table;
				$this->load->view('header_admin');
				$this->load->view('excel_view',$data);
				$this->load->view('footer');  
}
	function tambah_data_phk(){
		
		$a=0;
		$jml=$_POST['jml']-1;
		$this->load->model('admin');
		$table='';
		for($i=1;$i<=$jml;$i++){
			$col1=$_POST['col_A'.$i];//EeNo
			$col2=$_POST['col_B'.$i];//ErCode
			$col3=$_POST['col_C'.$i];//Name
			$col4=$_POST['col_D'.$i];//JoinDate
			$col4=date('Y-m-d',strtotime($col4));
			$col5=$_POST['col_E'.$i];//PHKDate
			$col5=date('Y-m-d',strtotime($col5));
			$col6=$_POST['col_F'.$i];//Cuti
			$col7=$_POST['col_G'.$i];//Alasan
			$col8=$_POST['col_H'.$i];//Gaji
			$col9=$_POST['col_I'.$i];//Dll
			$col10=$_POST['col_J'.$i];//Transform
			if($i>1){
				$cek_data=$this->admin->cek_nik($col1);
				
				if($col1=="" || $col5 == "" || $col6 == "" || $col7 == "" || $col8 == "" || $col9 == ""){
					//echo "Ref_code ".$col1." gagal di tambah <br/> [ERROR] < 0 <br/>";
				}
				else if($cek_data){
					
				}
				else{
					if($col10==1){
						$res=$this->admin->tambah_phk($col1,$col5,$col6,$col7,$col8,$col9,$col10);
						if($res){
							$a=$a+1;	
						}
					}
					else{
						$res2=$this->admin->tambah_non_transform($col1,$col3,$col2,$col4);
						if($res2){
							$res=$this->admin->tambah_phk($col1,$col5,$col6,$col7,$col8,$col9,$col10);
							if($res){
								$a=$a+1;	
							}	
						}	
					}
				}	
			}
			else{
			}
			
			//$table.=$this->admin->tambah_phk($col1,$col2,$col3,$col4,$col5);
		}
		if($a==0){
			echo json_encode(array('status' => 'Error', 'msg' => $table));
		}
		else{
			echo json_encode(array('status' => 'success', 'msg' => $table));	
		}
	}
	
	function view_tambah_toko(){
		$this->load->model('m_admin');
		
								
		
			$i=1;
			$table='';
			$table.= '
							<script type="text/javascript">
							$(function() {
								$(\'#datatfile\').dataTable();
							});
							$(\'.pagination, .dataTables_info\').css({ "font-size" : "11px" });
							$(\'#datatfile_filter\').css({ "margin-right" : "5px" });
							
							</script>
							
							<h3>Id Trans : '.$id_trf.'</h3>
							<br/>
							';
							$table.= '
							
							<table class="table table-hover" id="datatfile" width="80%" align="center">';
							$table.= '<thead>
										<th width="5%">No</th>
										<th width="25%">Item Code</th>
										<th width="30%">Description</th>
										<th width="5%">Stock Old</th>
										<th width="5%">Stock Add</th>
										<th width="5%">Stock New</th>
										<th width="20%">Keterangan</th>
										<th width="6%">Action</th>
										</thead>
										<tbody>';
							$z='A001';
							foreach($get_data as $row):
								$table.= '<tr>';
								$table.= '<td><font style="visibility:hidden">'.$z.'</font><b>'. $i .'</b></td>';
								$table.= '<td>'.$row->ref_code.'</td>';
								$table.= '<td>'.$row->nama_barang.'</td>';
								$table.= '<td>'.$row->stock_old.'</td>';
								$table.= '<td>'.$row->stock_add.'</td>';
								$table.= '<td>'.$row->stock_new.'</td>';
								$table.= '<td>'.$row->keterangan.'</td>';
								$table.= '<td>'.$row->act_trans.'</td>';
								$table.= '</tr>';
							$z++;
							$i++;
							endforeach;
							$table.= '</tbody>';
							$table.= '</tfoot>';
							$table.= '</tfoot>';
							$table.= '</table>';
							$table.= '';
							
							$data['title']='Store : '.$nama_cust;
							$data['main']=$table;
							$this->load->view('header_admin');
							$this->load->view('excel_view',$data);
							$this->load->view('footer');	
	}
}
?>