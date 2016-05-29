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


}?>