<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model
{
     function __construct()
     {
          // Call the Model constructor
          parent::__construct();
     }

     //get the username & password from tbl_usrs
     function get_user($usr, $pwd)
     {
          $sql = "select * from grammarTestUsers where username = '" . $usr . "' and password = '" . md5($pwd) . "'";
          $query = $this->db->query($sql);
          return $query;
     }

     function get_user2($phone, $pwd)
     {
          $sql = "select * from grammarTestUsers where phone = '" . $phone . "' and password = '" . md5($pwd) . "'";
          $query = $this->db->query($sql);
          return $query;
     }


     function get_user_by_phone($phone)
     {
          $sql = "select * from grammarTestUsers where phone = '" . $phone . "'";
          $query = $this->db->query($sql);
          return $query;
     }

     function create_user($phone, $password){
          $sql = "INSERT INTO grammarTestUsers (phone, password)
                  VALUES ('{$phone}','" . md5($password) . "');";
          $query = $this->db->query($sql);
          return $query;
     }
}?>