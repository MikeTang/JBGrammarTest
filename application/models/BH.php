<?php

class BH extends CI_Model
{

    // publics:

    function grammarsInUnits($unitsIn) 
    {
        $results = [];

        if ($unitsIn != null) {
            $safeUnits = array_filter($unitsIn);
            $safeUnits = array_map('trim', $safeUnits);
            // $this->BH->echor($safeUnits);

            // $sql = "select * from grammarDict where No in ($safeUnits)";
            $this->db->select('*');
            $this->db->from('grammarDict');
            $this->db->where_in('No', $safeUnits);

            $query = $this->db->get();
            $results = $query->result();
        }

        return $results;
    }


    function selectColumnOutFromTableWhereColumnInLikeStringIn(
        $columnOut,
        $table, 
        $columnIn, 
        $stringIn 
        ) 
    {
        $spottedUnits = [];
        

        $this->db->select($columnOut);
        $this->db->from($table);
        $this->db->like($columnIn, $stringIn, 'both'); 

        // $sql = "select $columnOut from $table where $columnIn like ".'"%'.$stringIn.'%"';
        // $sql = "select $columnOut from $table where $columnIn like \"%$stringIn%\"";

        // echo $sql."<br/>";
        //$sql = mysql_real_escape_string($sql);

        $query = $this->db->get();
        $results = $query->result();

        if (count($results) > 0) {
            $spottedUnits = $this->uniqueUnionResult($results, $columnOut);
        }

        return $spottedUnits;
    }


// lab

    function uniqueUnionResult($inResults, $column) {
        $outResults = [];

        foreach ($inResults as $result) {
            // $results = preg_split('/[;,，]+/', trim($result->$column));
            $results = preg_split('/[;,，]+/', $result->$column);
            if ($results != null) {
                $results = array_filter($results);
            }
            $outResults = array_merge($outResults, $results);
        }

        $outResults = array_unique($outResults);
        $outResults = array_filter($outResults);

        return $outResults;
    }


    function intersectOfArrays($arraysIn) {
        // $outResults = [];
        $outResults = array_pop($arraysIn);
        if ( $arraysIn != null) {
            $nonEmptyArrays = array_filter($arraysIn);
            // if ( count($nonEmptyArrays) > 1) {
                foreach ($nonEmptyArrays as $arrayIn) {
                    $outResults = array_intersect($arrayIn, $outResults);
                // }
            }
        }

        return $outResults;
    }

    
	function nameOfVar ($var) 
	{
		$vuser = array_slice($GLOBALS,8,count($GLOBALS)-8);
		foreach($vuser as $key=>$value) 
		{
			if($var===$value) return $key ; 
		}
	}


    function echor( $data ) { 
    	echo $this->nameOfVar($data);
    	echo '<pre>';
    	print_r($data);
    	echo '</pre>';
    }


    function isCN($stringIn) {
        $isCN = false;
        $clearString = str_replace("’","", $stringIn);
        if (preg_match("/[\x7f-\xff]/", $clearString)) {
            $isCN = true;
        }
        return $isCN;
    }
}?>
