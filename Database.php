<?php

class Database
{
    public $server = "localhost";
    public $username = "root";
    public $password = "";
    public $dbname = "ecomdb";

    private $conn = null;

    public function connect()
    {
        $this->conn = new mysqli($this->server, $this->username, $this->password, $this->dbname, 9000);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        return $this;
    }

    public function insert($query)
    {
        if ($this->conn->query($query) === true) {
            return (int) $this->conn->insert_id;
        }
        return false;
    }

    public function update($query)
    {
        return $this->conn->query($query) === true;
    }

    public function delete($query)
    {
        return $this->conn->query($query) === true;
    }

    public function fetchRow($query)
    {
        $result = $this->conn->query($query);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return false;
    }

    public function fetchAll($query)
    {
        $result = $this->conn->query($query);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }

    public function fetchOne($query)
    {
        $result = $this->conn->query($query);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_row();
            return $row[0];
        }
        return false;
    }

    public function fetchPair($query)
    {
        $result = $this->conn->query($query);
        if (! $result || $result->num_rows === 0) {
            return false;
        }

        $pairs = [];
        while ($row = $result->fetch_row()) {
            $pairs[$row[0]] = $row[1];
        }

        return $pairs;
    }
}
