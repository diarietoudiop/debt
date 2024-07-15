<?php

namespace App\Core;

/**
 * Class Validator
 *
 * Classe de validation des données.
 *
 * @package App\Core
 */
class Validator {

    /**
     * @var array $errors Les erreurs de validation.
     */
    private static array $errors = [];
    private static array $data = [];

    private function __construct(){}

    /**
     * Valide les données en fonction des règles spécifiées.
     *
     * @param array $data Les données de validation.
     * @param array $rules Les règles de validation.
     * @return array|null Les erreurs de validation ou null si aucune erreur.
     */
    public static function validate(array $data, array $rules): ?array {
        self::$data = $data;
        foreach ($rules as $name => $rulesArray) {
            if (array_key_exists($name, $data)) {
                foreach ($rulesArray as $rule) {
                    if ($rule === 'required') {
                        self::required($name, $data[$name]);
                    } elseif (strpos($rule, 'min:') === 0) {
                        self::min($name, $data[$name], $rule);
                    } elseif (strpos($rule, 'max:') === 0) {
                        self::max($name, $data[$name], $rule);
                    } elseif ($rule === 'email') {
                        self::email($name, $data[$name]);
                    } elseif ($rule === 'phone') {
                        self::phone($name, $data[$name]);
                    } elseif ($rule === 'alpha') {
                        self::alpha($name, $data[$name]);
                    } elseif ($rule === 'alpha_num') {
                        self::alphaNum($name, $data[$name]);
                    } elseif ($rule === 'numeric') {
                        self::numeric($name, $data[$name]);
                    } elseif ($rule === 'date') {
                        self::date($name, $data[$name]);
                    }elseif (strpos($rule, 'regex:') === 0) {
                        self::regex($name, $data[$name], $rule);
                    }
                }
            } else {
                self::$errors[$name][] = "{$name} est requis.";
            }
        }

        return self::$errors;
    }

    /**
     * Valide la longueur minimale d'une chaîne de caractères.
     *
     * @param string $name Le nom du champ.
     * @param string $value La valeur du champ.
     * @param string $rule La règle de validation.
     */
    private static function min(string $name, string $value, string $rule) {
        preg_match('/min:(\d+)/', $rule, $matches);
        $min = (int)$matches[1];
        if (strlen($value) < $min) {
            self::$errors[$name][] = "Votre {$name} doit avoir au minimum {$min} caractères.";
        }
    }

    /**
     * Valide la longueur maximale d'une chaîne de caractères.
     *
     * @param string $name Le nom du champ.
     * @param string $value La valeur du champ.
     * @param string $rule La règle de validation.
     */
    private static function max(string $name, string $value, string $rule) {
        preg_match('/max:(\d+)/', $rule, $matches);
        $max = (int)$matches[1];
        if (strlen($value) > $max) {
            self::$errors[$name][] = "Votre {$name} doit avoir au maximum {$max} caractères.";
        }
    }

    /**
     * Vérifie si une valeur est requise.
     *
     * @param string $name Le nom du champ.
     * @param string $value La valeur du champ.
     */
    private static function required(string $name, string $value) {
        $value = trim($value);
        if (empty($value)) {
            self::$errors[$name][] = "{$name} est requis.";
        }
    }

    /**
     * Vérifie si une valeur est un email valide.
     *
     * @param string $name Le nom du champ.
     * @param string $value La valeur du champ.
     */
    private static function email(string $name, string $value) {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            self::$errors[$name][] = "{$name} n'est pas un email valide.";
        }
    }

    /**
     * Vérifie si une valeur est un numéro de téléphone sénégalais valide.
     *
     * @param string $name Le nom du champ.
     * @param string $value La valeur du champ.
     */
    private static function phone(string $name, string $value) {
        if (!preg_match("/^(?:\+221)?(70|76|77|78)[0-9]{7}$/", $value)) {
            self::$errors[$name][] = "{$name} n'est pas un numéro de téléphone sénégalais valide.";
        }
    }
    
    /**
     * Vérifie si une valeur contient uniquement des lettres.
     *
     * @param string $name Le nom du champ.
     * @param string $value La valeur du champ.
     */
    private static function alpha(string $name, string $value) {
        // if (!ctype_alpha($value)) {
        //     self::$errors[$name][] = "{$name} doit contenir uniquement des lettres.";
        // }
        if (!preg_match('/^[A-Za-z\s]+$/', $value)) {
            self::$errors[$name][] = "{$name} doit contenir uniquement des lettres.";
        }
    }

    /**
     * Vérifie si une valeur contient uniquement des lettres et des chiffres.
     *
     * @param string $name Le nom du champ.
     * @param string $value La valeur du champ.
     */
    private static function alphaNum(string $name, string $value) {
        if (!ctype_alnum($value)) {
            self::$errors[$name][] = "{$name} doit contenir uniquement des lettres et des chiffres.";
        }
    }

    /**
     * Vérifie si une valeur est numérique.
     *
     * @param string $name Le nom du champ.
     * @param string $value La valeur du champ.
     */
    private static function numeric(string $name, string $value) {
        if (!is_numeric($value)) {
            self::$errors[$name][] = "{$name} doit être un nombre.";
        }
    }

 

    /**
     * Vérifie si une valeur est une date valide.
     *
     * @param string $name Le nom du champ.
     * @param string $value La valeur du champ.
     */
    private static function date(string $name, string $value) {
        if (!strtotime($value)) {
            self::$errors[$name][] = "{$name} n'est pas une date valide.";
        }
    }
    

    /**
     * Vérifie si une valeur correspond à une expression régulière.
     *
     * @param string $name Le nom du champ.
     * @param string $value La valeur du champ.
     * @param string $rule La règle de validation.
     */
    private static function regex(string $name, string $value, string $rule) {
        preg_match('/regex:(.+)/', $rule, $matches);
        $pattern = $matches[1];
        if (!preg_match($pattern, $value)) {
            self::$errors[$name][] = "{$name} ne correspond pas au format attendu.";
        }
    }
}


