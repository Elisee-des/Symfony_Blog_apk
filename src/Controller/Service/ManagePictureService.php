<?php

use App\Entity\Annonces;
use App\Entity\Images;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class MangePictureService
{

    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    public function add(
        array $images,
        Annonces $annonce
    )
    {
         //on boucle sur les images
         foreach ($images as $image) {

            //on gener un nouveau nom de fichier
            $fichier = md5(uniqid()) . '.' . $image->getExtension();
            //on le copie dans le dossiers uploads

            $image->move($this->params->get('images_directory'));
            //on stock l'image dans la base de donneé
            $img = new Images();
            $img->setName($fichier);
            $annonce->addImage($img);
        }
        
    }
}
