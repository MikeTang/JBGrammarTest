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


    function isCN($stringIn) {
        $str=$stringIn;
        if(!eregi("[^\x80-\xff]","$str")) {
            echo "是";
        }
        else
        {
            echo "不是";
        }
    }

    function searchUnits($stringIn) {
        // $query = str_replace(" ", "%", $query);
        $parts = preg_split("/ /", $stringIn);
        echo $stringIn;
        print_r($parts);

        $enParts = [];
        $cnParts = [];

        foreach ($parts as $v) {
            // if( isCN($v) ) {
            // if(!preg_match("[^\x80-\xff]","$v")) {
            if (preg_match("/[\x7f-\xff]/", $v)) {
                array_push($cnParts, $v);
            } else {
                array_push($enParts, $v);
            }
        }

        // print_r($enParts);
        // print_r($cnParts);



        $enGlue = "%' and i.Keywords like '%";
        $enMatchAllKeywords = join($enGlue, $enParts);

        $cnGlue = "%' and Name like '%";
        $cnMatchAllKeywords = join($cnGlue, $cnParts);


        // dynamic filter

        // $enSnippet = '';
        // $enHaving = '';
        // $cnSnippet = '';
        // $cnHaving = '';

        // $havingParts = [];
        // $havingSnippet = '';


        // if ( count($enParts) > 0 ) {
        //     $enSnippet = "Inner Join grammarIndex i
        //                 On i.Keywords like '%$enMatchAllKeywords%'";

        //     $enHaving = "LOCATE(d.no, i.Units_index) > 0";
        //     array_push($havingParts, $enHaving);
        // }

        // if ( count($cnParts) > 0 ) {
        //     $cnSnippet = "Inner Join grammarKeyPoints gkp
        //                 on gkp.Grammar_Point_ like '%$cnMatchAllKeywords%'";

        //     $cnHaving = "LOCATE(d.no, gkp.related_units) > 0";
        //     array_push($havingParts, $cnHaving);
        // }

        // if ( count($cnParts) + count($enParts) > 0 ) {
        //     $havingSnippet = "having ".join($havingParts, ' and ');
        // }

        // $sql = "SELECT *
        //         FROM grammarDict d 
        //             $enSnippet
        //             $cnSnippet

        //         group by d.no

        //         $havingSnippet

        //         ";


        // echo $sql;

        // echo count(array_filter($enParts));
        // echo count(array_filter($cnParts));

        $spotEnUnits = [];
        $spotCnUnits = [];

        if ( count(array_filter($enParts)) > 0 ) {
            $sqlEn = "select i.Units_index from grammarIndex i
                where i.keywords like '%$enMatchAllKeywords%'";
echo $sqlEn;
            $enResults = $this->db->query($sqlEn)->result();

            $spotEnUnits = $this->uniqueResult($enResults, 'Units_index');

            // echo "en==";
            print_r($enResults);
        }

        if ( count(array_filter($cnParts)) > 0 ) {
            $sqlCn = "select gkp.Related_Units from grammarKeyPoints gkp 
                where gkp.Grammar_Point_ like '%$cnMatchAllKeywords%'";

            $cnResults = $this->db->query($sqlCn)->result();

            $spotCnUnits = $this->uniqueResult($cnResults, 'Related_Units');
            // echo "cn===";

        }




        $spottedUnits = array_merge($spotEnUnits, $spotCnUnits);
        $spotUnitsString = join(',', array_unique($spottedUnits));


        $spotUnitsString = str_replace(",,", ",", $spotUnitsString);

        $sql = "select * from grammarDict where No in ($spotUnitsString)";
        echo $sql;

        $results = $this->db->query($sql)->result();



        return $results;

    }



    function uniqueResult($inResults, $column) {
        $displayUnits = [];

        foreach ($inResults as $result) {
            $units = preg_split('/[;,]+/', $result->$column);
            if( count($units) > 0) {
                $displayUnits = array_merge( $displayUnits, $units );
            }
        }

        $displayUnits = array_unique($displayUnits);

        return $displayUnits;
    }




}?>