<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Login extends CI_Controller
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
          $this->load->model('login_model');
     }

     public function index()
     {

          date_default_timezone_set('Asia/Hong_Kong');
          //get the posted values
          $phone = $this->input->post("txt_phone");
          $password = $this->input->post("txt_password");
          $code = $this->input->post("txt_code");

          //set validations
          $this->form_validation->set_rules("txt_phone", "Phone Number", "trim|required|numeric");
          $this->form_validation->set_rules("txt_password", "Password", "trim|required");
          $this->form_validation->set_rules("txt_code", "Code", "trim|required");
          $title['title'] = "Welcome to ".TITLE;


          //if form was not submitted (i.e. arrived at login page)
          if ($this->form_validation->run() == FALSE)
          {
               //validation fails or not logged
               $this->load->view('templates/header', $title);
               $this->load->view('templates/nav_alt', $title);
               $this->load->view('login_view');
               $this->load->view('templates/footer_reg');
             
          }
          //if form was submitted (i.e. entered username/pass/code)
          else
          {
               //if arrived here via pressing the login button
               if ($this->input->post('btn_login') == "Login")
               {
                    //check if username and password is correct
                    $usr_result = $this->login_model->get_user2($phone, $password);
                    $code_session = $_SESSION["security_code"];

                    if ($usr_result->num_rows() > 0)  //user exists
                    {
                         //if validation code is correct proceed
                         if ($code == $code_session){
                             
                              //set the session variables
                              $_SESSION["user_id"] = $usr_result->result()[0]->id;
                              
                              redirect('home/index'); 
                         }else{ 
                         //if validation code is incorrect show warning
                             $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Please enter the correct validation code</div>');
                              redirect('login/index'); 
                         }
                    }
                    else
                    {    
                         //User doesn't exist or entered incorrectly
                         $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Sorry, incorrect phone number or password.</div>');
                         redirect('login/index');
                    }
               }

               else //arrived here by not pressing the login button
               {
                    redirect('login/index');
               }
          }
     }

     //Used for creating the image for the validation code
     public function create_image() 
     { 
         //Generate a random string using md5 
         $md5_hash = md5(rand(0,999)); 
         //Trim it down to 5 
         $security_code = substr($md5_hash, 15, 5); 

         //Set the session to store the security code
         $_SESSION["security_code"] = $security_code;

         //Set the image width and height 
         $width = 60; 
         $height = 20;  

         //Create the image resource 
         $image = ImageCreate($width, $height);  

         //We are making three colors, white, black and gray 
         $white = ImageColorAllocate($image, 255, 255, 255); 
         $black = ImageColorAllocate($image, 0, 0, 0); 
         $grey = ImageColorAllocate($image, 204, 204, 204); 

         //Make the background black 
         ImageFill($image, 0, 0, $white); 

         //Add randomly generated string in white to the image
         ImageString($image, 5, 10, 3, $security_code, $black); 
 
         //Tell the browser what kind of file is come in 
         header("Content-Type: image/jpeg"); 

         //Output the newly created image in jpeg format 
         ImageJpeg($image); 
         
         //Free up resources
         ImageDestroy($image); 
     } 

     public function logout(){
          $this->session->unset_userdata('username');
          $this->session->unset_userdata('loginuser');
          $this->session->unset_userdata('userid');
          $this->session->sess_destroy();
          redirect('login/index');
     }

}?>