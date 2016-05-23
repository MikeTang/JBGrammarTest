<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dict_model extends CI_Model
{
    function __construct()
    {
      // Call the Model constructor
      parent::__construct();
    }

    function getStudyUnits($study_units){

        $sql = "";
        for ($i=0; $i < count($study_units); $i++) { 
            if ($i == 0){
               $sql = "SELECT *
                FROM grammarDict
                WHERE Study_Unit = '{$study_units[$i]}' ";
                
            }else{
                $sql = $sql . "OR Study_Unit = '{$study_units[$i]}' ";
            }
        }
        $query = $this->db->query($sql);
        return $query->result();
    }

    function searchStudyUnits($query){
       
        $query = str_replace(" ", "%", $query);

        $sql = "SELECT *
        FROM grammarDict
        WHERE Category like '%{$query}%' ";

        $query = $this->db->query($sql);
        return $query->result();
    }

}?>