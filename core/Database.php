<?php
/**
 * Classe Database - Gestion de la connexion à la base de données
 * Cette classe utilise les constantes définies dans config.php
 */

class Database
{
    private $host;
    private $port;
    private $db;
    private $db_user;
    private $db_pass;

    public function __construct()
    {
        $this->host = DB_HOST;
        $this->port = DB_PORT;
        $this->db = DB_NAME;
        $this->db_user = DB_USER;
        $this->db_pass = DB_PASSWORD;
    }

    public function connect()
    {
        $conn = new mysqli($this->host, $this->db_user, $this->db_pass, $this->db, $this->port);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $conn->set_charset("utf8mb4");
        return $conn;
    }

    public function query($sql, $types = "", $args = [])
    {
        // types est un string qui contient les types des arguments
        // Par ex : "ssds" signifie que les 4 arguments sont de type string, string, decimal, string
        $conn = $this->connect();

        $stmt = $conn->prepare($sql);
        if (!empty($types))
        {
            $stmt->bind_param($types, ...$args);
        }

        $stmt->execute();

        $id = $conn->insert_id;
        $stmt->close();
        $conn->close();
        return $id;
    }

    public function select($sql, $types = "", $args = [])
    {
        $conn = $this->connect();

        $stmt = $conn->prepare($sql);
        if (!empty($types))
        {
            $stmt->bind_param($types, ...$args);
        }

        $stmt->execute();

        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc())
        {
            $data[] = $row;
        }

        $stmt->close();
        $conn->close();
        return $data;
    }
}
