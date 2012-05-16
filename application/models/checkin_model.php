
<?php
class Checkin_model extends CI_Model {
//hello
	public function __construct()
	{
		$this->load->database();
		require_once("./lib/4sq_auth_config.php");
		require_once("./lib/FoursquareAPI.class.php");

	}
	
	public function get_checkins($slug = FALSE)
	{
		

		if ($slug === FALSE)
			{

			$this->db->order_by("id", "desc"); 
			$this->db->limit(15);
			$query = $this->db->get('checkins');
			return $query->result_array();

			}


		$query = $this->db->get_where('checkins', array('id' => $slug));
			
		
		return $query->result_array();
	}	


	public function addtodo($checkin_id)
		{


		$this->load->library('userlib');
	

		$user_id = $this->session->userdata('foursq_user_id');

		$auth_token = $this->userlib->get_token($user_id);

		$query_checkin = $this->db->get_where('checkins', array('id' => $checkin_id));

		$checkin = $query_checkin->row();
		
		$receiver_user_id = $this->session->userdata('foursq_user_id');

		$init_user_id = $checkin->user_id;
		$venue_id = $checkin->venue_id;
		$venue_name = $checkin->venue_name;



		//check if todo is locked

		$query_data = array(
					//'init_user_id' => $init_user_id,
					'venue_id'=> $venue_id,
					"receiver_user_id"=> $receiver_user_id,
					"locked"=> '1'
					);
				

		$query = $this->db->get_where('todos', $query_data);
		$query_num_rows = $query->num_rows();



		if ($receiver_user_id == $init_user_id) {
			
			$response = "<h1> Sharing is caring! </h1> <h2> Checkins are meant for sharing with other people. Don't think you can try to be selfish. ;) </h2>";
			
			return $response; 
			
		}
		
		if ($query_num_rows < 1) {

			// Load the Foursquare API library
			$foursquare = new FoursquareAPI(FOURSQ_CLIENT_KEY,FOURSQ_CLIENT_KEY);
			$foursquare->SetAccessToken($auth_token);
			 
			$POST = true;
			$params = array("oauth_token"=>$auth_token, "venueId" => $venue_id);

			//add the checkin via foursquare's api
			
			$response_foursquare = $foursquare->GetPrivate("lists/self/todos/additem",$params);
			$response_decoded = json_decode($response_foursquare);

			//check if add was ok

		 	$api_status = $response_decoded->meta->code;


		 	if ($api_status == '200') {

		 		$venue_name = $response_decoded->response->item->venue->name;

				//add checkin todo to db

				$data = array(
					"init_user_id" => $init_user_id,
					"receiver_user_id"=> $receiver_user_id,
					"venue_id" => $venue_id,
					"locked" => '1',
					"venue_name" => $venue_name
					);
				
				$this->db->insert('todos', $data);
				
				$response = "<h1> Todo successfully added on Foursquare. :) </h1> <h2> I'm sure the fine folks at $venue_name can't wait too see you! </h2>";


				return $response;
			}
			else{ 		
	
	
				return "Failure. Sadface.";						
			}
				
		}
		
		else{

			$response = "<h1> The bad-ish news: it looks like you've already made plans to visit. The good news? Next time you check-in, you'll get a nice little reward :-) </h1>";
			return $response;
		}
	}	




	public function view_by_venue($venue_id)
	{
		$this->db->order_by("id", "desc");
		$query = $this->db->get_where('checkins', array('venue_id' => $venue_id));
		return $query->result_array();
	}

	public function view_by_user($user_id)
	{

		$receiver_user_id = $this->session->userdata('foursq_user_id');

		$this->db->order_by("id", "desc");
		$query = $this->db->get_where('checkins', array('user_id' => $user_id), '10');
		return $query->result_array();
	}


}