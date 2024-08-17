<?php
include_once(__DIR__ . "/../configuration/database.php");

date_default_timezone_set('America/Chicago');

class GameModel
{

    private $database = null;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function registerGame($gameUID, $gameName, $gamePrice, $gameDescription)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('INSERT INTO ff_games (ffg_guid, ffg_uid, ffg_name, ffg_price, ffg_description) 
VALUES (UUID(), :gameUID, :gameName, :gamePrice, :gameDescription)');
            $stmt->bindParam(':gameUID', $gameUID);
            $stmt->bindParam(':gameName', $gameName);
            $stmt->bindParam(':gamePrice', $gamePrice);
            $stmt->bindParam(':gameDescription', $gameDescription);
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

    //Update Game

    public function updateGame($gameUID, $gameName, $gamePrice, $gameDescription)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('UPDATE ff_games 
SET ffg_name=:gameName, ffg_price=:gamePrice, ffg_description=:gameDescription
WHERE ffg_uid=:gameUID');
            $stmt->bindParam(':gameUID', $gameUID);
            $stmt->bindParam(':gameName', $gameName);
            $stmt->bindParam(':gamePrice', $gamePrice);
            $stmt->bindParam(':gameDescription', $gameDescription);
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


    public function updateGameImage($gameImage, $gameUID)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('UPDATE ff_games SET ffg_image=:gameImage WHERE ffg_uid=:gameUID');
            $stmt->bindParam(':gameUID', $gameUID);
            $stmt->bindParam(':gameImage', $gameImage);
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

    public function checkGameExists($gameName)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT COUNT(*) FROM ff_games WHERE ffg_name=:gameName');
            $stmt->bindParam(':gameName', $gameName);
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

    public function checkUID($gameUID)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT COUNT(*) FROM ff_games WHERE ffg_uid=:gameUID');
            $stmt->bindParam(':gameUID', $gameUID);
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

    public function getAllGames($searchArray, $sortArray, $limitArray)
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
            $stmt = $db->prepare("SELECT * FROM ff_games $search $sort $limit");
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

    //Get Game By UID

    public function getGameByUID($gameUID)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT * FROM ff_games WHERE ffg_uid=:gameUID');
            $stmt->bindParam(':gameUID', $gameUID);
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

    public function getTotalGames()
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT COUNT(*) FROM ff_games');
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

    //Delete Game

    public function deleteGame($gameUID)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('DELETE FROM ff_games WHERE ffg_uid=:gameUID');
            $stmt->bindParam(':gameUID', $gameUID);
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
