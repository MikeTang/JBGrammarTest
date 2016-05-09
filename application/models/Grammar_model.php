<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Grammar_model extends CI_Model
{
    function __construct()
    {
      // Call the Model constructor
      parent::__construct();
    }

    function getQuestionsFromGroup($group_num){
      $needle = $group_num . ".";
      $sql = "SELECT * 
              FROM grammarTests 
              WHERE No LIKE '{$needle}%' ";
      $query = $this->db->query($sql);
      return $query;

    }

    function getQuestion($question_no){
        $sql = "SELECT *
                FROM grammarTests
                WHERE No = '{$question_no}' ";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function getSubmission($user_id){
        $sql = "SELECT *
                FROM grammarTestSubmissions
                WHERE user_id = '{$user_id}' ";
        $query = $this->db->query($sql);
        return $query;
    }

    function getSubmissionById($id){
        $sql = "SELECT *
                FROM grammarTestSubmissions
                WHERE id = '{$id}' ";
        $query = $this->db->query($sql);
        return $query;
    }

    function getInPorgressSubmission($user_id){
        $sql = "SELECT *
                FROM grammarTestSubmissions
                WHERE user_id = '{$user_id}'
                AND completed = 2";
        $query = $this->db->query($sql);
        return $query;
    }

    function submitAnswer($data){
        $this->load->helper('url');
        $this->db->insert('grammarTestSubmissions', $data);
        return;
    }

    function testComplete($user_id, $data){
        $this->load->helper('url');
        $this->db->where('user_id', $user_id);
        $this->db->update('grammarTestSubmissions', $data);
    }

    function updateAnswer($user_id, $data){
        $this->load->helper('url');
        $this->db->where('user_id', $user_id);
        $this->db->where('completed', 2);
        $this->db->update('grammarTestSubmissions', $data);
    }


}?>