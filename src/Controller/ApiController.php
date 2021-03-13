<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Trainee;
use App\Entity\Training;
use App\Entity\C2;

/**
 * @Route("/api")
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/tg", methods={"POST"}, name="api_tg")
     */
    public function index(Request $request): Response
    {
        // $request->isXmlHttpRequest();
        //$p = $request->request->get('tgid');
        $params = json_decode($request->getContent(), true);
        $tgId = $params['tgid'];
        $tes = $params['te'];

        $em = $this->getDoctrine()->getManager();
        $tg = $this->getDoctrine()->getRepository(Training::class)->find($tgId);
        foreach($tes as $v){
            $te = $this->getDoctrine()->getRepository(Trainee::class)->find($v);
            $te->addTraining($tg);
            $em->persist($te);
            $em->flush();
        }

        return $this->json($params['te']);
    }

    /**
     * @Route("/v1/record/face", methods={"POST"}, name="api_face")
     */
    public function face(Request $request): Response
    {
        $code = 0;
        $content = '';
        $msg = '更新成功';
        $params = json_decode($request->getContent(), true);

        $res = [
            "Result" => $code,
            "Content" => $content,
            "Msg" => $msg
        ];
        //return $this->json($params['logs'][0]['photo']);
        return $this->json($res);
    }

    /**
     * @Route("/v1/stranger", methods={"POST", "GET"}, name="api_stranger")
     */
    public function stranger(Request $request): Response
    {
        $code = 0;
        $content = '';
        $msg = '更新成功';

        $data = '{
        "sn": "RL001-00186",
            "Count":1,
            "logs":[
        {
            "user_id":"334", 
                "recog_time":"2018-12-26 12:00:00",
                "recog_type":"face",
                "photo":"base64",
                "body_temperature":"36.5",
                "confidence":"95.5",
                "reflectivity":86,
                "room_temperature":25.5
    }
            ]
    }';
        //$params = json_decode($data, true);
        $params = json_decode($request->getContent(), true);
        // 新版机器 logs 只有一条数据，不用再检查了
        //$count = sizeof($params['logs']);
        //$params['count0'] = $count;
        $d = $params['logs'][0];

        $em = $this->getDoctrine()->getManager();
        $c = new C2();
        $c->setCount($params['Count']);
        $c->setUid($d['user_id']);
        //$c->setTime($d['recog_time']);
        $c->setType($d['recog_type']);
        $c->setPhoto($d['photo']);
        $c->setTemperature($d['body_temperature']);
        $c->setConfidence($d['confidence']);
        $c->setReflectivity($d['reflectivity']);
        $c->setRoomTemperature($d['room_temperature']);
            $c->setCount(0);
        if(isset($d['gender'])){
            $c->setGender($d['gender']);
        }

        $em->persist($c);
        $em->flush();

        $res = [
            "Result" => $code,
            "Content" => $content,
            "Msg" => $msg
        ];
        //return $this->json($params);
        return $this->json($res);
    }
}
