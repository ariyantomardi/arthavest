<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class admin extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
	
   	
	function get_lang(){
		$sql="select * from t_language
			 ";	
		$query= $this->db->query($sql);
		return $query->result();	 
	}
	function get_max_parent(){
		$sql="select max('id_parent') as maxi from t_menu
			 ";	
		$query= $this->db->query($sql);	
		$row= $query->row();
		return $row->maxi;
	}
}
