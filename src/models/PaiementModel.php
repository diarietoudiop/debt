<?php

// namespace App\Model;

// use App\Core\Model;

// class PaiementModel extends Model
// {


//     public function paimentFromDette(int $id)
//     {
//         $sql = "SELECT p.* FROM `Paiements` p JOIN `DetailsDettes` dd ON p.id = dd.dette_id WHERE dd.dette_id = :id";
//         return $this->prepare($sql, ["id"=>$id]);
        
//     }

// }


namespace App\Model;

use App\Core\Model;

class PaiementModel extends Model
{
    public function paiementFromDette(int $id)
    {
        $sql = "SELECT p.* FROM `Paiements` p 
                JOIN `PaiementsDettes` pd ON p.id = pd.paiement_id 
                WHERE pd.dette_id = :id";
        return $this->prepare($sql, ["id" => $id]);
    }
}
