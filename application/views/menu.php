<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no"/>
    <link rel="stylesheet" href="<?php echo base_url()?>plugins/node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>plugins/index.css">

</head>
<script src="<?php echo base_url()?>plugins/admin/js/jquery.js"></script>

<script src="<?php echo base_url()?>plugins/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

<body>
<div class="container">
  <div class="row">
  <div class="col-md-5 col-xs-12 ">  <img src="<?php echo base_url()?>plugins/img/logo.png" class="logo"></div>
  <div class="col-md-5 col-xs-12">
  <div class="lang">
  	<form method="post" id="f_search" name="f_search">
      	<input type="text" id="search_text" name="search_text" placeholder="Search...">
        <button type="button" onClick="get_search()">GO</button>
      </form>	</div>
  
  </div>
  <div class="col-md-2 col-xs-12 ">
    <div class="lang">
      <a onClick="set_language(2)">English</a>|<a onClick="set_language(1)">Indonesia</a><br/>
    </div>
  </div>
</div>


    <nav class="navbar navbar-default" style="    background: white;
    border-color: white;">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="menu"><a href="<?php echo base_url()?>index.php/home">Home</a></li>
                    <?php
								$sm=1;
                            	$sqlmenu="select * from t_menu where id_language = '".$this->session->userdata('language')."' and lvl_menu=1 and id_menu not in (select c.id_menu from t_menu c where c.id_language = '".$this->session->userdata('language')."' and c.child_active=1)
					and id_language = '".$this->session->userdata('language')."' order by id_child,id_menu asc";
								$querymenu=$this->db->query($sqlmenu);
								$resultmenu=$querymenu->result();
								foreach($resultmenu as $rsm):
								$sqlcek = "select * from t_menu where id_language = '".$this->session->userdata('language')."' and id_parent = '".$rsm->id_parent."'";
								$cekchild = $this->db->query($sqlcek);
								if($cekchild->num_rows()<=1){
									$class= '';	
									$tag_a = 'onClick="get_menu(\''.$rsm->id_menu.'\')"';
									$span='';
								}
								else if($cekchild->num_rows()>1){
									
									$class= 'class="dropdown"';	
									$tag_a='href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                                           aria-expanded="false"';
									$span='<span class="caret"></span>';
								}
					?>
                                    
                                        <li class="menu" <?php echo $class;?>>
                                        <a <?php echo $tag_a;?> style="cursor:pointer"><?php echo $rsm->menu_name.' '.$span.' ';?> </a>
                                            <?php
                                            	if($cekchild->num_rows()>1){
											
											?>	
                                                  <ul class="dropdown-menu">	  
													  <?php
														$sqlsubmenu="select * from t_menu where id_language = '".$this->session->userdata('language')."' and id_parent=".$rsm->id_parent." and lvl_menu !=1 order by id_menu asc";
														$querysubmenu=$this->db->query($sqlsubmenu);
														$resultsubmenu=$querysubmenu->result();
														foreach($resultsubmenu as $rssm):
													  ?>
														  <li><a onClick="get_menu('<?php echo $rssm->id_menu?>')" style="cursor:pointer"><?php echo $rssm->menu_name?></a></li>
													  <?php
														endforeach;
													  ?>	
													</ul>	
											<?php
                                            	}
											?>
                                            
                            <?php		
									$sm++;
								endforeach;
							?>
                      </li>      
                    <?php
						$sqlk="select * from t_menu where id_language = '".$this->session->userdata('language')."' and id_parent=".$rsm->id_parent." and lvl_menu !=1 order by id_menu asc";
						$queryk=$this->db->query($sqlk);
						$resultk=$queryk->result();
						foreach($resultk as $resultk):
					  ?>
						  <li><a onClick="get_menu('<?php echo $resultk->id_menu?>')" style="cursor:pointer"><?php echo $resultk->menu_name?></a></li>
					  <?php
						endforeach;
					  ?>	
                </ul>


            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
</div>
<div class="container">
	<div id="content">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
            </ol>
    
            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <?php 
                    $i = 1;
                    $sql="select * from t_head_img where id_menu in (select c.id_menu from t_menu c where c.id_language = '".$this->session->userdata('language')."' and c.child_active=1)";
                    $query=$this->db->query($sql);
                    $res= $query->result();
                    foreach($res as $row):
                        if($i==1){
                            echo '
                                <div class="item active">
                                    <img src="'.base_url().'plugins/img/'.$row->image_name.'" alt="...">
                    
                                   
                                </div>
                            ';	
                        }
                        else{
                            echo '
                                <div class="item">
                                    <img src="'.base_url().'plugins/img/'.$row->image_name.'" alt="...">
                    
                                   
                                </div>
                            ';	
                        }
                        $i++;
                    endforeach;
                   ?> 
            </div>
    
    
        </div>
    
        <div class="row" style="background-color:#e6e7e8;    margin-left: 0px;
        margin-right: 0px;">
            <br>
    		<?php
            	$i=1;
				$sql="select * from t_content_home where id_menu in (select c.id_menu from t_menu c where c.id_language = '".$this->session->userdata('language')."' and c.child_active=1)
						order by id_content_home asc
					 ";	
				$query= $this->db->query($sql);	
				$get_content_home = $query->result();
				foreach($get_content_home as $gch):
				echo '
				<div class="col-md-4">
					<center><img src="'.base_url().'plugins/img/'.@$gch->icon_img.'" width="50%"></center>
					<h3 style="color:#2f3490; text-align:center"><a style="cursor:pointer; color:#2f3490; " onclick="'.@$gch->link_home.'">'.@$gch->head_title.'</a></h3>
		
					<p>'.@$gch->isi.'</p>
		
				</div>
				';
				$i++;
				endforeach;
			?>
        </div>
     </div>   
        <div class="row" style="text-align: center;
    /* padding-top: 20px; */
    color: white;
    background: #999;
    margin-top: 40px;">
            <?php
            	$sqlfoot="select * from t_menu where lvl_menu = 1 and id_menu not in (select c.id_menu from t_menu c where c.id_language = '".$this->session->userdata('language')."' and c.child_active=1)
					and id_language = '".$this->session->userdata('language')."' order by id_child,id_menu asc";
				$queryfoot=$this->db->query($sqlfoot);
				$get_foot = $queryfoot->result();
				foreach($get_foot as $gf):
				
			?>
                    <div class="col-md-2">
                        <h5 style="color:white;cursor:pointer" onClick="get_menu('<?php echo $gf->id_menu?>')"><?php echo $gf->menu_name?></h5>
                    </div>
            <?php
            	endforeach;
			?>
            		
        </div>
	
</div>
<script type="text/javascript">
	function get_menu(id){
		$.post("<?php echo base_url()?>index.php/c_admin/get_menu/"+id, '', 
			function(respon) 
			{
				var table=respon.data;
				document.getElementById("content").innerHTML=table;
				$('html,body').animate({scrollTop:0},500);
			},
		'json');	
	}
	function get_search(){
		var dt_string = $('#f_search').serialize();
		$.post("<?php echo base_url()?>index.php/c_admin/get_search/", dt_string, 
			function(respon) 
			{
				var table=respon.data;
				document.getElementById("content").innerHTML=table;
				$('html,body').animate({scrollTop:0},500);
			},
		'json');
	}
	function set_language(lang){
		$.post("<?php echo base_url().'index.php/c_admin/set_lang';?>/"+lang, '', 
		function(respon) 
		{
			window.location.href = "<?php echo base_url().'index.php/home';?>";
			
		},
	'json');	
	}
</script>
</body>

</html>
