<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Trainee;
use App\Entity\Absence;
use App\Entity\Training;
use App\Entity\C2;
use GatewayClient\Gateway;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\Admin\TraineeCrudController;
use App\Controller\PushController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;

/**
 * @Route("/api")
 */
class ApiController extends AbstractController
{
    private $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

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
        $content = '0';
        $msg = 'Face record added';

        $params = json_decode($request->getContent(), true);
        // 新版机器 logs 只有一条数据，不用再检查了
        //$count = sizeof($params['logs']);
        //$params['count0'] = $count;
        $d = $params['logs'][0];

        $em = $this->getDoctrine()->getManager();
        $c = new C2();
        $c->setCount($params['Count']);
        $c->setUid($d['user_id']);
        $te = $this->getDoctrine()->getRepository(Trainee::class)->find($d['user_id']);;
        $c->setName($te->getName());
        //$c->setTime($d['recog_time']);
        $c->setType($d['recog_type']);
        //$c->setPhoto($d['photo']);
        $c->setTemperature($d['body_temperature']);
        $c->setConfidence($d['confidence']);
        $c->setReflectivity($d['reflectivity']);
        $c->setRoomTemperature($d['room_temperature']);
            $c->setCount(0);
        if(isset($d['gender'])){
            $c->setGender($d['gender']);
        }
        $em->persist($c);
        // $em->flush();

        //$te = $this->getDoctrine()->getRepository(Trainee::class)->find(18);;
        $te->setCheckinCount($te->getCheckinCount() + 1);
        if($te->getCheckinCount() > 1){
            $date = new \DateTimeImmutable("Asia/Shanghai");
            if($te->getCheckinCount() % 2 == 0){
                $absence = new Absence();
                $absence->setLeaveAt($date);
            }
            else{
                $absence = $this->getDoctrine()->getRepository(Absence::class)->findBy([ 'name' => $te->getId() ], ['id' => 'DESC'], 1)[0];
                $absence->setBackAt($date);
            }
            $absence->setName($te);
            $em->persist($absence);
        }
        $em->persist($te);
        $em->flush();

        $res = [
            "Result" => $code,
            "Content" => $content,
            "Msg" => $msg
        ];
        //return $this->json($params);
        return $this->json($res);
    }

    /**
     * @Route("/v1/stranger", methods={"POST", "GET"}, name="api_stranger")
     */
    public function stranger(Request $request): Response
    {
        $code = 0;
        $content = '1';
        $msg = 'Stranger record added';

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
        //$c->setPhoto($d['photo']);
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

    /**
     * @Route("/push", methods={"POST"}, name="api_push")
     */
    public function push(Request $request): Response
    {
        $params = json_decode($request->getContent(), true);
        $d = $params;

        $data = [
            "cmd" => "addUser",
            //"cmd" => "onlineAuthorization",
            //"cmd" => "editUser",
            //"cmd" => "delUser",
            //"cmd" => "delMultiUserRet",
            //"cmd" => "delAllUser",
            //"user_id" => 800005,
            "user_id" => $d->id,
            //"name" => '杨一14',
            "name" => $d->name,
            //"id_card" => '420302199012121111',
            "id_card" => $d->idnum(),
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

        Gateway::$registerAddress = '127.0.0.1:8001';
        Gateway::sendToAll(json_encode($resp));

        //return $this->json(["code" => 0 ]);
        return $this->json($resp);
    }

    /**
     * @Route("/trainees/import", name="api_xlsx2db")
     */
    public function xlsx2db(): Response
    {
        $file=$_FILES['file']['tmp_name'];

        if(!$file){
        }
        $type='Xlsx';
        // $inputFileName = 'xlsx/1.xlsx';
        $inputFileName = $file;
        $reader = IOFactory::createReader($type);
        //$reader->setLoadSheetsOnly($sheetname);
        $spreadsheet = $reader->load($inputFileName);
        $range = 'A2:I1000';
        $sheetData = $spreadsheet->getActiveSheet()->rangeToArray($range, null, true, true, true);
        //$sheetname = $spreadsheet->getSheetNames();
        // dump($sheetData);
        //return 1;
        $sexes = array_flip(Trainee::$sexes);
        $pstatuses = array_flip(Trainee::$pstatuses);
        $allPolitics = array_flip(Trainee::$allPolitics);
        $areas = array_flip(Trainee::$areas);
        $degrees = array_flip(Trainee::$degrees);

        $em = $this->getDoctrine()->getManager();
        $p = new PushController();
        foreach($sheetData as $k => $v){
            $te = new Trainee();
            // 如果姓名为空，我们就当作后面没有了
            if(is_null($v['A'])) break;
            // 如果是姓名外的某一项为空，将其设为 0 以避免报错
            foreach($v as $kk => $vv){
                if(is_null($vv))
                    $v[$kk] = '0';
            }

            $te->setName($v['A']);
            $te->setAge($v['B']);
            if(isset($sexes[$v['C']])) {
                $te->setSex($sexes[$v['C']]);
            }
            else {
                $te->setSex(0);
            }
            if(isset($pstatuses[$v['D']])) {
                $te->setPstatus($pstatuses[$v['D']]);
            }
            else {
                $te->setPstatus(0);
            }
            if(isset($allPolitics[$v['E']])) {
                $te->setPolitics($allPolitics[$v['E']]);
            }
            else {
                $te->setPolitics(0);
            }
            $te->setPhone($v['F']);
            $te->setIdnum($v['G']);
            $te->setAddress($v['H']);
            if(isset($areas[$v['I']])) {
                $te->setArea($areas[$v['I']]);
            }
            else {
                $te->setArea(0);
            }
            $te->setLevel($v['J']);
            if(isset($degrees[$v['K']])) {
                $te->setEdu($degrees[$v['K']]);
            }
            else {
                $te->setEdu(0);
            }
            $te->setCompany($v['L']);
            $te->setCompanyProperty($v['M']);
            $te->setService($v['N']);
            $te->setProLocal($v['O']);
            $te->setMilitaryPro($v['P']);
            $te->setHometown($v['Q']);
            $te->setSkills($v['R']);
            //$p = new TraineeCrudController();
            //$p->persistEntity($em, $te);
            $em->persist($te);
            $em->flush();

            $id = $te->getId();
            //$newId = $this->getDoctrine()->getRepository(Trainee::class)->findBy([], ["id" => "DESC"], 1)[0]->getId() + 1;
            $data = [
                "cmd" => "addUser",
                "user_id" => $id,
                "name" => $v['A'],
                "id_card" => $v['G'],
                "id_valid" => '',
                // 验证模式为人脸或卡时照片才不是非必填，但此模式下 Ic 必填
                "Ic" => '1001',
            ];
            $p->push($data);
        }
        // rename($inputFileName, "xlsx/old/" . date("Ymd") . ".xlsx");
        $resp = ["code" => 0];
        //return $this->json($resp);
        
        $url = $this->adminUrlGenerator
            ->setDashboard(ImportGuideController::class)
            ->setController(TraineeCrudController::class)
            ->setAction(Action::INDEX)
            ->generateUrl();
        return $this->redirect($url);
    }

    /**
     * @Route("/capture/{uid}", name="api_capture")
     */
    function capture($uid)
    {
        $p = new PushController();
        $data = [
            "cmd" => "onlineAuthorization"
        ];
        $p->push($data, $uid);

        $resp = ["code" => 0 ];
        return $this->json($resp);
    }

    /**
     * @Route("/trainees/export", name="export_trainees")
     */
    function exportTrainees()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $th = [
            'A1' => '姓名',
            'B1' => '年龄',
            'C1' => '性别',
            'D1' => '身份',
            'E1' => '政治面貌',
            'F1' => '片区',
            'G1' => '手机',
            'H1' => '联系地址',
            'I1' => '身份证号',
        ];
        foreach($th as $k => $v){
            $sheet->setCellValue($k, $v);
        }
        $trainees = $this->getDoctrine()->getRepository(Trainee::class)->findAll();
        foreach($trainees as $k => $v){
            $sheet->setCellValue('A' . ($k + 2), $v->getName());
            $sheet->setCellValue('B' . ($k + 2), $v->getAge());
            $sheet->setCellValue('C' . ($k + 2), Trainee::$sexes[$v->getSex()]);
            $sheet->setCellValue('D' . ($k + 2), Trainee::$pstatuses[$v->getPstatus()]);
            $sheet->setCellValue('E' . ($k + 2), Trainee::$allPolitics[$v->getPolitics()]);
            $sheet->setCellValue('F' . ($k + 2), Trainee::$areas[$v->getArea()]);
            // $sheet->setCellValue('G' . ($k + 2), $v->getPhone());
            $sheet->getCell('G' . ($k + 2))->setValueExplicit($v->getPhone(), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('H' . ($k + 2), $v->getAddress());
            // $sheet->setCellValue('I' . ($k + 2), $v->getIdnum());
            $sheet->getCell('I' . ($k + 2))->setValueExplicit($v->getIdnum(), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        }
        date_default_timezone_set('Asia/Shanghai');
        $file = 'xlsx/人员名单' . date('YmdHis') . '.xlsx';
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
        $writer->save($file);

        return $this->file($file);
    }

    /**
     * @Route("/absence/export", name="export_absence")
     */
    function exportAbsence()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $th = [
            'A1' => '姓名',
            'B1' => '请假时间',
            'C1' => '到岗时间',
        ];
        foreach($th as $k => $v){
            $sheet->setCellValue($k, $v);
        }
        $absence = $this->getDoctrine()->getRepository(Absence::class)->findBy([], ['leaveAt' => 'DESC']);
        foreach($absence as $k => $v){
            $sheet->setCellValue('A' . ($k + 2), $v->getName());
            $sheet->setCellValue('B' . ($k + 2), $v->getLeaveAt());
            $sheet->setCellValue('C' . ($k + 2), $v->getBackAt());
        }
        date_default_timezone_set('Asia/Shanghai');
        $file = 'xlsx/考勤记录' . date('YmdHis') . '.xlsx';
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
        $writer->save($file);

        return $this->file($file);
    }

    /**
     * @Route("/adduser/{uid}", name="add_use")
     */
    function adduser($uid)
    {
        $te = $this->getDoctrine()->getRepository(Trainee::class)->find($uid);
        $data = [
            "cmd" => "addUser",
            "user_id" => $uid,
            "name" => $te->getName(),
            "id_card" => $te->getIdnum(),
            "id_valid" => '',
            "Ic" => '1001',
        ];
        $p = new PushController();
        $p->push($data);
        $resp = [
            "code" => 0
        ];
        return $this->json($resp);
    }

    /**
     * @Route("/batch_hide_users", name="batch_hide_users")
     */
    function batchHideUsers(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $params = json_decode($request->getContent(), true);
        $trainees = $params['te'];
        $repo = $this->getDoctrine()->getRepository(Trainee::class);
        foreach ($trainees as $v) {
            $trainee = $repo->find($v);
            $trainee->setIsVisible(0);

            // $em->remove($trainee);

            // $data = [
            //     "cmd" => "delUser",
            //     "user_id" => $v,
            //     "user_type" => '0',
            // ];
            // $p = new PushController();
            // $p->push($data);

            $em->flush();
        }

        $resp = [
            "code" => 0
        ];

        return $this->json($resp);
    }
}
