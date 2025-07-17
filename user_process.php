<?php

require_once("globals.php");
require_once("db.php");
require_once("models/User.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");


$message = new Message($BASE_URL);

$userDAO = new UserDAO($conn, $BASE_URL);

$type = filter_input(INPUT_POST, "type");

if($type === "update") {

    $userData = $userDAO->verifyToken();
    $name = filter_input(INPUT_POST,"name");
    $lastname = filter_input(INPUT_POST, "lastname");
    $email = filter_input(INPUT_POST,"email");
    $bio = filter_input(INPUT_POST, "bio");


    $user = new User();
    $userData->name = $name;
    $userData->lastname = $lastname;
    $userData->email = $email;
    $userData->bio = $bio;

    if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {
        $image = $_FILES["image"];
        $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
        $jpgArray = ["image/jpg", "image/png"];

        if (in_array($image["type"], $imageTypes)) {

            if(in_array($image, $jpgArray)) {

                $imageFile = imagecreatefromjpeg($image["tmp_name"]);
            } else {
                $imageFile = imagecreatefrompng($image["tmp_name"]);
            }
            $imageName = $user->imageGenerateName();

            imagejpeg($imageFile, "./img/users/" . $imageName , 100);

            $userData->image = $imageName;
        } else {
            $message->setMessage("Tipo invalido de imagem!", "Error", "back");
        }
    }
    $userDAO->update($userData);

} else if ($type === "changepassword") {

    $password = filter_input(INPUT_POST, "password");
    $confirmpassword = filter_input(INPUT_POST, "confirmpassword");
    

    $userData = $userDAO->verifyToken();
    $id = $userData->id;

    if ($password == $confirmpassword) {
        $finalPassword = $user->generatePassword($password);
        $user->password = $finalPassword;
        $user->id = $id;

        $userDAO->changePassword($user);
    }else 
    {
        $message->setMessage("As senhas não sao iguais!", "error","back");
    }
} else
{
    $message->setMessage("Informações invalidas!", "error", "index.php");
}