<?php

namespace App\Core;

/**
 * Classe abstraite Entity
 * @package App\Core
 *
 * Classe de base pour les entités de données.
 */
abstract class Entity {
    protected int $id;

    public function getId(){
        return $this->id;
    }

    /**
     * Magique : Accès en lecture aux propriétés de l'entité.
     *
     * @param string $name Le nom de la propriété à accéder.
     * @return mixed La valeur de la propriété.
     */
    public function __get(string $name) {
        $getter = "get".ucwords($name);
        if(method_exists($this::class, $getter)){
            return $this->$getter();
        }
        trigger_error('Propriété non définie : ' . $name, E_USER_NOTICE);
        return null;
    }

    /**
     * Magique : Accès en écriture aux propriétés de l'entité.
     *
     * @param string $name Le nom de la propriété à définir.
     * @param mixed $value La valeur à assigner à la propriété.
     * @return void
     */
    public function __set(string $name, mixed $value) {
        $setter = "set".ucwords($name);
        if(method_exists($this::class, $setter)){
            $this->$setter($value);
        }
        trigger_error('Propriété non définie : ' . $name, E_USER_NOTICE);
    }
}
