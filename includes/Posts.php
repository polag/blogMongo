<?php

namespace DataHandle;

require_once __DIR__ . '/db.php';

use DateTime;
use Mysqli;
use Exception;
use MongoDB;

class Posts extends FormHandle
{
    public static function createPost($form_data, $loggedInUserId)
    //public static function createPost($form_data)
    {
        $date_time = date('Y-m-d');
        if (isset($form_data['publish'])) {
            $publish = 1;
            $published_date = $date_time;
        } else {
            $publish = 0;
            $published_date = null;
        }

        $fields = array(
            'title'          => $form_data['title'],
            'content'       => $form_data['content'],
            'summary'       => $form_data['summary'],
            'image'          => $form_data['image']


        );


        if ($fields) {

            global $client;
            $collection = $client->blog->post;

            $new_post = $collection->insertOne(array(
                'title' => $fields['title'],
                'content' => $fields['content'],
                'summary' => $fields['summary'],
                'image' => $fields['image'],
                'published_at' => $published_date,
                'published' => $publish,
                'creation_date' => $date_time

                // 'author_id' => $loggedInUserId

            ));

            if ($new_post->getInsertedCount() === 0) {
                error_log('Errore MongoDB ');
                header('Location: https://localhost/blogMongo/create-post.php?stato=ko');
                exit;
            }

            $post_id = (string)$new_post->getInsertedId();
            $collection_user = $client->blog->user;
            $new_post_user = $collection_user->updateOne(
                array('_id' => new MongoDB\BSON\ObjectId($loggedInUserId)),
                array('$push' => ['posts_id' => $post_id])
            );

            if ($new_post_user->getModifiedCount() === 0) {
                error_log('Errore MongoDB ');
                header('Location: https://localhost/blogMongo/create-post.php?stato=ko');
                exit;
            }


            header('Location: https://localhost/blogMongo/create-post.php?stato=ok');
            exit;
        }
    }

    public static function selectPost($id = null, $userId = null)
    {
        global $client;
        $collection = $client->blog->post;
        $collection_user = $client->blog->user;
        $results = array();

        if ($id and !$userId) {
            $post = $collection->findOne(array(
                '_id' => new MongoDB\BSON\ObjectId($id)
            ));
            $author = $collection_user->findOne(['posts_id' => $id]);
            $post = iterator_to_array($post);
            $post['id'] = $id;
            $author = iterator_to_array($author);

            $results = array_merge($post, $author);
        } elseif ($userId and !$id) {
            $author = $collection_user->find(array(
                '_id' => new MongoDB\BSON\ObjectId($userId)
            ));
            $author = iterator_to_array($author);
            $author = iterator_to_array($author[0]);
            $posts_id = iterator_to_array($author['posts_id']);
            $count = count($posts_id);
            $results[0] = $author;
            for ($i = 1; $i <= $count; $i++) {
                $post = $collection->findOne(array(
                    '_id' => new MongoDB\BSON\ObjectId($posts_id[$i - 1])
                ));
                if (isset($post)) {
                    $post = iterator_to_array($post);

                    $post['id'] = $posts_id[$i - 1];
                    $results[$i] = $post;
                }
            }
        } elseif ($userId and $id) { //findOne
            $post = $collection->findOne(array(
                '_id' => new MongoDB\BSON\ObjectId($id)
            ));
            $author = $collection_user->findOne(['posts_id' => $id]);
            $post = iterator_to_array($post);
            $post['id'] = $id;
            $author = iterator_to_array($author);

            $results = array_merge($post, $author);
        } else {


            $posts = $collection->find(array('published' => 1));

            if (isset($posts)) {
                foreach ($posts as $post) {
                    $id = (string)new MongoDB\BSON\ObjectId($post['_id']);

                    $author = $collection_user->findOne(['posts_id' => $id]);
                    $post = iterator_to_array($post);
                    $post['id'] = $id;
                    $author = iterator_to_array($author);
                    $results[] = array_merge($post, $author);
                }
            }
        }
        return $results;
    }

    public static function updatePost($form_data, $id, $userId)
    {
        $fields = array(
            'title'          => $form_data['title'],
            'content'       => $form_data['content'],
            'summary'       => $form_data['summary'],
            'image'          => $form_data['image']

        );

        if ($fields) {

            $is_in_error = false;

            global $client;
            $collection = $client->blog->post;

            try {

                $update_post = $collection->updateOne(
                    array('_id' => new MongoDB\BSON\ObjectId($id)),
                    array(
                        '$set' => [
                            'title' => $fields['title'],
                            'content' => $fields['content'],
                            'summary' => $fields['summary'],
                            'image' => $fields['image'],
                        ]
                    )
                );
            } catch (Exception $e) {
                error_log("Errore PHP in linea {$e->getLine()}: " . $e->getMessage() . "\n", 3, 'my-errors.log');
            }


            if ($update_post->getModifiedCount() == 0) {

                $is_in_error = true;

                header('Location: https://localhost/blogMongo/manage-post.php?id=' . $id . '&stato=ko');
                exit;
            }


            $stato = $is_in_error ? 'ko' : 'ok';
            header('Location: https://localhost/blogMongo/manage-post.php?id=' . $id . '&stato=' . $stato . '&update=1');
            exit;
        }
    }
    public static function deletePost($userId, $id = null)
    {



        global $client;
        $collection = $client->blog->post;
        $collection_user = $client->blog->user;


        $is_in_error = false;

        if ($id) {

            try {
                $risultatoCancellazione = $collection->deleteOne(array('_id' => new MongoDB\BSON\ObjectId($id)));

                if ($risultatoCancellazione->getDeletedCount() == 0) {
                    $is_in_error = true;
                    throw new Exception('Query non valida.');
                }
                $risultatoCancellazione = $collection_user->updateOne(
                    array('_id' => new MongoDB\BSON\ObjectId($userId)),
                    array('$pull' => [
                        'posts_id' => $id
                    ])
                );
            } catch (Exception $e) {
                error_log("Errore PHP in linea {$e->getLine()}: " . $e->getMessage() . "\n", 3, 'my-errors.log');
            }


            $stato = $is_in_error ? 'ko' : 'ok';
            header('Location: https://localhost/blogMongo/manage-post.php?id=' . $id . '&stato=' . $stato . '&delete=1');
            exit;
        } else {
            try {
                $author = $collection_user->find(array(
                    '_id' => new MongoDB\BSON\ObjectId($userId)
                ));
                $author = iterator_to_array($author);
                $author = iterator_to_array($author[0]);
                $posts_id = iterator_to_array($author['posts_id']);
                $count = count($posts_id);

                for ($i = 0; $i < $count; $i++) {
                    $risultatoCancellazione = $collection->deleteOne(
                        array('_id' => new MongoDB\BSON\ObjectId($posts_id[$i]))
                    );
                    if ($risultatoCancellazione->getDeletedCount() == 0) {
                        $is_in_error = true;
                        throw new Exception('Query non valida.');
                    }
                }

                $user_deleteIds = $collection_user->updateOne(
                    array('_id' => new MongoDB\BSON\ObjectId($userId)),
                    array('$unset' => [
                        'posts_id' => ''
                    ])
                );
            } catch (Exception $e) {
                error_log("Errore PHP in linea {$e->getLine()}: " . $e->getMessage() . "\n", 3, 'my-errors.log');
            }


            $stato = $is_in_error ? 'ko' : 'ok';
            header('Location: https://localhost/blogMongo/index.php?id=' . $id . '&stato=' . $stato . '&delete=1');
            exit;
        }
    }
    public static function publishPost($publish, $id, $userId)
    {
        global $client;
        $collection = $client->blog->post;

        $update_post = $collection->updateOne(
            array('_id' => new MongoDB\BSON\ObjectId($id)),
            array('$set' => ['published' => $publish])
        );

        header('Location: https://localhost/blogMongo/manage-post.php?stato=ok&publish=' . $publish);
        exit;
    }
}
