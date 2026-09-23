<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/defuse-crypto.phar');

use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;

class Encryption
{

    public function __construct($plain_val)
    {

        // *** COPY THIS FILE INSIDE PROJECT FOLDER TO EXECUTE WHERE COMPOSER AND NECESSARY LIBRARIES ARE INSTALLED *** //

        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/');
        $dotenv->load();
        echo ' || ENC_KEY: ';
        echo $_ENV['DB_ENC_KEY'];

        $db_enc_key = Key::loadFromAsciiSafeString($_ENV['DB_ENC_KEY']);

        $plain_val_enc = Crypto::encrypt($plain_val, $db_enc_key);

        echo ' || ORIG_VAL: ' . $plain_val . ' || ENC_VAL: ';
        echo $plain_val_enc;
        echo ' || END <br>';

        /* $db_name_enc = $_ENV['DB_NAME_ENC'];
        try{
        $db_name_dec = Crypto::decrypt($db_name_enc, $db_enc_key);
        echo "\nDEC_VAL: " . $db_name_dec;
        }catch(\Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException $ex) {
        die($ex->getMessage());
        } */
    }
}

//Define below variable with value to be encrypted
//Or call this class in any external file and pass the text to be encrypted as parameter

new Encryption("freedomfunusa");
