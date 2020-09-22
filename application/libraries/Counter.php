<?php

class Counter{

    var $CI;

    public function __construct()
    {
            $this->CI =& get_instance();
            $this->CI->load->model('M_auth');
    } 

    function countMhsonClass($idjadwal="",$semester="")
    {
        $where['IDJadwal'] = $idjadwal;
        return $this->CI->db->get_where('_v2_krs'.$semester, $where)->num_rows();
    }

    function checkCapacityClass($idjadwal="",$semester="")
    {
        
        $where['IDJADWAL']  = $idjadwal;
        $total_college      = $this->countMhsonClass($idjadwal,$semester);
        $capasity           = $this->CI->db->select('kap')->get_where('_v2_jadwal', $where)->result_array();

        if($capasity <= $total_college ){ 
            return "full";
        }

        return false;
    }



}
?>