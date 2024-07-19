<?php

namespace App\Controller;

use App\Core\Controller;
use App\Core\Session;
use App\Core\Validator;

class UtilisateurController extends Controller
{
    public function index()
    {
        if (!Session::get('user_id') || Session::get('user_role') != 'Vendeur') {
            $this->redirect('/login');
        }
        $data = [];
        if (isset($_REQUEST["search"])) {
            $leNomDuMethode = "search";
            $data = [$this->model->$leNomDuMethode($_REQUEST["telephone"], 0)];
            if ($data[0] != false) {
                Session::set("client", $data[0]->telephone);
                Session::set("client_id", $data[0]->id);
            }
        }else{
            Session::unset('client');
            Session::unset('client_id');

        }

        foreach (["prenom", "nom", "email", "telephone"] as $champ) {
            Session::unset($champ);
        }

        $this->renderView("index.php", ["data" => $data]);
    }

    public function addClient()
    {
        $error = Validator::validate($_POST, [
            "nom" => ["required", "min:3", "max:30", "alpha"],
            "prenom" => ["required", "min:3", "max:30", "alpha"],
            "email" => ["required", "email"],
            "telephone" => ["required", "phone"],
        ]);

        $client = [];
        foreach (["prenom", "nom", "email", "telephone"] as $champ) {
            Session::set($champ, $_POST[$champ]);
            $client[$champ] = $_POST[$champ];
            if (isset($error[$champ])) {
                $error[$champ] = $error[$champ][0];
            }
        }

        if (!$error) {
            if ($this->model->findBy(["telephone" => $client["telephone"]])) {
                $error["telephone"] = "Le numéro de téléphone existe déjà";
            } else {
                $client["role_id"] = 2;
                $this->model->save($client);

                // Stocker le message de succès dans la session
                Session::set("success_message", "Client enregistré avec succès!");
                

                // Rediriger vers la même page
                $this->redirect('/');
                return;
            }
        }
        

        $this->renderView("index.php", ["data" => [], "error" => $error]);
    }
   
    
}
