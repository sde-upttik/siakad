<?php

class Authenticate{

    var $CI;

    public function __construct()
    {
            $this->CI =& get_instance();
            $this->CI->load->model('M_auth');
    }

    public function isSessionExists(){
        if($this->CI->session->has_userdata('uname')){
            return $this->CI->session->userdata('uname');
        }else{
            return false;
        }
    }

    /**
    * function 		    checkPrivilage()
    * @author 		    Mohamad Fadli
    * @return bool      Status privilage user
    * @var    int       $ulevel             (user level)
    * @var    array     $moduleLevel        (module level)
    * @var    string    $umenu              (get from session for status current menu )
    * @var    int       $checkPrivilage     (Check match level user and level module )
    * Checking privilage right user to access some menu on system     
    **/
    public function checkPrivilage()
    {
        $ulevel         = $this->CI->session->userdata('ulevel');
        $umenu          = $this->CI->session->userdata('tamplate');
        $moduleLevel    = $this->CI->M_auth->getLevelModul($umenu)->result_array();
        $checkPrivilage = substr(stristr($moduleLevel[0]['Level'], $ulevel), 0,1); 

        if($checkPrivilage){
            return True;
        }
        return False;
    }


    /**
    * function 		    checkSession()
    * @author 			Mohamad Fadli
    *
    * Redirect if session user not found
    **/
    public function checkSession()
    {
        if(!$this->isSessionExists() || !$this->checkPrivilage() ){
             redirect(base_url(), 'refresh');
        }
    }
}

?>
