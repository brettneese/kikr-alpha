<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Receivecheckins extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URl: https://s140524.gridserver.com/index.php/receivecheckins
	 * @todo: error checkin on visit from browser
	 * @todo: make ALL json results database entries
	 */

	public function index()
	{

		$json = $this->input->post('checkin');
		$push_secret = $this->input->post('secret');
				
		
		
	if ($push_secret = FOURSQ_PUSH_SECRET)
		{




			$json = $this->input->post('checkin');
			$json_decoded = json_decode($json);


			$venue_id = $json_decoded->venue->id;
			$user_id = $json_decoded->user->id;



									
				$query_init_data = array(
							'init_user_id' => $user_id,
							'venue_id'=> $venue_id,
							'locked'=> '0'
							);
						

				$query_init_score = $this->db->get_where('todos', $query_init_data);
				$query_init_score_num_rows = $query_init_score->num_rows() + 1;
							

				$query_received_data = array(
							'receiver_user_id' => $user_id,
							'venue_id'=> $venue_id,
							'locked'=> '0'
							);
						

				$query_received_score = $this->db->get_where('todos', $query_received_data);
				$query_received_score_num_rows = $query_received_score->num_rows()+1;
							
				$current_kikr_score = $query_received_score_num_rows + $query_init_score_num_rows;		

				$data = array(
		   			'foursq_id' => $json_decoded->id,
		   			'createdAt' => $json_decoded->createdAt,
		   			'user_id' => $json_decoded->user->id,
		   			'user_firstName' => $json_decoded->user->firstName,
		   			'user_lastName' => $json_decoded->user->lastName,
		   			'user_gender' => $json_decoded->user->gender,
		   			'user_homeCity' => $json_decoded->user->homeCity,
		   			'venue_id' => $json_decoded->venue->id,		
		   			'venue_name' => $json_decoded->venue->name,
		   			'venue_location_address' => $json_decoded->venue->location->address,
		   			'venue_lat' => $json_decoded->venue->location->lat,
		   			'venue_lng' => $json_decoded->venue->location->lng,
		   			'venue_city' => $json_decoded->venue->location->city,
		   			'venue_state' => $json_decoded->venue->location->state,
		   			'venue_postalCode' => $json_decoded->venue->location->postalCode,
		   			'current_init_score' => $query_init_score_num_rows,
		   			'current_received_score' => $query_received_score_num_rows,
		   			'current_kikr_score' => $current_kikr_score,
		   	//		'user_push' => 1,
				);
				
							
			
				//send a push

				require('./lib/Pusher.php');
				$pusher = new Pusher('', '', '');
				$pusher->trigger($venue_id, 'checkin', $data);


				$this->db->insert('checkins', $data); 	

				//remove lock
				$data_lock = array('locked' => '0' );
				$this->db->update('todos', $data_lock, array('receiver_user_id' => $user_id, 'venue_id' => $venue_id, 'locked' => "1"));
						
		
		
		}
					
	}

}






/* End of file checkins.php */
/* Location: ./application/controllers/checkins.php */