<?php

namespace App\Controller;

use App\Core\Controller;
use App\Core\App;
use App\Core\Session;

class PaiementController extends Controller
{

    public function index()
    {
        $telephone = Session::isset("client_telephone")?Session::get("client_telephone"):"+221764076933";
        $dette = Session::isset("dette_id")?Session::get("dette_id"):1;
        $method = "paimentFromDette";
        $data =$this->model->$method($dette);
        $method = "search";
        $client = App::getInstance()->getModel("Utilisateur")->$method($telephone, $dette);
        $this->renderView("paiement.php", ["data"=>$data, "client"=>$client]);
    }
}
