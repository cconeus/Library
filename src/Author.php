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

        //Static functions
        static function getAll()
        {
            $returned_authors = $GLOBALS['DB']->query("SELECT * FROM authors;");
            $authors = array();
            foreach($returned_authors as $authors) {
                $id = $authors['id'];
                $author_1 = $authors['author_1'];
                $new_authors = new Author($id, $author_1);
                array_push($authors, $new_authors);
            }
        return $authors;
        }

        static function deleteAll()
        {
          $GLOBALS['DB']->exec("DELETE FROM authors;");
        }
    }
 ?>
