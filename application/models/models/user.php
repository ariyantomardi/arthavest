<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class user extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
   	function select($id){
		$sql="select * from t_att where id_att=".$id."";	
		$query=$this->db->query($sql);
		return $query->result();
	}
	function cek_admin($username,$password){
		$sql="select * from adm_login where username='".$username."' and password = '".$password."'  limit 1";	
		$query=$this->db->query($sql);
		$row=$query->row();
		return $row;	
	}
	
	
	function get_periode_aktif(){
		$sql="select date_1,date_2 from t_rules";	
		$query=$this->db->query($sql);
		$row=$query->row();
		return $row;		
	}
	function test(){
		$sql="insert into test values('','test2')";	
		$query=$this->db->query($sql);
		if($query){
			return TRUE;	
		}
		else{
			return FALSE;	
		}
	}
	function get_lvldesc($lvl){
		$sql="select lvldesc,lvlcode from sync_att where lvlcode='".$lvl."'";	
		$query=$this->db->query($sql);
		$row=$query->row();
		return $row->lvldesc;	
	}
	function get_lvllist($lvl){
		$sql="select lvldesc,lvlcode,Company from sync_att where lvlcode!='".$lvl."' group by lvldesc,lvlcode";	
		$query=$this->db->query($sql);
		$row=$query->row();
		return $query->result();	
	}
	function login($username,$password){
		
		$sql="
		select * from user where userid='".$username."' and passid='".$password."'";
		$query=$this->db->query($sql);
		return $query->result();
	}
	function select_user($user){
		$this->db2=$this->load->database('db_info', TRUE);
		$sql="select Nik from office_info where alias='".$user."'";
		$query=$this->db2->query($sql);
		$row=$query->result();
		$nik ='';
		foreach($row as $rs):
			$nik.=$rs->Nik.',';
		endforeach;
		$nik.='test';
		$nik=str_replace(',test','',$nik);
		return $nik;
	}
	function user_triger($username){
		$this->db2=$this->load->database('db_info', TRUE);
		$sql="select Nik,alias AS Splitted from office_info where (alias='".$username."') and Active=1";
		$query=$this->db2->query($sql);
		return $query->num_rows();	
	}
	function cek_data_user($username){
		/*$sql="
		select Nik,SUBSTRING_INDEX( email, '@', 1 ) AS Splitted from office_info
		where  (SUBSTRING_INDEX( email, '@', 1 )='".$username."')";*/
		$this->db2=$this->load->database('db_info', TRUE);
		$sql="
		select Nik,alias
		 AS Splitted
		from office_info
		where  (alias='".$username."') and Active=1";
		
		$query=$this->db2->query($sql);
		return $query->result();
	}
	function cek_level_user($username){
		$this->db2=$this->load->database('db_info', TRUE);
		$sql="
		select level from admin_info
		where  username='".$username."'";
		$query=$this->db2->query($sql);
		return $query;
	}
	function select_nik($nik){
		$sql="
			select z.nik,count(z.nik) as cnt,sum(z.status_app) as stt,
			(select count(status) from t_att where status like '%hadir%' and nik=z.nik ) as hadir,
			(select count(status) from t_att where status like '%sakit%' and nik=z.nik ) as sakit,
			(select count(status) from t_att where status like '%ijin%' and nik=z.nik ) as ijin,
			(select count(status) from t_att where status like '%alpa%' and nik=z.nik ) as alpa,
			(select count(status) from t_att where status like '%cuti%' and nik=z.nik ) as cuti
			 from t_att z where z.nik='".$nik."' and z.libur!=1
			 group by z.nik
		";	
		$query=$this->db->query($sql);
		return $query->result();
	}
	function get_emplpoyee_selection($app_emp,$lvl,$comp){
		$lvlsql="select Company,Directorate,Division,Department from sync_att where lvlcode='".$lvl."' and Company='".$comp."' limit 1";
		$lvlquery=$this->db->query($lvlsql);
		$lvlrow=$lvlquery->row();
		
		$sql="select nik,companycode,lvl1code,lvl2code,lvl3code from t_att where app_by='".$app_emp."' and 
			companycode='".$lvlrow->Company."' and lvl1code='".$lvlrow->Directorate."' and  lvl2code='".$lvlrow->Division."' and lvl3code='".$lvlrow->Department."'
		   group by nik,lvl1code,lvl2code,lvl3code";	
		$query=$this->db->query($sql);
		return $query->result();
	}
	function getName($nik){
		$sql="select name from t_att where nik='".$nik."' LIMIT 1";	
		$query=$this->db->query($sql);
		$row=$query->row();
		return $row->name;
	}
	
	function getStatus($nik,$stats){
		if($stats=='h'){
			$desc='Hadir';	
		}
		else if($stats=='s'){
			$desc='sakit';		
		}
		else if($stats=='i'){
			$desc='ijin';		
		}
		else if($stats=='a'){
			$desc='alpa';		
		}
		$sql="select count(nik) as su from t_att where nik='".$nik."' and status like '%".$desc."%'";	
		$query=$this->db->query($sql);
		$row=$query->row();
		return $row->su;	
	}
	
	function select_idtrans($idtrans){
		$this->db2=$this->load->database('db_tie', TRUE);
		$sql="select id_trans,ErCode,EeNo,CmpltName,EtDate,CONVERT(VARCHAR(19),PHKDate,105) as PHKDate,Cuti,Gaji,Alasan,DLL from db_phk.dbo.vTransPHK where id_trans=".$idtrans;	
		$query=$this->db2->query($sql);
		return $query->result();	
	}
	function get_emp_tie(){
		$this->db2=$this->load->database('db_tie', TRUE);
		$sql="select * from db_phk.dbo.vTransPHK";	
		$query=$this->db2->query($sql);
		return $query->result();
	}
	function get_emp_tie_per($from,$till){
		$this->db2=$this->load->database('db_tie', TRUE);
		$sql="select * from db_phk.dbo.vTransPHK where PHKDate between '".$from."' and '".$till."'";	
		$query=$this->db2->query($sql);
		return $query->result();
	}
	function get_emp_active($nik){
		$this->db2=$this->load->database('db_tie', TRUE);
		$sql="select ErCode,EeNo,CmpltName,Lvl1Desc,GradeCode,EtDate,LvlDesc,
			case
				when ErCode in ('SDJ','SLR','SMS') then Lvl3Desc
				else
					Lvl2Desc
				End
				as Division	,
			case
				when ErCode in ('SDJ','SLR','SMS') then Lvl4Desc
				else
					Lvl3Desc
				End
				as Department		
		 from TIE.dbo.VHRMST_EmployeeActiveTitan where 
		 	 EeNo not in (select c.EeNo from db_phk.dbo.TransPHK c)
			 and EeNo like '%".$nik."%'
		 ";	
		$query=$this->db2->query($sql);
		return $query->result();
	}
	function get_emp_nik($nik){
		$this->db2=$this->load->database('db_tie', TRUE);
		$sql="select * from db_phk.dbo.vTransPHK where EeNo='".$nik."'";	
		$query=$this->db2->query($sql);
		return $query;
	}
	function getMandays($nik,$comp){
		$sql="select count(nik) as su from t_att where nik='".$nik."' and (status!='cuti' and libur !=1) ";	
		$query=$this->db->query($sql);
		$row=$query->row();
		return $row->su;	
	}
	function get_libur($nik,$comp){
		$sql="select count(nik) as su from t_att where nik='".$nik."' and status!='cuti'";	
		$query=$this->db->query($sql);
		$row=$query->row();
		$this->db2=$this->load->database('db_tie', TRUE);
		$sql="select * from HRMST_NonWorkDay where ErCode='".$comp."'";
		return $row->su;	
	}
	function getList($nik){
		$sql="select * from t_att where nik='".$nik."' order by act_date asc";	
		$query=$this->db->query($sql);
		return $query->result();	
	}
	function get_description($codeabs,$typeabs,$comp){
		
		if($typeabs=='ab'){
			$this->db2=$this->load->database('db_tie', TRUE);
			$sql="select AbsTypeDesc from HRMST_AbsenceType where AbsTypeCode='".$codeabs."' and ErCode='".$comp."'";
			$query=$this->db2->query($sql);
			$row=$query->row();
			if($query->num_rows()>0)
			return $row->AbsTypeDesc;
		}
		else if($typeabs=='nab'){
			$this->db2=$this->load->database('db_tie', TRUE);
			$sql= "select CodeDesc from HRMST_Code where CodeType='nab' and CodeVal='".$codeabs."'";	
			$query=$this->db2->query($sql);
			$row=$query->row();
			if($query->num_rows()>0)
			return $row->CodeDesc;
		}
		else{
			return '';	
		}
	}
	function cek_libur($comp,$date){
		$this->db2=$this->load->database('db_tie', TRUE);
		$sql="select * from HRMST_NonWorkDay where NonWrkDayDate='".$date."' and ErCode='".$comp."'";	
		$query=$this->db2->query($sql);
		if($query->num_rows()>0){
			return 'bgcolor="#FF8080"';
		}
		else{
			return 'bgcolor="#D9ECFF"';
		}
	}
	function get_alasan_list(){
		$this->db2=$this->load->database('db_tie', TRUE);
		$sql="select * from db_phk.dbo.RuleAlasanPHK";	
		$query=$this->db2->query($sql);
		return $query->result();
	}
	function add_new_emp_phk($data){
		$this->db2=$this->load->database('db_tie', TRUE);
		if($this->db2->insert('db_phk.dbo.TransPHK', $data))
		{
			return TRUE;	
		}
		else{
			return FALSE;	
		}
	}
	function upd_new_emp_phk($data,$id){
		$this->db2=$this->load->database('db_tie', TRUE);
		if($this->db2->update('db_phk.dbo.TransPHK', $data,array('EeNo' => $id)))
		{
			return TRUE;	
		}
		else{
			return FALSE;	
		}
	}
	function data_non_transform_upd($data,$id){
		$this->db2=$this->load->database('db_tie', TRUE);
		if($this->db2->update('db_phk.dbo.nonTransform', $data,array('EeNo' => $id)))
		{
			return TRUE;	
		}
		else{
			return FALSE;	
		}
	}
	function data_non_transform($data){
		$this->db2=$this->load->database('db_tie', TRUE);
		if($this->db2->insert('db_phk.dbo.nonTransform', $data))
		{
			return TRUE;	
		}
		else{
			return FALSE;	
		}
	}
	function cek_transform($nik){
		$this->db2=$this->load->database('db_tie', TRUE);
		$sql="select EeNo from test.dbo.all_emp where EeNo = '".$nik."'";
		$query=$this->db2->query($sql);
		if($query->num_rows()>0)
		{
			return 1;	
		}
		else{
			return 0;	
		}
	}
	function cek_trans($nik){
		$this->db2=$this->load->database('db_tie', TRUE);
		$sql="select EeNo from db_phk.dbo.TransPHK where EeNo = '".$nik."'";
		$query=$this->db2->query($sql);
		if($query->num_rows()>0)
		{
			return 1;	
		}
		else{
			return 0;	
		}
	}
	function cek_proses($nik,$comp){
		$sql="select count(nik) as cnt,sum(status_app) as stt from t_att where nik='".$nik."'
				and libur!=1
			";	
		$query=$this->db->query($sql);
		$row=$query->row();
		if($row->cnt<=$row->stt){
			return '<span class="fa fa-check-circle" style="color:#0F0;size:15px;"></span>';
		}
		else{
			return '<span class="fa fa-exclamation" style="color:#F00;size:15px;"></span>';
		}
	}
	function cek_proses_det($id){
		$sql="select status_app from t_att where id_att='".$id."' 
			";	
		$query=$this->db->query($sql);
		$row=$query->row();
		if($row->status_app==1){
			return '<span class="fa fa-check-circle" style="color:#0F0;size:15px;"></span>';
		}
		else{
			return '<span class="fa fa-exclamation" style="color:#F00;size:15px;"></span>';
		}
	}
	
	function getabsdescription($comp,$type,$code){
		$this->db2=$this->load->database('db_tie', TRUE);
		if($type=='d'){
			$sql="select CodeDesc as description from HRMST_Code where CodeType='NAB' and CodeVal='".$code."'";		
		}
		else{
			$sql="select AbsTypeDesc as description from HRMST_AbsenceType where ErCode='".$comp."' and AbsTypeCode ='".$code."' ";		
		}
		$query=$this->db2->query($sql);
		$row=$query->row();
		return $row->description;
	}
	
	function desc_list($type,$comp){
		if($type=='d'){
			$this->db2=$this->load->database('db_tie', TRUE);
			$sql="select CodeVal as kode,CodeDesc as description from HRMST_Code where CodeType='NAB'";	
			$query=$this->db2->query($sql);
			return $query->result();
		}
		else{
			if($type=='s'){
				$abscat="('9000017','9000018','9000019')";	
			}
			else if($type=='i'){
				$abscat="('9000020','9000021','9000022','9000024','9000025','9000026','9000027','9000028','9000029','9000030','9000031','9000032')";	
			}	
			else if($type=='a'){
				$abscat="('9000001')";	
			}
			else if($type=='c'){
				$abscat="('9100000','9100001','9100002','9100003','9100004','9100005','9100006','9100007','9100008')";	
			}
			$this->db2=$this->load->database('db_tie', TRUE);
			$sql="select AbsTypeCode as kode,AbsTypeDesc as description from HRMST_AbsenceType where ErCode='".$comp."' and AbsTypeCode in ".$abscat;	
			$query=$this->db2->query($sql);
			return $query->result();	
		}
	}
	function update_att_abs($data,$id)
	{	
		if($this->db->update('t_att', $data,array('id_att' => $id)))
		{
			return TRUE;	
		}
		else{
		return FALSE;	
		}
	}
	function update_att($id){
		$sql="
			select * from  t_att where id_att=".$id.";
		";	
		$lama=0;
		$query=$this->db->query($sql);
		$row=$query->row();
		$masuk=$row->act_start;
		$keluar=$row->act_end;
		
		if($masuk==0){
			$masuk=8.30;	
		}
		if($keluar==0){
			$keluar=17.30;	
		}
		$tempstart=explode(".", round($masuk,2), 2);
		$tempend=explode(".", round($keluar,2), 2);
		if(@$tempstart[1]>@$tempend[1]){
			$lama=round($keluar+0.60-1,2)-round($masuk,2)-1;
		}
		else{
			$lama=round($keluar,2)-round($masuk,2)-1;	
		}

		$lembur=$lama-8;
		if($lembur>1){
			$lembur=$lembur;	
		}
		else{
			$lembur=0;	
		}
		if($masuk>8.45){
			$desc="Terlambat Datang";	
		}
		else{
			$desc='';	
		}
		if($keluar<17.3){
			$desc="Pulang Cepat";	
		}
		else{
			$desc='';	
		}
		
		$sqlins="
			update t_att set act_start=".$masuk." , act_end=".$keluar." , service_hour='".$lama."' , overtime='".$lembur."' , description='".$desc."',status='Hadir' ,status_app=1
			,typeabs=''
			where id_att=".$id."
		";
		if($this->db->query($sqlins)){
			return TRUE;	
		}
		else{
			return FALSE;
		}
	}
	function cek_libur_detail($date){
		$this->db2=$this->load->database('db_tie', TRUE);
		$sql="select * from HRMST_NonWorkDay where NonWrkDayDate='".$date."'";
		$query=$this->db2->query($sql);
		if($query->num_rows()>0){
			return TRUE;	
		}	
		else{
			return FALSE;	
		}
	}
	function ceknol($id,$date){
		$sql="select nik from t_att where act_date in (select tgl_libur from t_libur) and id_att=".$id."";
		$query=$this->db->query($sql);
		if($query->num_rows()>0){
			return TRUE;	
		}	
		else{
			return FALSE;	
		}	
	}
	function nonth($id,$desc){
		if($desc==0){
			$status='';
			$description='Not Verify';	
			$masuk=0;
			$keluar=0;
			$lama=0;
			$lembur=0;
		}
		else{
			$status='Hadir';
			$description='Verify';	
			$sql="
			select * from  t_att where id_att='".$id."';
			";	
			$lama=0;
			$query=$this->db->query($sql);
			$row=$query->row();
			$masuk=$row->act_start;
			$keluar=$row->act_end;
			
			if($masuk==0){
				$masuk=8.31;	
			}
			if($keluar==0){
				$keluar=17.31;	
			}
			$tempstart=explode(".", round($masuk,2), 2);
			$tempend=explode(".", round($keluar,2), 2);
			if(@$tempstart[1]>@$tempend[1]){
				$lama=round($keluar+0.60-1,2)-round($masuk,2)-1;
			}
			else{
				$lama=round($keluar,2)-round($masuk,2)-1;	
			}
	
			$lembur=$lama-8;
			if($lembur>1){
				$lembur=$lembur;	
			}
			else{
				$lembur=0;	
			}
			if($masuk>8.4){
				$desc="Terlambat Datang";	
			}
			else{
				$desc='';	
			}
			if($keluar<=17.3){
				$desc="Pulang Cepat";	
			}
			else{
				$desc='';	
			}
		}
		$sqlins="
			update t_att set act_start='".$masuk."' , act_end='".$keluar."' , service_hour='".$lama."' , overtime='".$lembur."' , description='".$description."',status='".$status."' 
			,status_app=1
			where id_att=".$id."
		";
		if($this->db->query($sqlins)){
			return TRUE;	
		}
		else{
			return FALSE;
		}
	}
}
