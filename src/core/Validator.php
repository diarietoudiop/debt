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
                    } elseif ($rule === 'url') {
                        self::url($name, $data[$name]);
                    } elseif ($rule === 'boolean') {
                        self::boolean($name, $data[$name]);
                    } elseif ($rule === 'date') {
                        self::date($name, $data[$name]);
                    } elseif (strpos($rule, 'same:') === 0) {
                        self::same($name, $data[$name], $rule);
                    } elseif (strpos($rule, 'different:') === 0) {
                        self::different($name, $data[$name], $rule);
                    } elseif (strpos($rule, 'in:') === 0) {
                        self::in($name, $data[$name], $rule);
                    } elseif (strpos($rule, 'not_in:') === 0) {
                        self::notIn($name, $data[$name], $rule);
                    } elseif ($rule === 'integer') {
                        self::integer($name, $data[$name]);
                    } elseif ($rule === 'float') {
                        self::float($name, $data[$name]);
                    } elseif ($rule === 'ip') {
                        self::ip($name, $data[$name]);
                    } elseif (strpos($rule, 'regex:') === 0) {
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
            self::$errors[$name][] = "{$name} doit avoir au minimum {$min} caractères.";
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
            self::$errors[$name][] = "{$name} doit avoir au maximum {$max} caractères.";
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
     * Vérifie si une valeur est une URL valide.
     *
     * @param string $name Le nom du champ.
     * @param string $value La valeur du champ.
     */
    private static function url(string $name, string $value) {
        if (!filter_var($value, FILTER_VALIDATE_URL)) {
            self::$errors[$name][] = "{$name} n'est pas une URL valide.";
        }
    }

    /**
     * Vérifie si une valeur est un booléen valide.
     *
     * @param string $name Le nom du champ.
     * @param string $value La valeur du champ.
     */
    private static function boolean(string $name, string $value) {
        if (!in_array($value, [true, false, 'true', 'false', 1, 0, '1', '0'], true)) {
            self::$errors[$name][] = "{$name} doit être un booléen.";
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
     * Vérifie si deux champs ont la même valeur.
     *
     * @param string $name Le nom du champ.
     * @param string $value La valeur du champ.
     * @param string $rule La règle de validation.
     */
    private static function same(string $name, string $value, string $rule) {
        preg_match('/same:(\w+)/', $rule, $matches);
        $otherField = $matches[1];
        if ($value !== self::$data[$otherField]) {
            self::$errors[$name][] = "{$name} doit être identique à {$otherField}.";
        }
    }

    /**
     * Vérifie si deux champs ont des valeurs différentes.
     *
     * @param string $name Le nom du champ.
     * @param string $value La valeur du champ.
     * @param string $rule La règle de validation.
     */
    private static function different(string $name, string $value, string $rule) {
        preg_match('/different:(\w+)/', $rule, $matches);
        $otherField = $matches[1];
        if ($value === self::$data[$otherField]) {
            self::$errors[$name][] = "{$name} doit être différent de {$otherField}.";
        }
    }

    /**
     * Vérifie si une valeur est dans une liste de valeurs données.
     *
     * @param string $name Le nom du champ.
     * @param string $value La valeur du champ.
     * @param string $rule La règle de validation.
     */
    private static function in(string $name, string $value, string $rule) {
        preg_match('/in:([a-zA-Z0-9,_]+)/', $rule, $matches);
        $allowedValues = explode(',', $matches[1]);
        if (!in_array($value, $allowedValues)) {
            self::$errors[$name][] = "{$name} doit être l'une des valeurs suivantes : " . implode(', ', $allowedValues) . ".";
        }
    }

    /**
     * Vérifie si une valeur n'est pas dans une liste de valeurs données.
     *
     * @param string $name Le nom du champ.
     * @param string $value La valeur du champ.
     * @param string $rule La règle de validation.
     */
    private static function notIn(string $name, string $value, string $rule) {
        preg_match('/not_in:([a-zA-Z0-9,_]+)/', $rule, $matches);
        $disallowedValues = explode(',', $matches[1]);
        if (in_array($value, $disallowedValues)) {
            self::$errors[$name][] = "{$name} ne doit pas être l'une des valeurs suivantes : " . implode(', ', $disallowedValues) . ".";
        }
    }

    /**
     * Vérifie si une valeur est un entier.
     *
     * @param string $name Le nom du champ.
     * @param string $value La valeur du champ.
     */
    private static function integer(string $name, string $value) {
        if (!filter_var($value, FILTER_VALIDATE_INT)) {
            self::$errors[$name][] = "{$name} doit être un entier.";
        }
    }

    /**
     * Vérifie si une valeur est un nombre à virgule flottante.
     *
     * @param string $name Le nom du champ.
     * @param string $value La valeur du champ.
     */
    private static function float(string $name, string $value) {
        if (!filter_var($value, FILTER_VALIDATE_FLOAT)) {
            self::$errors[$name][] = "{$name} doit être un nombre à virgule flottante.";
        }
    }

    /**
     * Vérifie si une valeur est une adresse IP valide.
     *
     * @param string $name Le nom du champ.
     * @param string $value La valeur du champ.
     */
    private static function ip(string $name, string $value) {
        if (!filter_var($value, FILTER_VALIDATE_IP)) {
            self::$errors[$name][] = "{$name} doit être une adresse IP valide.";
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


