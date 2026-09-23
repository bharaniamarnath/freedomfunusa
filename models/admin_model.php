<?php
include_once(__DIR__ . "/../configuration/database.php");

date_default_timezone_set("America/Chicago");

class AdminModel
{

    private $database = null;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function registerAdmin($adminUserID, $adminPwdHash, $adminName, $adminEmail, $adminImageFileName)
    {
        try {
            $adminLastLogin = date("Y-m-d H:i:s");
            $adminCreatedDate = date("Y-m-d H:i:s");
            $adminLoginStatus = 0;
            $db = $this->database->openConnection();
            $stmt = $db->prepare("INSERT INTO ff_admins (ffa_guid, ffa_uid, ffa_pwd, ffa_name, ffa_email, ffa_image, ffa_login_status, ffa_last_login, ffa_created_date) 
VALUES (UUID(), :adminUserID, :adminPwdHash, :adminName, :adminEmail, :adminImageFileName, :adminLoginStatus, :adminLastLogin, :adminCreatedDate)");
            $stmt->bindParam(':adminUserID', $adminUserID);
            $stmt->bindParam(':adminPwdHash', $adminPwdHash);
            $stmt->bindParam(':adminName', $adminName);
            $stmt->bindParam(':adminEmail', $adminEmail);
            $stmt->bindParam(':adminImageFileName', $adminImageFileName);
            $stmt->bindParam(':adminLoginStatus', $adminLoginStatus);
            $stmt->bindParam(':adminLastLogin', $adminLastLogin);
            $stmt->bindParam(':adminCreatedDate', $adminCreatedDate);
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            $log = "Error in database connection: " . $e->getMessage();
            $this->db_console($log);
            return false;
        } finally {
            $this->database->closeConnection();
        }
    }

    //Update Administrator

    public function updateAdmin($adminName, $adminEmail, $adminUID)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('UPDATE ff_admins
SET ffa_name=:adminName, ffa_email=:adminEmail
WHERE ffa_uid=:adminUID');
            $stmt->bindParam(':adminName', $adminName);
            $stmt->bindParam(':adminEmail', $adminEmail);
            $stmt->bindParam(':adminUID', $adminUID);
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

    public function updateAdminImage($adminImage, $adminUID)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('UPDATE ff_admins SET ffa_image=:adminImage WHERE ffa_uid=:adminUID');
            $stmt->bindParam(':adminUID', $adminUID);
            $stmt->bindParam(':adminImage', $adminImage);
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

    //Update Admin Settings

    public function updateAdminSettings($adminEmail, $adminNewPwd)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('UPDATE ff_admins SET ffa_pwd=:adminNewPwd WHERE ffa_email=:adminEmail');
            $stmt->bindParam(':adminNewPwd', $adminNewPwd);
            $stmt->bindParam(':adminEmail', $adminEmail);
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

    //Get Admin By UID

    public function getAdminByUID($adminUID)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT * FROM ff_admins WHERE ffa_uid=:adminUID');
            $stmt->bindParam(':adminUID', $adminUID);
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


    public function checkAdminExists($adminEmail)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare("SELECT COUNT(*) FROM ff_admins WHERE ffa_email=:adminEmail");
            $stmt->bindParam(':adminEmail', $adminEmail);
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
            $log = "Error in database connection: " . $e->getMessage();
            $this->db_console($log);
            return false;
        } finally {
            $this->database->closeConnection();
        }
    }

    public function checkUID($adminUID)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare("SELECT COUNT(*) FROM ff_admins WHERE ffa_uid=:adminUID");
            $stmt->bindParam(':adminUID', $adminUID);
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

    public function getTotalAdmins()
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare("SELECT COUNT(*) FROM ff_admins");
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

    public function checkAdminLogin($adminLoginEmail, $adminLoginPwd)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare("SELECT * FROM ff_admins WHERE ffa_email=:adminLoginEmail");
            $stmt->bindParam(':adminLoginEmail', $adminLoginEmail);
            if ($stmt->execute()) {
                $row = $stmt->fetch();
                if ($row && password_verify($adminLoginPwd, $row["ffa_pwd"]) && $row['ffa_acc_status'] == 1) {
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

    public function setAdminLoginStatus($adminLoginEmail, $adminLoginStatus)
    {
        try {
            $db = $this->database->openConnection();
            $adminLastLogin = date('Y-m-d H:i:s');
            $stmt = $db->prepare("UPDATE ff_admins SET ffa_login_status=:adminLoginStatus, ffa_last_login=:adminLastLogin WHERE ffa_email=:adminLoginEmail");
            $stmt->bindParam(':adminLoginEmail', $adminLoginEmail);
            $stmt->bindParam(':adminLoginStatus', $adminLoginStatus);
            $stmt->bindParam(':adminLastLogin', $adminLastLogin);
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

    public function getAdminLoginStatus($adminLoginEmail, $adminLoginStatus)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare("SELECT COUNT(*) FROM ff_admins WHERE ffa_email=:adminLoginEmail AND ffa_login_status=:adminLoginStatus");
            $stmt->bindParam(':adminLoginEmail', $adminLoginEmail);
            $stmt->bindParam(':adminLoginStatus', $adminLoginStatus);
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

    public function getAdminInfo($adminLoginEmail)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare("SELECT * FROM ff_admins WHERE ffa_email=:adminLoginEmail");
            $stmt->bindParam(':adminLoginEmail', $adminLoginEmail);
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

    public function getAllAdmins($searchArray, $sortArray, $limitArray)
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
            $stmt = $db->prepare("SELECT * FROM ff_admins $search $sort $limit");
            if ($stmt->execute($searchTerms)) {
                $result = $stmt->fetchAll();
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

    public function updateAdminStatus($adminUID, $adminAccountStatus)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('UPDATE ff_admins
SET ffa_acc_status=:adminAccountStatus
WHERE ffa_uid=:adminUID');
            $stmt->bindParam(':adminAccountStatus', $adminAccountStatus);
            $stmt->bindParam(':adminUID', $adminUID);
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

    public function db_console($msg)
    {
        $console_file = __DIR__ . "/../public/logs/console.json";
        $log_date = date("Y-m-d H:i:s");
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
