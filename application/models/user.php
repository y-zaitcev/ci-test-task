<?php
/**
 * User model
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Model
{
    const TABLE_NAME = 'users';
    
    /**
     * Find user for login
     * @param type $email Email
     * @param type $password Password
     * @return mixed
     */
    public function findForLogin($email, $password)
    {
	$this->db->select('id, email');
        $this->db->from(self::TABLE_NAME);
        $this->db->where(array('email' => $email, 'password' => self::encriptPassword($password)));
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row_array();
        
        return FALSE;
    }
    
    /**
     * Returns encripted password
     * @param string $string
     * @return string
     */
    public static function encriptPassword($string)
    {
        return md5($string);
    }
    
    /**
     * Register (add) user
     * @param array $data
     * @return integer
     */
    public function register($data)
    {
        $data['password'] = self::encriptPassword($data['password']);
        
        $this->db->insert(self::TABLE_NAME, $data);
        return $this->db->insert_id();
    }
    
    /**
     * Check if email exists
     * @param string $email
     * @return boolean
     */
    public function emailExists($email)
    {
	$this->db->select('id');
        $this->db->from(self::TABLE_NAME);
        $this->db->where(array('email' => $email));
        $query = $this->db->get();
	
        if($query->num_rows() > 0)
            return TRUE;
        
        return FALSE;
    }
}