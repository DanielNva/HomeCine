<?php

class Container
{
    protected $bindings = [];

    public function set($key, $value)
    {
        $this->bindings[$key] = $value;
    }

    public function get($key)
    {
        if (isset($this->bindings[$key])) {
            return $this->bindings[$key]($this);
        }

        throw new Exception("No binding found for key: $key");
    }
}

class Database
{
    private $conn;

    public function __construct($servername, $username, $password, $dbname)
    {
        $this->conn = new mysqli($servername, $username, $password, $dbname);

        if ($this->conn->connect_error) {
            die("Conexión fallida: " . $this->conn->connect_error);
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function closeConnection()
    {
        $this->conn->close();
    }
}
?>
