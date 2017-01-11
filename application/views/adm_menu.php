<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Arthavest Admin</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="<?php echo base_url()?>plugins/node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>plugins/index.css">
    <script src="<?php echo base_url()?>plugins/ckeditor/ckeditor.js"></script>
    	<link rel="stylesheet" href="<?php echo base_url()?>plugins/admin/css/editor.css">



    <!-- Custom CSS -->
    <link href="<?php echo base_url()?>plugins/admin/css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="<?php echo base_url()?>plugins/admin/css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url()?>plugins/admin/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">Arthavest Admin</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>Admin <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li>
                          <a data-toggle="modal" data-target="#myModal1"><i class="fa fa-fw fa-gear"></i> Settings</a>
                      </li>
                      <li class="divider"></li>
                        <li>
                            <a href="admin/index.html"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a onClick="set_home()" style="cursor:pointer"><i class="fa fa-fw fa-dashboard"></i> Home</a>
                    </li>

                    <li >
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo" ><i class="fa fa-fw fa-bars"></i> Menu <i style="float:right; margin-right:10px" class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" style="padding-left: 10px;"class="collapse">

                            <?php
								$sm=1;
                            	$sqlmenu="select * from t_menu where lvl_menu=1 and id_menu !=1 order by id_menu asc";
								$querymenu=$this->db->query($sqlmenu);
								$resultmenu=$querymenu->result();
								foreach($resultmenu as $rsm):
							?>
                                    
                                        <li>
                                          <a style="display:inline;cursor:pointer" onClick="edit_menu('<?php echo $rsm->id_parent?>','<?php echo $rsm->lvl_menu?>','<?php echo $rsm->id_menu?>')"><?php echo $rsm->menu_name;?></a><span href="javascript:;" data-toggle="collapse" data-target="#demo<?php echo $sm;?>"> <i style="float:right; margin-right:10px ; cursor:pointer" class="fa fa-fw fa-caret-down"></i></span>
                                          <ul id="demo<?php echo $sm;?>" class="collapse" style="padding-left: 60px;
                                            border-bottom: grey solid 1px;">
                                              <?php
												$sqlsubmenu="select * from t_menu where id_parent=".$rsm->id_parent." and lvl_menu !=1 order by id_menu asc";
												$querysubmenu=$this->db->query($sqlsubmenu);
												$resultsubmenu=$querysubmenu->result();
												foreach($resultsubmenu as $rssm):
											  ?>
                                                  <li style="color: grey;
                                                    list-style-type: none; padding-bottom:10px;padding-top:10px">
                                                      <a style="color: #999;cursor:pointer" onClick="edit_menu('<?php echo $rssm->id_parent?>','<?php echo $rssm->lvl_menu?>','<?php echo $rssm->id_menu?>')"><?php echo $rssm->menu_name;?></a>
                                                  </li>
                                              <?php
                                              	endforeach;
											  ?>
          
                                               <li style="color: grey;
                                                 list-style-type: none; padding-bottom:10px;padding-top:10px" >
                                                  <a style="color: grey;cursor:pointer" onClick="add_menu(<?php $lvl=$rsm->lvl_menu+1; echo $lvl?>,'<?php echo $rsm->id_parent?>')"><i class="fa fa-fw fa-plus-circle"></i>Add SubMenu</a>
                                               </li>
                                          </ul>
                                        </li>
                            <?php		
									$sm++;
								endforeach;
							?>

                             <li style="color: grey;
                               list-style-type: none;">
                                <a style="cursor:pointer" onClick="add_menu('1','0')"><i class="fa fa-fw fa-plus-circle"></i>Add Menu</a>



                             </li>
                        </ul>
                    </li>
                    <li>
                        <a href="admin/contact.html"><i class="fa fa-fw fa-phone"></i> Contact Us</a>
                    </li>

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">
           
				<div id="main_content">
				
                <!-- Page Heading -->
                
                    <!-- edit profile Modal -->
                    
				</div>
                <div id="editor" hidden="hide">
                        	<?php
								echo form_open_multipart('c_admin/set_edit_menu');
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
									  	<div id="del_menu">
											<button type="button" onclick="delete_menu(\'\')"  class="btn btn-danger">Delete</button>
										</div>
									  </div>
									  <br><br>
										<h2></h2>
										<div class="row">
											<div class="col-lg-12">
											  <select class="form-control" id="lang" name="lang">
												';
												$sql="select * from t_language
													 ";	
												$query= $this->db->query($sql);
												$get_language = $query->result();
												foreach($get_language as $gl):
													$table.='
														<option value="'.$gl->id_language.'">'.$gl->language_name.'</option>
													';
												endforeach;
									$table.='			
											  </select>
											  <div class="form-group">
												  <label for="title">Title</label>
												  <input type="text" class="form-control" id="menu_name" name="menu_name" value="" >
												  <input type="text" class="form-control" id="id_menu" name="id_menu" value="" >
											  </div>
						
											</div>
										</div>
										<!-- /.row -->
						
										  <div class="form-group">
											  <label for="h_image">Header Image</label>
											  <input type="file" id="userfile[]" name="userfile[]" value="">
											</div>
						
								';
							echo $table	
							?>
                            
                        <textarea class="ckeditor" cols="10" rows="40" id="isi" name="isi"><?php echo '';?></textarea>
                        <br/>
                        <div id="exc_but">
                         	<button type="button"  class="btn btn-default">Cancel</button>
                            <button type="submit"  class="btn btn-default">Save</button>   
                        </div>
                    </form>
                </div>
                
                    
                <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                 <div class="modal-dialog" role="document">
                   <div class="modal-content">
                   	
                     <div id="modal_content">
                     </div>
                     
                   </div>
                 </div>
                </div>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="<?php echo base_url()?>plugins/admin/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url()?>plugins/admin/js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="<?php echo base_url()?>plugins/admin/js/plugins/morris/raphael.min.js"></script>
    <script src="<?php echo base_url()?>plugins/admin/js/plugins/morris/morris.min.js"></script>
    <script src="<?php echo base_url()?>plugins/admin/js/plugins/morris/morris-data.js"></script>
    <script>
	  	function add_menu(type,parent){
			$.post("<?php echo base_url('index.php/c_admin/get_add_menu')?>/"+type+"/"+parent, '', 
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
			$.post("<?php echo base_url('index.php/c_admin/refresh_screen')?>", '', 
				function(respon) 
				{
					
				},
			'json');
			$('#main_content').html('');
			document.getElementById('editor').hidden=false;
		}
		function set_home(){
			$.post("<?php echo base_url('index.php/c_admin/get_content_home')?>", '', 
				function(respon) 
				{
					var table='';
					var table=respon.data;
					document.getElementById('editor').hidden=true;
					$('#main_content').html(table)
				},
			'json');
		}
		$.post("<?php echo base_url('index.php/c_admin/get_content_home')?>", '', 
			function(respon) 
			{
				var table='';
				var table=respon.data;
				
				$('#main_content').html(table)
			},
		'json');
		
    </script>
</body>

</html>
