<?php

class DB
{
    protected PDO $db;

    public function connect(): PDO
    {
        // Database connection configuration
        define("HOST", '');
        define("DATABASE", '');
        define("USERNAME", '');
        define("PASSWORD", '');

        $this->db = new PDO("mysql:host=" . HOST . ";dbname=" . DATABASE, USERNAME, PASSWORD);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $this->db;
    }
}
