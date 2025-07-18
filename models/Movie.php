<?php


class Movie {
    public $id;
    public $title;
    public $description;
    public $trailer;
    public $category;
    public $image;
    public $length;
    public $users_id;

    public function imageGenerateName() {
        return bin2hex(random_bytes(60)) .  ".jpg";
    }
}

interface MovieDAOInterface {
    public function buildMovie($data);
    public function findAll();
    public function getLatestMovies();
    public function getMoviesByCategory($category);
    public function getMoviesByUserId($Id);
    public function findbyId($id);
    public function findByTitle($title);
    public function create(Movie $movie);
    public function update(Movie $movie);
    public function destroy($id);

}