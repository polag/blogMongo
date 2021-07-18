<?php
require_once __DIR__.'/../vendor/autoload.php';

 $client = new MongoDB\Client(

    
    //"mongodb://127.0.0.1:27017/?compressors=disabled&gssapiServiceName=mongodb"
   "mongodb+srv://paula:luna12182@cluster0.bsigg.mongodb.net/todo?retryWrites=true&w=majority"
   
);
