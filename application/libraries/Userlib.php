<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Userlib {

    public function get_token($user_id)
    {

    	$CI =& get_instance();
    	$CI->load->library('encrypt');

        $query = $CI->db->get_where('users', array('foursq_userid' => $user_id));


        if ($query->num_rows() > 0)
        {
            $row = $query->row(); 

            $token_encrypted = $row->token;

            return $CI->encrypt->decode($token_encrypted);

        }

        return "405";

    }

    public function user_exists($foursq_userid){
            $CI =& get_instance();

            $query = $CI->db->get_where('users', array('foursq_userid' => $foursq_userid));

            if ($query->num_rows > 0){
                return TRUE;
            } else {

                return FALSE;
            }

    }


    public function add_user($response, $token){

        $CI =& get_instance();
        $CI->load->library('encrypt');

        
        //decode the response
        $response_decoded = json_decode($response);

        //encrypt the token
        $token_encrypted = $CI->encrypt->encode($token);

            $foursq_userid = $response_decoded->response->user->id;
            $user_firstName = $response_decoded->response->user->firstName;

            $data = array('user_firstName' => $user_firstName,
                           'foursq_userid' => $foursq_userid,
                           'token' => $token_encrypted);

            if (isset($response_decoded->user->lastName)){
                $data['user_lastName'] = $response_decoded->user->lastName;
            }

            if (isset($response_decoded->user->gender)){
                $data['user_gender'] = $response_decoded->user->gender;
            }

            if (isset($response_decoded->user->photo)){
                $data['user_photo'] = $response_decoded->user->photo;
            }

            if (isset($response_decoded->user->contact->email)){
                $data['user_contact_email'] = $response_decoded->user->photo;
            }

            if (isset($response_decoded->user->contact->twitter)){
                $data['user_contact_twitter'] = $response_decoded->user->twitter;
            }


            if (isset($response_decoded->user->contact->facebook)){
                $data['user_contact_twitter'] = $response_decoded->user->facebook;
            }

            if (isset($response_decoded->user->contact->phone)){
                $data['user_contact_twitter'] = $response_decoded->user->phone;
            }
                
             $CI->db->insert('users', $data); 

            return "200";
    }
}

/* End of file Userlib.php */