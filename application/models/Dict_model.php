<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Dict_model extends CI_Model
{
    function __construct()
    {
      // Call the Model constructor
      parent::__construct();
      $this->load->model('BH');

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

    function getUnits($units){
        $column = 'Grammar_Units';
        $sql = "";
        for ($i=0; $i < count($units); $i++) { 
            if ($i == 0){
               $sql = "SELECT *
                FROM grammarDict
                WHERE $column = '{$units[$i]}' ";
                
            }else{
                $sql = $sql . "OR $column = '{$units[$i]}' ";
            }
        }
        $query = $this->db->query($sql);
        return $query->result();
    }

    // a,an,冦词
    function searchUnits($stringIn) {
        // $stringIn = str_replace("'","\\'", $stringIn);
        // if (!get_magic_quotes_gpc()){
            // $stringIn=addslashes($stringIn);
        // }
        $finalUnits = [];

        $allUnitsArrays = [];

        $parts = preg_split("/[,，]+/", $stringIn);

        $partsCount = count(array_filter($parts));

        if ($partsCount > 0) {
            foreach ($parts as $keyword) {
                $spottedUnits = $this->atomSearch($keyword);
                array_push($allUnitsArrays, $spottedUnits);
            }
        }

        $allUnitsArrays = array_filter($allUnitsArrays);

        $finalUnits = $this->BH->intersectOfArrays($allUnitsArrays);

        // $finalUnits = call_user_func_array('array_intersect', $arr_results);
        // $this->BH->echor($finalUnits);

        $finalGrammars = $this->BH->grammarsInUnits($finalUnits);
        return $finalGrammars;
    }


    // lib

    function atomSearch($stringIn) {
        $keyword = $stringIn;
        $units = [];

        if ($this->BH->isCN($keyword)) {
            $units = $this->BH->selectColumnOutFromTableWhereColumnInLikeStringIn(
                'related_units',
                'grammarKeyPoints',
                'Grammar_Point',
                $keyword
                );
        } else {
            $units = $this->BH->selectColumnOutFromTableWhereColumnInLikeStringIn(
                'Units_index',
                'grammarIndex',
                'keywords',
                $keyword
                );
        }

        return $units;
    }
}?>
