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
            "cmd" => "to_device",
            "to" => "7f0000010b5600000001",
            "type" => "send",
            "content" => "hello all",
            "user" => "admin",
            "pass" => "123"
        ];
        Gateway::sendToAll(json_encode($data));

        return $this->json(["code" => 0 ]);
    }
}
