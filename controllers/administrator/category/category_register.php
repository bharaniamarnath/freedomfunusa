<?php
ob_start();

include_once(__DIR__ . '/../../../models/category_model.php');
include_once(__DIR__ . '/../../../models/validation_model.php');
include_once(__DIR__ . '/../../../models/content_model.php');
include_once(__DIR__.'/../../../application/sendmail.php');

if(isset($_POST['categoryRegisterSubmit'])){

$categoryName = trim(htmlspecialchars($_POST['categoryName']));
$categoryEvent = trim(htmlspecialchars($_POST['categoryEvent']));
$categoryDescription = trim(htmlentities($_POST['categoryDescription']));

$categoryImage = $_FILES["categoryProfileImage"]["name"];
$categoryImageTemp = $_FILES["categoryProfileImage"]["tmp_name"];
$categoryImageSize = $_FILES["categoryProfileImage"]["size"];

$validationModel = new ValidationModel();

$validateCategoryRegister = $validationModel->validateCategoryRegister($categoryName, $categoryEvent, $categoryDescription);

if(!($validateCategoryRegister)){
$validation_errors = $validationModel->get_errors();
$res = array("err" => 1, "msg" => implode(', ', $validation_errors));
echo json_encode($res);
}
else{
try{
$categoryModel = new CategoryModel();
$checkCategoryExists = $categoryModel->checkCategoryExists($categoryName);
if($checkCategoryExists){
$res = array("err" => 1, "msg" => "Category with name already exists");
echo json_encode($res);
}
else{
$categoryUserID = getCategoryUserID();
if($categoryUserID == false){
$res = array("err" => 1, "msg" => "Maximum ID limit reached");
echo json_encode($res);
}
else{
$registerCategory = $categoryModel->registerCategory($categoryUserID, $categoryName, $categoryEvent, $categoryDescription);
if($registerCategory){

//Validate and Upload Image
if($categoryImageSize > 0){
$validationModel = new ValidationModel();
$validateCategoryImage = $validationModel->validateCategoryImage($categoryImage, $categoryImageTemp, $categoryImageSize);
if(!($validateCategoryImage)){
$validation_errors = $validationModel->get_errors();
$res = array("err" => 1, "msg" => implode(', ', $validation_errors));
echo json_encode($res);
}
else{
try{
uploadImage($categoryImage, $categoryImageTemp, $categoryUserID);
}
catch(Exception $e){
$res = array("err" => 1, "msg" => "Error occured. Unable to upload profile image.");
echo json_encode($res);
}
}
}

$res = array("err" => 0, "msg" => "Category created successfully");
echo json_encode($res);
}
else{
$res = array("err" => 1, "msg" => "Error occured. Unable to create category profile.");
echo json_encode($res);
}
}
}
}
catch (PDOException $e){
$res = array("err" => 1, "msg" => "Error in database connection: " . $e->getMessage());
echo json_encode($res);
}
}
}
else{
$res = array("err" => 1, "msg" => "Invalid form submission");
echo json_encode($res);
}

function uploadImage($categoryImage, $categoryImageTemp, $categoryUserID){
$categoryImagePath = pathinfo($categoryImage);
$categoryImageFileType = $categoryImagePath['extension'];
$targetDir = __DIR__."/../../../public/assets/images/category/";
$categoryImageFile = strtolower(str_replace(" ", "_", $categoryUserID) . "." . $categoryImageFileType);
$targetFile = $targetDir . $categoryImageFile;
move_uploaded_file($categoryImageTemp, $targetFile);
//Add Image File Name to Database
$categoryModel = new CategoryModel();
$categoryModel->updateCategoryImage($categoryImageFile, $categoryUserID);
}

function getCategoryUserID(){
$min = 11111;
$max = 99999;
$categoryUID = generateCategoryUserID($min, $max);
$categoryModel = new CategoryModel();
if($categoryModel->getTotalCategories() < (($max - $min) + 1)){
do{
$categoryUID = generateCategoryUserID($min, $max);
if($categoryModel->checkUID($categoryUID) == false){
return $categoryUID;
break;
}
}while($categoryModel->checkUID($categoryUID) == true && $dne == 0);
}
else{
return false;
}
}

//Generate UID
function generateCategoryUserID($min, $max){
$categoryUID = 'FFEC' . rand($min, $max);
return $categoryUID;
}

ob_end_flush();

?>