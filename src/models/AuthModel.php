<?php
namespace App\Model;

use App\Core\Model;

class AuthModel extends Model
{
    public function authenticateUser($login, $password)
    {
        $sql = "SELECT * FROM Utilisateurs WHERE login = SHA1(:login) AND password = SHA1(:password)";
        $params = [
            'login' => $login,
            'password' => $password
        ];
        return $this->prepare($sql, $params, "App\Entity\UtilisateurEntity", true);
    }
}