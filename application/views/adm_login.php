<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no"/>
    <link rel="stylesheet" href="<?php echo base_url()?>plugins/node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>plugins/index.css">

</head>
<script src="<?php echo base_url()?>plugins/js/jquery.js"></script>

<script src="<?php echo base_url()?>plugins/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>


<body>

<div class="container">
  <br><br>
  <center>
  <div class="panel panel-default" style="width:50%">
    <div class="panel-heading">Login</div>
    <div class="panel-body">
    <?php echo form_open('verifylogin'); ?>
      <div class="form-group">
      
        <input type="text" class="form-control" id="Username" name="Username" placeholder="Username">
      </div>
      <div class="form-group">

        <input type="password" class="form-control" id="Password" name="Password" placeholder="Password">
      </div>
    </div>
    <a><button type="submit" class="btn btn-primary" style="width:90%;">Login</button></a>
    <br><br>
  </div>
  </form>
</center>

</div>

</body>

</html>
