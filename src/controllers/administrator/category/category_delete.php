<?php
ob_start();

include_once(__DIR__ . '/../../../models/category_model.php');

if(isset($_POST['categoryUID']) && !empty($_POST['categoryUID'])){

$categoryUID = trim(htmlspecialchars($_POST['categoryUID']));


if($categoryUID == ''){
$res = array("err" => 1, "msg" => "Unable to get category ID");
echo json_encode($res);
}
else{
try{
$categoryModel = new CategoryModel();
$checkCategoryUID = $categoryModel->checkUID($categoryUID);
if($checkCategoryUID){
$deleteCategory = $categoryModel->deleteCategory($categoryUID);
if($deleteCategory){
$res = array("err" => 0, "msg" => "Category deleted successfully");
echo json_encode($res);
}
else{
$res = array("err" => 1, "msg" => "Unable to delete category from records");
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
$res = array("err" => 1, "msg" => "Unable to get category ID");
echo json_encode($res);
}

ob_end_flush();

?>