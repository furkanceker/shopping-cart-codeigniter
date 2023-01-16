<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		$viewData['product'] = $this->common_model->getAll('urunler');
		$this->load->view('home_view',$viewData);
	}
}
