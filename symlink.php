<?php
$target = '/home/cegmenk/www/dwesta/storage/app/public';
$link = '/home/cegmenk/www/dwesta/public/storage';
if (symlink($target, $link)) {
    echo "Le lien symbolique a été créé avec succès !";
} else {
    echo "Erreur lors de la création du lien.";
}