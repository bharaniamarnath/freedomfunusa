<?php
include_once(__DIR__ . "/../configuration/database.php");

date_default_timezone_set('America/Chicago');

class OAuthModel
{

    public function getOATData($pval)
    {
        $database = new Database();
        try {
            $db = $database->openConnection();
            $stmt = $db->prepare("SELECT * FROM ff_oauth WHERE provider=:pval");
            $stmt->bindParam(':pval', $pval);
            if ($stmt->execute()) {
                $row = $stmt->fetch();
                return $row;
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            $this->db_console($e->getMessage());
        } finally {
            $database->closeConnection();
        }
    }

    //Insert OAuth Data

    public function insOATData($provider, $token)
    {
        $database = new Database();
        try {
            $db = $database->openConnection();
            $stmt = $db->prepare("INSERT INTO ff_oauth (provider, provider_value) VALUES(:provider, :token)");
            $stmt->bindParam(':provider', $provider);
            $stmt->bindParam(':token', $token);
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            $this->db_console($e->getMessage());
        } finally {
            $database->closeConnection();
        }
    }

    //Update OAuth Data

    public function setOATData($provider, $token)
    {
        $database = new Database();
        try {
            $db = $database->openConnection();
            $stmt = $db->prepare("UPDATE ff_oauth SET provider_value=:token WHERE provider=:provider");
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':provider', $provider);
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            $this->db_console($e->getMessage());
        } finally {
            $database->closeConnection();
        }
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
