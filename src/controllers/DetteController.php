<?php

namespace App\Controller;

use App\Core\Controller;
use App\Core\Session;

class DetteController extends Controller
{

    public function index()
    {
        $method = "detteClient";
        $data = $this->model->$method("+221764076933");
        $this->renderView("listedette.php", $data);
    }

}
