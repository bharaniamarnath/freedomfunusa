<?php

include_once(__DIR__ . '/../../models/oauth_model.php');

class DB {

public function is_token_empty() {
$oauth = new OAuthModel();
$result = $oauth->getOATData('google');
if($result) {
return false;
}

return true;
}

public function get_refresh_token(){
$oauth = new OAuthModel();
$result = $oauth->getOATData('google');
if($result) {
return $result['provider_value'];
}
}

public function update_refresh_token($token) {
$oauth = new OAuthModel();
if($this->is_token_empty()) {
$oauth->insOATData('google', $token);
} else {
$oauth->setOATData('google', $token);
}
}
}