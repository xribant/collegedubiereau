<?php

namespace App\Service;

class PasswordGenerator 
{
    public function getRandomBytes($nbBytes = 32)
    {
        $bytes = openssl_random_pseudo_bytes($nbBytes, $strong);
        if (false !== $bytes && true === $strong) {
            return $bytes;
        }
        else {
            throw new \Exception("Unable to generate secure token from OpenSSL.");
        }
    }

    public function generatePassword($length): string
    {
        return substr(preg_replace("/[^a-zA-Z0-9]/", "", base64_encode($this->getRandomBytes($length+1))),0,$length);
    }
}

