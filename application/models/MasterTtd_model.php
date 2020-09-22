<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MasterTtd_model extends CI_Model{
    
    private function _cleanFields($data, $table)
    {
        $filedClean =[];
        $arrayKeys  = array_keys($data);
        
        foreach ($arrayKeys as $key) {
            if ($this->db->field_exists($key, $table))
            {
                $filedClean[$key] = htmlspecialchars($data[$key]);
            }    
        }
        return $filedClean;
    }

    public function getDataJurusuan($kode = null)
    {

        $fields = [
            'Kode',        
            'Nama_Indonesia',        
            'Ket_Jenjang',       
            'TTJabatan1',       
            'TTJabatan2',       
            'TTJabatan3',           
            'TTPejabat1',           
            'TTPejabat2',           
            'TTPejabat3',           
            'TTnippejabat1',           
            'TTnippejabat2',           
            'TTnippejabat3',           
            'TTJabatanKUjian',           
            'TTPejabatKUjian',           
            'TTnippejabatKUjian',
            'TTJabatanTn1',       
            'TTJabatanTn2',       
            'TTJabatanTn3',
            'TTPejabatTn1',           
            'TTPejabatTn2',           
            'TTPejabatTn3',
            'TTnippejabatTn1',           
            'TTnippejabatTn2',           
            'TTnippejabatTn3',
            'TTnippejabat3',           
            'TTJabatanKHS',           
            'TTPejabatKHS',           
            'TTnippejabatKHS',                  
            'TTJabatanKHS2',           
            'TTPejabatKHS2',           
            'TTnippejabatKHS2'                  
        ];

        $this->db->select($fields);
        
        if($kode == null){
            $where  = [
                'KodeFakultas' => $this->session->userdata("kdf"),
            ];
            $result = $this->db->get_where('_v2_jurusan',$where)->result_array();
            return $result;
        }else{
            $where  = [
                        'Kode' => $kode, 
                        'KodeFakultas' => $this->session->userdata("kdf"),
                    ];
            $result = $this->db->get_where('_v2_jurusan',$where)->result_array();
            return $result;
        }

    }

    public function updateTtd($data)
    {
        $table = '_v2_jurusan';

        $where['Kode'] = $data['Kode']; 
        
        unset($data['Kode']);
        
        $cleanData = $this->_cleanFields($data, $table);

        $result = $this->db->update($table, $cleanData, $where );
        
        return $result;
    }

}