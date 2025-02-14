<?php

namespace App\Controller;

use App\Core\Controller;
use App\Core\Session;
use App\Core\Validator;

class DetteController extends Controller
{

    public function index()
    {
        if (!Session::isset("user_id"))
            $this->redirect("/login");

        $id = Session::get("client_id");
        $method = "clientDette";
        $data = $this->model->$method($id);
        $this->renderView("listedette.php", $data);
    }

    public function detteClient()
    {
        $telephone = Session::get("user_telephone");
        $method = "clientDette";
        $data = $this->model->$method(Session::get("user_id"));
        $this->renderView("listedette.php", $data);
    }

    public function list($id)
    {
        if (!Session::isset("user_id"))
            $this->redirect("/login");
        $method = "recupererArticle";
        $articles = $this->model->$method($id);
        $this->renderView("details.php", ["articles" => $articles]);
    }

    function payer($id)
    {
        if (!Session::isset("user_id"))
            $this->redirect("/login");
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

    public function enregistrerdette()
    {
        if (!Session::isset("user_id"))
            $this->redirect("/login");
        $succes = null;
        if (!Session::isset("total"))
            Session::set("total", 0);

        list($error, $article) = $this->rechercherArticle();
        if (isset($_REQUEST["ajouter-article"]))
            $error = $this->ajouterArticle();

        if (isset($_REQUEST["enregistrer-dette"])) {
            $succes["msg"] = "La dette n'a pas été enregistrer";
            $succes["status"] = false;

            if ($this->enregistrer()) {
                $succes["msg"] = "La dette a été enregistrer avec succes";
                $succes["status"] = true;
            }
        }
        if (isset($_REQUEST["supprimer-article"])) {
            $this->supprimerArticle();
        }
        $this->renderView("enregistrerdette.php", ["error" => $error, "article" => Session::get("article") ?? null, "succes" => $succes]);
    }

    private function rechercherArticle()
    {
        if (!Session::isset("user_id"))
            $this->redirect("/login");
        $error = $article = null;
        if (isset($_REQUEST["rechercher-article"])) {
            $ref = $_REQUEST["ref"];
            $error = Validator::validate($_POST, [
                "ref" => ["required", "numeric"]
            ]);
            if (!$error) {
                Session::set("ref", $ref);
                $method = "rechercherArticle";
                $article = $this->model->$method($ref);

                if (empty($article)) {
                    $error["ref"][0] = "Aucun article ne correspond à la référence saisie";
                } else {
                    Session::set("article", $article);
                }
            }
        }
        return [$error, $article];
    }

    public function ajouterArticle()
    {
        if (!Session::isset("user_id"))
            $this->redirect("/login");
        $error = null;
        $quantite = $_REQUEST["quantite"];
        $article = Session::get("article");
        if ($article == null) {
            $error["article"] = "Il faut d'abord rechercher une article";
        } else {
            $error = Validator::validate($_POST, [
                "quantite" => ["required"]
            ]);
        }

        if ($error == null) {
            if ($quantite <= 0) {
                $error["quantite"][] = "La quantite doit être supérieur à 0";
            } else {
                // Vérifier la quantité disponible en stock
                if ($quantite > $article->quantite) {
                    $error["quantite"][] = "La quantité demandée dépasse la quantité disponible en stock";
                } else {
                    $panierArticles = Session::get("panierArticles") ?? [];
                    $articleEstDansPanier = false;
                    foreach ($panierArticles as $k => $art) {
                        if ($art->id == $article->id) {
                            $panierArticles[$k]->quantite += $quantite;
                            $articleEstDansPanier = true;
                            break;
                        }
                    }
                    if ($articleEstDansPanier == false) {
                        $article->quantite = $quantite;
                        $panierArticles[] = $article;
                    }
                    $montant = Session::get("total") ?? 0;
                    $montant += ($quantite * $article->prixUnitaire);

                    Session::set("total", $montant);
                    Session::unset("article");
                    Session::unset("ref");
                    Session::set("panierArticles", $panierArticles);
                }
            }
        }
        return $error;
    }

    private function enregistrer()
    {
        if (!Session::isset("user_id"))
            $this->redirect("/login");
        $montant = Session::get("total") ?? 0;
        $articles = Session::get("panierArticles") ?? [];


        if ($montant && count($articles)) {
            $result = $this->model->save([
                "montant" => $montant,
                "articles" => $articles,
                "client" => Session::get("client_id"),
                "vendeur" => 1
            ]);

            if ($result) {
                Session::unset("total");
                Session::unset("panierArticles");
                return true;
            }
        }
        return false;
    }

    public function supprimerArticle() {
        if (isset($_POST['supprimer-article'])||isset($_POST['vider'])) {
            $id = $_POST['id'];
    
            if (isset($_SESSION["panierArticles"])) {
                foreach ($_SESSION["panierArticles"] as $key => $article) {
                    $condition = isset($_POST['vider'])? true : $article->id == $id ;
                    if ($condition) {
                        $total = Session::get("total") - ($article->prixUnitaire * $article->quantite);
                        Session::set("total", $total);
                        unset($_SESSION["panierArticles"][$key]);
                        $_SESSION["panierArticles"] = array_values($_SESSION["panierArticles"]); 
                        break;
                    }
                }
            }
        }
    }
    
}
