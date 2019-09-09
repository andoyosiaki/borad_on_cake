<?php
namespace App\Model\Validation;
use Cake\Validation\Validation;

class CustomValidation extends Validation {

  public static function postal_codeCustom($check) {
    return (bool) preg_match("/^[a-zA-Z0-9]+$/",$check);
  }
}
