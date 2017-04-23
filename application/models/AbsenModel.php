<?php
class AbsenModel extends ci_model{

	function regionShow(){
		$query =  $this->db->get('region');
    	return $query->result_array();
	}

	function addRegion($data){
		echo "<script>alert('Cabang ".$data." telah dibuat');</script>";
		$sql = "INSERT INTO region (regionNAME) VALUES ('".$data."')";
        $this->db->query($sql);
    }

    function deleteRegion($data){
    	$sql = "DELETE FROM region WHERE regionID = ".$data."";
    	$this->db->query($sql);
    }

    function addPoint($data, $regionID){
		$sql = "INSERT INTO point (pointNAME, regionID) VALUES ('".$data."', ".$regionID.")";
        $this->db->query($sql);
    }

    function addPerson($personNAME, $personADDRESS, $personREGION, $personPOINT, $pointID){
    	$rowAbsen = $this->db->count_all_results('absen');
		$rowPerson = $this->db->count_all_results('person');
		$value = $rowAbsen/$rowPerson;
		$sql = "INSERT INTO person (personNAME, personADDRESS, personREGION, personPOINT, pointID) 
				VALUES ('".$personNAME."', '".$personADDRESS."', '".$personREGION."', '".$personPOINT."', ".$pointID.")";
        $this->db->query($sql);

        $s = $this->db->query("SELECT * FROM person ORDER BY personID DESC LIMIT 1");
        foreach($s->result_array() as $row){
        	for($i=1; $i<=$value; $i++){
				$sql2 = "INSERT INTO absen (absenSTATUS, personID) VALUES ('-', ".$row['personID'].")";
				$this->db->query($sql2);
			}
        }
    }

    function viewPerson($pointID, $regionID){
    	$this->db->where('pointID', $pointID);
    	$queries =  $this->db->get('person');
    	return $queries->result_array();
    }
}
