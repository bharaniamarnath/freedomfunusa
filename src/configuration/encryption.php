<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/defuse-crypto.phar');

use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;

// *** COPY THIS FILE INSIDE PROJECT FOLDER TO EXECUTE WHERE COMPOSER AND NECESSARY LIBRARIES ARE INSTALLED *** //

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/');
$dotenv->load();
echo ' || ENC_KEY: ';
echo $_ENV['FF_DB_ENC_KEY'];

$ff_db_enc_key = Key::loadFromAsciiSafeString($_ENV['FF_DB_ENC_KEY']);

//Define below variable with value to be encrypted

$db_val = 'db';

$db_val_enc = Crypto::encrypt($db_val, $ff_db_enc_key);

echo ' || ORIG_VAL: ' . $db_val . ' || ENC_VAL: ';
echo $db_val_enc;
echo ' || END > ';

/* $db_name_enc = $_ENV['FFSC_DB_NAME_ENC'];
try{
$db_name_dec = Crypto::decrypt($db_name_enc, $db_enc_key);
echo "\nDEC_VAL: " . $db_name_dec;
}catch(\Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException $ex) {
die($ex->getMessage());
} */
