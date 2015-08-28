<?php

    class Book
    {
        private $id;
        private $title;
        private $synopsis;

        function __construct($id = null, $title, $synopsis)
        {
            $this->id = $id;
            $this->title = $title;
            $this->synopsis = $synopsis;
        }

        function setTitle($new_title)
        {
            $this->title = $new_title;
        }

        function setSynopsis($new_synopsis)
        {
            $this->synopsis = $new_synopsis;
        }

        function getId()
        {
            return $this->id;
        }

        function getTitle()
        {
            return $this->title;
        }

        function getSynopsis()
        {
            return $this->synopsis;
        }

        //CRUD stuffs
        function addAuthor($author)
        {
            $GLOBALS['DB']->exec("INSERT INTO authors_books (author_id, book_id) VALUES ({$this->getId()}, {$author->getId()});");
        }

        function getAuthor()
        {
            $query = $GLOBALS['DB']->query("SELECT author_id FROM authors_books WHERE book_id = {$this->getId()};");
            $author_ids = $query->fetchAll(PDO::FETCH_ASSOC);

            $authors = array();
            foreach($author_ids as $id) {
                $author_id = $id['author_id'];
                $result = $GLOBALS['DB']->query("SELECT * FROM authors WHERE id = {$author_id};");
                $returned_author = $result->fetchAll(PDO::FETCH_ASSOC);

                $id = $returned_author[0]['id'];
                $author_1 = $returned_author[0]['author_1'];
                $author_2 = $returned_author[0]['author_2'];
                $author_3 = $returned_author[0]['author_3'];
                $new_author = new Author($id, $author_1, $author_2, $author_3);
                array_push($authors, $new_author);
            }
            return $authors;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO books (title, synopsis) VALUES ('{$this->getTitle()}', '{$this->getSynopsis()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM books WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM authors_books WHERE book_id = {$this->getId()};");
        }

        static function getAll()
        {
            $returned_books = $GLOBALS['DB']->query("SELECT * FROM books;");

            $books = array();
            foreach($returned_books as $book) {
                $id = $book['id'];
                $title = $book['title'];
                $synopsis = $book['synopsis'];
                $new_books = new Book($id, $title, $synopsis);
                array_push($books, $new_books);
            }
        return $books;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM books;");
        }

        static function find($search_id)
        {
            $found_book = null;
            $books = Book::getAll();

            foreach($books as $book) {
                $book_id = $book->getId();
                if ($book_id == $search_id) {
                    $found_book = $book;
                }
            return $found_book;
            }
        }
    }
 ?>
