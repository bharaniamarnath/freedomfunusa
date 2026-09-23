<?php
include_once(__DIR__ . "/../configuration/database.php");

date_default_timezone_set('America/Chicago');

class EventModel
{

    private $database = null;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function registerEvent($eventUID, $eventName, $eventStartDate, $eventEndDate, $eventDescription)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('INSERT INTO ff_events (ffe_guid, ffe_uid, ffe_name, ffe_start_date, ffe_end_date, ffe_description) 
VALUES (UUID(), :eventUID, :eventName, :eventStartDate, :eventEndDate, :eventDescription)');
            $stmt->bindParam(':eventUID', $eventUID);
            $stmt->bindParam(':eventName', $eventName);
            $stmt->bindParam(':eventStartDate', $eventStartDate);
            $stmt->bindParam(':eventEndDate', $eventEndDate);
            $stmt->bindParam(':eventDescription', $eventDescription);
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

    public function updateEvent($eventUID, $eventName, $eventStartDate, $eventEndDate, $eventDescription)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('UPDATE ff_events 
SET ffe_name=:eventName, ffe_start_date=:eventStartDate, ffe_end_date=:eventEndDate, ffe_description=:eventDescription 
WHERE ffe_uid=:eventUID');
            $stmt->bindParam(':eventUID', $eventUID);
            $stmt->bindParam(':eventName', $eventName);
            $stmt->bindParam(':eventStartDate', $eventStartDate);
            $stmt->bindParam(':eventEndDate', $eventEndDate);
            $stmt->bindParam(':eventDescription', $eventDescription);
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

    public function updateEventImage($eventImage, $eventUID)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('UPDATE ff_events SET ffe_image=:eventImage WHERE ffe_uid=:eventUID');
            $stmt->bindParam(':eventUID', $eventUID);
            $stmt->bindParam(':eventImage', $eventImage);
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

    public function checkEventExists($eventName, $eventStartDate)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT COUNT(*) FROM ff_events WHERE ffe_name=:eventName AND ffe_start_date=:eventStartDate');
            $stmt->bindParam(':eventStartDate', $eventStartDate);
            $stmt->bindParam(':eventName', $eventName);
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

    public function checkUID($eventUID)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT COUNT(*) FROM ff_events WHERE ffe_uid=:eventUID');
            $stmt->bindParam(':eventUID', $eventUID);
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

    public function getAllEvents($searchArray, $sortArray, $limitArray)
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
            $stmt = $db->prepare("SELECT * FROM ff_events $search $sort $limit");
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

    //Get Event By UID

    public function getEventByUID($eventUID)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT * FROM ff_events WHERE ffe_uid=:eventUID');
            $stmt->bindParam(':eventUID', $eventUID);
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

    //Get Events By Category UID

    public function getEventsByCategoryUID($categoryUID)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT * FROM ff_events WHERE ffe_category_uid=:categoryUID');
            $stmt->bindParam(':categoryUID', $categoryUID);
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

    //Delete Category

    public function deleteEvent($eventUID)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('DELETE FROM ff_events WHERE ffe_uid=:eventUID');
            $stmt->bindParam(':eventUID', $eventUID);
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

    /* -------------------------------------------------------------------------------------------------------------------- */

    // Event Game

    /* -------------------------------------------------------------------------------------------------------------------- */

    public function registerEventGame($eventGameUID, $eventGameEvent, $eventGameCategory, $eventGameName, $eventGameDate, $eventGameDuration, $eventGameSession, $eventGameSlots, $eventGameAvailability, $eventGameDescription)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('INSERT INTO ff_event_games (ffeg_guid, ffeg_uid, ffeg_event_uid, ffeg_category_uid, ffeg_game_uid, ffeg_game_date, ffeg_game_duration, ffeg_game_session, ffeg_slots, ffeg_availability, ffeg_description) 
VALUES (UUID(), :eventGameUID, :eventGameEvent, :eventGameCategory, :eventGameName, :eventGameDate, :eventGameDuration, :eventGameSession, :eventGameSlots, :eventGameAvailability, :eventGameDescription)');
            $stmt->bindParam(':eventGameUID', $eventGameUID);
            $stmt->bindParam(':eventGameEvent', $eventGameEvent);
            $stmt->bindParam(':eventGameCategory', $eventGameCategory);
            $stmt->bindParam(':eventGameName', $eventGameName);
            $stmt->bindParam(':eventGameDate', $eventGameDate);
            $stmt->bindParam(':eventGameDuration', $eventGameDuration);
            $stmt->bindParam(':eventGameSession', $eventGameSession);
            $stmt->bindParam(':eventGameSlots', $eventGameSlots);
            $stmt->bindParam(':eventGameAvailability', $eventGameAvailability);
            $stmt->bindParam(':eventGameDescription', $eventGameDescription);
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

    public function updateEventGame($eventGameUID, $eventGameEvent, $eventGameCategory, $eventGameName, $eventGameDate, $eventGameDuration, $eventGameSession, $eventGameSlots, $eventGameAvailability, $eventGameDescription)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('UPDATE ff_event_games 
SET ffeg_event_uid=:eventGameEvent, ffeg_category_uid=:eventGameCategory, ffeg_game_uid=:eventGameName, ffeg_game_date=:eventGameDate, ffeg_game_duration=:eventGameDuration, ffeg_game_session=:eventGameSession, ffeg_slots=:eventGameSlots, ffeg_availability=:eventGameAvailability, ffeg_description=:eventGameDescription 
WHERE ffeg_uid=:eventGameUID');
            $stmt->bindParam(':eventGameUID', $eventGameUID);
            $stmt->bindParam(':eventGameEvent', $eventGameEvent);
            $stmt->bindParam(':eventGameCategory', $eventGameCategory);
            $stmt->bindParam(':eventGameName', $eventGameName);
            $stmt->bindParam(':eventGameDate', $eventGameDate);
            $stmt->bindParam(':eventGameDuration', $eventGameDuration);
            $stmt->bindParam(':eventGameSession', $eventGameSession);
            $stmt->bindParam(':eventGameSlots', $eventGameSlots);
            $stmt->bindParam(':eventGameAvailability', $eventGameAvailability);
            $stmt->bindParam(':eventGameDescription', $eventGameDescription);
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

    public function checkEventGameExists($eventGameEvent, $eventGameName, $eventGameDate)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT COUNT(*) FROM ff_event_games WHERE ffeg_event_uid=:eventGameEvent AND ffeg_game_uid=:eventGameName AND ffeg_game_date=:eventGameDate');
            $stmt->bindParam(':eventGameEvent', $eventGameEvent);
            $stmt->bindParam(':eventGameName', $eventGameName);
            $stmt->bindParam(':eventGameDate', $eventGameDate);
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

    public function checkEventGameUID($eventGameUID)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT COUNT(*) FROM ff_event_games WHERE ffeg_uid=:eventGameUID');
            $stmt->bindParam(':eventGameUID', $eventGameUID);
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

    public function getAllEventGames($searchArray, $sortArray, $limitArray)
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
            $stmt = $db->prepare("SELECT * FROM ff_event_games $search $sort $limit");
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

    //Get EventGame By UID

    public function getEventGameByUID($eventGameUID)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT * FROM ff_event_games WHERE ffeg_uid=:eventGameUID');
            $stmt->bindParam(':eventGameUID', $eventGameUID);
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

    //Get Event Games By Event UID

    public function getEventGamesByEventUID($eventUID)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT * FROM ff_event_games WHERE ffeg_event_uid=:eventUID');
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

    //Get Event Games By Category UID

    public function getEventGamesByEventCategory($eventUID, $categoryUID)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT * FROM ff_event_games WHERE ffeg_event_uid=:eventUID AND ffeg_category_uid=:categoryUID');
            $stmt->bindParam(':eventUID', $eventUID);
            $stmt->bindParam(':categoryUID', $categoryUID);
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

    //Delete Event Game

    public function deleteEventGame($eventGameUID)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('DELETE FROM ff_event_games WHERE ffeg_uid=:eventGameUID');
            $stmt->bindParam(':eventGameUID', $eventGameUID);
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


    /* -------------------------------------------------------------------------------------------------------------------- */

    // Event Orders

    /* -------------------------------------------------------------------------------------------------------------------- */


    public function registerEventOrder($eventOrderID, $orderID, $transactionID, $eventOrderDate, $eventPaymentStatus, $eventStatusMessage, $eventResponseCode, $eventPaymentMethod, $eventSubTotal, $eventTax, $eventShipping, $eventTotal, $eventDonorIP)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('INSERT INTO ff_event_orders (ffeo_guid, ffeo_oid, ffeo_order_id, ffeo_transaction_id, ffeo_order_date, ffeo_payment_status, ffeo_status_msg, ffeo_response_code, ffeo_payment_method, ffeo_subtotal_amt, ffeo_tax, ffeo_shipping, ffeo_total_amt, ffeo_ip_addr) 
VALUES (UUID(), :eventOrderID, :orderID, :transactionID, :eventOrderDate, :eventPaymentStatus, :eventStatusMessage, :eventResponseCode, :eventPaymentMethod, :eventSubTotal, :eventTax, :eventShipping, :eventTotal, :eventDonorIP)');
            $stmt->bindParam(':eventOrderID', $eventOrderID);
            $stmt->bindParam(':orderID', $orderID);
            $stmt->bindParam(':transactionID', $transactionID);
            $stmt->bindParam(':eventOrderDate', $eventOrderDate);
            $stmt->bindParam(':eventPaymentStatus', $eventPaymentStatus);
            $stmt->bindParam(':eventStatusMessage', $eventStatusMessage);
            $stmt->bindParam(':eventResponseCode', $eventResponseCode);
            $stmt->bindParam(':eventPaymentMethod', $eventPaymentMethod);
            $stmt->bindParam(':eventSubTotal', $eventSubTotal);
            $stmt->bindParam(':eventTax', $eventTax);
            $stmt->bindParam(':eventShipping', $eventShipping);
            $stmt->bindParam(':eventTotal', $eventTotal);
            $stmt->bindParam(':eventDonorIP', $eventDonorIP);
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


    //Check Event Order ID Exists

    public function checkEventOrderUID($eventOrderUID)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT COUNT(*) FROM ff_event_orders WHERE ffeo_oid=:eventOrderUID');
            $stmt->bindParam(':eventOrderUID', $eventOrderUID);
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

    //Check Event Order Exists

    public function checkEventOrderExists($eventOrderID)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT COUNT(*) FROM ff_event_orders WHERE ffeo_oid=:eventOrderID');
            $stmt->bindParam(':eventOrderID', $eventOrderID);
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

    //Get Event Order By Order ID

    public function getEventOrderByOrderID($eventOrderOID)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT * FROM ff_event_orders WHERE ffeo_oid=:eventOrderOID');
            $stmt->bindParam(':eventOrderOID', $eventOrderOID);
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

    //Get All Event Orders

    public function getAllEventOrders($searchArray, $sortArray, $limitArray)
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
            $stmt = $db->prepare("SELECT * FROM ff_event_orders $search $sort $limit");
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

    //Get All Event Orders List With Participants

    public function getAllEventOrdersList($searchArray, $sortArray, $limitArray)
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
            $stmt = $db->prepare("SELECT ffeo.*, ffep.* FROM ff_event_orders AS ffeo INNER JOIN ff_event_participants AS ffep ON ffeo.ffeo_order_id = ffep.ffep_order_id $search $sort $limit");
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


    /* -------------------------------------------------------------------------------------------------------------------- */

    // Event Participant Game

    /* -------------------------------------------------------------------------------------------------------------------- */


    //Register Event Participant Game

    public function registerEventParticipantGame($participantGameTicketID, $participantEventGameUID, $participantGameOrderID, $participantGameType, $participantGamePrice)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('INSERT INTO ff_participant_games (ffpg_guid, ffpg_uid, ffpg_order_id, ffpg_event_game, ffpg_event_type, ffpg_event_price) 
VALUES (UUID(), :participantGameTicketID, :participantGameOrderID, :participantEventGameUID, :participantGameType, :participantGamePrice)');
            $stmt->bindParam(':participantGameTicketID', $participantGameTicketID);
            $stmt->bindParam(':participantEventGameUID', $participantEventGameUID);
            $stmt->bindParam(':participantGameOrderID', $participantGameOrderID);
            $stmt->bindParam(':participantGameType', $participantGameType);
            $stmt->bindParam(':participantGamePrice', $participantGamePrice);
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

    //Get Participant Game By OrderID

    public function getparticipantGameByOrderID($participantGameOID)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT * FROM ff_participant_games WHERE ffpg_order_id=:participantGameOID');
            $stmt->bindParam(':participantGameOID', $participantGameOID);
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

    //Get Event Check In Info

    public function getEventCheckinInfo($eventOrderID)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT * FROM ff_participant_games WHERE ffpg_order_id=:eventOrderID ORDER BY ffpg_created_date ASC LIMIT 1');
            $stmt->bindParam(':eventOrderID', $eventOrderID);
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


    public function checkinEventParticipant($eventCheckinOrderID, $eventCheckinStatus, $eventCheckinTime)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('UPDATE ff_participant_games SET ffpg_checkin_status=:eventCheckinStatus, ffpg_checkin_time=:eventCheckinTime WHERE ffpg_order_id=:eventCheckinOrderID');
            $stmt->bindParam(':eventCheckinOrderID', $eventCheckinOrderID);
            $stmt->bindParam(':eventCheckinStatus', $eventCheckinStatus);
            $stmt->bindParam(':eventCheckinTime', $eventCheckinTime);
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


    //Get Total Events Participant Checked In

    public function getTotalCheckedIn($eventCheckinOrderID, $eventCheckinStatus)
    {
        try {
            $db = $this->database->openConnection();
            $stmt = $db->prepare('SELECT COUNT(*) FROM ff_participant_games WHERE ffpg_order_id=:eventCheckinOrderID AND ffpg_checkin_status=:eventCheckinStatus');
            $stmt->bindParam(':eventCheckinOrderID', $eventCheckinOrderID);
            $stmt->bindParam(':eventCheckinStatus', $eventCheckinStatus);
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

    //Update Event Game Slots

    public function updateEventGameSlots($eventGameUID, $eventGameSlotIncDec)
    {
        try {
            $db = $this->database->openConnection();
            $stmt1 = $db->prepare('SELECT ffeg_slots FROM ff_event_games WHERE ffeg_uid=:eventGameUID');
            $stmt1->bindParam(':eventGameUID', $eventGameUID);
            if ($stmt1->execute()) {
                $stmt1 = $stmt1->fetch();
                if ($stmt1['ffeg_slots'] > 0 && $eventGameSlotIncDec == 0)
                    $stmt2 = $db->prepare('UPDATE ff_event_games SET ffeg_slots=ffeg_slots-1 WHERE ffeg_uid=:eventGameUID');
                $stmt2->bindParam(':eventGameUID', $eventGameUID);
                if ($stmt2->execute()) {
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


    //Statistics

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
