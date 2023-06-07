<?php

class AuthenticationModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

public function register($username, $password, $email)
{
    $this->db->select('userName');
    $this->db->from('users');
    $this->db->where('userName', $username);
    $query = $this->db->get();
    if ($query->num_rows() == 0) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $data = array(
            'username' => $username,
            'password' => $passwordHash,
            'email' => $email
        );
        $this->db->insert('users', $data);
        $detail = $this->db->get_where('users', array('userName' => $username));
        if ($this->db->affected_rows() > 0) {
            return $detail->row();
        } else {
            return false;
        }
    } else {
        return false;
    }
}

public function login($username, $password)
{
    $this->db->select("*");
    $this->db->from('users');
    $this->db->where('userName', $username);
    $query = $this->db->get();
    if ($query->num_rows() == 1) {
        $result = $query->result();
        $passwordHash = $result[0]->password;
        if (password_verify($password, $passwordHash)) {
            return $query->row();
        } else {
            return false;
        }
    } else {
        return false;
    }
}

public function editProfile($id, $username, $description, $profilePic)
{
    if ($profilePic != NULL){
        $data = array(
            'userName' => $username,
            'userDescription' => $description,
            'profilePic' => $profilePic
        );
    }else{
        $data = array(
            'userName' => $username,
            'userDescription' => $description,
        );
    }

    $this->db->where('userID', $id);
    $this->db->update('users', $data);
    $updates = $this->db->get_where('users', array('userID' => $id));
    if ($this->db->affected_rows() > 0) {
        return $updates->row();
    } else {
        return false;
    }
}
}