<?php

namespace DataHandle;

require_once __DIR__ . '/db.php';

use \DataHandle\Utils\InputSanitize;
use Mysqli;
use Exception;

class User
{
    use \DataHandle\Utils\InputSanitize;
    public static function sanitize($fields)
    {
        $errors        = array();
        $fields['username'] = self::cleanInput($fields['username']);
        $fields['firstname'] = self::cleanInput($fields['firstname']);
        $fields['lastname'] = self::cleanInput($fields['lastname']);
        // Sanificare numero di telefono e verificarne la validità
        $fields['phone'] = self::cleanInput($fields['phone']);
        if (self::isPhoneNumberValid($fields['phone']) === 0) {
            $errors[] = new Exception('Phone number not valid.');
        }


        // Sanificare email e verificarne la validità
        if (isset($fields['email']) && $fields['email'] !== '') {
            $fields['email'] = self::cleanInput($fields['email']);
            if (!self::isEmailAddressValid($fields['email'])) {
                $errors[] = new Exception('E-mail address not valid.');
            }
        }



        if (count($errors) > 0) {
            return $errors;
        }

        return $fields;
    }



    public static function registerUser($form_data)
    {

        $fields = array(
            'username'        => $form_data['username'],
            'password'        => $form_data['password'],
            'password-check'  => $form_data['password-check'],
            'firstname'        => $form_data['firstname'],
            'lastname'        => $form_data['lastname'],
            'phone'        => $form_data['phone'],
            'email'        => $form_data['email'],
        );

        $fields = self::sanitize($fields);
        $avatarId = rand(1,50);
        $avatar = 'https://robohash.org/'.$avatarId; 

        if ($fields[0] instanceof Exception) {
            $error_messages = '';
            foreach ($fields as $key => $error) {
                $error_messages .= $error->getMessage();
                if ($key < count($fields) - 1) {
                    $error_messages .= '|';
                }
            }
            header('Location: https://localhost/blogMongo/login.php?statoreg=errore&messages='
                . $error_messages);
            exit;
        }
        if ($fields['password'] !== $fields['password-check']) {
            header('Location: https://localhost/blogMongo/login?statoreg=errore&messages=Passwords are different');
            exit;
        }

        global $client;
        $collection = $client->blog->user;
        
        //check if username already exists
        $username = $collection->findOne(array(
            'username' => $fields['username'] 
        ));
           

        if ($username != null) {
            header('Location: https://localhost/blogMongo/login.php?statoreg=errore&messages=Username already in use');
            exit;
        }
        
        //check if email already registered
        $email = $collection->findOne(array(
            'email' => $fields['email'] 
        ));
        
        
        if ($email != null) {
            header('Location: https://localhost/blogMongo/login.php?statoreg=errore&messages=Email already registered. Do you want to <a href="/blog/login.php"> LOG IN </a> instead?');
            exit;
        }

        $new_user = $collection->insertOne(array(
            'username'=>$fields['username'],
            'firstname' =>$fields['firstname'],
            'lastname' => $fields['lastname'],
            'email'=>$fields['email'],
            'phone' =>$fields['phone'],
            'password' => md5($fields['password']),
            'avatar' => $avatar,
            'posts_id'=>array()
        ));

    

        if ($new_user->getInsertedCount() === 0) {
            error_log('Error MongoDB');
            header('Location: https://localhost/blogMongo/login.php?statoreg=ko');
            exit;
        }

        header('Location: https://localhost/blogMongo/login.php?statoreg=ok');
        exit;
    }

    public static function loginUser($form_data)
    {

        $fields = array(
            'username'  => $form_data['username'],
            'password'  => $form_data['password']
        );



        global $client;
        $collection = $client->blog->user;

        $user = $collection->findOne(array(
            'username' => $fields['username'] 
        ));

        if ($user == null) {
            header("Location: https://localhost/blogMongo/login.php?statologin=errore&messages=User doesn't exist");
            exit;
        }

        

        if ($user['password'] !== md5($fields['password'])) {
            header('Location: https://localhost/blogMongo/login.php?statologin=errore&messages=Wrong password');
            exit;
        }

        return array(
            'id'  => (string)$user['_id'],
            'username' => $user['username']
        );
    }

    public static function deleteUser($userId)
    {
        global $mysqli;
        $userId = intval($userId);
        $query = $mysqli->prepare('DELETE FROM user WHERE id = ?');
        $query->bind_param('i', $userId);
        $query->execute();

        if ($query->affected_rows > 0) {
            session_destroy();
            unset($_SESSION['username']);
            header('Location: https://localhost/blog/login.php?logout=1');
            exit;
        } else {
            //var_dump($query);
            header('Location: https://localhost/blog/profile.php=stato=ko');
            exit;
        }
    }

    public static function selectUser($userId)
    {
        global $mysqli;

        $query_user = $mysqli->query("SELECT * FROM user WHERE id = " . $userId);
        $user = $query_user->fetch_assoc();
        return $user;
    }
    public static function updateUser($form_data, $userId)
    {

        $fields = array(
            'username'        => $form_data['username'],
            'firstname'        => $form_data['firstname'],
            'lastname'        => $form_data['lastname'],
            'phone'        => $form_data['phone'],
            'email'        => $form_data['email'],
            'image'        => $form_data['image'],
            'bio'        => $form_data['bio'],
        );

        if ($fields) {
            global $mysqli;
            $query = $mysqli->prepare('UPDATE user SET username = ?, firstname = ?, lastname = ?, phone = ?, email = ?, image = ?, bio = ? WHERE id = ? ');

            $query->bind_param('sssssssi', $fields['username'], $fields['firstname'], $fields['lastname'], $fields['phone'], $fields['email'], $fields['image'], $fields['bio'], $userId);
            $query->execute();


            if ($query->affected_rows > 0) {
                header('Location: https://localhost/blog/profile.php?id=' . $userId . '&stato=ok');
                exit;
            } else {
                header('Location: https://localhost/blog/profile.php?id=' . $userId . '&stato=ko');
                exit;
            }
        }
    }
    public static function updatePassword($password, $newPassword, $userId){
        global $mysqli;
            $query = $mysqli->prepare('UPDATE user SET password = ? WHERE id = ? AND password = ?');

            $query->bind_param('sis', md5($newPassword), $userId, md5($password));
            $query->execute();


            if ($query->affected_rows > 0) {
                header('Location: https://localhost/blog/profile.php?id=' . $userId . '&stato=ok');
                exit;
            } else {
                header('Location: https://localhost/blog/profile.php?id=' . $userId . '&stato=ko&message=Incorrect Password');
                exit;
            }
    }
}
