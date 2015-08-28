<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Author.php";

    $server = 'mysql:host=localhost:8889;dbname=Library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class AuthorTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Author::deleteAll();
        }

        function testSave()
        {
            //Arrange
            $id = 1;
            $author_1 = "Michael Bennet";
            $test_author = new Author($id, $author_1);

            //Act
            $test_author->save();

            //Assert
            $result = Author::getAll();
            $this->assertEquals($test_author, $result[0]);
        }

        function testGetAll()
        {
            $id = 1;
            $author_1 = "Michael Bennet";
            $test_author = new Author($id, $author_1);
            $test_author->save();

            $id2 = 1;
            $author_12 = "Author 12";
            $test_author2 = new Author($id2, $author_12);
            $test_author2->save();

            $result = Author::getAll();

            $this->assertEquals([$test_author, $test_author2], $result);
        }
    }
 ?>
