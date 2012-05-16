<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Docs extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URl: https://s140524.gridserver.com/index.php/checkins
	 * @todo: error checkin on visit from browser
	 * @todo: make ALL json results database entries
	 */

	public function __construct()
	{
		parent::__construct();
		require_once("./lib/4sq_auth_config.php");
		require_once("./lib/FoursquareAPI.class.php");
		
	}

	public function index(){
		
		
	}

	public function privacy(){
		
		$this->load->view('head_view');
		$this->load->view('privacy_view');
		$this->load->view('foot_view');


	}

}	
	
/* End of file checkinlist.php */
/* Location: ./application/controllers/checkinlist.php */