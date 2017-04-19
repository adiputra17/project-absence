<script type="text/javascript">
	$(document).ready(function(){
		$('#inputNamaAnggota').fadeIn("slow");		
		$('#inputAlamatAnggota').fadeIn("slow");
		$('#addSaveAnggota').fadeIn("slow");
	});
	// $('#addAbsenAnggota').click(function(){
	// 	$('#addAbsenStatus').show();
	// 	$('#addAbsenCancel').show();
	// });
	$(document).ready(function(){
		//tambah anggota
		$('#addSaveAnggota').click(function(event){
			event.preventDefault();
			var a = $('#inputNamaAnggota').val();
			var b = $('#inputAlamatAnggota').val();
			var c = $('#inputCabangAnggota').val();
			var d = $('#inputTitikAnggota').val();
			var e = $('#inputTitikIdAnggota').val();
			//if(confirm('Anda Yakin Membuka Titik : '+b+' dan Region : '+ a)){
				$.ajax({
					type:'POST',
					url:'http://localhost/absen/index.php/AbsenController/addPerson',
					data:{personNAME : a, personADDRESS : b, personREGION : c, personPOINT : d, pointID: e},
					success: function(){
						$('#inputNamaAnggota').val("");
						$('#inputAlamatAnggota').val("");
						$('#refreshData').load();
					}
				});
			//}
		});
	});
</script>

<div class="form-inline"> 
<div class="form-group">
	<ol class="breadcrumb">
		<?php 
  			$query = $this->db->query('SELECT * FROM region WHERE regionID = '.$regionID.'');
  			foreach($query->result_array() as $r):
  		?>
  		<li>Cabang <?php echo $r['regionNAME']; ?></li>
  		<?php endforeach; ?>
  		<?php 
  			$query = $this->db->query('SELECT * FROM point WHERE pointID = '.$pointID.'');
  			foreach($query->result_array() as $r):
  		?>
  		<li><?php echo $r['pointNAME']; ?></li>
  		<?php endforeach; ?>
  		&nbsp&nbsp&nbsp
  		<div class="input-group">
  		<!-- <button type="submit" id="addAnggota" style="display: none;" class="btn btn-default">Tambah Anggota</button> -->
  		<div class="input-group-addon">Tambah Anggota</div>
  		<input type="text" class="form-control" id="inputNamaAnggota" style="/*display: none;*/ width: 200px;" placeholder="Masukkan Nama">
  		<input type="text" class="form-control" id="inputAlamatAnggota" style="/*display: none;*/ width: 200px;" placeholder="Masukkan Alamat">

  		<!-- Input cabang anggota -->
  		<?php 
  			$query = $this->db->query('SELECT * FROM region WHERE regionID = '.$regionID.'');
  			foreach($query->result_array() as $r):
  		?>
  		<input type="hidden" class="form-control" id="inputCabangAnggota" style="/*display: none;*/ width: 200px;" placeholder="Masukkan Alamat" value="<?php echo $r['regionNAME']; ?>">
  		<?php endforeach; ?>

  		<!-- Input titik anggota --> 
  		<?php 
  			$query = $this->db->query('SELECT * FROM point WHERE pointID = '.$pointID.'');
  			foreach($query->result_array() as $r):
  		?>
  		<input type="hidden" class="form-control" id="inputTitikAnggota" style="/*display: none;*/ width: 200px;" placeholder="Masukkan Alamat" value="<?php echo $r['pointNAME']; ?>">
  		<input type="hidden" class="form-control" id="inputTitikIdAnggota" style="/*display: none;*/ width: 200px;" placeholder="Masukkan Alamat" value="<?php echo $r['pointID']; ?>">
  		<?php endforeach; ?>

  		<button type="submit" id="addSaveAnggota" style="display: none;" class="btn btn-default">Save</button>
  		</div>
	</ol>
</div>
</div>

<table class="table-striped">
	<tr>
		<th style="padding: 5px;">No</th>
	    <th style="padding: 5px;">Nama</th>
		<th style="padding: 5px;">Alamat</th>
		<th style="padding: 5px;">Cabang</th>
		<th style="padding: 5px;">Titik</th>
		<th style="padding: 5px;">Aktif</th>
		<?php $rowAbsen = $this->db->count_all_results('absen'); ?>
		<?php $rowPerson = $this->db->count_all_results('person'); ?>
		<?php $s = $this->db->query("SELECT * FROM person ORDER BY personID DESC LIMIT 1");
        foreach($s->result_array() as $row): ?>
		<th style="padding: 5px;" colspan="<?php echo $rowAbsen/$rowPerson; ?>">Absen 
		<button id="" class="btn btn-info btn-xs" title="Tambah data absen">
			Tambah data absen <?php echo $rowAbsen."+".$rowPerson."+".$row['personID'] ;?>
		</button>
		</th>
		<?php endforeach; ?>
	</tr>

	<div id="refreshData">
	<?php
		$query = $this->db->query('SELECT * FROM person WHERE pointID = '.$pointID.'');
		$no = 1;
		foreach($query->result_array() as $r):
	?>
	<tr>
		<td width="20px" style="border:0px solid #000; padding: 5px;"><?php echo $no; ?></td>
		<td width="150px" style="border:0px solid #000; padding: 5px;"><?php echo $r['personNAME']; ?></td>
		<td width="150px" style="border:0px solid #000; padding: 5px;"><?php echo $r['personADDRESS']; ?></td>
		<td width="100px" style="border:0px solid #000; padding: 5px;"><?php echo $r['personREGION']; ?></td>
		<td width="60px" style="border:0px solid #000; padding: 5px;"><?php echo $r['personPOINT']; ?></td>

		<!-- Keaktifan -->
		<?php
			$this->db->where('personID', $r['personID']);
			$bind = array('H', '-');
			$this->db->where_in('absenSTATUS', $bind);
			$active = $this->db->get('absen');
			$all = $this->db->count_all_results('absen');
			$col = $this->db->count_all_results('person');
			$fullactive = $all/$col;
		?>
		<td width="60px" style="border:0px solid #000; padding: 5px;">
			<?php echo round($active->num_rows()/$fullactive*100); ?>%
		</td>
		<?php
			$query = $this->db->query('SELECT * FROM absen WHERE personID = '.$r['personID'].'');
			foreach($query->result_array() as $r):
		?>
		<td width="20px" style="border:0px solid #000; padding: 5px;">
		<?php
			if($r['absenSTATUS'] == 'H'){
				echo '<span class="badge" style="background:#3DD94A">'.$r['absenSTATUS'].'</span>';
			}else if($r['absenSTATUS'] == 'I'){
				echo '<span class="badge" style="background:#FFD500">'.$r['absenSTATUS'].'</span>';
			}else if($r['absenSTATUS'] == 'S'){
				echo '<span class="badge" style="background:#F262D3">'.$r['absenSTATUS'].'</span>';
			}else if($r['absenSTATUS'] == 'A'){
				echo '<span class="badge" style="background:#777">'.$r['absenSTATUS'].'</span>';
			}else if($r['absenSTATUS'] == '-'){
				echo '<span class="" style="font-color:#000">'.$r['absenSTATUS'].'</span>';
			}
		?> <!-- #41C4FF alt 'A' -->
		</td>
		<?php
			endforeach;
		?>
	</tr>
	<?php
		$no++;
		endforeach;
	?>
	</div>
</table>
