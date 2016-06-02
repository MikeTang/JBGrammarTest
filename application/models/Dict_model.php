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

    function searchStudyUnits($stringIn) {
        // $query = str_replace(" ", "%", $query);
        $parts = preg_split("/[\s,]+/", $stringIn);

        $glue = "%' and Category like '%";
        $matchAllKeywords = join($glue, $parts);

        $sql = "SELECT *
            FROM grammarDict
            WHERE Category like '%$matchAllKeywords%'
            ";
        // echo $sql;

        $results = $this->db->query($sql)->result();
        return $results;
    }

}?>