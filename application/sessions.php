<?php
include_once(__DIR__.'/../models/admin_model.php');

class Sessions{

//Administrator Session

public function adminSession(){
if(isset($_SESSION['bccc_admin']) && !empty($_SESSION['bccc_admin'])){
if(isset($_SESSION['bccc_admin']['adminLoginEmail']) && !empty($_SESSION['bccc_admin']['adminLoginEmail'])){
$adminLoginEmail = $_SESSION['bccc_admin']['adminLoginEmail'];
$adminLoginStatus = 1;
$adminModel = new AdminModel();
$adminLoggedIn = $adminModel->getAdminLoginStatus($adminLoginEmail, $adminLoginStatus);
if($adminLoggedIn){
return true;
}
else{
return false;
}
}
else{
return false;
}
}
else{
return false;
}
}

//Check Participant Information Session Status

function participantSession(){
if(isset($_SESSION['bccc_participant']) && !empty($_SESSION['bccc_participant']) && $_SESSION['bccc_participant'] !== null && is_array($_SESSION['bccc_participant'])){
return true;
}
else{
return false;
}
}

//Check Cart Session Status
function isCartAvailable(){
if(isset($_SESSION['bccc_event_game']) && !empty($_SESSION['bccc_event_game']) && $_SESSION['bccc_event_game'] !== null && is_array($_SESSION['bccc_event_game'])){
return true;
}
else{
return false;
}
}

}
?>