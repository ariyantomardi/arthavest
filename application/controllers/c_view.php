<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class c_view extends CI_Controller {

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
	 
	 */
	function refresh_screen($id){
		$this->load->model('user');
		$itm = $this->user->select($id);
            // menjadikan objek menjadi JSON
            $data = json_encode($itm);
            // mengeluarkan JSON ke browser
        
		echo json_encode(array('data' => $itm));	
	}
	function refresh_screen_nik($nik){
		$this->load->model('user');
		$itm = $this->user->select_nik($nik);
            // menjadikan objek menjadi JSON
            $data = json_encode($itm);
            // mengeluarkan JSON ke browser
        
		echo json_encode(array('data' => $itm));		
	}
	function nonworkver($id,$desc){
		$this->load->model('user');
		$res=$this->user->nonth($id,$desc);
		if($res){
			echo json_encode(array('status' => 'success', 'msg' => "Data Updated"));
		}
		else{
			echo json_encode(array('status' => 'Fail', 'msg' => "Update Data Fail"));
		}
	}
	function change_lvl($lvl){
		$arr = explode('-', $lvl);
		$lvlcode = $arr[1];
		$company = $arr[0];
		$session_array = array(
								'lvlcode' => $lvlcode,
								'company' => $company,				
							   	);
		$this->session->set_userdata($session_array);
	
		echo json_encode(array('status' => 'success', 'msg' => " Succes"));
	}
	function view_employee($nik){
		$this->load->model('user');
		$eeno=$this->replace_char_dec($nik);
		$get_data=$this->user->get_emp_nik($eeno);
		$row=$get_data->row();
		$head='';
		$body='';
		$foot='';
		$head.=
			'
				<html>
					<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">
					<style type="text/css">
						table {
							border-collapse: collapse;
						}
						
						table, th, td {
							border: 1px solid black;
						}
						.div-left{
							float: left;
   							width: 50%;
						}
						.div-right{
							float: right;
   							width: 50%;
						}
					</style>
			';
		$body.=
			'
				<body>
													<center>PERJANJIAN  BERSAMA<br/></center>
					<div style="font-size:10pt">
										<center>( Lampiran SK-PHK Nomor : 049/SK-PB/HS/XII/2014)</center>
						<p align="justify">
							Yang bertanda tangan dibawah ini  :
							<br/>
							&#9;N a m a &#9;&#9;: 
							<br/>
							&#9;Jabatan &#9;&#9;:  
							<br/>
							&#9;Alamat &#9;&#9;:  
							<br/>
							Untuk selanjutnya dalam Persetujuan Bersama ini disebut <b>Pihak Pertama.</b>                             
							<br/>
							&#9;NIK &#9;&#9;: '.$row->EeNo.'
							<br/>
							&#9;N a m a &#9;&#9;: '.$row->CmpltName.' 
							<br/>
							&#9;Jabatan &#9;&#9;:  
							<br/>
							&#9;Alamat &#9;&#9;:  
							<br/>
							&#9;Mulai Bekerja &#9;:  '.date('d-m-Y',strtotime(@$row->EtDate)).'
							<br/>
							&#9;Akhir Bekerja &#9;:  '.date('d-m-Y',strtotime(@$row->PHKDate)).'
							<br/>
							&#9;Masa Kerja &#9;:  	 '.$row->YOSDesc.'	
							<br/>
							Untuk selanjutnya dalam Persetujuan Bersama ini disebut <b>Pihak Kedua.</b>
							<br/>
							Pada tanggal 2 Januari 2015 bertempat di office PT. Hillconjaya Sakti – Kantor Pusat, sehubungan dengan Pemutusan Hubungan Kerja antara pihak pertama dengan pihak kedua telah mengadakan perundingan dan telah tercapai persetujuan sebagai berikut  :
							<br/>
							1.&#9;Bahwa pihak kedua dengan ikhlas dan sukarela menerima dan menyetujui Pemutusan Hubungan Kerja  dengan pihak pertama terhitung mulai tanggal 2 Januari 2015
							<br/>
							2.&#9;Bahwa sehubungan dengan pemutusan hubungan kerja tersebut pihak pertama akan memberikan kepada&#9;pihak kedua sesuatu pembayaran  :
							<br/>
						</p>
						<center>
							<table style="font-size:10pt">
								<tr>
									<td style="width:20px"><b>1</td>		<td><b>Gaji terakhir										</b></td>	<td style="width:95px"><b>Rp.'.number_format($row->Gaji).'</b></td>	
								</tr>
								<tr>			
									<td><b>2</b></td>						<td><b>Kompensasi PHK 										</b></td>	<td></td>
								</tr>	
								<tr>
									<td></td>								<td>a.Uang Pesangon												</td> 	<td><b>Rp.'.number_format($row->pesangon).'</b></td>
								</tr>
								<tr>	
									<td></td>								<td>b.Uang Penghargaan Masa Kerja								</td> 	<td><b>Rp.'.number_format($row->pmk).'</b></td>	
								</tr>
								<tr>	
									<td></td>								<td>c.Uang Penggantian Perum, pengobatan & Perawatan			</td>	<td><b>Rp.</b></td>	
								</tr>
								<tr>	
									<td></td>								<td>d. Uang Pengganti cuti tahunan yang belum diambil (..HK)	</td>	<td><b>Rp.'.number_format($row->sisa_cuti).'</b></td>	
								</tr>
								<tr>	
									<td></td>								<td>e.Uang pisah												</td>	<td><b>Rp.</b></td>	
								</tr>
								<tr>	
									<td></td>								<td>f. Lain-lain												</td>	<td><b>Rp.'.number_format($row->DLL).'</b></td>	
								</tr>
								<tr style="background-color:#BFBFFF">	
									<td colspan="2" align="center" style="font-weight:bold;">	G R A N D  T O T A L						</td>	<td><b>Rp.'.number_format($row->total).'</b></td>	
								</tr>
							</table>
						</center>
						<p align="justify">
						&#9;<b><i>Terbilang : (....................)</i></b>
						<br/>
						3.&#9;Bahwa pihak kedua dengan ikhlas dan sukarela menerima dan menyetujui pembayaran tersebut.
						<br/>
						4.&#9;Bahwa dengan dibayarkannya pembayaran tersebut, maka persoalan pemutusan hubungan kerja antara&#9;pihak pertama dengan pihak kedua telah selesai, dan baik pihak pertama maupun pihak kedua tidak akan&#9;mengajukan suatu tuntutan berupa apapun juga baik selama masih ada hubungan kerja maupun setelah&#9;berakhirnya hubungan kerja.
						<br/>
						5.&#9;ahwa dengan ditandatanganinya persetujuan bersama ini sekaligus juga merupakan kuitansi penerimaan&#9;uang tersebut.
						<br/>
						Demikian Persetujuan Bersama ini dibuat dan ditandatangani bersama tanpa ada tekanan dari siapapun juga dan dalam keadaan sehat jasmani dan rohani, baik pihak pertama maupun pihak kedua akan melaksanakan persetujuan bersama ini dengan sebaik-baiknya dan dengan penuh rasa tanggung jawab.  
						<br/>
						<br/>
						</p>
						Jakarta, 30 Desember 2014
						<br/>
						<table style="border:none;font-size:10pt;width:100%" border="0">
							<tr style="border:none;" border="0">
								<td style="border:none;" border="0" align="left">Pihak Pertama, 			<td style="border:none;" border="0" align="right">Pihak Kedua,
							<tr style="border:none;" border="0"><td style="border:none;" border="0" colspan="2"></td></tr>
							<tr style="border:none;" border="0" ><td style="border:none;" border="0" colspan="2"></td></tr>
							<tr style="border:none;" border="0">
								<td style="border:none;" border="0" align="left">......................	</td><td style="border:none;" border="0" align="right">......................</td>
							</tr>
							<tr style="border:none;" border="0">
								<td style="border:none;" border="0" align="left">HRG Dept Head				</td><td style="border:none;" border="0" align="right">Karyawan</td>	 
							</tr>
						</table>
					</div>
			';	
		$foot.='	
					<div style="font-size:6pt">
						Tembusan : 
						<br/>
						1.	Asli – Kabag PGA
						<br>
						2.	Kabag Finance
						<br/>
						3.	Karyawan Ybs
						<br/>
						4.	File
					</div>	
				</body>		
			</html>
		';
		$nik=str_replace('%10spasi','',$nik);
		$name='PHK_'.$nik;
		header("Content-type: application/vnd.ms-word");
		header("Content-Disposition: attachment;Filename=".$name.".doc");
		
		echo $head;
		echo $body;
		echo $foot;
	}
	function search_emp(){
		$nik=$_POST['nik'];
		$this->load->model('user');
		$get_employee=$this->user->get_emp_active(@$nik);
		$table='';
		$table.='
		<script type="text/javascript">
			$(function() {
			$(\'#emp_search\').dataTable();
			});
			$(\'.pagination, .dataTables_info\').css({ "font-size" : "11px" });
			$(\'#emp_search_filter\').css({ "margin-right" : "5px" });
			
			function set_value(comp,nik,name,etdate){
				document.getElementById(\'ErCode\').value=comp;
				document.getElementById(\'EeNo\').value=nik;
				document.getElementById(\'CmpltName\').value=name;
				document.getElementById(\'EtDate\').value=etdate;
				$(\'#myModal\').modal(\'hide\');
			}
		</script>
		
		<h3>List Employee Active</h3>
			<div class="table-responsive">
				<table class="table table-hover" id="emp_search" name="emp_search">
					<thead>
						<th>Company</th>
						<th>EeNo</th>
						<th>Employee Name</th>
						<th>Directorate</th>
						<th>Division</th>
						<th>Department</th>
						<th>Level</th>
						<th>Grade</th>
						<th>Join Date</th>
					</thead>
					<tbody>
					';
					foreach($get_employee as $emp_row) : 
						$table.='
							<tr onclick="set_value(\''.$emp_row->ErCode.'\',\''.$emp_row->EeNo.'\',\''.$emp_row->CmpltName.'\',\''.date('d-m-Y',strtotime($emp_row->EtDate)).'\')" style="cursor:pointer">
								<td>'.$emp_row->ErCode.'</td>
								<td>'.$emp_row->EeNo.'</td>
								<td>'.$emp_row->CmpltName.'</td>
								<td>'.$emp_row->Lvl1Desc.'</td>
								<td>'.$emp_row->Division.'</td>
								<td>'.$emp_row->Department.'</td>
								<td>'.$emp_row->LvlDesc.'</td>
								<td>'.$emp_row->GradeCode.'</td>
								<td>'.$emp_row->EtDate.'</td>
							</tr>
						';
					endforeach;
					$table.='</tbody>
				</table>
			<div>	
		';
		echo json_encode(array('data' => $table));	
	}
	function search_alasan(){
		$this->load->model('user');
		$get_employee=$this->user->get_alasan_list();
		$table='';
		$table.='
		<script type="text/javascript">
			$(function() {
			$(\'#alasan_search\').dataTable();
			});
			$(\'.pagination, .dataTables_info\').css({ "font-size" : "11px" });
			$(\'#alasan_search_filter\').css({ "margin-right" : "5px" });
			
			function set_value_alasan(alasan){
				document.getElementById(\'Alasan\').value=alasan;
				$(\'#myModal\').modal(\'hide\');
			}
		</script>
		
		<h3>List</h3>
			<div class="table-responsive">
				<table class="table table-hover" id="alasan_search" name="alasan_search">
					<thead>
						<th>ID</th>
						<th>Alasan</th>
						<th>Pesangon</th>
						<th>PMK</th>
					</thead>
					<tbody>
					';
					foreach($get_employee as $emp_row) : 
						$table.='
							<tr onclick="set_value_alasan(\''.$emp_row->id_alasan.'\')" style="cursor:pointer">
								<td>'.$emp_row->id_alasan.'</td>
								<td>'.$emp_row->alasan.'</td>
								<td>'.$emp_row->pesangon.'</td>
								<td>'.$emp_row->pmk.'</td>
							</tr>
						';
					endforeach;
					$table.='</tbody>
				</table>
			<div>	
		';
		echo json_encode(array('data' => $table));	
	}
	function set_add_new(){
		$this->load->model('user');
		$EeNo=$_POST['EeNo'];
		$Cuti=$_POST['Cuti'];
		$Gaji=$_POST['Gaji'];
		$Gaji=$_POST['Gaji'];
		$Dll=$_POST['Dll'];
		$JoinDate=$_POST['EtDate'];
		$ErCode=$_POST['ErCode'];
		$CmpltName=$_POST['CmpltName'];
		$Alasan=$_POST['Alasan'];
		$PHKDate=$_POST['date_1'];
		$Transform=$this->user->cek_transform($EeNo);
		$data = array(
			   'EeNo' => $EeNo ,
			   'Cuti' => $Cuti,
			   'PHKDate' => date('Y-m-d',strtotime($PHKDate)),
			   'Gaji' => $Gaji ,
			   'Alasan' => $Alasan,
			   'Transform' => $Transform,
			   'Dll' => $Dll,
			);
			$data2 = array(
			   'EeNo' => $EeNo ,
			   'CmpltName' => $CmpltName,
			   'ErCode' =>  $ErCode,
			   'JoinDate' => date('Y-m-d',strtotime($JoinDate))
			);
		$cektrans= $this->user->cek_trans($EeNo);
		if($cektrans==0){
			
			if($Transform==1){
				$res=$this->user->add_new_emp_phk($data);
				if($res){
					echo json_encode(array('status' => 'success', 'msg' => "Data Updated"));
				}
				else{
					echo json_encode(array('status' => 'Fail', 'msg' => "Update Data Fail"));
				}	
			}
			else{
				$res=$this->user->add_new_emp_phk($data);
				if($res){
					$res2=$this->user->data_non_transform($data2);
					if($res2){
						echo json_encode(array('status' => 'success', 'msg' => "Data Updated"));
					}
					else{
						echo json_encode(array('status' => 'Fail', 'msg' => "Update Data Fail"));
					}
				}
				else{
					echo json_encode(array('status' => 'Fail', 'msg' => "Update Data Fail"));
				}
			}
		}
		else{
			if($Transform==1){
				$res=$this->user->upd_new_emp_phk($data,$EeNo);
				if($res){
					echo json_encode(array('status' => 'success', 'msg' => "Data Updated"));
				}
				else{
					echo json_encode(array('status' => 'Fail', 'msg' => "Update Data Fail"));
				}	
			}
			else{
				$res=$this->user->upd_new_emp_phk($data,$EeNo);
				if($res){
					$res2=$this->user->data_non_transform_upd($data2,$EeNo);
					if($res2){
						echo json_encode(array('status' => 'success', 'msg' => "Data Updated"));
					}
					else{
						echo json_encode(array('status' => 'Fail', 'msg' => "Update Data Fail"));
					}
				}
				else{
					echo json_encode(array('status' => 'Fail', 'msg' => "Update Data Fail"));
				}
			}	
		}
		
	}
	function get_data_view($na){
            // mengambil data mahasiswa dari database
			$na=$this->replace_char_dec($na);
			$this->load->model('user');
            $itm = $this->user->select_idtrans($na);
            // menjadikan objek menjadi JSON
            $data = json_encode($itm);
            // mengeluarkan JSON ke browser
        
		echo json_encode(array('data' => $itm));
        //header('Content-Length: '.strlen($data));
        //exit($data);
    }
	function get_employee(){
		$table='';
		$hiden='';
		$app_emp=$this->session->userdata('nik');
		$this->load->model('user');
		$i=1;
		$temptbl='';
				$temptbl.='			  
				<div class="table-responsive">
				  <table class="table table-hover" id="t_v_phk" name="t_v_phk">
				  
					  <thead>
						  <tr>
						  	  <th align="center">Action</th>
							  <th>Company</th>
							  <th>NIK</th>
							  <th>Employee Name</th>
							  <th>Join Date</th>
							  <th>Resign Date</th>
							  <th>Lama</th>
							  <th>Sisa Cuti</th>
							  <th>Alasan PHK</th>
							  <th>Gaji</th>
							  <th>Harga Cuti</th>
							  <th>Pesangon</th>
							  <th>PMK</th>
							  <th>15% Hak</th>
							  <th>Total</th>
						  </tr>
					  </thead>
				  
					  <tbody>
						  ';
						  $get_employee=$this->user->get_emp_tie();
						  foreach($get_employee as $emp_row) : 
						  $temptbl.='
						  	  	<tr>
									<td align="center">';
									
						  $temptbl.='		
						  				<div onClick="set_update(\''.$this->replace_char_enc($emp_row->id_trans).'\')" style="cursor:pointer;">
											<i class="fa fa-edit" style="color:green"></i>
										</div>
										<div onClick="alert(\'asd\')" style="cursor:pointer;color:red" >
											<span class="fa fa-trash"></span>
										</div>	
										<div onClick="v_emp(\''.$this->replace_char_enc($emp_row->EeNo).'\')" style="cursor:pointer">
											<span class="fa fa-eye"></span>
										</div>
									</td>
									
									<td>'.$emp_row->ErCode.'</td>
									<td>'.$emp_row->EeNo.'</td>
									<td>'.$emp_row->CmpltName.'</td>
									<td>'.date('d-m-Y',strtotime($emp_row->EtDate)).'<input type="hidden" id="etdate'.$emp_row->id_trans.'" name="etdate'.$emp_row->id_trans.'" value="'.date('d-m-Y',strtotime($emp_row->EtDate)).'"></td>
									<td>'.date('d-m-Y',strtotime($emp_row->PHKDate)).'<input type="hidden" id="phkdate'.$emp_row->id_trans.'" name="phkdate'.$emp_row->id_trans.'" value="'.date('d-m-Y',strtotime($emp_row->PHKDate)).'"></td>
									<td>'.$emp_row->YOSDesc.'</td>
									<td>'.$emp_row->Cuti.'</td>
									<td>'.$emp_row->AlasanDesc.'</td>
									<td>'.number_format($emp_row->Gaji).'</td>
									<td>'.number_format($emp_row->sisa_cuti).'</td>
									<td>'.number_format($emp_row->pesangon).'</td>
									<td>'.number_format($emp_row->pmk).'</td>
									<td>'.number_format($emp_row->hak).'</td>
									<td>'.number_format($emp_row->total).'</td>
									
						  		</tr>';
						  endforeach;
					  $temptbl.='</tbody>
				  </table>
				   </div>';
		$table.='
		<script type="text/javascript">
		$(function() {
			$(\'#t_v_phk\').dataTable();
			});
			$(\'.pagination, .dataTables_info\').css({ "font-size" : "11px" });
			$(\'#t_v_phk_filter\').css({ "margin-right" : "5px" });
		
		$(\'#EtDate\').datepicker({ format: \'dd-mm-yyyy\' });	
		$(\'#date_1\').datepicker({ format: \'dd-mm-yyyy\' });	
		$(\'#per_1\').datepicker({ format: \'dd-mm-yyyy\' });	
		$(\'#per_2\').datepicker({ format: \'dd-mm-yyyy\' });		
		function v_emp(nik){
			window.location.href = "'.base_url().'index.php/c_view/view_employee/"+nik;		
		}
		function search_emp(){
			var title = \'\';
			var footer = \'\';
			
			document.getElementById(\'myModalLabel\').innerHTML=title;
			document.getElementById(\'modal-footerq\').innerHTML=footer;	
					$.post("'.base_url().'index.php/c_view/search_emp/", {
					  nik: document.getElementById(\'EeNo\').value
					}, 
				function(respon) 
				{
					var table=\'\';
					var table=respon.data;
					
					//setModalBox(title,\'\',footer,size,table);
					$(\'#modal_data\').html(table)
					$(\'#myModal\').modal(\'show\');
				},
				\'json\');			
		}
		function set_update(id_trans){
			var title = \'\';
			var footer = \'\';
			
			$.post("'.base_url().'index.php/c_view/get_data_view/"+id_trans, \'\', 
				function(respon) 
				{
					var table=\'\';
					var ErCode=respon.data[0].ErCode;
					var CmpltName=respon.data[0].CmpltName;
					var EeNo=respon.data[0].EeNo;
					var EtDate=document.getElementById(\'etdate\'+id_trans).value;
					var Cuti=respon.data[0].Cuti;
					var Gaji=respon.data[0].Gaji;
					var PHKDate=document.getElementById(\'phkdate\'+id_trans).value;
					var Alasan=respon.data[0].Alasan;
					var DLL=respon.data[0].DLL;
					document.getElementById(\'ErCode\').value=ErCode;
					document.getElementById(\'CmpltName\').value=CmpltName;
					document.getElementById(\'EeNo\').value=EeNo;
					document.getElementById(\'EtDate\').value=EtDate;
					document.getElementById(\'Cuti\').value=Cuti;
					document.getElementById(\'Gaji\').value=Gaji;
					document.getElementById(\'date_1\').value=PHKDate;
					document.getElementById(\'Alasan\').value=Alasan;
					document.getElementById(\'Dll\').value=DLL;
				},
				\'json\');	
		}
		function search_alasan(){
			var title = \'\';
			var footer = \'\';
			
			document.getElementById(\'myModalLabel\').innerHTML=title;
			document.getElementById(\'modal-footerq\').innerHTML=footer;	
					$.post("'.base_url().'index.php/c_view/search_alasan/", \'\', 
				function(respon) 
				{
					var table=\'\';
					var table=respon.data;
					
					//setModalBox(title,\'\',footer,size,table);
					$(\'#modal_data\').html(table)
					$(\'#myModal\').modal(\'show\');
				},
				\'json\');			
		}
		function add_new_phk(){
			 var dt_string = $(\'#f_new\').serialize();
			$.post("'.base_url().'index.php/c_view/set_add_new", dt_string, 
			function(respon) 
			{
				if(respon.status=="Fail"){
					alert(respon.msg)
				}
				else{
					alert(respon.msg)
					window.location.href = "'.base_url().'index.php/home";
				}
			},
		\'json\');
		}
		</script>
				
				<br/>
				<div class="col-lg-3">
					<form action="post" id="f_new" name="f_new">
							<div class="panel panel-default">
							  <div class="panel-body">
								<label for="ErCode"> Company</label>
								<input class="form-control" type="text" name="ErCode" id="ErCode" />
								<label for="EeNo"> EeNo</label>
								<input class="form-control" type="text" name="EeNo" id="EeNo" />
								<label for="CmpltName"> Name</label>
								<input class="form-control" type="text" name="CmpltName" id="CmpltName" />
								<label for="EtDate"> Join Date</label>
								<input type="text" name="EtDate" id="EtDate"  autocomplete="off" data-dateformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" class="form-control"  maxlength="10" size="4">
								<button class="btn btn-info btn-flat" type="button" onclick="search_emp()"><i class="fa fa-search"></i></button>
							  </div>
						  	</div>	
							<label for="Cuti"> Cuti</label>
							<input class="form-control" type="text" name="Cuti" id="Cuti"/>
							<label for="Gaji"> Gaji</label>
							<input class="form-control" type="text" name="Gaji" id="Gaji"/>
						  	<label for="date_1"> PHKDate : </label>
							<input type="text" name="date_1" id="date_1"  autocomplete="off" data-dateformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" class="form-control"  maxlength="10" size="4">
							<label for="Alasan"> Alasan</label>
							<div class="input-group input-group-sm">
								<input class="form-control" type="text" id="Alasan" name="Alasan">
								<span class="input-group-btn">
									<button class="btn btn-info btn-flat" type="button" onclick="search_alasan()"><i class="fa fa-search"></i></button>
								</span>
							</div>
							<label for="Dll"> Dan Lain Lain</label>
							<input class="form-control" type="text" name="Dll" id="Dll"/>
							<div class="input-group input-group-sm">
								<input type="button" class="btn btn-primary form-control" id="pencet_submit" name="pencet_submit" onclick="add_new_phk()" value="Submit">
							</div>
					</form>	
				</div>
				
			   <div class="col-lg-9">
							  <div class="panel panel-default">
							  <div class="panel-body">
							  <div class="col-lg-7">
							  </div>
							  <div class="col-lg-5" style="padding-left:78px">
							  	<form action="'.base_url('index.php/c_view/to_excel').'" name="f_excel" id="f_excel" method="post" >
									<label>From</label>
									<input type="text" name="per_1" id="per_1"  autocomplete="off" data-dateformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" maxlength="10" size="10">
									<label>Till</label>
									<input type="text" name="per_2" id="per_2"  autocomplete="off" data-dateformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" maxlength="10" size="10">
									<button type="submit" class="btn btn-primary btn-sm" style="background-color:black" style="cursor:pointer"><i class="fa fa-file-excel-o"></i></button>
							 	</form>
							  </div>
							  <br/><br/>
				';
				
				$table.=$temptbl.'   
						  
				</div> 
						  
			</div>
		  </div>
		';	
		echo json_encode(array('data' => $table));	
	}
	function to_excel(){
		$app_emp=$this->session->userdata('nik');
		$from=$this->input->post('per_1');
		$till=$this->input->post('per_2');
		if($from==''){
			$from='1970-01-01';
		}
		else{
			$from=$from;
		}
		if($till==''){
			$till='2080-01-01';
		}
		else{
			$till=$till;
		}
		$this->load->model('user');
		$i=1;
		$temptbl='';
		$tfrom=strtotime($from);
		$ttill=strtotime($till);
		$from = date('Y-m-d',$tfrom);
		$till = date('Y-m-d',$ttill);
				$temptbl.='			  
				  <table border="1">
					  <thead>
						  <tr>
							  <th>Company</th>
							  <th>NIK</th>
							  <th>Employee Name</th>
							  <th>Join Date</th>
							  <th>Resign Date</th>
							  <th>Lama</th>
							  <th>Sisa Cuti</th>
							  <th>Alasan PHK</th>
							  <th>Gaji</th>
							  <th>DLL</th>
							  <th>Harga Cuti</th>
							  <th>Pesangon</th>
							  <th>PMK</th>
							  <th>15% Hak</th>
							  <th>Total</th>
						  </tr>
					  </thead>
				  
					  <tbody>
						  ';
						  $get_employee=$this->user->get_emp_tie_per($from,$till);
						  foreach($get_employee as $emp_row) : 
						  $temptbl.='
						  	  	<tr>
									<td>'.$emp_row->ErCode.'</td>
									<td>'.$emp_row->EeNo.'</td>
									<td>'.$emp_row->CmpltName.'</td>
									<td>'.$emp_row->EtDate.'</td>
									<td>'.$emp_row->PHKDate.'</td>
									<td>'.$emp_row->YOSDesc.'</td>
									<td>'.$emp_row->Cuti.'</td>
									<td>'.$emp_row->AlasanDesc.'</td>
									<td>'.number_format($emp_row->Gaji).'</td>
									<td>'.number_format($emp_row->DLL).'</td>
									<td>'.number_format($emp_row->sisa_cuti).'</td>
									<td>'.number_format($emp_row->pesangon).'</td>
									<td>'.number_format($emp_row->pmk).'</td>
									<td>'.number_format($emp_row->hak).'</td>
									<td>'.number_format($emp_row->total).'</td>
									
						  		</tr>';
						  endforeach;
					  $temptbl.='</tbody>
				  </table>';
		header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
		header("Content-Disposition: attachment; filename=PHK_Record.xls");  //File name extension was wrong
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);
		echo $temptbl;		   
	}
	function get_desc($status,$comp,$id,$nik){
		$this->load->model('user');
		$table='';
		$table.='
			<script type="text/javascript">
					$(function() {
					$(\'#lertable\').dataTable();
					});
					$(\'.pagination, .dataTables_info\').css({ "font-size" : "11px" });
					$(\'#lertable_filter\').css({ "margin-right" : "5px" });
					
					function upd_absence(nik,id,status,absdesc){
							$.post("'.base_url().'index.php/c_view/upd_absence/"+id+"/"+status+"/"+absdesc, \'\', 
							function(respon) 
							{
								if(respon.status=="Fail"){
									alert(respon.msg)
								}
								else{
									upd_screen_detail(id,nik);
									
									$(\'#myModal\').modal(\'hide\');
									
								}
							},
						\'json\');
					}
					
			</script>	
			<div class="table-responsive">
					<form method="post" id="cari_tanggal" name="cari_tanggal">
						<table border="0" id="lertable" name="lertable" cellspacing="0" cellpadding="0" class="table table-hover" style="font-size:12px; margin-bottom:0px">
							<thead align="center">
								<tr align="center">
									<td align="center" style="font-size:12pt;font-weight:bold;">
										Description
									</td>	
								</th>
							</thead>
							<tbody>
												
		';
		$description_list=$this->user->desc_list($status,$comp);
		foreach($description_list as $dl) :
			$table.='
				<tr align="center" onclick="upd_absence(\''.$nik.'\','.$id.',\''.$status.'\',\''.trim($dl->kode).'\')" style="cursor:pointer">
					<td align="center">
						'.$dl->description.'
					</td>
				</tr>
			';
		endforeach;	
		$table.='
						</table>
					</form>
			</div>		
		';
		echo json_encode(array('data' => $table));	
	}
	function upd_absence($id,$status,$abskode){
		$this->load->model('user');
		$abs_desc=$this->user->getabsdescription($this->session->userdata('company'),$status,$abskode);
		$str=0;
		$end=0;
		$ovr=0;
		$dur=0;
		$typeabs='ab';
		if($status=='d'){
			$statdesc='Hadir';
			$str=8.3;
			$end=17.3;
			$ovr=8;
			$dur=8;	
			$typeabs='nab';
		}
		else if($status=='s'){
			$statdesc='sakit';	
		}
		else if($status=='i'){
			$statdesc='izin';	
		}
		else if($status=='a'){
			$statdesc='alpa';	
		}
		else if($status=='c'){
			$statdesc='cuti';	
		}
		$data = array(
		   'act_start' => $str ,
		   'act_end' => $end,
		   'status' => $statdesc ,
		   'service_hour' => $dur ,
		   'overtime' => $ovr ,
		   'codeabs' => $abskode,
		   'typeabs' => $typeabs,
		   'description' => $abs_desc ,
		   'status_app' => 1 
		);
		$this->load->model('user');
		$res=$this->user->update_att_abs($data,$id);
		if($res){
			echo json_encode(array('status' => 'success', 'msg' => "Data Updated"));
		}
		else{
			echo json_encode(array('status' => 'Fail', 'msg' => "Update Data Fail"));
		}
	}
	function upd_att($id,$nik){
		
		$this->load->model('user');
		$res=$this->user->update_att($id);
		if($res){
			echo json_encode(array('status' => 'success', 'msg' => "Data Updated"));
		}
		else{
			echo json_encode(array('status' => 'Fail', 'msg' => "Update Data Fail"));
		}
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