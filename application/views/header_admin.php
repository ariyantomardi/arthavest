
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
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i><?php echo $this->session->userdata('username')?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li>
                          <a data-toggle="modal" data-target="#myModal1"><i class="fa fa-fw fa-gear"></i> Settings</a>
                      </li>
                      <li class="divider"></li>
                        <li>
                            <a href="<?php echo base_url()?>index.php/admin/logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demoh"><i class="fa fa-fw fa-dashboard"></i> Home<i style="float:right; margin-right:10px" class="fa fa-fw fa-caret-down"></i></a>
                        	<ul id="demoh" class="collapse">
                                <li style="cursor:pointer" onClick="set_lang(1)">
                                  <a style="display:inline;cursor:pointer" ></a>Indonesia<span> <i style="float:right; margin-right:10px ; cursor:pointer" ></i></span>
                                  
                                </li>
                                <li style="cursor:pointer" onClick="set_lang(2)">
                                  <a href="javascript:;" style="display:inline;cursor:pointer" ></a>English<span> <i style="float:right; margin-right:10px ; cursor:pointer" ></i></span>
                                </li>
                            </ul>     
                                    
                    </li>

                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo" ><i class="fa fa-fw fa-bars"></i> Menu <i style="float:right; margin-right:10px" class="fa fa-fw fa-caret-down"></i></a>
                           <ul id="demo" class="collapse">
                                    <li>
                                      <a style="display:inline;cursor:pointer" ></a>Indonesia<span href="javascript:;" data-toggle="collapse" data-target="#demoindo"> <i style="float:right; margin-right:10px ; cursor:pointer" class="fa fa-fw fa-caret-down"></i></span>
                                      <ul id="demoindo" class="collapse" style="padding-left: 60px;
                                        border-bottom: grey solid 1px;">
                
                                            <?php
                                                $sm=1;
                                                $sqlmenu="select * from t_menu where lvl_menu=1 and id_menu not in (1) and id_child != 99 and id_language=1 order by id_menu asc";
                                                $querymenu=$this->db->query($sqlmenu);
                                                $resultmenu=$querymenu->result();
                                                foreach($resultmenu as $rsm):
                                            ?>
                                                    
                                                        <li>
                                                          <a style="display:inline;cursor:pointer" href="<?php echo base_url('index.php/admin/edit_menu').'/'.$rsm->id_parent.'/'.$rsm->lvl_menu.'/'.$rsm->id_menu?>"><?php echo $rsm->menu_name;?></a><span href="javascript:;" data-toggle="collapse" data-target="#demo<?php echo $sm;?>"> <i style="float:right; margin-right:10px ; cursor:pointer" class="fa fa-fw fa-caret-down"></i></span>
                                                          <ul id="demo<?php echo $sm;?>" class="collapse" style="padding-left: 5px;
                                                            border-bottom: grey solid 1px;">
                                                              <?php
                                                                $sqlsubmenu="select * from t_menu where id_parent=".$rsm->id_parent." and lvl_menu !=1 and id_language=1 order by id_menu asc";
                                                                $querysubmenu=$this->db->query($sqlsubmenu);
                                                                $resultsubmenu=$querysubmenu->result();
                                                                foreach($resultsubmenu as $rssm):
                                                              ?>
                                                                  <li style="color: grey;
                                                                    list-style-type: none; padding-bottom:10px;padding-top:10px">
                                                                      <a style="color: #999;cursor:pointer" href="<?php echo base_url('index.php/admin/edit_menu').'/'.$rssm->id_parent.'/'.$rssm->lvl_menu.'/'.$rssm->id_menu?>"><?php echo $rssm->menu_name;?></a>
                                                                  </li>
                                                              <?php
                                                                endforeach;
                                                              ?>
                          
                                                               <li style="color: grey;
                                                                 list-style-type: none; padding-bottom:10px;padding-top:10px" >
                                                                  <a style="color: grey;cursor:pointer" onClick="add_menu('1',<?php $lvl=$rsm->lvl_menu+1; echo $lvl?>,'<?php echo $rsm->id_parent?>')"><i class="fa fa-fw fa-plus-circle"></i>Add SubMenu</a>
                                                               </li>
                                                          </ul>
                                                        </li>
                                            <?php		
                                                    $sm++;
                                                endforeach;
                                            ?>
                
                                             <li style="color: grey;
                                               list-style-type: none;">
                                                 <?php
                                                    $sqlfoot="select count(id_menu) as cnt from t_menu where lvl_menu = 1 and id_menu not in (1) and id_language=1";
                                                    $queryfoot=$this->db->query($sqlfoot);
                                                    $get_foot = $queryfoot->row();
                                                    if($get_foot->cnt <=5){
                                                    
                                                ?>
                                                        <a style="cursor:pointer" onClick="add_menu('1','1','0')"><i class="fa fa-fw fa-plus-circle"></i>Add Menu</a>
                                                <?php
                                                    }
                                                ?>
                                                
                
                                             </li>
                                             <?php
                                             	$sqlk = "select * from t_menu where id_child = 99 order by id_language asc";
												$queryk = $this->db->query($sqlk);
												$rowk1 = $queryk->row(0);
												$rowk2 = $queryk->row(1);
												
											 ?>
                                            <li>
                                                <a href="<?php echo base_url('index.php/admin/edit_menu').'/'.$rowk1->id_parent.'/'.$rowk1->lvl_menu.'/'.$rowk1->id_menu.''?>"><i class="fa fa-fw fa-phone"></i> <?php echo $rowk1->menu_name;?></a>
                                            </li>
                                        </ul>
                                  </li>
                                  <li>
                                      <a style="display:inline;cursor:pointer" ></a>English<span href="javascript:;" data-toggle="collapse" data-target="#demoeng"> <i style="float:right; margin-right:10px ; cursor:pointer" class="fa fa-fw fa-caret-down"></i></span>
                                      <ul id="demoeng" class="collapse" style="padding-left: 60px;
                                        border-bottom: grey solid 1px;">
                
                                            <?php
                                                $sm=10;
                                                $sqlmenu="select * from t_menu where lvl_menu=1 and id_menu not in (1) and id_child != 99 and id_language=2 order by id_menu asc";
                                                $querymenu=$this->db->query($sqlmenu);
                                                $resultmenu=$querymenu->result();
                                                foreach($resultmenu as $rsm):
                                            ?>
                                                    
                                                        <li>
                                                          <a style="display:inline;cursor:pointer" href="<?php echo base_url('index.php/admin/edit_menu').'/'.$rsm->id_parent.'/'.$rsm->lvl_menu.'/'.$rsm->id_menu?>"><?php echo $rsm->menu_name;?></a><span href="javascript:;" data-toggle="collapse" data-target="#demo<?php echo $sm;?>"> <i style="float:right; margin-right:10px ; cursor:pointer" class="fa fa-fw fa-caret-down"></i></span>
                                                          <ul id="demo<?php echo $sm;?>" class="collapse" style="padding-left: 5px;
                                                            border-bottom: grey solid 1px;">
                                                              <?php
                                                                $sqlsubmenu="select * from t_menu where id_parent=".$rsm->id_parent." and lvl_menu !=1 and id_language=2 order by id_menu asc";
                                                                $querysubmenu=$this->db->query($sqlsubmenu);
                                                                $resultsubmenu=$querysubmenu->result();
                                                                foreach($resultsubmenu as $rssm):
                                                              ?>
                                                                  <li style="color: grey;
                                                                    list-style-type: none; padding-bottom:10px;padding-top:10px">
                                                                      <a style="color: #999;cursor:pointer" href="<?php echo base_url('index.php/admin/edit_menu').'/'.$rssm->id_parent.'/'.$rssm->lvl_menu.'/'.$rssm->id_menu?>"><?php echo $rssm->menu_name;?></a>
                                                                  </li>
                                                              <?php
                                                                endforeach;
                                                              ?>
                          
                                                               <li style="color: grey;
                                                                 list-style-type: none; padding-bottom:10px;padding-top:10px" >
                                                                  <a style="color: grey;cursor:pointer" onClick="add_menu('2',<?php $lvl=$rsm->lvl_menu+1; echo $lvl?>,'<?php echo $rsm->id_parent?>')"><i class="fa fa-fw fa-plus-circle"></i>Add SubMenu</a>
                                                               </li>
                                                          </ul>
                                                        </li>
                                            <?php		
                                                    $sm++;
                                                endforeach;
                                            ?>
                
                                             <li style="color: grey;
                                               list-style-type: none;">
                                                 <?php
                                                    $sqlfoot="select count(id_menu) as cnt from t_menu where lvl_menu = 1 and id_menu not in (1) and id_language=2";
                                                    $queryfoot=$this->db->query($sqlfoot);
                                                    $get_foot = $queryfoot->row();
                                                    if($get_foot->cnt <=5){
                                                    
                                                ?>
                                                        <a style="cursor:pointer" onClick="add_menu('2','1','0')"><i class="fa fa-fw fa-plus-circle"></i>Add Menu</a>
                                                <?php
                                                    }
                                                ?>
                                                
                
                                             </li>
                                             
                                            <li>
                                                <a href="<?php echo base_url('index.php/admin/edit_menu').'/'.$rowk2->id_parent.'/'.$rowk2->lvl_menu.'/'.$rowk2->id_menu?>"><i class="fa fa-fw fa-phone"></i> <?php echo $rowk2->menu_name;?></a>
                                            </li>
                                        </ul>
                                  </li>
                             </ul>     
                    </li>
 					<li>
                        <a href="<?php echo base_url('index.php/admin/upload')?>"><i class="fa fa-fw fa-upload"></i>UPLOAD</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">
</html>