<?php
namespace DataHandle;

use \DataHandle\Utils\InputSanitize;

abstract class FormHandle
{
    //use \DataHandle\Utils\InputSanitize;
    abstract public static function createPost($form_data, $loggedInUserId);
    //abstract public static function createPost($form_data);

    abstract public static function selectPost($id = null, $userId = null);
    abstract public static function deletePost($userId, $id = null);
    abstract public static function updatePost($form_data, $id, $userId);
  
}