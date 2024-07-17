<?php
namespace App\Controller;
use App\Core\Controller;
use App\Core\Session;
use App\Core\Validator;

class PaiementController extends Controller
{
    public function list($id){
        $method = "paiementDette";
        $paiements = $this->model->$method($id);
        $method = "getDette";
        $id = (int)Session::get("client");
        $client = [];
        // Session::set("client", $id);
        $this->renderView("listepaiement.php", ["client" => $client, "paiements" => $paiements]);
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
                    "client_id" => (int)$dette->idClient
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