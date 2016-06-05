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
        $finalUnits = [];

        $allUnitsArrays = [];


        $parts = preg_split("/[,，]+/", trim($stringIn));

        $partsCount = count(array_filter($parts));

        if ($partsCount > 0) {
            foreach ($parts as $keyword) {
                $spottedUnits = $this->atomSearch($keyword);
                // print_r($spottedCnUnits);
                array_push($allUnitsArrays, $spottedUnits);
            }
        }

        $allUnitsArrays = array_filter($allUnitsArrays);

        $finalUnits = $this->intersectAllSubArrays($allUnitsArrays);

        $finalGrammars = $this->getGrammarFromUnits($finalUnits);
        return $finalGrammars;
    }

    // finally get the result
    function getGrammarFromUnits($unitsIn) {
        $safeUnits = array_filter($unitsIn);
        $unitString = join(',', $safeUnits);


        $sql = "select * from grammarDict where No in ($unitString)";
        // echo $sql;

        $results = [];

        if (count($safeUnits) > 0) {
            $results = $this->db->query($sql)->result();
        }

        return $results;
    }


    // lib


    function isCN($stringIn) {
        $isCN = false;
        if (preg_match("/[\x7f-\xff]/", $stringIn)) {
            $isCN = true;
        }
        return $isCN;
    }

    function atomSearch($stringIn) {
        $units = [];
        $keyword = trim($stringIn);

        if ($this->isCN($keyword)) {
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

        $stringIn = trim($stringIn);
        $sql = "select $columnOut from $table
                    where $columnIn like '%$stringIn%'";

        // echo $sql;

        $results = $this->db->query($sql)->result();
        $results = array_filter($results);

        if (count($results) > 0) {
            $spottedUnits = $this->uniqueUnionResult($results, $columnOut);
        }

        return $spottedUnits;
    }


    function intersectAllSubArrays($arraysIn) {
        $outResults = [];
        $nonEmptyArray = array_filter($arraysIn);
        if (count($nonEmptyArray) > 0) {

            $outResults = $nonEmptyArray[0];

            foreach ($nonEmptyArray as $arrayIn) {
                $outResults = array_intersect($outResults, $arrayIn);
            }
        }

        return $outResults;
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





}?>