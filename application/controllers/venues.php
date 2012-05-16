<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Venues extends CI_Controller {

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
		//$client_key = "0SXF2UHSX22RZ3ROFHP0JL4HS141LURXNUN4A0EUBHP2C4SV";
		//$client_secret = "1UMHSLBHX5YJOX5VWNPCLBUPRF4G4FLTYETXXB4PBFU2P3DG";
	}

	public function index(){
	
	echo "hello, world!";
	
	}
	



	public function dashboard($venue_id)
	{

		
		$this->load->library('parser');

		// Set your client key and secret
		$client_key = FOURSQ_CLIENT_KEY;
		$client_secret = FOURSQ_CLIENT_SECRET;
		// Load the Foursquare API library
		$foursquare = new FoursquareAPI($client_key,$client_secret);
		$response = $foursquare->GetPublic("venues/$venue_id");
		$response_decoded = json_decode($response);
		$venue_name = $response_decoded->response->venue->name;


		echo FOURSQ_CLIENT_SECRET;
		//$this->load->view('checkin_list_venue_view', $data);
	}


}	
	
/* End of file checkinlist.php */
/* Location: ./application/controllers/checkinlist.php */