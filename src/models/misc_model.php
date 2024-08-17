<?php
include_once(__DIR__ . "/../configuration/database.php");

date_default_timezone_set('America/Chicago');

class MiscModel
{

    private $database = null;

    public function __construct()
    {
        $this->database = new Database();
    }

    //Get All Phone Codes

    public function getAllPhoneCodes()
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT pc_code, pc_namecode, pc_name FROM ff_phonecodes ORDER BY pc_name ASC');
            if ($stmt->execute()) {
                $row = $stmt->fetchAll();
                return $row;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            $log = 'Error in database connection: ' . $e->getMessage();
            $this->db_console($log);
            return false;
        } finally {
            $this->database->closeConnection();
        }
    }

    //Get All US States

    public function getAllUSStates()
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT st_code, st_name FROM ff_usastates ORDER BY st_name ASC');
            if ($stmt->execute()) {
                $row = $stmt->fetchAll();
                return $row;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            $log = 'Error in database connection: ' . $e->getMessage();
            $this->db_console($log);
            return false;
        } finally {
            $this->database->closeConnection();
        }
    }

    //Get All Countries

    public function getAllCountries()
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT c_code, c_name FROM ff_countries ORDER BY c_name ASC');
            if ($stmt->execute()) {
                $row = $stmt->fetchAll();
                return $row;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            $log = 'Error in database connection: ' . $e->getMessage();
            $this->db_console($log);
            return false;
        } finally {
            $this->database->closeConnection();
        }
    }

    public function getTaxRate()
    {
        try {
            $db = $this->database->openConnection();
            $field_name = 'tax_rate';
            $stmt = $db->prepare('SELECT ffc_name, ffc_value FROM ff_constants WHERE ffc_name=:taxRate');
            $stmt->bindParam(':taxRate', $field_name);
            if ($stmt->execute()) {
                $row = $stmt->fetch();
                return $row;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            $log = 'Error in database connection: ' . $e->getMessage();
            $this->db_console($log);
            return false;
        } finally {
            $this->database->closeConnection();
        }
    }

    public function getConstantInfo($constName)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT ffc_name, ffc_value FROM ff_constants WHERE ffc_name=:constName');
            $stmt->bindParam(':constName', $constName);
            if ($stmt->execute()) {
                $row = $stmt->fetch();
                return $row;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            $log = 'Error in database connection: ' . $e->getMessage();
            $this->db_console($log);
            return false;
        } finally {
            $this->database->closeConnection();
        }
    }

    public function updateConstantInfo($constParams)
    {
        try {
            $db = $this->database->openConnection();
            $count = 0;
            foreach ($constParams as $constName => $constValue):
                $stmt = $db->prepare('UPDATE ff_constants SET ffc_value=:constValue WHERE ffc_name=:constName');
                $stmt->bindParam(':constValue', $constValue);
                $stmt->bindParam(':constName', $constName);
                if ($stmt->execute()) {
                    $count += 1;
                }
            endforeach;
            if ($count == count($constParams)): return true;
            else: return false;
            endif;
        } catch (PDOException $e) {
            $log = 'Error in database connection: ' . $e->getMessage();
            $this->db_console($log);
            return false;
        } finally {
            $this->database->closeConnection();
        }
    }

    public function db_console($msg)
    {
        $console_file = __DIR__ . '/../public/logs/console.json';
        $log_date = date('Y-m-d H:i:s');
        $log_array = array(
            'log_date' => $log_date,
            'log_msg' => $msg
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
