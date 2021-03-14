<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use GatewayClient\Gateway;
use App\Controller\PushController;

/** 
 * websocket 接口文档 https://www.showdoc.com.cn/286682190140856
 */
class PController extends AbstractController
{
    /**
     * @Route("/push1", name="push1")
     */
    public function index(): Response
    {
        $data = [
            "cmd" => "addUser",
            //"cmd" => "onlineAuthorization",
            //"cmd" => "editUser",
            //"cmd" => "delUser",
            //"cmd" => "delMultiUserRet",
            //"cmd" => "delAllUser",
            "user_id" => 800004,
            "name" => '杨一13',
            "id_card" => '420302199012121111',
            "id_valid" => '',
            // 验证模式为人脸或卡时照片才不是非必填，但此模式下 Ic 必填
            "Ic" => '111',
        ];
        $p = new PushController();
        $p->push($data,'addUser');
        return $this->json(["code" => 0 ]);
    }
}
