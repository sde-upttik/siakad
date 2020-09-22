<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    class m_pdf {

        function m_pdf()
        {
            $CI = & get_instance();
            log_message('Debug', 'mPDF class is loaded.');
        }


        function exp_pdf($param=NULL)
        {
            include_once APPPATH.'/third_party/mpdf60/mpdf.php';

            $CI = & get_instance();

            if($CI->session->userdata('kdf')=="E" || $CI->session->userdata('kdf')=="E" ){                
                return new mPDF("", "Legal","","times",10,10,5,5,1,3);//Kiri, Kanan, Atas, Bawah
            }
            else{
                return new mPDF("", "Legal","","times",10,10,5,5,1,3);//Kiri, Kanan, Atas, Bawah
            }
        }
    }
?>
