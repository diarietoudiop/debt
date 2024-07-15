<?php

namespace App\Controller;

use App\Core\Controller;
use App\Core\Session;
use App\Core\Validator;

class DetteController extends Controller
{

    public function index()
    {
        $telephone = isset($_GET['telephone']) ? $_GET['telephone'] : '';
        $method = "detteClient";
        $data = $this->model->$method($telephone);
        $this->renderView("listedette.php", $data);
    }


    // public function payer($id)
    // {

    //     $this->renderView("paiement.php", ["client"=>[], "errors"=>[], "succes"=>[]]);
    // }


    public function list($id){


        $method = "recupererArticle";
        $articles = $this->model->$method($id);

        $this->renderView("details.php", ["articles"=>$articles]);
    }

    function payer($id)
    {
        $method = "recupererDette";
        $dette = $this->model->$method($id);
        $error = [];
        $succes = [];
        if (isset($_REQUEST["payer"])) {
            $error = Validator::validate($_POST, [
                "paiement" => ["required", "numeric"]
            ]);
            $paiement = (int)$_REQUEST["paiement"];

            if ($paiement < 1) $error["paiement"][] = "Le paiement doit être au minimum 1 fcfa";
            if ($paiement > $dette->montantRestant) $error["paiement"][] = "Le paiement ne doit pas dépasser le montant restant";


            if (!$error) {
                $result = $this->model->save([
                    "vendeur_id" => 1,
                    "dette_id" => (int)$id,
                    "montant" => $paiement,
                    "client_id" => $dette->idClient
                ]);


                if ($result == "succès") {
                    $succes = [
                        "msg" => "Le paiement a été enregistrer avec succes",
                        "status" => true
                    ];
                    $dette = $this->model->$method($id);
                } else {
                    $succes = [
                        "msg" => "Le paiement n'a été enregistrer",
                        "status" => false
                    ];
                }
            }
        }

        $this->renderView("paiement.php", ["dette" => $dette, "error" => $error, "id" => $id, "succes" => $succes]);
    }
    
}
