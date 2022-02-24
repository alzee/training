<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @author z14 <z@arcz.ee>
 * @version
 * @todo
 */

namespace App\EventListener;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Trainee;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use App\Controller\PushController;

class TraineeNew extends AbstractController
{
    public function postPersist(Trainee $trainee, LifecycleEventArgs $event): void
    {
        $em = $event->getEntityManager();
        $id = $trainee->getId();
        $trainee->setImage($id . '.jpg');
        $em->flush();

        $prefix = 'images/avatar/';
        copy($prefix . 'avatar.jpg', $prefix . $id . '.jpg');

        $data = [
            "cmd" => "addUser",
            //"cmd" => "onlineAuthorization",
            //"cmd" => "editUser",
            //"cmd" => "delUser",
            //"cmd" => "delMultiUserRet",
            //"cmd" => "delAllUser",
            "user_id" => $id,
            "name" => $trainee->getName(),
            "id_card" => $trainee->getIdnum(),
            "id_valid" => '',
            // 验证模式为人脸或卡时照片才不是非必填，但此模式下 Ic 必填
            "Ic" => '1001',
        ];
        $p = new PushController();
        $p->push($data);
    }
}

