<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Checkins extends CI_Controller {

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
		require_once("./lib/FoursquareAPI.class.php");
	}
 
	public function index(){
		
		$foursq_userid = $this->session->userdata('foursq_user_id');

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



	public function addtodo()
	{

		$this->load->library('encrypt');
				$this->load->library('userlib');

		$user_id = $this->session->userdata('foursq_user_id');

		$auth_token = $this->userlib->get_token($user_id);


			$this->load->model('checkin_model');


			$checkin_id = $this->session->flashdata('entrance_checkin_id');

			$data['response'] = $this->checkin_model->addtodo($checkin_id);		
			$this->load->view('head_view');
			$this->load->view('user/addtodo', $data);
			$this->load->view('foot_view'); 
	
	}
	
	}

	
/* End of file checkinlist.php */
/* Location: ./application/controllers/checkinlist.php */