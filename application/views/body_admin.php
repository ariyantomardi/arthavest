<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
			<div id="main_content">
        		<?php echo $content?>
            </div>
            <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
             <div class="modal-dialog" role="document">
               <div class="modal-content">
                
                 <div id="modal_content">
                 </div>
                 
               </div>
             </div>
            </div>
            
        <script>
	  	function add_menu(language,type,parent){
			$.post("<?php echo base_url('index.php/c_admin/get_add_menu')?>/"+language+"/"+type+"/"+parent, '', 
				function(respon) 
				{
					var table='';
					var table=respon.data;
					$('#modal_content').html(table)
					$('#myModal1').modal('show'); 
				},
			'json');	 
		}
		function edit_menu(parent,lvl_menu,id_menu){
			$.post("<?php echo base_url('index.php/c_admin/refresh_screen')?>"+parent+"/"+lvl_menu+"/"+id_menu, '', 
				function(respon) 
				{
					
				},
			'json');
			$('#main_content').html('');
			document.getElementById('editor').hidden=false;
		}
		function set_home(){
			window.location.href = "<?php echo base_url().'index.php/admin/home';?>";
		}
		function set_lang(lang){
			$.post("<?php echo base_url().'index.php/c_admin/set_lang';?>/"+lang, '', 
			function(respon) 
			{
					window.location.href = "<?php echo base_url().'index.php/admin/home';?>";
				
			},
		'json');	
		}
    </script>
</html>