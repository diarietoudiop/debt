<?php 

use App\Core\Route;

Route::get("/", [\App\Controller\UtilisateurController::class, "index"]);
Route::get("/newDette", [\App\Controller\PaiementController::class, "index"]);
Route::get("/dette/add", [App\Controller\DetteController::class, "index"]);
Route::get("/listedette", [App\Controller\DetteController::class, "index"]);
Route::get("/details/{id}", [App\Controller\DetteController::class, "list"]);
Route::get("/payer/{id}", [App\Controller\PaiementController::class, "payer"]);
Route::get("/listepaiement/{id}", [App\Controller\PaiementController::class, "list"]);



Route::post("/", [\App\Controller\UtilisateurController::class, "index"]);
Route::post("/add-client", [\App\Controller\UtilisateurController::class, "addClient"]);
Route::post("/listedette", [App\Controller\DetteController::class, "index"]);
Route::post("/payer/{id}", [App\Controller\PaiementController::class, "payer"]);




Route::run($_SERVER["REQUEST_URI"]);