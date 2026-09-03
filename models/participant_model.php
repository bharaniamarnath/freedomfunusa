<?php
include_once(__DIR__ . "/../configuration/database.php");

date_default_timezone_set('America/Chicago');

class ParticipantModel
{

    private $database = null;

    public function __construct()
    {
        $this->database = new Database();
    }
    
    
    /* -------------------------------------------------------------------------------------------------------------------- */

    // Event Participant

    /* -------------------------------------------------------------------------------------------------------------------- */


    //Register Event Participant

    public function registerEventParticipant($eventParticipantID, $eventParticipantFirstName, $eventParticipantLastName, $eventParticipantEmail, $eventParticipantPwdHash, $eventParticipantPhone, $eventParticipantZip)
    {
        try {
            $participantLastLogin = date("Y-m-d H:i:s");
            $participantCreatedDate = date("Y-m-d H:i:s");
            $participantLoginStatus = 0;
            $db = $this->database->openConnection();
            $stmt = $db->prepare('INSERT INTO ff_event_participants (ffep_guid, ffep_uid, ffep_first_name, ffep_last_name, ffep_email, ffep_pwd, ffep_phone, ffep_zip, ffep_login_status, ffep_last_login, ffep_created_date) 
VALUES (UUID(), :eventParticipantID, :eventParticipantFirstName, :eventParticipantLastName, :eventParticipantEmail, :eventParticipantPwdHash, :eventParticipantPhone, :eventParticipantZip, :participantLoginStatus, :participantLastLogin, :participantCreatedDate)');
            $stmt->bindParam(':eventParticipantID', $eventParticipantID);
            $stmt->bindParam(':eventParticipantFirstName', $eventParticipantFirstName);
            $stmt->bindParam(':eventParticipantLastName', $eventParticipantLastName);
            $stmt->bindParam(':eventParticipantEmail', $eventParticipantEmail);
            $stmt->bindParam(':eventParticipantPwdHash', $eventParticipantPwdHash);
            $stmt->bindParam(':eventParticipantPhone', $eventParticipantPhone);
            $stmt->bindParam(':eventParticipantZip', $eventParticipantZip);
            $stmt->bindParam(':participantLoginStatus', $participantLoginStatus);
            $stmt->bindParam(':participantLastLogin', $participantLastLogin);
            $stmt->bindParam(':participantCreatedDate', $participantCreatedDate);
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


    //Check Participant Login
        public function checkParticipantLogin($participantLoginEmail, $participantLoginPwd)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare("SELECT * FROM ff_event_participants WHERE ffep_email=:participantLoginEmail");
            $stmt->bindParam(':participantLoginEmail', $participantLoginEmail);
            if ($stmt->execute()) {
                $row = $stmt->fetch();
                if ($row && password_verify($participantLoginPwd, $row["ffep_pwd"])) {
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

    //Set Participant Login Status
    public function setParticipantLoginStatus($participantLoginEmail, $participantLoginStatus)
    {
        try {
            $db = $this->database->openConnection();
            $participantLastLogin = date('Y-m-d H:i:s');
            $stmt = $db->prepare("UPDATE ff_event_participants SET ffep_login_status=:participantLoginStatus, ffep_last_login=:participantLastLogin WHERE ffep_email=:participantLoginEmail");
            $stmt->bindParam(':participantLoginEmail', $participantLoginEmail);
            $stmt->bindParam(':participantLoginStatus', $participantLoginStatus);
            $stmt->bindParam(':participantLastLogin', $participantLastLogin);
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return false;
        } finally {
            $this->database->closeConnection();
        }
    }

    //Check Event Participant Exists

    public function checkParticipantExists($eventParticipantID)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT COUNT(*) FROM ff_event_participants WHERE ffep_uid=:eventParticipantID');
            $stmt->bindParam(':eventParticipantID', $eventParticipantID);
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

    //Check Participant ID Exists

    public function checkParticipantUID($eventParticipantUID)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT COUNT(*) FROM ff_event_participants WHERE ffep_uid=:eventParticipantUID');
            $stmt->bindParam(':eventParticipantUID', $eventParticipantUID);
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

    //Get Event Participant By Email ID
    public function getEventParticipantByEmailID($eventParticipantEmail)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT * FROM ff_event_participants WHERE ffep_email=:eventParticipantEmail');
            $stmt->bindParam(':eventParticipantEmail', $eventParticipantEmail);
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

    //Get Event Participant By OrderID

    public function getEventParticipantByOrderID($eventParticipantOID)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT * FROM ff_event_participants WHERE ffep_order_id=:eventParticipantOID');
            $stmt->bindParam(':eventParticipantOID', $eventParticipantOID);
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

    //Get Total Participants Count

    public function getTotalParticipants()
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT COUNT(*) FROM ff_event_participants');
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

    public function db_console($msg)
    {
        $console_file = __DIR__ . '/../public/logs/console.json';
        $log_date = date('Y-m-d H:i:s');
        $log_array = array(
            'log_date' => $log_date,
            'log_msg'  => $msg
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