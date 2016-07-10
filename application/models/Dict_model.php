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

    function getUnitsByUID($uid){
        $column = 'uID';
        $sql = "SELECT *
                FROM grammarDict
                WHERE $column = '$uid'
                ";
                
        $query = $this->db->query($sql);
        return $query->result();
    }


     function uidOfUnit($unit){
          $sql =   "SELECT uID 
                    FROM grammarDict
                    where Grammar_Units = $unit
                    ";

          $query = $this->db->query($sql);
          $results = $query->result();
          $result = $results[0]->uID;
          echo $result;
          return $results;
     }


    function getGrammarID($id){
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


    function searchUnits($stringIn) {
        $units = $this->unitsOfKeywords($stringIn);
        // $this->BH->echor($units);
        $grammars = $this->grammarsOfUnits($units);
        return $grammars;
    }

    // a,an,冦词
    function unitsOfKeywords($stringIn) {
        $stringIn = htmlentities($stringIn);

        // $stringIn = str_replace("'","\\'", $stringIn);
        // if (!get_magic_quotes_gpc()){
            // $stringIn=addslashes($stringIn);
        // }
        $finalUnits = [];

        $allUnitsArrays = [];

        $stringIn = $this->BH->mb_trim($stringIn);
        $parts = preg_split("/[,，]+/u", $stringIn);

        $parts = $this->BH->mb_trim($parts);

        $parts = array_filter($parts);
        // $this->BH->echor($parts);

        if (count($parts) > 0) {
            foreach ($parts as $keyword) {
                $spottedUnits = $this->atomSearch($keyword);
                array_push($allUnitsArrays, $spottedUnits);
            }
        }

        $allUnitsArrays = array_filter($allUnitsArrays);


        // $outResults = call_user_func_array('array_merge', $arr));

        // $this->BH->echor($allUnitsArrays);
        $finalUnits = $this->BH->intersectOfArrays($allUnitsArrays);

        // $finalUnits = call_user_func_array('array_intersect', $arr_results);


        if ($finalUnits != null) {
            $finalUnits = array_map('trim', $finalUnits);
            $finalUnits = array_unique($finalUnits);
            sort($finalUnits);
        }
        // $this->BH->echor($finalUnits);
        return $finalUnits;
    }

    function grammarsOfUnits($units)
    {
        $finalGrammars = $this->BH->grammarsInUnits($units);
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
