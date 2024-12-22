<?php
namespace App\Controller;

use App\Core\Controller;
use App\Core\Session;

class AuthController extends Controller
{
    public function login()
    {
        Session::close();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = $_POST['login'] ?? '';
            $password = $_POST['password'] ?? '';
            $method = 'authenticateUser';
            $user = $this->model->$method($login, $password);
            if ($user) {
                Session::set('user_id', $user->getId());
                Session::set('user_role', $user->getRole());
                Session::set('user_telephone', $user->getTelephone());
                
                if (Session::get("user_role") == 'Vendeur') {
                    $this->redirect('/');
                } else if (Session::get("user_role") == 'Client') {
                    $this->redirect('/client/dette');
                }
            } else {
                $error = "Login ou mot de passe incorrect";
                $this->renderView("login.php", ['error' => $error]);
            }
        } else {
            $this->renderView("login.php");
        }
    }

    // public function logout()
    // {
    //     Session::destroy();
    //     $this->redirect('/login');
    // }
}