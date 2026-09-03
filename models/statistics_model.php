<?php
include_once(__DIR__ . "/../configuration/database.php");

date_default_timezone_set('America/Chicago');

class StatisticsModel
{

    private $database = null;

    public function __construct()
    {
        $this->database = new Database();
    }


    /* --------------------------------------------------- */

    /* Orders */

    /* --------------------------------------------------- */


    public function getAllEventsAmount()
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT SUM(ffeo_total_amt) as total_amt FROM ff_event_orders');
            if ($stmt->execute()) {
                $count = $stmt->fetch();
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

    //Get Total Event Order Count

    public function getTotalEventOrders()
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT COUNT(*) FROM ff_event_orders');
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

    public function getTotalAmountByEventGames()
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT fpg.ffpg_event_game, feg.ffeg_uid, fg.ffg_name, fe.ffe_name, SUM(fpg.ffpg_event_price) AS event_amount 
FROM ff_participant_games AS fpg 
INNER JOIN ff_event_games AS feg ON fpg.ffpg_event_game=feg.ffeg_uid 
INNER JOIN ff_games AS fg ON feg.ffeg_game_uid=fg.ffg_uid 
INNER JOIN ff_events AS fe ON feg.ffeg_event_uid=fe.ffe_uid 
GROUP BY fpg.ffpg_event_game');
            if ($stmt->execute()) {
                $count = $stmt->fetchAll();
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

    public function getTotalOrdersByOrderDate()
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT fpg.ffpg_event_game, feg.ffeg_uid, fe.ffe_name, SUM(fpg.ffpg_event_price) AS event_amount, DATE(fpg.ffpg_created_date) AS order_date
FROM ff_participant_games AS fpg 
INNER JOIN ff_event_games AS feg ON fpg.ffpg_event_game=feg.ffeg_uid 
INNER JOIN ff_events AS fe ON feg.ffeg_event_uid=fe.ffe_uid 
GROUP BY order_date');
            if ($stmt->execute()) {
                $count = $stmt->fetchAll();
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

    public function getTotalAmountByOrderDate()
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT SUM(ffeo_total_amt) as ffeo_total_amt_date, DATE(ffeo_order_date) as ffeo_order_date_only
FROM ff_event_orders 
GROUP BY DATE(ffeo_order_date) 
ORDER BY DATE(ffeo_order_date) DESC LIMIT 5');
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

    public function getTotalByPaymentMethod($paymentMethod)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT COUNT(*) FROM ff_event_orders WHERE ffeo_payment_method=:paymentMethod');
            $stmt->bindParam(':paymentMethod', $paymentMethod);
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

    /* --------------------------------------------------- */

    /* Events */

    /* --------------------------------------------------- */

    public function getTotalEvents()
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT COUNT(*) FROM ff_events');
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


    public function getTotalEventGames()
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT COUNT(*) FROM ff_event_games');
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

    public function getTotalEventGamesByDate()
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT ffeg_game_date, COUNT(ffeg_uid) AS event_games_count FROM ff_event_games GROUP BY ffeg_game_date');
            if ($stmt->execute()) {
                $count = $stmt->fetchAll();
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

    public function getTotalEventGamesByEvent()
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT feg.ffeg_event_uid, fe.ffe_name, COUNT(feg.ffeg_uid) AS event_games_count 
FROM ff_event_games AS feg 
INNER JOIN ff_events AS fe ON feg.ffeg_event_uid=fe.ffe_uid 
GROUP BY feg.ffeg_event_uid');
            if ($stmt->execute()) {
                $count = $stmt->fetchAll();
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

    public function getTotalEventGamesByCategory()
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT feg.ffeg_category_uid, fec.ffec_name, COUNT(feg.ffeg_uid) AS event_games_count 
FROM ff_event_games AS feg 
INNER JOIN ff_event_categories AS fec ON feg.ffeg_category_uid=fec.ffec_uid 
GROUP BY feg.ffeg_category_uid');
            if ($stmt->execute()) {
                $count = $stmt->fetchAll();
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


    public function getTotalEventGameSlots()
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT feg.ffeg_event_uid, fg.ffg_name, feg.ffeg_slots, fe.ffe_name 
FROM ff_event_games AS feg 
INNER JOIN ff_events AS fe ON feg.ffeg_event_uid=fe.ffe_uid 
INNER JOIN ff_games AS fg ON feg.ffeg_game_uid=fg.ffg_uid 
ORDER BY feg.ffeg_created_date');
            if ($stmt->execute()) {
                $count = $stmt->fetchAll();
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

    public function getTotalOrdersByEventGameCategory($eventGameCategory)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT *
FROM ff_participant_games AS fpg 
INNER JOIN ff_event_games AS feg ON fpg.ffpg_event_game=feg.ffeg_uid 
INNER JOIN ff_event_categories AS fec ON fec.ffec_uid=feg.ffeg_category_uid 
WHERE fec.ffec_name=:eventGameCategory');
            $stmt->bindParam(':eventGameCategory', $eventGameCategory);
            if ($stmt->execute()) {
                $count = $stmt->fetchAll();
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

    /* --------------------------------------------------- */

    /* Games */

    /* --------------------------------------------------- */

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

    /* --------------------------------------------------- */

    /* Participants */

    /* --------------------------------------------------- */

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

    public function getTotalParticipantsByEvent()
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT fpg.ffpg_event_game, feg.ffeg_uid, fe.ffe_name, COUNT(fpg.ffpg_uid) AS event_participants 
FROM ff_participant_games AS fpg 
INNER JOIN ff_event_games AS feg ON fpg.ffpg_event_game=feg.ffeg_uid 
INNER JOIN ff_events AS fe ON feg.ffeg_event_uid=fe.ffe_uid 
GROUP BY fe.ffe_uid');
            if ($stmt->execute()) {
                $count = $stmt->fetchAll();
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

    public function getTotalParticipantsByEventGames()
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT fpg.ffpg_event_game, feg.ffeg_uid, fg.ffg_name, fe.ffe_name, COUNT(fpg.ffpg_uid) AS event_participants 
FROM ff_participant_games AS fpg 
INNER JOIN ff_event_games AS feg ON fpg.ffpg_event_game=feg.ffeg_uid 
INNER JOIN ff_games AS fg ON feg.ffeg_game_uid=fg.ffg_uid 
INNER JOIN ff_events AS fe ON feg.ffeg_event_uid=fe.ffe_uid 
GROUP BY fpg.ffpg_event_game');
            if ($stmt->execute()) {
                $count = $stmt->fetchAll();
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

    public function getTotalParticipantsByState()
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT fep.ffep_state, fuss.st_name, COUNT(fep.ffep_uid) AS event_participants 
FROM ff_event_participants AS fep 
INNER JOIN ff_usastates AS fuss ON fep.ffep_state=fuss.st_code 
GROUP BY fep.ffep_state');
            if ($stmt->execute()) {
                $count = $stmt->fetchAll();
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

    /* --------------------------------------------------- */

    /* Categories */

    /* --------------------------------------------------- */

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
