<?php

class Model
{
    public $db;

    public function __construct($host, $user, $password, $dbname)
    {
        $this->db = new mysqli($host, $user, $password, $dbname);
    }

    public function getById($id, $table)
    {
        return $this->db->query("SELECT * FROM $table WHERE id = '$id'")->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllFromTable($table) {
        return $this->db->query("SELECT * FROM $table")->fetch_all(MYSQLI_ASSOC);
    }

    public function deleteById($id, $table)
    {
        $this->db->query("DELETE FROM $table WHERE id = '$id'");
    }

    public function count($table)
    {
        return $this->db->query("SELECT COUNT(*) FROM $table")->fetch_row();
    }
}