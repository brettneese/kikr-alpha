<?php
class Venue_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	

	public function login($login_array)
	{

		//set some variables
		$user_id = $this->session->userdata('foursq_user_id');
		$token = $login_array['token'];
	
		//load the encryption, venue and 4sq libraries
		$this->load->library('encrypt');
		$this->load->library('venuelib');
		$this->load->library('userlib');


		require_once("lib/FoursquareAPI.class.php");

		//instatiate the 4sq lib 
		$foursquare = new FoursquareAPI();

		//get list of venues managed			
		$venues_managed_array = $this->venuelib->get_venues_managed($user_id, $token);
		
		//set 4sq access token
		$foursquare->SetAccessToken($token);
			
		//foursquare response
		$response = $foursquare->getPrivate("/users/self", $params=false, $POST=false);
		
		//decode
		$response_decoded = json_decode($response);
		
		$foursq_userid = $response_decoded->response->user->id;
		$user_firstName = $response_decoded->response->user->firstName;
		
		//encrypt the token
		$token_encrypted = $this->encrypt->encode($token);

		$logged_in_session_data = array(
                   'foursq_userid'  => $foursq_userid,
                   'foursq_firstName' => $user_firstName,
                  	'logged_in' => TRUE
               );

		$this->session->set_userdata($logged_in_session_data);


		if ($this->userlib->user_exists($foursq_userid) === FALSE){
			$this->userlib->add_user($response, $token); 
		} 
		
		$this->venuelib->add_venues_to_database($venues_managed_array, $foursq_userid);

		redirect('/v/dashboard');
		
		}



	public function logout() 
	{
		$this->session->sess_destroy();
	}		



	public function deleteaccount($foursq_user_id)
	{
	
		$this->db->where('foursq_userid', $foursq_user_id);
		$this->db->delete('users');
		
		$this->db->where('init_user_id', $foursq_user_id);
		$this->db->delete('todos');
	
		$this->db->where('receiver_user_id', $foursq_user_id);
		$this->db->delete('todos');

		$this->db->where('user_id', $foursq_user_id);
		$this->db->delete('checkins');
	}
}
	


		