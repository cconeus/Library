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

    class BookTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Book::deleteAll();
            Author::deleteAll();
        }

        function testSave()
        {
            $id = 1;
            $title = "Moby Dick";
            $synopsis = "A thrilling tale of whale hunting adventures";
            $test_book = new Book($id, $title, $synopsis);

            $test_book->save();

            $result = Book::getAll();
            $this->assertEquals($test_book, $result[0]);
        }

        function testGetAll()
        {
            $id = 1;
            $title = "Moby Dick";
            $synopsis = "A thrilling tale of whale hunting adventures";
            $test_book = new Book($id, $title, $synopsis);
            $test_book->save();

            $id2 = 2;
            $title2 = "Running Man";
            $synopsis2 = "Some book Ive never read";
            $test_book2 = new Book($id2, $title2, $synopsis2);
            $test_book2->save();

            $result = Book::getAll();

            $this->assertEquals([$test_book, $test_book2], $result);
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

            $test_book->addAuthor($test_author);
            $test_book->delete();

            $this->assertEquals([], $test_author->getBooks());
        }

        function testFind()
        {
            $id = 1;
            $title = "Moby Dick";
            $synopsis = "A thrilling tale of whale hunting adventures";
            $test_book = new Book($id, $title, $synopsis);
            $test_book->save();

            $id2 = 2;
            $title2 = "Running Man";
            $synopsis2 = "Some book Ive never read";
            $test_book2 = new Book($id2, $title2, $synopsis2);
            $test_book2->save();

            $result = Book::find($test_book->getId());

            $this->assertEquals($test_book, $result);
        }

        function testAddAuthor()
        {
            $id = null;
            $title = "Moby Dick";
            $synopsis = "A thrilling tale of whale hunting adventures";
            $test_book = new Book($id, $title, $synopsis);
            $test_book->save();

            $author_1 = "Michael Bennet";
            $test_author = new Author($id, $author_1);
            $test_author->save();

            $test_book->addAuthor($test_author);

            $this->assertEquals($test_book->getAuthors(), [$test_author]);
        }

        function testGetAuthors()
        {
            $id = null;
            $title = "Moby Dick";
            $synopsis = "A thrilling tale of whale hunting adventures";
            $test_book = new Book($id, $title, $synopsis);
            $test_book->save();

            $author_1 = "Michael Bennet";
            $test_author = new Author($id, $author_1);
            $test_author->save();

            $author_12 = "Sir Hampton the Meek";
            $test_author2 = new Author($id, $author_12);
            $test_author2->save();

            $test_book->addAuthor($test_author);
            $test_book->addAuthor($test_author2);

            $this->assertEquals($test_book->getAuthors(), [$test_author, $test_author2]);
        }
    }
 ?>
