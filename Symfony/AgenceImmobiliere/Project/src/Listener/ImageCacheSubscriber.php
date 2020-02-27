<?php
namespace App\Listener;


use App\Entity\Property;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

/**
 * Class ImageCacheSubscriber
 * @package App\Listener
*/
class ImageCacheSubscriber implements EventSubscriber
{
    /**
     * @var CacheManager
    */
    private $cacheManager;


    /**
     * @var UploaderHelper
    */
    private $uploaderHelper;

    /**
     * ImageCacheSubcriber constructor.
     * @param CacheManager $cacheManager
     * @param UploaderHelper $uploaderHelper
    */
    public function __construct(CacheManager $cacheManager, UploaderHelper $uploaderHelper)
    {
        $this->cacheManager = $cacheManager;
        $this->uploaderHelper = $uploaderHelper;
    }

    /**
     * @inheritDoc
    */
    public function getSubscribedEvents()
    {
         # On retourne les evenements qu'on doit ecouter
         return [
           'preRemove',
           'preUpdate'
         ];
    }


    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        # si l'entite n'est pas une instance de Property, on ne fera rien
        if(! $entity instanceof Property)
        {
            return;
        }

        # vide le cache de l'image
        $this->cacheManager->remove(
            $this->uploaderHelper->asset($entity, 'imageFile')
        );
    }


    /**
     * @param LifecycleEventArgs $args [ LifecycleEventArgs est une classe generique pour preUpdateArgs, pre... ]
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        /* dump($args->getEntity());
        dump($args->getObject());
        */

        $entity = $args->getEntity();

        # si l'entite n'est pas une instance de Property, on ne fera rien
        if(! $entity instanceof Property)
        {
            return;
        }

        # Si image n'est pas une instance de UploadedFile
        if($entity->getImageFile() instanceof UploadedFile)
        {
            # vide le cache de l'image dans le dossier /public/media/..
            $this->cacheManager->remove(
                $this->uploaderHelper->asset($entity, 'imageFile')
            );
        }
    }
}