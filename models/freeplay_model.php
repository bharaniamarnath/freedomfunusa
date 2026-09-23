<?php
include_once(__DIR__ . "/../configuration/database.php");

date_default_timezone_set('America/Chicago');

class FreeplayModel
{

    private $database = null;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function registerFreeplay($freeplayUserID, $freeplayEmail, $freeplayName, $freeplayPhone, $freeplayDOB, $freeplayGuardianName, $freeplayAddress, $freeplayZip)
    {
        try {
            $freeplayLastLogin =  date('Y-m-d H:i:s');
            $freeplayAccStatus = 0;
            $freeplayLoginStatus = 0;
            $db = $this->database->openConnection();
            $stmt = $db->prepare('INSERT INTO ff_freeplay (fffp_guid, fffp_uid, fffp_email, fffp_name, fffp_phone, fffp_dob, fffp_guardian, fffp_address, fffp_zip) 
VALUES (UUID(), :freeplayUserID, :freeplayEmail, :freeplayName, :freeplayPhone, :freeplayDOB, :freeplayGuardianName, :freeplayAddress, :freeplayZip)');
            $stmt->bindParam(':freeplayUserID', $freeplayUserID);
            $stmt->bindParam(':freeplayEmail', $freeplayEmail);
            $stmt->bindParam(':freeplayName', $freeplayName);
            $stmt->bindParam(':freeplayPhone', $freeplayPhone);
            $stmt->bindParam(':freeplayDOB', $freeplayDOB);
            $stmt->bindParam(':freeplayGuardianName', $freeplayGuardianName);
            $stmt->bindParam(':freeplayPhone', $freeplayPhone);
            $stmt->bindParam(':freeplayAddress', $freeplayAddress);
            $stmt->bindParam(':freeplayZip', $freeplayZip);
            if ($stmt->execute()) {
                return true;
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


    public function checkFreeplayExists($freeplayEmail)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT COUNT(*) FROM ff_freeplay WHERE fffp_email=:freeplayEmail');
            $stmt->bindParam(':freeplayEmail', $freeplayEmail);
            if ($stmt->execute()) {
                $count = $stmt->fetchColumn();
                if ($count > 0) {
                    return true;
                } else {
                    return false;
                }
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

    public function checkUID($freeplayUID)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT COUNT(*) FROM ff_freeplay WHERE fffp_uid=:freeplayUID');
            $stmt->bindParam(':freeplayUID', $freeplayUID);
            if ($stmt->execute()) {
                $count = $stmt->fetchColumn();
                if ($count > 0) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return false;
        } finally {
            $this->database->closeConnection();
        }
    }

    public function getAllFreeplays($searchArray, $sortArray, $limitArray)
    {
        try {
            $search = $sort = $limit = '';
            //Search Filter
            $searchString = array();
            $searchTerms = array();
            //Search Filter
            if (!empty($searchArray) && count($searchArray) > 0):
                $search = ' WHERE ';
                for ($i = 0; $i < count($searchArray); $i++) {
                    $searchString[] = $searchArray[$i]['searchKey'] . '=?';
                    $searchTerms[] = $searchArray[$i]['searchValue'];
                }
                $search .= implode(' AND ', $searchString);
            endif;
            //Sort Filter
            if (!empty($sortArray) && count($sortArray) > 0): $sort = ' ORDER BY ' . $sortArray['sortField'] . ' ' . $sortArray['sortOrder'];
            endif;
            //Limit Filter
            if (!empty($limitArray) && count($limitArray) > 0): $limit = ' LIMIT ' . $limitArray['limitOnset'] . ', ' . $limitArray['limitOffset'];
            endif;
            $db = $this->database->openConnection();
            $stmt = $db->prepare("SELECT * FROM ff_freeplay $search $sort $limit");
            if ($stmt->execute($searchTerms)) {
                $result = $stmt->fetchAll();
                return $result;
            } else {
                $this->db_console(var_dump($this->database->errorInfo()));
                return false;
            }
        } catch (PDOException $e) {
            $this->db_console($e->getMessage());
            return false;
        } finally {
            $this->database->closeConnection();
        }
    }

    public function getTotalFreeplays()
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT COUNT(*) FROM ff_freeplay');
            if ($stmt->execute()) {
                $count = $stmt->fetchColumn();
                return $count;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return false;
        } finally {
            $this->database->closeConnection();
        }
    }

    public function getFreeplayInfo($freeplayLoginEmail)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT * FROM ff_freeplay WHERE fffp_email=:freeplayLoginEmail');
            $stmt->bindParam(':freeplayLoginEmail', $freeplayLoginEmail);
            if ($stmt->execute()) {
                $result = $stmt->fetch();
                return $result;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return false;
        } finally {
            $this->database->closeConnection();
        }
    }


    //Get Freeplay By User ID

    public function getFreeplayByUID($freeplayUID)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT * FROM ff_freeplay WHERE fffp_uid=:freeplayUID');
            $stmt->bindParam(':freeplayUID', $freeplayUID);
            if ($stmt->execute()) {
                $result = $stmt->fetch();
                return $result;
            } else {
                return false;
            }
        } catch (PDOException $e) {
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
