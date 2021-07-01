<?php
namespace DataHandle\Utils;


function show_alert($action_type, $state)
{
    if ($state === 'ko') {
      echo '<div class="alert alert-danger" role="alert">Please try again later.</div>';
      return false;
    }

    if ($state === "errore") {
      echo '<div class="alert alert-danger" role="alert"><ul>';
      $error_messages = explode('|', $_GET['messages']);
      foreach ($error_messages as $error) {
          echo "<li>$error</li>";
      }
      echo '</ul></div>';
    }

    if($state === 'ok'){
      if(($action_type == 'registration')||($action_type == 'login')) {
        echo '<div class="alert alert-success" role="alert">'.ucfirst($action_type).' succesfull!</div>';
      }
     else{
        echo '<div class="alert alert-success" role="alert">Your post has been succesfully '.strtolower($action_type).'</div>';

      }
    }

    
}

trait InputSanitize
{
    public static function cleanInput($data)
    {
        $data = trim($data);
        $data = filter_var($data, FILTER_SANITIZE_ADD_SLASHES);
        $data = filter_var($data, FILTER_SANITIZE_SPECIAL_CHARS);
        return $data;
    }
    public static function isPhoneNumberValid($phone_number)
    {
         return preg_match('/^([\+][0-9]{2,3})?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/', $phone_number);
    }
    public static function isEmailAddressValid($email_address)
    {
        // return preg_match('/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/i', $email_address);
        return filter_var($email_address, FILTER_VALIDATE_EMAIL);
    }


}
