<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use GatewayClient\Gateway;

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
            "cmd" => "onlineAuthorization",
            //"cmd" => "addUser",
            //"user_id" => 800003,
            //"name" => '杨兴伟',
            //"id_card" => '420302199012121111',
            //"id_valid" => '',
            //"Ic" => '111',
            //"face_template" => 'https://uploadfile.bizhizu.cn/up/d2/7f/15/d27f157652629be2d04f41e7c697c25a.jpg',
            //"vlface_template" => ''
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
