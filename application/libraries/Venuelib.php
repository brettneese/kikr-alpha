<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Venuelib {


    public function get_venues_managed($user_id,$auth_token)
        {

        require_once("./lib/FoursquareAPI.class.php");


        $CI =& get_instance();
        $CI->load->library('userlib');

        // Load the Foursquare API library
            $foursquare = new FoursquareAPI(FOURSQ_CLIENT_KEY,FOURSQ_CLIENT_KEY);
            $foursquare->SetAccessToken($auth_token);
             
        //get the list of venues the acting user manages
            
            $response = $foursquare->getPrivate("/venues/managed", $params=false, $POST=false);
            $response_decoded = json_decode($response, $assoc = TRUE);
            $api_status = $response_decoded['meta']['code'];


            if ($api_status == '200') {

                     return $response_decoded;

            } else{         
                return $api_status;                     
            }
    }   

    public function get_venues_managed_database($foursq_userid) {

             $CI =& get_instance();

             $query = $CI->db->get_where('venues', array('venue_owner' => $foursq_userid));

             if ($query->num_rows() > 0){
                return $query->result_array();
             }  else{
                return "404";
             }


    }

    public function check_if_owned($foursq_userid, $venue_id){
                     $CI =& get_instance();


         $query = $CI->db->get_where('venues', array('venue_owner' => $foursq_userid, 'venue_id' => $venue_id));

         if($query->num_rows > 0){
            return TRUE;
         } else{ 

            return FALSE;
        }



    }


    public function add_venues_to_database($venues_managed_array, $foursq_userid){
        $CI =& get_instance();

            // add the venues to the database

                foreach ($venues_managed_array['response']['venues'] as $venue) {

                    $query = $CI->db->get_where('venues', array('venue_id' => $venue['id']));

                    if ($query->num_rows() < 1){
                        
                        $data = array(
                            'venue_id' => $venue['id'], 
                            'venue_name' => $venue['name'],
                            'venue_owner' => $foursq_userid,
                        );


                        if (isset($venue['location']['address'])){  
                            $data['venue_location_address'] = $venue['location']['address'];
                        }
                        
                        if (isset($venue['location']['lat'])) {
                            $data['venue_location_lat'] = $venue['location']['lat'];
                        }

                        if (isset($venue['location']['lng'])) {
                            $data['venue_location_lng'] = $venue['location']['lng'];
                        }

                        if (isset($venue['location']['city'])) {
                            $data['venue_location_city'] = $venue['location']['city'];
                        }

                        if (isset($venue['location']['state'])) {
                                $data['venue_location_state'] = $venue['location']['state'];
                        }

                         if (isset($venue['location']['postalCode'])) {
                            $data['venue_location_postalCode'] = $venue['location']['postalCode'];
                        }

                        if (isset($venue['contact']['twitter'])) {
                            $data['venue_contact_twitter'] = $venue['contact']['twitter'];
                        }


                        if (isset($venue['contact']['phone'])) {
                            $data['venue_contact_phone'] = $venue['contact']['phone'];
                        }

                     $CI->db->insert('venues', $data); 
                 }
            }                

        return "200";

    }

}

/* End of file Userlib.php */