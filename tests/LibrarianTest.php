<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Librarian.php";
    require_once "src/Patron.php";

    $server = 'mysql:host=localhost:8889;dbname=to_do_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class LibrarianTest extends PHPUnit_Framework_TestCase
    {

    }
 ?>
