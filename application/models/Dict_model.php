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
        $isCN = false;
        // if(!eregi("[^\x80-\xff]","$str")) {
        if (preg_match("/[\x7f-\xff]/", $stringIn)) {
            $isCN = true;
        }
        return $isCN;
    }

    function searchKeywordInTableWithColumnIOAndLikeString($stringIn, $table, $columnIn, $columnOut, $likeString) {
        // $column = 'Units_index';
        $parts = preg_split("/[,，]+/", trim($stringIn));

        $enGlue = "%' or i.Keywords like '%";
        $enMatchAllKeywords = join($enGlue, $parts);

        $sql = "select $columnOut from $table
                    where $columnIn like '%$likeString%'";

        echo $sql;

        $results = $this->db->query($sql)->result();


        $spottedUnits = [];
        if (count(array_filter($results)) > 0) {
            $spottedUnits = $this->uniqueUnionResult($results, $columnOut);
        }

        // print_r( $spottedUnits );

        return $spottedUnits;
    }


    function searchUnits($stringIn) {
        // self->isCN($stringIn);

        $parts = preg_split("/[,，]+/", trim($stringIn));

// a,an,冦词
        $enParts = [];
        $cnParts = [];

        foreach ($parts as $v) {
            if (preg_match("/[\x7f-\xff]/", $v)) {
                array_push($cnParts, trim($v));
            } else {
                array_push($enParts, trim($v));
            }
        }


echo "en";
        print_r($enParts);
echo "cn";
        print_r($cnParts);


// en
        $enGlue = "%' or Keywords like '%";
        $enMatchAllKeywords = join($enGlue, $enParts);

        // print_r($enMatchAllKeywords);

        $spottedEnUnitsArrays = [];

        foreach ($enParts as $enKeyword) {
            $spottedEnUnits = $this->searchKeywordInTableWithColumnIOAndLikeString(
                trim($enKeyword),
                'grammarIndex',
                'keywords',
                'Units_index',
                $enMatchAllKeywords
            );
            array_push($spottedEnUnitsArrays, $spottedEnUnits);
        }

        // merge CN units;
        $finalEnUnits = [];
        if (count($spottedEnUnitsArrays) > 0 ) {
            $finalEnUnits = $spottedEnUnitsArrays[0];

            foreach ($spottedEnUnitsArrays as $units) {
                array_merge($finalEnUnits, $units);
            }
        }



// cn



        $cnGlue = "%' or Grammar_Point_ like '%";
        $cnMatchAllKeywords = join($cnGlue, $cnParts);


        $spottedCnUnitsArrays = [];

        foreach ($cnParts as $cnKeyword) {
            $spottedCnUnits = $this->searchKeywordInTableWithColumnIOAndLikeString(
                trim($cnKeyword),
                'grammarKeyPoints',
                'Grammar_Point_',
                'related_units',
                $cnMatchAllKeywords
            );
            array_push($spottedCnUnitsArrays, $spottedCnUnits);
        }

        $finalCnUnits = [];

        // merge CN units;
        if (count($spottedCnUnitsArrays) > 0 ) {
            $finalCnUnits = $spottedCnUnitsArrays[0];

            foreach ($spottedCnUnitsArrays as $units) {
                array_merge($finalCnUnits, $units);
            }
        }



        // intersection 
        $finalUnits = [];

        $enCount = count(array_filter($finalEnUnits));
        $cnCount = count(array_filter($finalCnUnits));

        if ($enCount > 0 and $cnCount > 0) {
            $finalUnits = array_intersect($finalEnUnits, $finalCnUnits);
        } else {
            $finalUnits = array_merge($finalEnUnits, $finalCnUnits);
        }


        $finalGrammars = $this->getGrammarFromUnits($finalUnits);
        return $finalGrammars;



        // self->uniqueIntersectResult($spottedEnUnitsArrays);


        // $cnGlue = "%' or gkp.Grammar_Point_ like '%";
        // $cnMatchAllKeywords = join($cnGlue, $cnParts);


    }
      
    function searchUnitsBilingual($stringIn) {
        // $query = str_replace(" ", "%", $query);
        $parts = preg_split("/ /", $stringIn);

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

        $enGlue = "%' or i.Keywords like '%";
        $enMatchAllKeywords = join($enGlue, $enParts);

        $cnGlue = "%' or gkp.Grammar_Point_ like '%";
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

        $spotUnits = [];
        $spotEnUnits = [];
        $spotCnUnits = [];

        if ( count(array_filter($enParts)) > 0 ) {
            $sqlEn = "select i.Units_index from grammarIndex i
                where i.keywords like '%$enMatchAllKeywords%'";
// echo $sqlEn;
            $enResults = $this->db->query($sqlEn)->result();

            $spotEnUnits = $this->uniqueResult($enResults, 'Units_index');

            // echo "en==";
        }

        if ( count(array_filter($cnParts)) > 0 ) {
            $sqlCn = "select gkp.Related_Units from grammarKeyPoints gkp 
                where gkp.Grammar_Point_ like '%$cnMatchAllKeywords%'";

            $cnResults = $this->db->query($sqlCn)->result();

            $spotCnUnits = $this->uniqueResult($cnResults, 'Related_Units');
            // echo "cn===";
        }

        if ( count(array_filter($enParts)) > 0 && count(array_filter($cnParts)) > 0) {
            $spottedUnits = array_merge($spotEnUnits, $spotCnUnits);
            echo "intersect";
        } else {
            $spottedUnits = array_merge($spotEnUnits, $spotCnUnits);
            echo "not all";
        }
        // print_r( $spottedUnits );

        $spotUnitsString = join(',', array_unique($spottedUnits));
        $spotUnitsString = str_replace(",,", ",", $spotUnitsString);


        $sql = "select * from grammarDict where No in ($spotUnitsString)";
        echo $sql;


        $results = [];
        if ($spotUnitsString) {
            $results = $this->db->query($sql)->result();
        }

        return $results;

    }


    function uniqueIntersectResult($inResults, $column) {
        $results = preg_split('/[;,，]+/', $inResults[0]->$column);

        foreach ($inResults as $result) {
            $units = preg_split('/[;,，]+/', $result->$column);
            if( count($units) > 0) {
                print_r($units);
                $results = array_intersect($results, $units);
            }
        }


        $results = array_unique($results);
        $results = array_filter($results);

        return $results;
    }


    function uniqueUnionResult($inResults, $column) {
        $outResults = [];
        foreach ($inResults as $result) {
            $results = preg_split('/[;,，]+/', $result->$column);
            $outResults = array_merge($outResults, $results);
        }

        $outResults = array_unique($outResults);
        $outResults = array_filter($outResults);

        return $outResults;
    }

    // finally get the result
    function getGrammarFromUnits($unitsIn) {
        $safeUnits = array_filter($unitsIn);
        print_r($safeUnits);
        $unitString = join(',', $safeUnits);


        $sql = "select * from grammarDict where No in ($unitString)";
        echo $sql;

        $results = [];

        if (count($safeUnits) > 0) {
            $results = $this->db->query($sql)->result();
        }

        return $results;
    }



}?>