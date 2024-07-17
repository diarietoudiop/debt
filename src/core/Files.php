<?php

class Files
{
    public $image = [];
    public $dir;

    public function __construct($dir)
    {
        $this->dir = $dir;
    }

    public function load($file)
    {
        // Vérifie si le répertoire de téléchargement existe, sinon le crée
        if (!is_dir($this->dir)) {
            mkdir($this->dir, 0777, true);
        }

        // Vérifie si le fichier est valide
        if (isset($file) && $file['error'] == UPLOAD_ERR_OK) {
            $uploadFile = $this->dir . basename($file['name']);

            // Déplace le fichier téléchargé vers le répertoire cible
            if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
                $this->image['path'] = $uploadFile;
                return true;
            } else {
                throw new Exception("Erreur lors du téléchargement du fichier.");
            }
        } else {
            throw new Exception("Aucun fichier téléchargé ou erreur lors du téléchargement.");
        }
    }
    public function getImagePath() {
        return isset($this->image['path']) ? $this->image['path'] : null;
    }
}
?>
