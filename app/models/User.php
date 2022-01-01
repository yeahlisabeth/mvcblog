<?php

class User {

    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function register($data) {
        $this->db->query("INSERT INTO `users` (username, email, password) VALUES (:username, :email, :password)");

        //bind values
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);

        //execute function
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function login($username, $password) {
        $this->db->query("SELECT * FROM `users` WHERE username = :username");
        //bind value
        $this->db->bind(':username', $username);

        $row = $this->db->single();

        $hashedPassword = $row->password;

        if (password_verify($password, $hashedPassword)) {
            return $row;
        } else {
            return false;
        }
    }

    //find user by email, email is passed by the controller
    public function findUserByEmail($email) {
        //prepared statement
        $this->db->query("SELECT * FROM `users` WHERE email = :email");

        //email param will be binded with the email variable
        $this->db->bind(':email', $email);

        //check if email is already registered
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getUsers() {
        $this->db->query("SELECT * FROM `users`");

        $result = $this->db->resultSet();

        return $result;
    }

}