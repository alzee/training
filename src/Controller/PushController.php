<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use GatewayClient\Gateway;

/** 
 * websocket 接口文档 https://www.showdoc.com.cn/286682190140856
 */
class PushController extends AbstractController
{
    /**
     * @Route("/push", name="push")
     */
    public function index(): Response
    {
        //Gateway::bindUid($client_id, 设备id);
        //Gateway::sendToUid(设备id, 数据);
        Gateway::$registerAddress = '127.0.0.1:8001';
        $data = [
            "cmd" => "addUser",
            //"cmd" => "onlineAuthorization",
            //"cmd" => "editUser",
            //"cmd" => "delUser",
            //"cmd" => "delMultiUserRet",
            //"cmd" => "delAllUser",
            "user_id" => 800003,
            "name" => '杨',
            "id_card" => '420302199012121111',
            "id_valid" => '',
            // 验证模式为人脸或卡时照片才不是非必填，但此模式下 Ic 必填
            "Ic" => '111',
        ];
        $resp = [
            "cmd" => "to_device",
            "from" => '',
            "to" => "RLM-00112166",
            "data" => $data,
        ];

        Gateway::sendToAll(json_encode($resp));

        return $this->json(["code" => 0 ]);
    }
}
