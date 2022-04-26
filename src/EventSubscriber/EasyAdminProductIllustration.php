<?php 
namespace App\EventSubsrciber;

use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class EasyAdminSubscriber implements EventSubscriberInterface {

    private $appKernel;
public function __construct(KernelInterface $appKernel) {
        $this->appKernel = $appKernel;
    }

public static function getSubscribedEvents() {
    return [
        BeforeEntityPersistedEvent::class=>['setIllustration'],
    ];
}
public function setIllustration(BeforeEntityPersistedEvent $event) {
    $entity = $event->getEntityInstance();
    $tmpname = $entity->getIllustration();
    $filename =uniqid();
    $extension = pathinfo(($_FILES['name']['Illustration']), PATHINFO_EXTENSION);
    $projectdir = $this->appKernel->getProjectDir();
    move_uploaded_file($tmpname, $projectdir.'/public/uploads/'.$filename. '.'.$extension);
    $entity->setIllustration($filename.'.'.$extension);
   // dd($entity);
}
    
}