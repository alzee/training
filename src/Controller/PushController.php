<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PushController extends AbstractController
{
    /**
     * @Route("/push", name="push")
     */
    public function index(): Response
    {
        /*
        // 建立socket连接到内部推送端口

        $client = stream_socket_client('tcp://127.0.0.1:8001', $errno, $errmsg, 3);

        // 推送的数据，包含uid字段，表示是给这个uid推送

        $data = array('uid'=>'1', 'percent'=>'88%');

        // 发送数据，注意5678端口是Text协议的端口，Text协议需要在数据末尾加上换行符

        fwrite($client, json_encode($data)."\n");

        // 读取推送结果

        echo fread($client, 8192);
         */

        $client = stream_socket_client('tcp://127.0.0.1:7273');
        if(!$client)exit("can not connect");
        // 模拟超级用户，以文本协议发送数据，注意Text文本协议末尾有换行符（发送的数据中最好有能识别超级用户的字段），这样在Event.php中的onMessage方法中便能收到这个数据，然后做相应的处理即可
        fwrite($client, '{"cmd":"to_device","to":"7f0000010b5600000001","type":"send","content":"hello all", "user":"admin", "pass":"******"}'."\n");


        return $this->json(1);
    }
}
