<?php
class MethodsModel{

public function sanitizeGet($input){
if($input == '' || empty($input) || $input == null){
return '';
}
else{
$sanitized = trim($input);
$sanitized = htmlspecialchars_decode($sanitized);
return $sanitized;
}
}

public function sanitizeSet($input){
if($input == '' || empty($input) || $input == null){
return '';
}
else{
$sanitized = trim($input);
$sanitized = htmlspecialchars($sanitized);
return $sanitized;
}
}

}
?>