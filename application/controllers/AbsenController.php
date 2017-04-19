<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AbsenController extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('AbsenModel');
		$this->load->helper('url');
		$this->load->helper('html');
    	$this->load->helper('form');
    	$this->load->helper('directory');
		$this->load->library('session');
    }

	public function index(){
		$data['query'] = $this->AbsenModel->regionShow();
		$this->load->view('absen/home', $data);
	}

	/*Tambah Cabang*/
	public function addRegion(){
		$data = $_POST['data'];
		$this->AbsenModel->addRegion($data);
		//redirect('AbsenController/index','refresh');
	}

	// Tambah Titik
	public function addPoint(){
		$data = $_POST['data'];
		$regionID = $_POST['regionID'];
		$this->AbsenModel->addPoint($data, $regionID);
	}

	// Menambah Anggota
	public function addPerson(){
		$personNAME = $_POST['personNAME'];
		$personADDRESS = $_POST['personADDRESS'];
		$personREGION = $_POST['personREGION'];
		$personPOINT = $_POST['personPOINT'];
		$pointID = $_POST['pointID'];
		$this->AbsenModel->addPerson($personNAME, $personADDRESS, $personREGION, $personPOINT, $pointID);
	}

	// Lihat anggota
	public function viewPerson(){
		$data = array(
			// 'personID' => $_POST['personID'],
			'pointID' => $_POST['pointID'], 
			'regionID' => $_POST['regionID']);
		$this->load->view('absen/viewPerson', $data);
	}

	//tambah absen
	public function addAbsen(){
		$data = $_POST['data'];
	}
}
