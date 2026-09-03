<?php
ob_start();

include_once(__DIR__ . '/../../../models/category_model.php');
include_once(__DIR__ . '/../../../models/validation_model.php');
include_once(__DIR__ . '/../../../models/content_model.php');
include_once(__DIR__.'/../../../application/sendmail.php');

if(isset($_POST['categoryEditSubmit'])){

$categoryName = trim(htmlspecialchars($_POST['categoryName']));
$categoryEvent = trim(htmlspecialchars($_POST['categoryEvent']));
$categoryDescription = trim(htmlentities($_POST['categoryDescription']));
$categoryUserID = trim(htmlspecialchars($_POST['categoryUID']));

$categoryImage = $_FILES["categoryProfileImage"]["name"];
$categoryImageTemp = $_FILES["categoryProfileImage"]["tmp_name"];
$categoryImageSize = $_FILES["categoryProfileImage"]["size"];

$validationModel = new ValidationModel();

$validateCategoryUpdate = $validationModel->validateCategoryUpdate($categoryName, $categoryEvent, $categoryDescription);

if(!($validateCategoryUpdate)){
$validation_errors = $validationModel->get_errors();
$res = array("err" => 1, "msg" => implode(', ', $validation_errors));
echo json_encode($res);
}
else{
try{
$categoryModel = new CategoryModel();
$checkCategoryExists = $categoryModel->checkUID($categoryUserID);
if(!$checkCategoryExists){
$res = array("err" => 1, "msg" => "Update failed. Category not found in the records.");
echo json_encode($res);
}
else{
$updateCategory = $categoryModel->updateCategory($categoryUserID, $categoryName, $categoryEvent, $categoryDescription);
if($updateCategory){
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
$res = array("err" => 0, "msg" => "Category updated successfully");
echo json_encode($res);
}
else{
$res = array("err" => 1, "msg" => "Error occured. Unable to update category profile.");
echo json_encode($res);
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
$categoryImageFile = strtolower(str_replace(" ", "_", $categoryUserID) . "." . $categoryImageFileType);
$targetDir = __DIR__."/../../../public/assets/images/category/";
$targetFile = $targetDir . $categoryImageFile;
move_uploaded_file($categoryImageTemp, $targetFile);
//Add Image File Name to Database
$categoryModel = new CategoryModel();
$categoryModel->updateCategoryImage($categoryImageFile, $categoryUserID);
}


ob_end_flush();

?>