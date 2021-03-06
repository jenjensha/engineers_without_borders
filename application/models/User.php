<?php

class User extends CI_Model {
  public function loginByUsernamePass($username, $password) {
    $query = "SELECT id, username, password, 'engineer' AS role, approved
      FROM engineers
      WHERE username = ?
      UNION
      SELECT id, username, password, 'ngo' AS role, approved
      FROM ngos
      WHERE username = ?";
    $values = array($username, $username);
    $user = $this->db->query($query, $values)->row_array();

    // if no user was found for username, $user is NULL
    if (!empty($user) && password_verify($password, $user['password'])){
      return $user;
    }
  }


   public function loginAdmin($username, $password) {
    $query = "SELECT id, username, password, 'admin' AS role, first_name, last_name
      FROM admins
      WHERE username = ?";
    $values = array($username);
    $user = $this->db->query($query, $values)->row_array();

    // if no user was found for username, $user is NULL
    if (!empty($user) && password_verify($password, $user['password'])){
      return $user;
    }
  }
}
