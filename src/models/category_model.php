<?php
include_once(__DIR__ . "/../configuration/database.php");

date_default_timezone_set('America/Chicago');

class categoryModel
{

    private $database = null;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function registerCategory($categoryUID, $categoryName, $categoryEvent, $categoryDescription)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('INSERT INTO ff_event_categories (ffec_guid, ffec_uid, ffec_name, ffec_event_uid, ffec_description) 
VALUES (UUID(), :categoryUID, :categoryName, :categoryEvent, :categoryDescription)');
            $stmt->bindParam(':categoryUID', $categoryUID);
            $stmt->bindParam(':categoryName', $categoryName);
            $stmt->bindParam(':categoryEvent', $categoryEvent);
            $stmt->bindParam(':categoryDescription', $categoryDescription);
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

    //Update Category

    public function updateCategory($categoryUID, $categoryName, $categoryEvent, $categoryDescription)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('UPDATE ff_event_categories
SET ffec_name=:categoryName, ffec_event_uid=:categoryEvent, ffec_description=:categoryDescription
WHERE ffec_uid=:categoryUID');
            $stmt->bindParam(':categoryUID', $categoryUID);
            $stmt->bindParam(':categoryName', $categoryName);
            $stmt->bindParam(':categoryEvent', $categoryEvent);
            $stmt->bindParam(':categoryDescription', $categoryDescription);
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

    //Update Category Image

    public function updateCategoryImage($categoryImage, $categoryUID)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('UPDATE ff_event_categories SET ffec_image=:categoryImage WHERE ffec_uid=:categoryUID');
            $stmt->bindParam(':categoryUID', $categoryUID);
            $stmt->bindParam(':categoryImage', $categoryImage);
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

    public function checkCategoryExists($categoryName)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT COUNT(*) FROM ff_event_categories WHERE ffec_name=:categoryName');
            $stmt->bindParam(':categoryName', $categoryName);
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

    public function checkUID($categoryUID)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT COUNT(*) FROM ff_event_categories WHERE ffec_uid=:categoryUID');
            $stmt->bindParam(':categoryUID', $categoryUID);
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

    public function getAllCategories()
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT * FROM ff_event_categories');
            if ($stmt->execute()) {
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

    //Get Category By UID

    public function getCategoryByUID($categoryUID)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT * FROM ff_event_categories WHERE ffec_uid=:categoryUID');
            $stmt->bindParam(':categoryUID', $categoryUID);
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

    //Get Categories by Event ID

    public function getCategoriesByEventUID($eventUID)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT * FROM ff_event_categories WHERE ffec_event_uid=:eventUID');
            $stmt->bindParam(':eventUID', $eventUID);
            if ($stmt->execute()) {
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

    public function getTotalCategories()
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT COUNT(*) FROM ff_event_categories');
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

    //Delete Category

    public function deleteCategory($categoryUID)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('DELETE FROM ff_event_categories WHERE ffec_uid=:categoryUID');
            $stmt->bindParam(':categoryUID', $categoryUID);
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
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
