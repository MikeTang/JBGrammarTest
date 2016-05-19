<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Locale_model extends CI_Model
{
    function __construct()
    {
      // Call the Model constructor
      parent::__construct();
    }

    function getLocale($lang){

        $sql = "SELECT *
                FROM locale
                WHERE locale = '{$lang}' ";
        $query = $this->db->query($sql);
        return $query->result();
    }

}?>