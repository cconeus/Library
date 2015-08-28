<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Author.php";
    require_once "src/Book.php";
    require_once "src/Patron.php";

    $server = 'mysql:host=localhost:8889;dbname=Library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class AuthorTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Book::deleteAll();
            Author::deleteAll();
        }

        function testGetAuthor_1()
        {
            $author_1 = "Michael Bennet";
            $test_author = new Author($id, $author_1);

            $result = $test_author->getAuthor_1();

            $this->assertEquals($author_1, $result);
        }

        function testSetAuthor_1()
        {
            $author_1 = "Michael Bennet";
            $test_author = new Author($id, $author_1);

            $test_author->setAuthor_1("Franklin");
            $result = $test_author->getAuthor_1();

            $this->assertEquals("Franklin", $result);
        }

        function testGetId()
        {
            $id = 1;
            $author_1 = "Michael Bennet";
            $test_author = new Author($id, $author_1);

            $result = $test_author->getId();

            $this->assertEquals(1, $result);
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

            $id2 = 2;
            $author_12 = "Michael Bennet";
            $test_author2 = new Author($id2, $author_12);
            $test_author2->save();

            $result = Author::getAll();

            $this->assertEquals([$test_author, $test_author2], $result);
        }

        function testDeleteAll()
        {
            $id = 1;
            $author_1 = "Michael Bennet";
            $test_author = new Author($id, $author_1);
            $test_author->save();

            $id2 = 2;
            $author_12 = "Sir Hampton the Meek";
            $test_author2 = new Author($id2, $author_12);
            $test_author2->save();

            Author::deleteAll();

            $result = Author::getAll();
            $this->assertEquals([], $result);
        }

        function testFind()
        {
            $id = 1;
            $author_1 = "Michael Bennet";
            $test_author = new Author($id, $author_1);
            $test_author->save();

            $id2 = 2;
            $author_12 = "Michael Bennet";
            $test_author2 = new Author($id2, $author_12);
            $test_author2->save();

            $result = Author::find($test_author->getId());

            $this->assertEquals($test_author, $result);
        }

        function testDelete()
        {
            $id = 1;
            $title = "Moby Dick";
            $synopsis = "A thrilling tale of whale hunting adventures";
            $test_book = new Book($id, $title, $synopsis);
            $test_book->save();

            $id2 = 2;
            $author_1 = "Michael Bennet";
            $test_author = new Author($id2, $author_1);
            $test_author->save();

            $test_author->addBook($test_book);
            $test_author->delete();

            $this->assertEquals([], $test_book->getAuthors());
        }

        function testAddBook()
        {
            $id = null;
            $title = "Moby Dick";
            $synopsis = "A thrilling tale of whale hunting adventures";
            $test_book = new Book($id, $title, $synopsis);
            $test_book->save();

            $author_1 = "Michael Bennet";
            $test_author = new Author($id, $author_1);
            $test_author->save();

            $test_author->addBook($test_book);

            $this->assertEquals($test_author->getBooks(), [$test_book]);
        }

        function testGetBooks()
        {
            $id = null;
            $title = "Moby Dick";
            $synopsis = "A thrilling tale of whale hunting adventures";
            $test_book = new Book($id, $title, $synopsis);
            $test_book->save();

            $id = null;
            $title2 = "Running Man";
            $synopsis2 = "Some book Ive never read";
            $test_book2 = new Book($id2, $title2, $synopsis2);
            $test_book2->save();

            $author_1 = "Sir Hampton the Meek";
            $test_author = new Author($id, $author_1);
            $test_author->save();

            $test_author->addBook($test_book);
            $test_author->addBook($test_book2);

            $this->assertEquals($test_author->getBooks(), [$test_book, $test_book2]);
        }
    }
 ?>
