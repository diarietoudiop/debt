<?php

namespace App\Controller;

use App\Core\Controller;
use App\Core\Session;

class DetteController extends Controller
{

    public function index()
    {
        $telephone = isset($_GET['telephone']) ? $_GET['telephone'] : '';
        $method = "detteClient";
        $data = $this->model->$method($telephone);
        $this->renderView("listedette.php", $data);
    }
    
}
