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

class TraineeChange extends AbstractController
{
    public function prePersist(Trainee $trainee, LifecycleEventArgs $event): void
    {
        $count = $this->getDoctrine()->getRepository(Trainee::class)->count([]);
        $trainee->setUid($count + 1);
    }

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

    public function postUpdate(Trainee $trainee, LifecycleEventArgs $event): void
    {
        $data = [
            "cmd" => "editUser",
            "user_id" => $trainee->getId(),
            "name" => $trainee->getName(),
            "id_card" => $trainee->getIdnum(),
            //"face_template" => 'http://192.168.0.55/images/avatar/' . $trainee->getId() . '.jpg',
            // "face_template" => $base_pic_urlencoded,
            "id_valid" => '',
            "Ic" => '1001',
            "edit_mode" => 1
        ];
        $p = new PushController();
        $p->push($data);
    }

    public function preRemove(Trainee $trainee, LifecycleEventArgs $event): void
    {
        $data = [
            "cmd" => "delUser",
            "user_id" => $trainee->getId(),
            "user_type" => '0',
        ];
        $p = new PushController();
        $p->push($data);
    }
}
