<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Lang extends CI_Controller
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
          $this->load->model('locale_model');
     }

     public function index(){
          echo "hello";
     }

     public function set($lang){

          

          $_SESSION['locale'] = $lang;
          $copy = $this->locale_model->getLocale($lang);

          $_SESSION['TITLE_WELCOME'] = $copy[0]->titleWelcome;
          $_SESSION['BTN_LOGIN'] = $copy[0]->btnLogin;
          $_SESSION['BTN_SIGNUP'] = $copy[0]->btnSignup;
          $_SESSION['BTN_LOGOUT'] = $copy[0]->btnLogout;
          $_SESSION['LABEL_PHONENUMBER'] = $copy[0]->labelPhoneNumber;
          $_SESSION['BTN_GETCODE'] = $copy[0]->btnGetCode;
          $_SESSION['LABEL_VALIDATIONCODE'] = $copy[0]->labelValidationCode;
          $_SESSION['LABEL_PASSWORD'] = $copy[0]->labelPassword;
          $_SESSION['LABEL_REPASSWORD'] = $copy[0]->labelRePassword;
          $_SESSION['TEXT_SELECTALL'] = $copy[0]->textSelectAll;
          $_SESSION['TEXT_ENTERCODE'] = $copy[0]->txtEnterCode;
          $_SESSION['TITLE_COMPLETESENTENCE'] = $copy[0]->titleCompeteTheSentence;
          $_SESSION['BTN_BACK'] = $copy[0]->btnBack;
          $_SESSION['BTN_NEXT'] = $copy[0]->btnNext;
          $_SESSION['TITLE_TESTCOMPLETE'] = $copy[0]->titleTestComplete;
          $_SESSION['TITLE_HOWWELL'] = $copy[0]->textHowWell;
          $_SESSION['TEXT_RESULTRECOMMEND'] = $copy[0]->textResultRecommendation;
          $_SESSION['BTN_RETAKE'] = $copy[0]->btnRetake;
          $_SESSION['BTN_STARTSTUDY'] = $copy[0]->btnStartStudy;
          $_SESSION['BTN_STARTTEST'] = $copy[0]->btnStartTest;
          $_SESSION['LINK_BACKTEST'] = $copy[0]->linkBackTest;
          $_SESSION['TITLE_GRAMMAR_DICT'] = $copy[0]->titleGrammarDict;
          $_SESSION['BTN_STUDYALL'] = $copy[0]->btnStudyAll;


          redirect($_SESSION["current_page"]);

         
    }
}?>