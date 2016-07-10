<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Api extends CI_Controller
{

     public function __construct()
     {
          parent::__construct();
          $this->load->library('session');
          $this->load->helper('form');
          $this->load->helper('url');
          $this->load->helper('html');
          $this->load->database();

          $this->load->model('info_model');
          $this->load->model('Dict_model');
          $this->load->model('BH');
     }

     public function current_submissions()
     {
          
          $currentSubmissions = $this->submission_model->getAllNotMarkedSubmissions();
          print_r(json_encode($currentSubmissions));          
     }

     public function submissions_of_date($date)
     {
          // $fetchedResults = $this->submission_model-> getNotMarkedSubmissions(3, $date);
          $fetchedResults = $this->submission_model-> getAllSubmissionsByDate($date);
          // print_r(json_encode($fetchedResults, JSON_FORCE_OBJECT));          
          $jsonData = json_encode($fetchedResults);
          echo($jsonData);
          
     }


     public function uidOfUnit($unit){
          $sql =   "SELECT uID 
                    FROM grammarDict
                    where Grammar_Units = $unit
                    ";

          $query = $this->db->query($sql);
          $results = $query->result();
          $result = $results[0]->uID;
          // echo $result;
          return $results;
     }

     public function grammarsOfUid($uid){
          $sql =   "SELECT * 
                    FROM grammarDict
                    where uID = '$uid'";

          $query = $this->db->query($sql);
          $results = $query->result();
          print_r($results);
          return $results;
     }


     // student 

     public function studentsForTeacher($teacher_id)
     {
          $fetchedResults = $this->user_model->studentsForTeacher($teacher_id);
          
          // print_r(json_encode($fetchedResults, JSON_FORCE_OBJECT));          
          $jsonData = json_encode($fetchedResults);
          echo($jsonData);
          
     }
     // list all bugs
     public function bugs()
     {
          $fetchedResults = $this->info_model->bugs();
          echo json_encode($fetchedResults);
     }

     // create bug
     public function newBug($url)
     {
          $url = base_url(uri_string());
          $fetchedResults = $this->info_model->create_bug($url);
          // echo json_encode($fetchedResults);
     }


     public function newKeyword($stringIn)
     {
          $fetchedResults = $this->info_model->create_keyword($stringIn);
          // echo json_encode($fetchedResults);
     }


          // list all keywords
     public function keywords()
     {
          $fetchedResults = $this->info_model->keywords();
          echo json_encode($fetchedResults);
     }


     // auto test
     public function s($stringIn)
     {
          // $stringIn = htmlentities($stringIn);
          // echo $stringIn;
          $stringIn = urldecode($stringIn);

          // $fetchedResults = $this->Dict_model->searchUnits($stringIn);

          $units = $this->Dict_model->unitsOfKeywords($stringIn);

          if ($units != null) {

               $grammars = $this->Dict_model->grammarsOfUnits($units);

               $grammarNos = [];

               foreach ($grammars as $grammar)
               {
                    array_push($grammarNos, $grammar->No);
               }

               // $this->BH->echor($grammarNos);
               $diffs = array_diff($units, $grammarNos);
               // $this->BH->echor($diffs);

               $diffString = join(" ", $diffs);

               $result = "";

               $spottedGrammarsCount = count($grammarNos);
               $diffCount = count($diffs);
               $missedCount = count($units) - count($grammarNos);
               if ($diffCount > 0) {
                    // missed grammar
                    $result = "Test Failed! Grammar DB missed $missedCount Units: \t$diffString for keyword [$stringIn]";
                    // reduntant grammar units
               } else {
                    // $result = "Test Failed! Grammar DB has reduntant $diffCount Units: \t$diffString for keyword [$stringIn]";
                    // }
               // } else {
                    $result = "Test Passed! Result spotted count[$spottedGrammarsCount]\t by keyword [$stringIn]";

               }

               if (count($spottedGrammarsCount) == 0) {
                    $result = "Test Pending Confirm! Result spotted count[$spottedGrammarsCount]\t by keyword [$stringIn]";

               }
          } else {
               $result = "Test Passed! No Result spotted by keywords [$stringIn]";
          }

          echo $result;

          // echo json_encode($fetchedResults);
          // echo count($fetchedResults);
          return $result;

     }

     function cnKeywords() {
          $cnKeywords = $this->BH->cnKeywords();
          print_r(array_values($cnKeywords));
     }

}?>