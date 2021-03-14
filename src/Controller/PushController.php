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
    public function push(array $d)
    {
        //Gateway::bindUid($client_id, 设备id);
        //Gateway::sendToUid(设备id, 数据);
        Gateway::$registerAddress = '127.0.0.1:8001';
        $resp = [
            "cmd" => "to_device",
            "from" => '',
            "to" => "RLM-00112166",
            "data" => $d,
        ];

        Gateway::sendToAll(json_encode($resp));
    }
}
