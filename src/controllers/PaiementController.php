<?php



namespace App\Controller;

use App\Core\Controller;
use App\Core\App;
use App\Core\Session;


class PaiementController extends Controller
{
    public function index()
    {
        $telephone = Session::isset("telephone") ? Session::get("telephone") : "+221764076933";
        $dette_id = Session::isset("dette_id") ? Session::get("dette_id") : 1;
        
        // Assurez-vous que le modèle est correctement chargé
       
        $clientModel = App::getInstance()->getModel("UtilisateurModel");
        $paiementModel = App::getInstance()->getModel("PaiementModel");
            if ($paiementModel === null) {
                throw new \Exception("Impossible de charger le modèle PaiementModel.");
            }

        // Vérifiez si la méthode existe dans le modèle
        if (!method_exists($paiementModel, 'paimentFromDette')) {
            throw new \Exception("La méthode paimentFromDette n'existe pas dans le modèle PaiementModel.");
        }

        $method = "paiementFromDette";
        $data = $paiementModel->$method($dette_id);
        
        $clientModel = App::getInstance()->getModel("Utilisateur");

        // Vérifiez si la méthode existe dans le modèle
        if (!method_exists($clientModel, 'search')) {
            throw new \Exception("La méthode search n'existe pas dans le modèle Utilisateur.");
        }

        $method = "search";
        $client = $clientModel->$method($telephone, $dette_id);

        // Vérifiez que les données ne sont pas nulles avant de les utiliser
        if (!$data) {
            throw new \Exception("Aucune donnée de paiement trouvée pour la dette ID: $dette_id.");
        }

        if (!$client) {
            throw new \Exception("Aucun client trouvé avec le téléphone: $telephone.");
        }

        $this->renderView("paiement.php", ["data" => $data, "client" => $client]);
    }
}
