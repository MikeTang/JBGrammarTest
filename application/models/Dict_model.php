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
        $stringIn = str_replace("'","\\'", $stringIn);
        $finalUnits = [];

        $allUnitsArrays = [];

        $parts = preg_split("/[,，]+/", trim($stringIn));

        $partsCount = count(array_filter($parts));

        if ($partsCount > 0) {
            foreach ($parts as $keyword) {
                $spottedUnits = $this->atomSearch($keyword);
                // $this->BH->echor($spottedUnits);
                array_push($allUnitsArrays, $spottedUnits);
            }
        }

        $allUnitsArrays = array_filter($allUnitsArrays);

        $finalUnits = $this->BH->intersectOfArrays($allUnitsArrays);
        
    //$finalUnits = call_user_func_array("array_intersect", $allUnitsArrays);
//        $values = call_user_func_array("array_intersect", $allUnitsArrays);

    // $finalUnits = $this->getIntersect($allUnitsArrays);
//  $finalUnits = call_user_func_array("my_array_intersect", $allUnitsArrays);

        // $this->BH->echor($finalUnits);

        $finalGrammars = $this->BH->grammarsInUnits($finalUnits);
        return $finalGrammars;
    }

    // finally get the result

    // lib




    function atomSearch($stringIn) {
        $units = [];
        $keyword = trim($stringIn);

        if ($this->BH->isCN($keyword)) {
            $units = $this->selectColumnOutFromTableWhereColumnInLikeStringIn(
                'related_units',
                'grammarKeyPoints',
                'Grammar_Point',
                $keyword
                );
        } else {
            $units = $this->selectColumnOutFromTableWhereColumnInLikeStringIn(
                'Units_index',
                'grammarIndex',
                'keywords',
                $keyword
                );
        }

        return $units;
    }


    function selectColumnOutFromTableWhereColumnInLikeStringIn(
        $columnOut,
        $table, 
        $columnIn, 
        $stringIn 
        ) 
    {
        $spottedUnits = [];

// $con = new mysqli("localhost", "root", "root", "yufa");

        // $stringIn = mysql_real_escape_string(trim($stringIn));
        // $stringIn = htmlspecialchars($stringIn);
        // $stringIn = str_replace("'", "\''", $stringIn);

        $sql = "select $columnOut from $table where $columnIn like ".'"%'.$stringIn.'%"';
        // $sql = "select $columnOut from $table where $columnIn like \"%$stringIn%\"";

        // echo $sql."<br/>";
        //$sql = mysql_real_escape_string($sql);

        $results = $this->db->query($sql)->result();
        $results = array_filter($results);

        if (count($results) > 0) {
            $spottedUnits = $this->uniqueUnionResult($results, $columnOut);
        }

        return $spottedUnits;
    }





    function uniqueUnionResult($inResults, $column) {
        $outResults = [];

        foreach ($inResults as $result) {
            $results = preg_split('/[;,，]+/', trim($result->$column));
            $results = array_filter($results);
            $outResults = array_merge($outResults, $results);
        }

        $outResults = array_unique($outResults);
        $outResults = array_filter($outResults);

        return $outResults;
    }

    function getIntersect($arrays){
        $totalArrays = count($arrays);
        if($totalArrays >= 2){
                $arrayTmp =  $arrays[0];
                for ($i = 1; $i < $totalArrays; $i++) {
                    //$arrayTmp = array_intersect($arrayTmp, $arrays[$i]);
                    $arrayTmp = $this->my_array_intersect($arrayTmp, $arrays[$i]);
                }
        $shipArray = array_filter($arrayTmp);
                return $shipArray;
        }else{
            return $arrays[0];
        }
    }


function my_array_intersect($arr1,$arr2)
{
    for($i=0;$i<sizeof($arr1);$i++)
    {
        $temp[]=$arr1[$i];
    }
     
    for($i=0;$i<sizeof($arr1);$i++)
    {
        $temp[]=$arr2[$i];
    }
     
    sort($temp);
    $get=array();
     
    for($i=0;$i<sizeof($temp);$i++)
    {
        if($temp[$i]==$temp[$i+1])
         $get[]=$temp[$i];
    }
     
    $result = array_filter($get);
    //return $result;
    return $get;
}


}?>
