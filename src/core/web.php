<?php 

use App\Core\Route;

Route::get("/", [\App\Controller\UtilisateurController::class]);
Route::get("/paiement", [\App\Controller\PaiementController::class]);

Route::get("/dette/add", [App\Controller\DetteController::class, "index"]);

Route::post("/", [\App\Controller\UtilisateurController::class]);
Route::post("/add-client", [\App\Controller\UtilisateurController::class, "addClient"]);
Route::post("/listedette", [App\Controller\DetteController::class, "index"]);


Route::run($_SERVER["REQUEST_URI"]);

// var_dump($_SERVER["REQUEST_URI"], $_SERVER["REQUEST_METHOD"]);