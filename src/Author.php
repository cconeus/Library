<?php

    class Author
    {
        private $id;
        private $author_1;

        function __construct($id = null, $author_1)
        {
            $this->id = $id;
            $this->author_1 = $author_1;
        }

        function setAuthor_1($new_author_1)
        {
            $this->author_1 = $new_author_1;
        }

        function getId()
        {
            return $this->id;
        }

        function getAuthor_1()
        {
            return $this->author_1;
        }

        //CRUD stuffs
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO authors (author_1) VALUES ('{$this->getAuthor_1()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function addBook($book)
        {
            $GLOBALS['DB']->exec("INSERT INTO authors_books (author_id, book_id) VALUES ({$book->getId()}, {$this->getId()});");
        }

        function getBooks()
        {
            $query = $GLOBALS['DB']->query("SELECT book_id FROM authors_books WHERE author_id = {$this->getId()};");
            $book_ids = $query->fetchAll(PDO::FETCH_ASSOC);

            $books = array();
            foreach($book_ids as $id) {
                $book_id = $id['book_id'];
                $result = $GLOBALS['DB']->query("SELECT * FROM books WHERE id = {$book_id};");
                $returned_book = $result->fetchAll(PDO::FETCH_ASSOC);

                $id = $returned_book[0]['id'];
                $title = $returned_book[0]['title'];
                $synopsis = $returned_book[0]['synopsis'];
                $new_book = new Book($id, $title, $synopsis);
                array_push($books, $new_book);
            }
            return $books;
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM authors WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM authors_books WHERE author_id = {$this->getId()};");
        }

        //Static functions
        static function getAll()
        {
            $returned_authors = $GLOBALS['DB']->query("SELECT * FROM authors;");

            $authors = array();
            foreach($returned_authors as $author) {
                $id = $author['id'];
                $author_1 = $author['author_1'];
                $new_authors = new Author($id, $author_1);
                array_push($authors, $new_authors);
            }
        return $authors;
        }

        static function deleteAll()
        {
          $GLOBALS['DB']->exec("DELETE FROM authors;");
        }

        static function find($search_id)
        {
            $found_author = null;
            $authors = Author::getAll();
            foreach($authors as $author) {
                $author_id = $author->getId();
                if ($author_id == $search_id) {
                    $found_author = $author;
                }
            return $found_author;
            }
        }
    }
 ?>
