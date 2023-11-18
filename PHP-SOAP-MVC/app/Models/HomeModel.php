<?php

class HomeModel extends DB
{
    private $conn;

    public function __construct()
    {
        $this->conn = $this->connect();
    }

}
