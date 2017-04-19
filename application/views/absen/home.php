<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Absen</title>	
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="<?php echo base_url('assets/bootstrap/css/bootstrap.css');?>" rel="stylesheet" >
	<link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet" >
	<script type="text/javascript" src="<?php echo base_url('assets/bootstrap/jquery.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/bootstrap/js/bootstrap.js');?>"/></script>
	<script type="text/javascript" src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js');?>"/></script>
	<style type="text/css">
		.btn-point{
			width: 80%;
		}
		.col-md-2{
			padding: 10px;
		}
		.col-md-4{
			padding: 0px;
			margin: 10px 0px 10px 0px;
		}
		.btn-point:hover{
			background: #90EE90;
		}
		.panel-heading:hover{
			background: #90EE90;
		}
	</style>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#addRegion').click(function(e){
				var m = $('#inputRegion').val();
				//var m = $(this).attr("inputRegion");
				if(confirm('Anda Yakin Membuat Cabang'+' '+m)){
					$.ajax({
						type:'POST',
						url:'http://localhost/absen/index.php/AbsenController/addRegion',
						data:{data : m},
						success: function(html){
							$().html(html);
						}
					});
				}
			});
		});
		
	</script>
</head>
<body style="padding: 20px;white-space: nowrap;width: auto;overflow: scroll;">
	<!-- <div class="container"> -->
		<!-- <h3>Absen</h3> -->

	<div class="row">
	<div class="col-sm-3">
		<!-- Input Cabang -->
		<form class="form-inline">
		  <div class="form-group">
		    <input type="text" class="form-control" id="inputRegion" placeholder="Tambah Cabang">
		  </div>
		  <button type="submit" id="addRegion" class="btn btn-default">Tambah</button>
		</form>
		<br>
	</div>
	<div class="col-sm-9">
		<form class="form-inline"> 
		  <div class="form-group">
		    <input type="text" class="form-control" id="inputCari" placeholder="Cari Nama, Titik, Cabang">
		  	<button type="submit" id="Cari" class="btn btn-default">Cari</button>
		  </div>
		</form>
		<br>
	</div>
	</div>

	<div class="row">
	<div class="col-sm-3">

		<!-- menu collaps -->
		<?php
			$no = 1;
			foreach($query as $row):
			$regionID = $row['regionID'];
		?>
		<div class="panel-group" style="width: 300px" id="accordion" role="tablist" aria-multiselectable="true">
		  <div class="panel panel-default">
		    <div class="panel-heading" role="tab" id="headingOne">
		      <h4 class="panel-title">
		      	<input type="hidden" name="regionID" value="<?php echo $row['regionID']; ?>" />
		        <a role="button" style="text-decoration: none;" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $regionID; ?>" aria-expanded="true" aria-controls="collapseOne">
				<?php echo $regionID.'Cabang'.' '.$row['regionNAME']; ?>
		        </a>
		      </h4>
		    </div>

		    <div id="collapse<?php echo $regionID;?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
		    <!-- <div> -->
		      <div class="panel-body" id="jqueryAccordion<?php echo $regionID;?>">
		      	<form class="form-inline">
		      	<script type="text/javascript">
		      		$(document).ready(function(){
						$('#addPoint<?php echo $regionID; ?>').click(function(e){
							var a = $('#inputRegionID<?php echo $regionID; ?>').val();
							var b = $('#inputPoint<?php echo $regionID; ?>').val();
							if(confirm('Anda Yakin Membuat Titik'+' '+b+a)){
								$.ajax({
									type:'POST',
									url:'http://localhost/absen/index.php/AbsenController/addPoint',
									data:{data: b, regionID: a},
									success: function(data){
										refreshedPage = $(data);
				                        newDemo = refreshedPage.find("#jqueryAccordion<?php echo $regionID;?>").html();
				                        $('#jqueryAccordion<?php echo $regionID;?>').html(newDemo)
									}
								});
							}
						});
					});
		      	</script>
				  <div class="form-group">
				    <input style="width: 170px" type="text" class="form-control" id="inputPoint<?php echo $regionID; ?>" placeholder="Tambah Titik">
				    <input style="width: 170px" type="hidden" class="form-control" id="inputRegionID<?php echo $regionID; ?>" value="<?php echo $regionID; ?>">
				  </div>
				  <button type="submit" id="addPoint<?php echo $regionID; ?>" class="btn btn-default"><?php echo $no; ?>Tambah</button>
				</form>
		      	<?php
		      		$query = $this->db->query('SELECT * FROM point WHERE regionID = '.$regionID.'');
		      	?>
		      	<div class="row">
		      	<?php
		      		foreach($query->result_array() as $rows):
		      		$pointID = $rows['pointID'];
		      	?>						

		      		<!-- Kode JavaScrip menampilkan person -->
		      		<script type="text/javascript">
				  		$(document).ready(function(){
							$('#viewPerson<?php echo $pointID; ?>').click(function(e){
								var a = $('#inputRegionID<?php echo $regionID; ?>').val();
								var b = $('#inputPointID<?php echo $pointID; ?>').val();
								//if(confirm('Anda Yakin Membuka Titik : '+b+' dan Region : '+ a)){
									$.ajax({
										type:'POST',
										url:'http://localhost/absen/index.php/AbsenController/viewPerson',
										data:{pointID: b, regionID: a},
										success: function(html){
											$('#viewAbsen').html(html);
											$('#addAnggota').fadeIn("slow");
											$('#inputNamaAnggota').fadeIn("slow");		
											$('#inputAlamatAnggota').fadeIn("slow");
											$('#addSaveAnggota').fadeIn("slow");
										}
									});
								//}
							});
						});
				  	</script>

		      		<div class="col-md-4">
		      		<center>
		      			<!-- Input data dari region ke person -->
		      			<input style="width: 170px" type="hidden" class="form-control" id="inputRegionID<?php echo $regionID; ?>" value="<?php echo $regionID; ?>">
		      			<!-- Input data dari point ke person -->
		      			<input style="width: 170px" type="hidden" class="form-control" id="inputPointID<?php echo $pointID; ?>" value="<?php echo $pointID; ?>">
		      			<!-- Passing to jQuery viewPerson -->
		      			<button type="submit" id="viewPerson<?php echo $pointID; ?>" class="btn btn-point btn-default"><?php echo $pointID.' '.$rows['pointNAME']; ?></button>
		      		</center>
		      		</div>
		      	<?php
		      		endforeach;
		      	?>
		      	</div>
		    </div>
		    <!-- </div> -->
		   </div>
		  </div>
		</div>	
		<?php
			$no++;
			endforeach; 
		?>	
	<!-- </div> container -->
	</div>
	
	<div class="col-md-9" >
		<div id="viewAbsen">
		</div>
	</div>
	</div>
</body>
</html>
