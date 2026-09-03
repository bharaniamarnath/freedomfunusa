<?php
class ValidationModel{

private $validation_errors = array();
private $error_count = 0;

//Form Validation Methods

public function validateParticipant($eventParticipantFirstName, $eventParticipantLastName, $eventParticipantEmail, 
$eventParticipantPassword, $eventParticipantPhoneCode, $eventParticipantPhoneNumber, $eventParticipantZip){

$this->validateName($eventParticipantFirstName, 'First Name');
$this->validateName($eventParticipantLastName, 'Last Name');
$this->validateEmail($eventParticipantEmail, 'Email');
$this->validatePassword($eventParticipantPassword, 'Password', 1);
$this->validatePhoneCode($eventParticipantPhoneCode, 'Phone Code');
$this->validatePhoneNumber($eventParticipantPhoneCode, 'Phone Number');
$this->validateZipCode($eventParticipantZip, 'Zip Code');

if($this->is_valid()){
return true;
}
else{
return false;
}

}

public function validateParticipantLogin($participantLoginEmail, $participantLoginPwd){

$this->validateEmail($participantLoginEmail, 'Username');
$this->validatePassword($participantLoginPwd, 'Password', 0);

if($this->is_valid()){
return true;
}
else{
return false;
}

}

public function validateBilling($eventBillingFirstName, $eventBillingLastName, 
$eventBillingEmail, $eventBillingPhoneCode, $eventBillingPhoneNumber, $eventBillingZip, $eventBillingPaymentMethod){

$this->validateName($eventBillingFirstName, 'First Name');
$this->validateName($eventBillingLastName, 'Last Name');
$this->validateEmail($eventBillingEmail, 'Email');
$this->validatePhoneCode($eventBillingPhoneCode, 'Phone Code');
$this->validatePhoneNumber($eventBillingPhoneNumber, 'Phone Number');
$this->validateZipCode($eventBillingZip, 'Zip Code');
$this->validatePaymentMethod($eventBillingPaymentMethod, 'Payment Method');

if($this->is_valid()){
return true;
}
else{
return false;
}

}

public function validateAddEvent($eventGameUID, $eventGamePrice, $eventGameSlots, $eventGameSlotsLimit){

$this->validateUserID($eventGameUID, 'Game ID');
$this->validatePrice($eventGamePrice, 'Price');
$this->validateQuantity($eventGameSlots, 'Quantity', $eventGameSlotsLimit);

if($this->is_valid()){
return true;
}
else{
return false;
}

}

public function validateAdminRegister($adminName, $adminEmail, $adminPwd){

$this->validateName($adminName, 'Name');
$this->validateEmail($adminEmail, 'Email');
$this->validatePassword($adminPwd, 'Password', 1);

if($this->is_valid()){
return true;
}
else{
return false;
}

}

public function validateAdminUpdate($adminName, $adminEmail){

$this->validateName($adminName, 'Name');
$this->validateEmail($adminEmail, 'Email');

if($this->is_valid()){
return true;
}
else{
return false;
}

}

public function validateAdminLogin($adminLoginEmail, $adminLoginPwd){

$this->validateEmail($adminLoginEmail, 'Username');
$this->validatePassword($adminLoginPwd, 'Password', 0);

if($this->is_valid()){
return true;
}
else{
return false;
}

}

public function validateAdminPwdUpdate($adminPwd, $adminNewPwd){

$this->validatePassword($adminPwd, 'Password', 1);
$this->validatePassword($adminNewPwd, 'New Password', 1);

if($this->is_valid()){
return true;
}
else{
return false;
}

}

public function validateCategoryRegister($categoryName, $categoryEvent, $categoryDescription){

$this->validateName($categoryName, 'Name');
$this->validateCode($categoryEvent, 'Event');
$this->validateText($categoryDescription, 'Description');

if($this->is_valid()){
return true;
}
else{
return false;
}

}

public function validateCategoryUpdate($categoryName, $categoryEvent, $categoryDescription){

$this->validateName($categoryName, 'Name');
$this->validateCode($categoryEvent, 'Event');
$this->validateText($categoryDescription, 'Description');

if($this->is_valid()){
return true;
}
else{
return false;
}

}

public function validateGameRegister($gameName, $gamePrice, $gameDescription){

$this->validateName($gameName, 'Name');
$this->validatePrice($gamePrice, 'Price');
$this->validateText($gameDescription, 'Description');

if($this->is_valid()){
return true;
}
else{
return false;
}
}

public function validateGameUpdate($gameName, $gamePrice, $gameDescription){

$this->validateName($gameName, 'Name');
$this->validatePrice($gamePrice, 'Price');
$this->validateText($gameDescription, 'Description');

if($this->is_valid()){
return true;
}
else{
return false;
}
}

public function validateEventRegister($eventName, $eventStartDate, $eventEndDate, $eventDescription){

$this->validateName($eventName, 'Name');
$this->validateDate($eventStartDate, 'Start Date');
$this->validateDate($eventEndDate, 'End Date');
$this->validateText($eventDescription, 'Description');

if($this->is_valid()){
return true;
}
else{
return false;
}
}

public function validateEventUpdate($eventName, $eventStartDate, $eventEndDate, $eventDescription){

$this->validateName($eventName, 'Name');
$this->validateDate($eventStartDate, 'Start Date');
$this->validateDate($eventEndDate, 'End Date');
$this->validateText($eventDescription, 'Description');

if($this->is_valid()){
return true;
}
else{
return false;
}
}

public function validateEventGameRegister($eventGameEvent, $eventGameCategory, $eventGameName, $eventGameDate, $eventGameDuration, $eventGameSession, $eventGameSlots, $eventGameAvailability, $eventGameDescription){

$this->validateCode($eventGameEvent, 'Event');
$this->validateCode($eventGameCategory, 'Category');
$this->validateCode($eventGameName, 'Game');
$this->validateDate($eventGameDate, 'Date');
$this->validateDuration($eventGameDuration, 'Duration');
$this->validateSession($eventGameSession, 'Session');
$this->validateQuantity($eventGameSlots, 'Quantity', 9999);
$this->validateAvailability($eventGameAvailability, 'Availability');
$this->validateText($eventGameDescription, 'Description');

if($this->is_valid()){
return true;
}
else{
return false;
}

}

public function validateEventGameUpdate($eventGameEvent, $eventGameCategory, $eventGameName, $eventGameDate, $eventGameDuration, $eventGameSession, $eventGameSlots, $eventGameAvailability, $eventGameDescription){

$this->validateCode($eventGameEvent, 'Event');
$this->validateCode($eventGameCategory, 'Category');
$this->validateCode($eventGameName, 'Game');
$this->validateDate($eventGameDate, 'Date');
$this->validateDuration($eventGameDuration, 'Duration');
$this->validateSession($eventGameSession, 'Session');
$this->validateQuantity($eventGameSlots, 'Quantity', 9999);
$this->validateAvailability($eventGameAvailability, 'Availability');
$this->validateText($eventGameDescription, 'Description');

if($this->is_valid()){
return true;
}
else{
return false;
}
}


public function validateEventCheckout($eventCheckoutSubtotal, $eventCheckoutTax, $eventCheckoutShipping, $eventCheckoutTotal){

$this->validatePrice($eventCheckoutSubtotal, 'Subtotal Price');
$this->validatePrice($eventCheckoutTax, 'Tax Rate');
$this->validatePrice($eventCheckoutShipping, 'Shipping Rate');
$this->validatePrice($eventCheckoutTotal, 'Total Price');

if($this->is_valid()){
return true;
}
else{
return false;
}

}

public function validateEventSignUpCheckout($eventCheckoutSubtotal, $eventCheckoutTax, $eventCheckoutShipping, $eventCheckoutTotal, $eventCheckoutPaymentMethod){

$this->validatePrice($eventCheckoutSubtotal, 'Subtotal Price');
$this->validatePrice($eventCheckoutTax, 'Tax Rate');
$this->validatePrice($eventCheckoutShipping, 'Shipping Rate');
$this->validatePrice($eventCheckoutTotal, 'Total Price');
$this->validatePaymentMethod($eventCheckoutPaymentMethod, 'Payment Method');

if($this->is_valid()){
return true;
}
else{
return false;
}

}

public function validateFreeplayRegister($freeplayName, $freeplayEmail, $freeplayPhoneCode, $freeplayPhoneNumber, $freeplayDOB, $freeplayGuardianName, $freeplayAddress, $freeplayZip){

$this->validateName($freeplayName, 'Name');
$this->validateEmail($freeplayEmail, 'Email');
$this->validatePhoneCode($freeplayPhoneCode, 'Phone Code');
$this->validatePhoneNumber($freeplayPhoneNumber, 'Phone Number');
$this->validateDate($freeplayDOB, 'Date of Birth');
$this->validateName($freeplayGuardianName, 'Guardian Name');
$this->validateAddress($freeplayAddress, 'Address', true);
$this->validateZipCode($freeplayZip, 'Zip Code');

if($this->is_valid()){
return true;
}
else{
return false;
}


}


//Image Validation Methods

public function validateGameImage($gameImage, $gameImageTemp, $gameImageSize){
$this->validateImage($gameImage, $gameImageTemp, $gameImageSize);
if($this->is_valid()){
return true;
}
else{
return false;
}
}

public function validateCategoryImage($categoryImage, $categoryImageTemp, $categoryImageSize){
$this->validateImage($categoryImage, $categoryImageTemp, $categoryImageSize);
if($this->is_valid()){
return true;
}
else{
return false;
}
}

public function validateAdminImage($adminImage, $adminImageTemp, $adminImageSize){
$this->validateImage($adminImage, $adminImageTemp, $adminImageSize);
if($this->is_valid()){
return true;
}
else{
return false;
}
}

public function validateEventImage($eventImage, $eventImageTemp, $eventImageSize){
$this->validateImage($eventImage, $eventImageTemp, $eventImageSize);
if($this->is_valid()){
return true;
}
else{
return false;
}
}

public function validateConstantUpdate($constantInfoTaxRate, $constantInfoAdminEmail, $constantInfoBaseURL){

$this->validateTaxRate($constantInfoTaxRate, 'Tax Rate');
$this->validateEmail($constantInfoAdminEmail, 'Admin Email');
$this->validateWebsite($constantInfoBaseURL, 'Base URL', true);

if($this->is_valid()){
return true;
}
else{
return false;
}
}

//Generic Field Validation Methods

public function validateName($fieldValue, $fieldName){
$error_msg = '';
if(empty($fieldValue) || $fieldValue == ''){
$error_msg = $fieldName . ' field is required';
$this->validation_errors[] = $error_msg;
$this->error_count += 1;
}
elseif(preg_match('/[\^£$%&*()}{@#~?><>,|=_+¬]/', $fieldValue)){
$error_msg = 'Special characters not allowed in ' . $fieldName . ' field';
$this->validation_errors[] = $error_msg;
$this->error_count += 1; 
}
elseif(strlen($fieldValue) < 1 || strlen($fieldValue) > 64){
$error_msg = $fieldName . ' field length must be between 1 and 64 characters';
$this->validation_errors[] = $error_msg;
$this->error_count += 1;                
}
else{
return false;
}
}

public function validateText($fieldValue, $fieldName){
$error_msg = '';
if(empty($fieldValue) || $fieldValue == ''){
$error_msg = $fieldName . ' field is required';
$this->validation_errors[] = $error_msg;
$this->error_count += 1;
}
elseif(strlen($fieldValue) < 8 || strlen($fieldValue) > 16384){
$error_msg = $fieldName . ' field length must be between 8 and 16384 characters';
$this->validation_errors[] = $error_msg;
$this->error_count += 1;                
}
else{
return false;
}
}

public function validateDate($fieldValue, $fieldName){

$error_msg = '';
if(empty($fieldValue) || $fieldValue == ''){
$error_msg = $fieldName . ' field is required';
$this->validation_errors[] = $error_msg;
$this->error_count += 1;
}
elseif(!preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $fieldValue)){
$error_msg = $fieldName . ' field format is invalid';
$this->validation_errors[] = $error_msg;
$this->error_count += 1; 
}
elseif(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬]/', $fieldValue)){
$error_msg = 'Special characters not allowed in ' . $fieldName . ' field';
$this->validation_errors[] = $error_msg;
$this->error_count += 1; 
}
elseif(strlen($fieldValue) < 8 || strlen($fieldValue) > 10){
$error_msg = $fieldName . ' field length is invalid';
$this->validation_errors[] = $error_msg;
$this->error_count += 1;                
}
else{
return false;
}
}

public function validateEmail($fieldValue, $fieldName){
$error_msg = '';
if(empty($fieldValue) || $fieldValue == ''){
$error_msg = $fieldName . ' field is required';
$this->validation_errors[] = $error_msg;
$this->error_count += 1;
}
elseif(!filter_var($fieldValue, FILTER_VALIDATE_EMAIL)){
$error_msg = $fieldName . ' field format is invalid';
$this->validation_errors[] = $error_msg;
$this->error_count += 1;
}
else{
return false;
}
}

public function validateCode($fieldValue, $fieldName){

$error_msg = '';
if(empty($fieldValue) || $fieldValue == ''){
$error_msg = $fieldName . ' field is required';
$this->validation_errors[] = $error_msg;
$this->error_count += 1;
}
elseif(!preg_match('/^[A-Z0-9]+$/i', $fieldValue)){
$error_msg = $fieldName . ' field format is invalid';
$this->validation_errors[] = $error_msg;
$this->error_count += 1;
}
else{
return false;
}

}

public function validatePhoneCode($fieldValue, $fieldName){
$error_msg = '';
if(empty($fieldValue) || $fieldValue == ''){
$error_msg = $fieldName . ' field is required';
$this->validation_errors[] = $error_msg;
$this->error_count += 1;
}
else{
return false;
}
}

public function validatePhoneNumber($fieldValue, $fieldName){
$error_msg = '';
if(empty($fieldValue) || $fieldValue == ''){
$error_msg = $fieldName . ' field is required';
$this->validation_errors[] = $error_msg;
$this->error_count += 1;
}
elseif(!filter_var($fieldValue, FILTER_SANITIZE_NUMBER_INT)){
$error_msg = $fieldName . ' field format is invalid';
$this->validation_errors[] = $error_msg;
$this->error_count += 1;
}
else{
return false;
}
}

public function validateWebsite($fieldValue, $fieldName, $fieldRequired){
$error_msg = '';
if($fieldRequired){
if(empty($fieldValue) || $fieldValue == ''){
$error_msg = $fieldName . ' field is required';
$this->validation_errors[] = $error_msg;
$this->error_count += 1;
}
}
elseif(!filter_var($fieldValue, FILTER_VALIDATE_URL)){
$error_msg = $fieldName . ' field format is invalid';
$this->validation_errors[] = $error_msg;
$this->error_count += 1;
}
else{
return false;
}
}

public function validateAddress($fieldValue, $fieldName, $fieldRequired){
$error_msg = "";
if($fieldRequired && (empty($fieldValue) || $fieldValue == '')){
$error_msg = $fieldName . " field is required";
$this->validation_errors[] = $error_msg;
$this->error_count += 1;
}
elseif(strlen($fieldValue) > 0 && (strlen($fieldValue) < 8 || strlen($fieldValue) > 256)){
$error_msg = $fieldName . " field length must be between 8 and 256 characters";
$this->validation_errors[] = $error_msg;
$this->error_count += 1;   
}
elseif(preg_match('/[\'^£$%&*()}{@#~?><>|=_+¬-]/', $fieldValue)){
$error_msg = "Special characters not allowed in " . $fieldName . ' field';
$this->validation_errors[] = $error_msg;
$this->error_count += 1; 
}
else{
return false;
}
}

public function validateCity($fieldValue, $fieldName){
$error_msg = "";
if(empty($fieldValue) || $fieldValue == ''){
$error_msg = $fieldName . " field is required";
$this->validation_errors[] = $error_msg;
$this->error_count += 1;
}
elseif(strlen($fieldValue) < 1 || strlen($fieldValue) > 64){
$error_msg = $fieldName . " field length must be between 1 and 64 characters";
$this->validation_errors[] = $error_msg;
$this->error_count += 1;   
}
elseif(preg_match('/[\'^£$%&*()}{@#~?><>|=_+¬-]/', $fieldValue)){
$error_msg = "Special characters not allowed in " . $fieldName . ' field';
$this->validation_errors[] = $error_msg;
$this->error_count += 1; 
}
else{
return false;
}
}

public function validateState($fieldValue, $fieldName){
$error_msg = "";
if(empty($fieldValue) || $fieldValue == ''){
$error_msg = $fieldName . " field is required";
$this->validation_errors[] = $error_msg;
$this->error_count += 1;
}
elseif(strlen($fieldValue) < 2 || strlen($fieldValue) > 2){
$error_msg = $fieldName . " field format is invalid";
$this->validation_errors[] = $error_msg;
$this->error_count += 1;   
}
elseif(preg_match('/[\'^£$%&*()}{@#~?><>|=_+¬-]/', $fieldValue)){
$error_msg = "Special characters not allowed in " . $fieldName . ' field';
$this->validation_errors[] = $error_msg;
$this->error_count += 1; 
}
else{
return false;
}
}

public function validateZipCode($fieldValue, $fieldName){
$error_msg = '';
if(empty($fieldValue) || $fieldValue == ''){
$error_msg = $fieldName . ' field is required';
$this->validation_errors[] = $error_msg;
$this->error_count += 1;
}
elseif(!preg_match('/^[0-9]{5}(-[0-9]{4})?$/', $fieldValue)){
$error_msg = $fieldName . ' field format is invalid';
$this->validation_errors[] = $error_msg;
$this->error_count += 1;
}
else{
return false;
}
}

public function validateCountry($fieldValue, $fieldName){
$error_msg = "";
if(empty($fieldValue) || $fieldValue == ''){
$error_msg = $fieldName . " field is required";
$this->validation_errors[] = $error_msg;
$this->error_count += 1;
}
elseif(strlen($fieldValue) < 2 || strlen($fieldValue) > 2){
$error_msg = $fieldName . " field format is invalid";
$this->validation_errors[] = $error_msg;
$this->error_count += 1;   
}
elseif(preg_match('/[\'^£$%&*()}{@#~?><>|=_+¬-]/', $fieldValue)){
$error_msg = "Special characters not allowed in " . $fieldName . " field";
$this->validation_errors[] = $error_msg;
$this->error_count += 1; 
}
else{
return false;
}
}

public function validateUserID($fieldValue, $fieldName){
$error_msg = "";
if(empty($fieldValue) || $fieldValue == ''){
$error_msg = $fieldName . " field is required";
$this->validation_errors[] = $error_msg;
$this->error_count += 1;
}
elseif(strlen($fieldValue) < 9 || strlen($fieldValue) > 10){
$error_msg = $fieldName . " field length is invalid";
$this->validation_errors[] = $error_msg;
$this->error_count += 1;   
}
elseif(preg_match('/[\'^£$%&*()}{@#~?><>|=_+¬-]/', $fieldValue)){
$error_msg = $fieldName . " field format is invalid";
$this->validation_errors[] = $error_msg;
$this->error_count += 1; 
}
else{
return false;
}
}

public function validatePrice($fieldValue, $fieldName){
$error_msg = "";
if(empty($fieldValue) || $fieldValue == ''){
$error_msg = $fieldName . " field is required";
$this->validation_errors[] = $error_msg;
$this->error_count += 1;
}
elseif(!preg_match('/^[0-9]+(?:\.[0-9]{0,2})?$/', $fieldValue)){
$error_msg = $fieldName . " field format " . $fieldValue . " is invalid";
$this->validation_errors[] = $error_msg;
$this->error_count += 1; 
}
elseif(strlen($fieldValue) < 1 || strlen($fieldValue) > 7){
$error_msg = $fieldName . " field length is invalid";
$this->validation_errors[] = $error_msg;
$this->error_count += 1;   
}
elseif(preg_match('/[\'^£$%&*()}{@#~?><>|=_+¬-]/', $fieldValue)){
$error_msg = "Special characters not allowed in " . $fieldName . " field";
$this->validation_errors[] = $error_msg;
$this->error_count += 1; 
}
else{
return false;
}
}

public function validateTaxRate($fieldValue, $fieldName){
$error_msg = "";
if(empty($fieldValue) || $fieldValue == ''){
$error_msg = $fieldName . " field is required";
$this->validation_errors[] = $error_msg;
$this->error_count += 1;
}
elseif(!preg_match('/^[0-9]+(?:\.[0-9]{0,3})?$/', $fieldValue)){
$error_msg = $fieldName . " field format " . $fieldValue . " is invalid";
$this->validation_errors[] = $error_msg;
$this->error_count += 1; 
}
elseif(strlen($fieldValue) < 1 || strlen($fieldValue) > 7){
$error_msg = $fieldName . " field length is invalid";
$this->validation_errors[] = $error_msg;
$this->error_count += 1;   
}
elseif(preg_match('/[\'^£$%&*()}{@#~?><>|=_+¬-]/', $fieldValue)){
$error_msg = "Special characters not allowed in " . $fieldName . " field";
$this->validation_errors[] = $error_msg;
$this->error_count += 1; 
}
else{
return false;
}
}

public function validateQuantity($fieldValue, $fieldName, $fieldLimit){
$error_msg = "";
if(empty($fieldValue) || $fieldValue == ''){
$error_msg = $fieldName . " field is required";
$this->validation_errors[] = $error_msg;
$this->error_count += 1;
}
elseif(!(preg_match('/^\d+$/', $fieldValue))){
$error_msg = $fieldName . " field format is invalid";
$this->validation_errors[] = $error_msg;
$this->error_count += 1; 
}
elseif(strlen($fieldValue) < 1 || strlen($fieldValue) > 7){
$error_msg = $fieldName . " field length is invalid";
$this->validation_errors[] = $error_msg;
$this->error_count += 1;   
}
elseif($fieldValue < 1 || $fieldValue > $fieldLimit){
$error_msg = $fieldName . " field value limit exceeded";
$this->validation_errors[] = $error_msg;
$this->error_count += 1;   
}
elseif(preg_match('/[\'^£$%&*()}{@#~?><>|=_+¬-]/', $fieldValue)){
$error_msg = "Special characters not allowed in " . $fieldName . " field";
$this->validation_errors[] = $error_msg;
$this->error_count += 1; 
}
else{
return false;
}
}

public function validateDuration($fieldValue, $fieldName){
$error_msg = "";
if(empty($fieldValue) || $fieldValue == ''){
$error_msg = $fieldName . " field is required";
$this->validation_errors[] = $error_msg;
$this->error_count += 1;
}
elseif(!(preg_match('/^\d+$/', $fieldValue))){
$error_msg = $fieldName . " field format is invalid";
$this->validation_errors[] = $error_msg;
$this->error_count += 1; 
}
elseif(strlen($fieldValue) < 1 || strlen($fieldValue) > 3){
$error_msg = $fieldName . " field length is invalid";
$this->validation_errors[] = $error_msg;
$this->error_count += 1;   
}
elseif($fieldValue < 5 || $fieldValue > 60){
$error_msg = $fieldName . " field value limit exceeded";
$this->validation_errors[] = $error_msg;
$this->error_count += 1;   
}
elseif(preg_match('/[\'^£$%&*()}{@#~?><>|=_+¬-]/', $fieldValue)){
$error_msg = "Special characters not allowed in " . $fieldName . " field";
$this->validation_errors[] = $error_msg;
$this->error_count += 1; 
}
else{
return false;
}
}

public function validateSession($fieldValue, $fieldName){
$error_msg = "";
if(empty($fieldValue) || $fieldValue == ''){
$error_msg = $fieldName . " field is required";
$this->validation_errors[] = $error_msg;
$this->error_count += 1;
}
elseif(!(preg_match('/^\d+$/', $fieldValue))){
$error_msg = $fieldName . " field format is invalid";
$this->validation_errors[] = $error_msg;
$this->error_count += 1; 
}
elseif(strlen($fieldValue) < 1 || strlen($fieldValue) > 1){
$error_msg = $fieldName . " field length is invalid";
$this->validation_errors[] = $error_msg;
$this->error_count += 1;   
}
elseif($fieldValue < 1 || $fieldValue > 2){
$error_msg = $fieldName . " field value limit exceeded";
$this->validation_errors[] = $error_msg;
$this->error_count += 1;   
}
elseif(preg_match('/[\'^£$%&*()}{@#~?><>|=_+¬-]/', $fieldValue)){
$error_msg = "Special characters not allowed in " . $fieldName . " field";
$this->validation_errors[] = $error_msg;
$this->error_count += 1; 
}
else{
return false;
}
}

public function validateAvailability($fieldValue, $fieldName){
$error_msg = "";
if(empty($fieldValue) || $fieldValue == ''){
$error_msg = $fieldName . " field is required";
$this->validation_errors[] = $error_msg;
$this->error_count += 1;
}
elseif(!(preg_match('/^\d+$/', $fieldValue))){
$error_msg = $fieldName . " field format is invalid";
$this->validation_errors[] = $error_msg;
$this->error_count += 1; 
}
elseif(strlen($fieldValue) < 1 || strlen($fieldValue) > 1){
$error_msg = $fieldName . " field length is invalid";
$this->validation_errors[] = $error_msg;
$this->error_count += 1;   
}
elseif($fieldValue < 1 || $fieldValue > 2){
$error_msg = $fieldName . " field value limit exceeded";
$this->validation_errors[] = $error_msg;
$this->error_count += 1;   
}
elseif(preg_match('/[\'^£$%&*()}{@#~?><>|=_+¬-]/', $fieldValue)){
$error_msg = "Special characters not allowed in " . $fieldName . " field";
$this->validation_errors[] = $error_msg;
$this->error_count += 1; 
}
else{
return false;
}
}



public function validatePaymentMethod($fieldValue, $fieldName){
$error_msg = '';
if(!isset($fieldValue) || empty($fieldValue) || $fieldValue == ''){
$error_msg = $fieldName . ' field is required';
$this->validation_errors[] = $error_msg;
$this->error_count += 1;
}
elseif($fieldValue < 1){
$error_msg = $fieldName . ' field format is invalid';
$this->validation_errors[] = $error_msg;
$this->error_count += 1;
}
elseif(preg_match('/[\'^£$%&*()}{@#~?><>|=_+¬-]/', $fieldValue)){
$error_msg = "Special characters not allowed in " . $fieldName . " field";
$this->validation_errors[] = $error_msg;
$this->error_count += 1; 
}
else{
return false;
}
}

public function validateImage($fileImage, $fileImageTemp, $fileImageSize){
$error_msg = '';
$allowedFileTypes = array('png', 'jpg');
$fileExtension = pathinfo($fileImage, PATHINFO_EXTENSION);
if(!file_exists($fileImageTemp) || !is_uploaded_file($fileImageTemp) || !($fileImageSize > 0)){
$error_msg = "Image file is required or uploaded file is corrupted";
$this->validation_errors[] = $error_msg;
$this->error_count += 1;
}
elseif(!in_array($fileExtension, $allowedFileTypes)){
$error_msg = "Invalid image file type or format";
$this->validation_errors[] = $error_msg;
$this->error_count += 1;
}
else{
return false;
}
}

public function validatePassword($fieldValue, $fieldName, $fieldRole){
$error_msg = '';
if(!isset($fieldValue) || empty($fieldValue) || $fieldValue == ''){
$error_msg = $fieldName . ' field is required';
$this->validation_errors[] = $error_msg;
$this->error_count += 1;
}
elseif(strlen($fieldValue) < 8){
$error_msg = $fieldName . " should be alteast 8 characters in length";
$this->validation_errors[] = $error_msg;
$this->error_count += 1;   
}
elseif($fieldRole == 1){
if(!preg_match("#[0-9]+#", $fieldValue)){
$error_msg = $fieldName . " must contain atleast 1 digit";
$this->validation_errors[] = $error_msg;
$this->error_count += 1;  
}
elseif(!preg_match("#[A-Z]+#", $fieldValue)) {
$error_msg = $fieldName . " must contain at least 1 uppercase letter";
$this->validation_errors[] = $error_msg;
$this->error_count += 1; 
}
elseif(!preg_match("#[a-z]+#", $fieldValue)) {
$error_msg = $fieldName . " must contain at least 1 lowercase letter";
$this->validation_errors[] = $error_msg;
$this->error_count += 1; 
}
}
else{
return false;
}
}

public function is_valid(){
if($this->error_count == 0 && empty($this->validation_errors)){
return true;
}
else{
return false;
}
}

public function get_errors(){
return $this->validation_errors;
}

}
?>