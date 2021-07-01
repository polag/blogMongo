<?php
namespace DataHandle;

use \DataHandle\Utils\InputSanitize;

abstract class FormHandle
{
    //use \DataHandle\Utils\InputSanitize;
    abstract protected static function sanitize($fields);
    abstract public static function createPost($form_data, $loggedInUserId);
    abstract public static function selectPost($id = null, $userId = null);
    //abstract public static function deletePost($id = null, $userId);
    abstract public static function updatePost($form_data, $id, $userId);
  
}