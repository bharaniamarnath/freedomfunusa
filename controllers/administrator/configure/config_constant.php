<?php
ob_start();

include_once(__DIR__ . '/../../../models/validation_model.php');
include_once(__DIR__ . '/../../../models/misc_model.php');
include_once(__DIR__.'/../../../application/sendmail.php');

if(isset($_POST['adminConstantInfoSubmit'])){

$constantInfoTaxRate = trim(htmlspecialchars($_POST['constantInfoTaxRate']));
$constantInfoAdminEmail = trim(htmlspecialchars($_POST['constantInfoAdminEmail']));
$constantInfoBaseURL = trim(htmlentities($_POST['constantInfoBaseURL']));

$validationModel = new ValidationModel();

$validateconstantUpdate = $validationModel->validateConstantUpdate($constantInfoTaxRate, $constantInfoAdminEmail, $constantInfoBaseURL);

if(!($validateconstantUpdate)){
$validation_errors = $validationModel->get_errors();
$res = array("err" => 1, "msg" => implode(', ', $validation_errors));
echo json_encode($res);
}
else{
try{
$constantInfoParams = array(
"tax_rate" => number_format($constantInfoTaxRate, 3, '.', ','),
"admin_email" => $constantInfoAdminEmail,
"base_url" => $constantInfoBaseURL,
);
$miscModel = new MiscModel();
$updateconstant = $miscModel->updateConstantInfo($constantInfoParams);
if($updateconstant){
$res = array("err" => 0, "msg" => "Constants updated successfully");
echo json_encode($res);
}
else{
$res = array("err" => 1, "msg" => "Error occured. Unable to update constant profile.");
echo json_encode($res);
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


ob_end_flush();

?>