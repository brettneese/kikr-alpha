<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class U extends CI_Controller {

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

		$this->load->library('parser');
		$this->load->library('venuelib');

		$this->load->library('userlib');

	//	$this->load->model('checkin_model');
		$this->load->model('signup_model');

	}
 
	public function index(){
		
		$foursq_userid = $this->session->userdata('foursq_userid');

		if (empty($foursq_userid)){
			redirect('/u/notready');} 
			else {
				redirect('/u/dashboard');
			}
	}
	

	public function view($slug)
	{

		if ($this->session->userdata('logged_in') == FALSE) {
			
			$this->session->set_userdata('redirect', TRUE);
		}


		$this->session->set_flashdata('entrance_checkin_id', $slug);

		$this->load->model('checkin_model');
		$data['checkins'] = $this->checkin_model->get_checkins($slug);	

		$venue_id =  $data['checkins']['0']['venue_id'];	
		$query = $this->db->get_where('venues', array('venue_id' => $venue_id, 'venue_kikr_enabled' => 1));
		$is_kikr_enabled = $query->num_rows();

		$this->parser->parse('head_view', $data);

		if ($is_kikr_enabled == TRUE) {

			$this->parser->parse('checkin_view', $data);


		} else{ 


			$this->parser->parse('user/checkin_view_no_kikr', $data);


	}

		$this->load->view('foot_view', $data);	
	}



	public function dashboard()
	{

		$checkinid = $this->session->flashdata('entrance_checkin_id');
		$this->load->library('parser');
		$this->load->model('checkin_model');

		$user_id = 	$this->session->userdata('foursq_userid');
		$auth_token = $this->session->userdata('auth_token_en');
	

			if ($checkinid != '0') {
				
 			redirect('/checkins/' . $checkinid);
					
			}


		$this->load->library('parser');
		$this->load->model('checkin_model');

		$user_id = 	$this->session->userdata('foursq_userid');
		$auth_token = $this->session->userdata('auth_token_en');

		
		if ($this->session->userdata('logged_in') == TRUE) {

	
				$data['checkins'] = $this->checkin_model->view_by_user($user_id);
				$data['firstName'] = $this->session->userdata('foursq_firstName');
				$data['id'] = $checkinid;


				$this->load->view('head_view');
				$this->parser->parse('user/user_view', $data);
				$this->load->view('foot_view');	
	 
		} 

			else {
				$data['status'] = "user not authed :-(";
			
				$this->load->view('head_view');
				$this->parser->parse('user/not_logged_in_user_view', $data);
				$this->load->view('foot_view');
			}
	}


	public function logout()
	{		
		$this->load->model('signup_model');

		$logout = array(
                   'logged_in' => FALSE
               );

		$this->session->set_userdata($logout);

		$this->signup_model->logout();
	
		
		$this->load->view('head_view');
		$this->load->view('user/logout_view');
		$this->load->view('foot_view');

	}

	public function notready(){

			$this->load->view('head_view');
			$this->load->view('user/no_signup_view');

	}




	public function login()
	{

	//	$this->session->keep_flashdata('entrance_checkin_id');


		require_once("lib/FoursquareAPI.class.php");

			
			// Load the Foursquare API library
			$foursquare = new FoursquareAPI(FOURSQ_CLIENT_KEY, FOURSQ_CLIENT_SECRET);
			
			// If the link has been clicked, and we have a supplied code, use it to request a token
			if(array_key_exists("code",$_GET)){
				$token = $foursquare->GetToken($_GET['code'],FOURSQ_REDIRECT_URI);}
			
			// If we have not received a token, display the link for Foursquare webauth
			if(!isset($token)){ 
			$data['echo']= "<a href='".$foursquare->AuthenticationLink(FOURSQ_REDIRECT_URI)."'> connect to this app via Foursquare </a>";

			$this->load->view('head_view');
			$this->load->view('user/signup_view', $data);


			// Otherwise use the token
			}else{

				$login_array = array('token' => $token);
				$status = $this->signup_model->login($login_array);

			}
		}

	public function settings_dialog(){


		$this->load->view('head_view');
		$this->load->view('user/settings_dialog_view');


	}

	public function settings($slug) 
	{
		//the foursquare folks tell us we just need to ensure deletion of account, but we can add more later!


		$foursq_userid = $this->session->userdata('foursq_userid');

		if ($slug == "delete"){

			$this->load->model('signup_model');
			$this->signup_model->deleteaccount($foursq_userid);

			$this->signup_model->logout();


			$this->load->view('head_view');
			$this->load->view('user/delete_account_view');
			$this->load->view('foot_view');	

		}

		 else {


			$this->load->view('head_view');
			$this->load->view('user/settings_view');
			$this->load->view('foot_view');	
	
		}

	}

}	
	
/* End of file checkinlist.php */
/* Location: ./application/controllers/checkinlist.php */