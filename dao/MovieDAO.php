<?php

require_once("models/Movie.php");
require_once("models/Message.php");


class MovieDAO implements MovieDAOInterface {

    private $conn;
    private $url;
    private $message;

    public function __construct($conn, $url) {
        $this->conn = $conn;
        $this->url = $url;
        $this->message = new Message($url);
    }
    public function buildMovie($data) {

        $movie = new Movie();

        $movie->id = $data["id"];
        $movie->title = $data["title"];
        $movie->description = $data["description"];
        $movie->image = $data["image"];
        $movie->trailer = $data["trailer"];
        $movie->category = $data["category"];
        $movie->length = $data["length"];
        $movie->users_id = $data["users_id"];  

        return $movie;
    }
    public function findAll() {

    }
    public function getLatestMovies() {

        $movies = [];

        $stmt = $this->conn->query("SELECT * FROM movies ORDER BY id DESC");

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $moviesArray = $stmt->fetchAll();

            foreach ($moviesArray as $movie) {
                $movies[] = $this->buildMovie($movie);
            }
        }

        return $movies;
    }
    public function getMoviesByCategory($category) {
         $movies = [];

        $stmt = $this->conn->query("SELECT * FROM movies WHERE category = :category ORDER BY id DESC");

        $stmt->bindParam(":category", $category);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $moviesArray = $stmt->fetchAll();

            foreach ($moviesArray as $movie) {
                $movies[] = $this->buildMovie($movie);
            }
        }

        return $movies;
    }
    public function getMoviesByUserId($Id) {
          $movies = [];

        $stmt = $this->conn->query("SELECT * FROM movies WHERE users_id = :id");

        $stmt->bindParam(":id", $Id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $moviesArray = $stmt->fetchAll();

            foreach ($moviesArray as $movie) {
                $movies[] = $this->buildMovie($movie);
            }
        }

        return $movies;
    }
    public function findbyId($id) {

    }
    public function findByTitle($title) {

    }
    public function create(Movie $movie) {

        $stmt = $this->conn->prepare(
            "INSERT INTO movies (title, description, image, trailer, category, length, users_id) VALUES (:title, :description, :image, :trailer, :category, :length, :users_id)"
        );

        $stmt->bind_param(":title", $movie->title);
        $stmt->bind_param(":description", $movie->description);
        $stmt->bind_param(":image", $movie->image);
        $stmt->bind_param(":trailer", $movie->trailer);
        $stmt->bind_param(":category", $movie->category);
        $stmt->bind_param(":length", $movie->length);
        $stmt->bind_param(":users_id", $movie->users_id);
        $stmt->execute();


        $this->message->setMessage("Filme adicionado com sucesso!", "success", "index.php");


    }
    public function update(Movie $movie) {

    }
    public function destroy($id) {

    }
}