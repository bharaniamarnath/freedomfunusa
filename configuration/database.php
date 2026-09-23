<?php

require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/defuse-crypto.phar');

use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;

class Database
{

    private $dbhost = NULL;
    private $dbuser = NULL;
    private $dbpwd = NULL;
    private $dbopt  = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
    protected $dbconn;

    public function __construct()
    {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/');
        $dotenv->load();

        $db_enc_key = Key::loadFromAsciiSafeString($_ENV['DB_ENC_KEY']);

        try {
            $this->dbhost = "mysql:host=" . Crypto::decrypt($_ENV['DB_HOST_ENC'], $db_enc_key) . ";dbname=" . Crypto::decrypt($_ENV['DB_NAME_ENC'], $db_enc_key);
            $this->dbuser = Crypto::decrypt($_ENV['DB_USER_ENC'], $db_enc_key);
            $this->dbpwd = Crypto::decrypt($_ENV['DB_PWD_ENC'], $db_enc_key);
        } catch (\Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException $ex) {
            die($ex->getMessage());
        }
    }

    public function openConnection()
    {
        try {
            $this->dbconn = new PDO($this->dbhost, $this->dbuser, $this->dbpwd, $this->dbopt);
            return $this->dbconn;
        } catch (PDOException $e) {
            $log = "Error in database connection: " . $e->getMessage();
            $this->db_console($log);
        }
    }

    public function closeConnection()
    {
        $this->dbconn = null;
    }

    public function db_console($msg)
    {
        $console_file = __DIR__ . '/../public/logs/console.json';
        $log_date = date('Y-m-d H:i:s');
        $log_array = array(
            "log_date" => $log_date,
            "log_msg" => $msg
        );
        $log_data = array();
        if (file_exists($console_file)) {
            $log_data = file_get_contents($console_file);
            $log_data_array = json_decode($log_data);
            $log_data_array[] = $log_array;
            $write_log = json_encode($log_data_array, JSON_PRETTY_PRINT);
            file_put_contents($console_file, $write_log);
        }
    }
}
