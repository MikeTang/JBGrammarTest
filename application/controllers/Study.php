<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Study extends CI_Controller
{

    public function __construct()
    {
      parent::__construct();
      $this->load->library('session');
      $this->load->helper('form');
      $this->load->helper('url');
      $this->load->helper('html');
      $this->load->database();
      $this->load->library('form_validation');
      //load the login model
      $this->load->model('dict_model');
      $this->load->model('info_model');
    }



    public function display($result_id, $uid, $page) {
        $_SESSION["current_page"] = current_url();
        //check if locale is set
        if (!isset($_SESSION["locale"])){
           redirect("lang/set/cn");     
        }
        //explode $study_nums string into an array
        $study_units = $this->dict_model->getUnitsByUID($uid);


        
        //page numbers
        $data['total_pages'] = count($study_units);
        $data['current_page'] = $page;

        if (count($study_units) == 0){
            redirect('test/result/' . $result_id);
        }

        //other info
        // $data['title'] = 'Study Unit ' . $study_units[$page-1]->No; 
        $data['title'] = 'Grammar Units' . $study_units[$page-1]->No; 

        //current page's study unit content
        $data['result_id'] = $result_id;
        $data['uid'] = $uid;


        $data['study_unit'] = $study_units[$page-1];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/nav', $data);
        $this->load->view('Study_view', $data);
        $this->load->view('templates/footer_test');

    }




    public function index($result_id, $study_nums, $page) {
        $_SESSION["current_page"] = current_url();
        //check if locale is set
        if (!isset($_SESSION["locale"])){
           redirect("lang/set/cn");     
        }
        //explode $study_nums string into an array
        $study_num_array = explode("-", $study_nums);
        $study_units = $this->dict_model->getUnits($study_num_array);
        $GrammarID = $this->dict_model->getUnits($study_num_array);


        
        //page numbers
        $data['total_pages'] = count($study_units);
        $data['current_page'] = $page;

        if (count($study_units) == 0){
            redirect('test/result/' . $result_id);
        }

        //other info
        $data['study_nums'] = $study_nums;
        $data['result_id'] = $result_id;
        // $data['title'] = 'Study Unit ' . $study_units[$page-1]->No; 
        $data['title'] = 'Grammar Units' . $study_units[$page-1]->No; 

        //current page's study unit content
        $data['study_unit'] = $study_units[$page-1];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/nav', $data);
        $this->load->view('Study_view', $data);
        $this->load->view('templates/footer_test');

    }

    public function search()
    {

/* 
        //check if user is logged in
        if (isset($_SESSION["user_id"])){
             $user_id = $_SESSION["user_id"];
        }else{
          // echo "<script type=\"text/javascript\">alert('要使用语法字典请先注册登录');</script>";
          redirect('Signup/index');
        }
        */

      $_SESSION["current_page"] = current_url();
      //check if locale is set
      if (!isset($_SESSION["locale"])){
         redirect("lang/set/cn");     
      }

      $data['title'] = 'Grammar Dictionary - Search'; 

      $this->load->view('templates/header', $data);
      $this->load->view('templates/nav', $data);
      $this->load->view('grammar_search_view', $data);
      $this->load->view('templates/footer_test');
    }


    public function search_result()
    {

      $_SESSION["current_page"] = current_url();
      //check if locale is set
      if (!isset($_SESSION["locale"])){
         redirect("lang/set/cn");     
      }

      $query = $this->input->get('query');

      // collect keywords
      if ($query == ''){
        redirect('study/search');
      } else {
        // collecting keywords
        $this->info_model->create_keyword($query);
      }

      $results = $this->dict_model->searchUnits($query);
      // $this->BH->echor($results);


      $data['title'] = 'Grammar Dictionary - Search';
      $data['study_units'] = $results;
      $data['grammars'] = $results;
      $data['query'] = $query;

      $this->load->view('templates/header', $data);
      $this->load->view('templates/nav', $data);
      $this->load->view('search_result_view', $data);
      // $this->load->view('grammar_search_view', $data);
      
      $this->load->view('templates/footer_test');
    }

}?>