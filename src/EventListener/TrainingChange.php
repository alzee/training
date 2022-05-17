<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @author z14 <z@arcz.ee>
 * @version
 * @todo
 */

namespace App\EventListener;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Training;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use App\Controller\PushController;

class TrainingChange extends AbstractController
{
    public function prePersist(Training $training, LifecycleEventArgs $event): void
    {
        $count = $this->getDoctrine()->getRepository(Training::class)->count([]);
        $training->setTid($count + 1);
    }
}
