<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Info_model extends CI_Model
{
     function __construct()
     {
// Call the Model constructor
          parent::__construct();
     }

//get the username & password from tbl_usrs

     function bugs(){
          $sql = "select id, content, count from bugs;";
          $results = $this->db->query($sql)->result_array();

          return $results;
     }

     function create_bug($url){
          $sql = "select id, content, count from bugs where content = '{$url}'";
          $results = $this->db->query($sql)->result_array();

          if (count($results) == 1) {
               $latestCount = $results[0]['count'] + 1;
               $latestID = $results[0]['id'];
               $sql = "UPDATE bugs set count = {$latestCount} where id = {$latestID}";
          } else {
               $sql = "INSERT INTO bugs (content, count) VALUES ('{$url}', 1)";
          }

          $this->db->query($sql);

          echo "谢谢您的反馈，已记录在案，请返回上一页继续。";

          return $results;
     }



     function keywords(){
          $table = 'keywords';
          $sql = "select id, content, count from {$table} order by count;";
          $results = $this->db->query($sql)->result_array();

          return $results;
     }

     function create_keyword($stringIn){
          $stringIn = addslashes($stringIn);
          $table = 'keywords';
          $sql = "select id, content, count from {$table} where content = '{$stringIn}'";
          $results = $this->db->query($sql)->result_array();

          if (count($results) == 1) {
               $latestCount = $results[0]['count'] + 1;
               $latestID = $results[0]['id'];
               $sql = "UPDATE {$table} set count = {$latestCount} where id = {$latestID}";
          } else {
               $sql = "INSERT INTO ${table} (content, count) VALUES ('{$stringIn}', 1)";
          }

          $this->db->query($sql);

          return $results;
     }
}
?>