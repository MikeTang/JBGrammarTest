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
    }

    public function index($result_id, $study_nums, $page){

        $_SESSION["current_page"] = current_url();
        //check if locale is set
        if (!isset($_SESSION["locale"])){
           redirect("lang/set/cn");     
        }
        //explode $study_nums string into an array
        $study_num_array = explode("-", $study_nums);
        $study_units = $this->dict_model->getStudyUnits($study_num_array);
        
        //page numbers
        $data['total_pages'] = count($study_units);
        $data['current_page'] = $page;

        if (count($study_units) == 0){
            redirect('test/result/' . $result_id);
        }

        //other info
        $data['study_nums'] = $study_nums;
        $data['result_id'] = $result_id;
        $data['title'] = 'Study Unit ' . $study_units[$page-1]->No; 

        //current page's study unit content
        $data['study_unit'] = $study_units[$page-1];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/nav', $data);
        $this->load->view('Study_view', $data);
        $this->load->view('templates/footer_test');

    }

}?>