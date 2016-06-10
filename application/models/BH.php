<?php

class BH extends CI_Model
{

    // publics:

    function grammarsInUnits($unitsIn) 
    {
        $results = [];

        $safeUnits = array_filter($unitsIn);
        if (count($safeUnits) > 0) {

            // $sql = "select * from grammarDict where No in ($unitString)";
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
            $results = preg_split('/[;,，]+/', trim($result->$column));
            $results = array_filter($results);
            $outResults = array_merge($outResults, $results);
        }

        $outResults = array_unique($outResults);
        $outResults = array_filter($outResults);

        return $outResults;
    }


    function intersectOfArrays($arraysIn) {
        $outResults = [];

        $nonEmptyArrays = array_filter($arraysIn);

        $inCount = count($nonEmptyArrays);

        // print_r( $outResults);
        if ( $inCount > 0) {
            $outResults = $nonEmptyArrays[0];
                if ( $inCount > 1) {
                foreach ($nonEmptyArrays as $arrayIn) {
                //for ($i = 1; $i < $inCount; $i++) {
                    $outResults = array_intersect($arrayIn, $outResults);
                    // $outResults = array_intersect($nonEmptyArrays[$i], $outResults);
                }
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
