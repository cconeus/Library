<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Author.php";
    require_once "src/Books.php";
    require_once "src/Patron.php";

    $server = 'mysql:host=localhost:8889;dbname=Library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BooksTest extends PHPUnit_Framework_TestCase
    {

    }
 ?>
