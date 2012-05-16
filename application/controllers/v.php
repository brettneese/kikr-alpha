<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class V extends CI_Controller {

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
		//require_once("./lib/4sq_auth_config.php");
		require_once("./lib/FoursquareAPI.class.php");

		$this->load->library('parser');
		$this->load->library('venuelib');

		$this->load->library('userlib');

		$this->load->model('venue_model');

	}
 
	public function index(){
		
		$foursq_userid = $this->session->userdata('foursq_userid');

		if (empty($foursq_userid)){
			redirect('/v/login');} 
			else {

			redirect('/v/dashboard');
			}
	}
	

	public function dashboard(){

		if ($this->session->userdata('logged_in') == TRUE) {

			$foursq_userid = $this->session->userdata('foursq_userid');
			$data['venues'] = $this->venuelib->get_venues_managed_database($foursq_userid);
			$venue_dash_venue_id = $this->session->userdata('venue_dash_venue_id');

			
				if ($venue_dash_venue_id != FALSE) {

					// Set your client key and secret
					$client_key = FOURSQ_CLIENT_KEY_VENUE;
					$client_secret = FOURSQ_CLIENT_SECRET_VENUE;

					// Load the Foursquare API library
					$foursquare = new FoursquareAPI($client_key,$client_secret);
					$response = $foursquare->GetPublic("venues/$venue_dash_venue_id");
					$response_decoded = json_decode($response);

	

					$venue_name = $response_decoded->response->venue->name;

					$this->load->model('checkin_model');
					
					$data['checkins'] = $this->checkin_model->view_by_venue($venue_dash_venue_id);
					$data['venue_id'] = $venue_dash_venue_id;
					$data['venue_name'] = $venue_name;

					$this->parser->parse('venue/checkin_list_venue_view', $data);

				  } else { 
					$this->load->view('head_view');

						if ($data['venues'] != "404") { 

							$this->parser->parse('venue/venue_list', $data); 
							$this->load->view('foot_view'); } 
						
						else {
								redirect('/u/dashboard');
							}
				  }}
			
			else{

				$this->load->view('head_view');
				$this->load->view('venue/not_logged_in_venue_view');
				$this->load->view('foot_view');


			}


	}


	public function set(){

		$foursq_userid = $this->session->userdata('foursq_userid');

		$venue_id = $this->uri->segment(3, 0);

		if ($venue_id != 0){

			$check = $this->venuelib->check_if_owned($foursq_userid, $venue_id);

			if($check == '1'){

				$this->session->set_userdata('venue_dash_venue_id', $venue_id);
				redirect('/v/dashboard');
			}
		} 




	}
	

	public function settings_dialog(){


		$this->load->view('head_view');
		$this->load->view('venue/settings_dialog_view');

}

	public function login()
	{



		require_once("lib/FoursquareAPI.class.php");

			
			// Load the Foursquare API library
			$foursquare = new FoursquareAPI(FOURSQ_CLIENT_KEY_VENUE, FOURSQ_CLIENT_SECRET_VENUE);
			
			// If the link has been clicked, and we have a supplied code, use it to request a token
			if(array_key_exists("code",$_GET)){
				$token = $foursquare->GetToken($_GET['code'],FOURSQ_REDIRECT_URI_VENUE);}
			
			// If we have not received a token, display the link for Foursquare webauth
			if(!isset($token)){ 
			$data['echo']= "<a href='".$foursquare->AuthenticationLink(FOURSQ_REDIRECT_URI_VENUE)."'> connect to this app via Foursquare </a>";

			$this->load->view('head_view');
			$this->load->view('venue/signup_view', $data);


			// Otherwise use the token
			}else{

				$login_array = array('token' => $token);
				$status = $this->venue_model->login($login_array);

			}
		}

	public function logout()
	{		
		
		$logout = array(
                   'logged_in' => FALSE
               );

		$this->session->set_userdata($logout);
		$this->venue_model->logout();
		
		$this->load->view('head_view');
		$this->load->view('venue/logout_view');
		$this->load->view('foot_view');

	}
 
	


	}


	
/* End of file checkinlist.php */
/* Location: ./application/controllers/checkinlist.php */