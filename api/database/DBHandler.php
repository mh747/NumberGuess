<?php

    class DBHandler {

        //Member variables
        var $dbUsername;
        var $dbPassword;
        var $dbHost;
        var $dbName;
        var $connUsable;
        var $conn;

        function __construct() {
            //Including DB configuration details
            include_once '/Library/WebServer/Documents/NumberGuess/api/database/config.php';

            //Initializing db variables from cfg
            $this->dbUsername = DB_USERNAME;
            $this->dbPassword = DB_PASSWORD;
            $this->dbHost = DB_HOST;
            $this->dbName = DB_NAME;

            //Attempting to connect using details from cfg
            //$this->connUsable = $this->dbConnect();

            //Initially setting this->conn to false, changed on connect
            $this->conn = false;
        }

        public function dbConnect() {
            $dsnString = "mysql:host=" . $this->dbHost . ";dbname=" . $this->dbName;
            try {
                $this->conn = new PDO($dsnString, $this->dbUsername, $this->dbPassword);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                echo "Database error: Cannot connect!";
            }

            return $this->conn;
        }
}

?>
