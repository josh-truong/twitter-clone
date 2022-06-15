<?php
   require_once 'vendor/autoload.php';
   $dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../dotenv');
   $dotenv->load();

   class DB {
      private $conn;
      private $dbhost;
      private $dbport;
      private $dbuser;
      private $dbpass;
      private $dbname;

      function __construct() {
         $this->dbhost = $_ENV['DB_HOST'];
         $this->dbport = $_ENV['DB_PORT'];
         $this->dbuser = $_ENV['DB_USER'];
         $this->dbpass = $_ENV['DB_PASS'];
         $this->dbname = $_ENV['DB_NAME'];

         try {
            $this->conn = new PDO(
               "mysql:host=$this->dbhost;
                port=$this->dbport;
                dbname=$this->dbname;", 
               $this->dbuser, 
               $this->dbpass);
            ($this->conn)->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            ($this->conn)->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            
         } catch ( PDOException $e ) {
            echo "Connection failed: ", $e->getMessage();
            die();
         }
      }

      function __destruct() {
         $this->conn = null;
      }

      private function handle_sql_errors($query, $error_message) {
         $debug = debug_backtrace();
         $error = array(
            "message" => 'Found in ' . $debug[0]['file'] . ' on line ' . $debug[0]['line'],
            "query" => $query,
            "sql" => $error_message
         );
         console_log($error);
         die();
      }

      public function query($query, $params=[]) {
         try {
            $stmt = ($this->conn)->prepare($query);
            $stmt->execute($params);
            return $stmt;
         } catch ( PDOException $e ) {
            $this->handle_sql_errors($query, $e->getMessage());
         }
      }
   }
?>
