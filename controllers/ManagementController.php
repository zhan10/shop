<?php
namespace backend\controllers;

use backend\models\User;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\Pagination;
use backend\models\Common;

/**
 * Dashboard controller
 */
class ManagementController extends Controller
{
    public $enableCsrfValidation = false;
    public function actionCompany(){
        return $this->render('company');
    }

    public function actionFindAllCorp(){
        $current = 0;
        $sort = '';
        $parameters = Yii::$app->request->post();
        $db_oa_central = Yii::getAlias('@db_oa_central');
        $rows = (new \yii\db\Query())->select('*')->from($db_oa_central.".e_company");
        foreach($parameters["sort"] as $k=>$v){
            $sort = $k." ".$v;
        }
        /*if ($parameters["current"]!=2){
            $current = $parameters["current"]+($parameters["current"]*$parameters["rowCount"]-$parameters["rowCount"])-$parameters["current"];
        }else if($parameters["current"]==2) {
            $current = $parameters["current"] + $parameters["rowCount"] - $parameters["current"];
        }*/
        //$parameters['searchPhrase']
        if(empty($parameters['searchPhrase'])){
            $sql = "1=1";
        }else{
            $sql = "companyName like '%".$parameters['searchPhrase']. "%' or registeName like '%".$parameters['searchPhrase']."%' or tel like '%".$parameters['searchPhrase']."%'";
        }
        $data = $rows->where($sql)->orderBy($sort)->offset(($parameters["current"]-1)*10)->limit($parameters["rowCount"])->all();
        $result = array(
            'current' => $parameters["current"],
            'rowCount' => $parameters["rowCount"],
            'rows' => $data,
            "total" => $rows->count()
        );
        $json_data = json_encode($result);
        echo $json_data;
    }

    public function actionFindCorp(){
        $id = $_POST["id"];
        $db_oa_central = Yii::getAlias('@db_oa_central');
        $sql = "SELECT * FROM ".$db_oa_central.".e_company
        INNER JOIN ".$db_oa_central.".user ON ".$db_oa_central.".user.mobile = ".$db_oa_central.".e_company.adminTel
        WHERE ".$db_oa_central.".e_company.id='".$id."'";
        $query=Yii::$app->db->createCommand($sql)->queryAll();
        echo json_encode($query);
    }

    public function actionFindCorpConsumption(){
        $id=$_POST["id"];
        $db_oa_central = Yii::getAlias('@db_oa_central');
        $sql=Yii::$app->db->createCommand("
         SELECT
         ".$db_oa_central.".e_company.companyName as companyName,
         ".$db_oa_central.".order.module_id as module_id,
         ".$db_oa_central.".order.order_num as order_num,
         ".$db_oa_central.".order.total_price as total_price,
         ".$db_oa_central.".order.duration as duration,
         ".$db_oa_central.".order.start_time as start_time,
         ".$db_oa_central.".order.end_time as end_time
         FROM
         ".$db_oa_central.".order
        INNER JOIN ".$db_oa_central.".e_company ON ".$db_oa_central.".e_company.id = ".$db_oa_central.".order.corp_id
         WHERE ".$db_oa_central.".order.corp_id=".$id."
         ")->queryAll();
        echo json_encode($sql);
    }

    public function actionEditLoginStatus(){
        $db_oa_central = Yii::getAlias('@db_oa_central');
        $sql = "UPDATE ".$db_oa_central.".e_company SET
             isEnabled = '".$_POST['status']."'
             where id=".$_POST['id'];
        Yii::$app->db->createCommand($sql)->execute();
        if($_POST['status']==0){
            $updateSql = "update ".$db_oa_central.".user_corp set status=0,userStatus=0 where cid = ".$_POST['id'];
            Yii::$app->db->createCommand($updateSql)->execute();
            $userSql = "select * from ".$db_oa_central.".user_corp where cid = ".$_POST['id'];
            $userArray = Yii::$app->db->createCommand($userSql)->queryAll();
            for($i=0;$i<count($userArray);$i++){
                $findSql = "select * from ".$db_oa_central.".user where id = ".$userArray[$i]['uid'];
                $user = Yii::$app->db->createCommand($findSql)->queryOne();
                if($user!=false){
                    $common = new Common();
                    $url = 'http://www.ucenter.com/ucenter.php/user/clearToken/clear';
                    $date['openids'] = $user['openid'];
                    $common->curl_post($url,$date);
                }
            }
        }else{
            $updateSql = "update ".$db_oa_central.".user_corp set status=1,userStatus=1 where cid = ".$_POST['id'];
            Yii::$app->db->createCommand($updateSql)->execute();
        }
        return $this->redirect('?r=management/company');
    }

    public function actionEditBase(){
        $data = Yii::$app->request->post();
        $db_oa_central = Yii::getAlias('@db_oa_central');
        $sql = "UPDATE ".$db_oa_central.".e_company SET
             innerCode = '".$data['innerCode']."', companyName = '".$data['companyName']."', address = '".$data['address']."',
             province = '".$data['province']."',city = '".$data['city']."',district = '".$data['district']."',
             industry = '".$data['industry']."', registeredCapital = '".$data['registeredCapital']."', turnover = '".$data['turnover']."',
             request = '".$data['request']."', qualifications = '".$data['qualifications']."', description = '".$data['description']."'
             where id=".$data['cid'];
        Yii::$app->db->createCommand($sql)->execute();
        return $this->redirect('?r=management/company');
    }
    public function actionEditUser(){
        $data = Yii::$app->request->post();
        $db_oa_central = Yii::getAlias('@db_oa_central');
        $sql = "UPDATE ".$db_oa_central.".user SET
             username = '".$data['username']."', birthday = '".$data['birthday']."',
             title = '".$data['title']."', gender = '".$data['gender']."', education = '".$data['education']."',
             identityNr = '".$data['identityNr']."', politicalStatus = '".$data['politicalStatus']."', domicileLocation = '".$data['domicileLocation']."'
             where mobile=".$data['mobile'];
        Yii::$app->db->createCommand($sql)->execute();
        $sql = "UPDATE ".$db_oa_central.".e_company SET
              registeName = '".$data['username']."'
              where tel = ".$data['mobile'];
        Yii::$app->db->createCommand($sql)->execute();
        return $this->redirect('?r=management/company');
    }
    public function actionEditCorp(){
        $data = Yii::$app->request->post();
        $file = $_FILES['orgCodeImg'];//得到图片传输的数据
        $db_oa_central = Yii::getAlias('@db_oa_central');
        $sql = "UPDATE ".$db_oa_central.".e_company SET
             orgCode = '".$data['orgCode']."', legalPerson = '".$data['legalPerson']."', tel = '".$data['tel']."',
             email = '".$data['email']."', level = '".$data['level']."', orgCodeImg = '".$file['name']."'
             where id=".$data['cid'];
        Yii::$app->db->createCommand($sql)->execute();
        return $this->redirect('?r=management/company');
    }

    public function actionAdd(){
        $data = Yii::$app->request->post();
        $common = new Common();
        //用户注册
        $json_Array = json_decode($common->registerUcenterUser($data["mobile"],$data["name"]),true);
        //获取图片
        $file = $_FILES['orgCodeImg'];//得到图片传输的数据
        //所有行业
        $filename = "area/industry.json";
        $industry = json_decode(file_get_contents($filename),1);
        $mainIndustry = $data["industry"];
        foreach($industry as $k=>$v){
            if(in_array($data["industry"],$v["sub"])){
                $mainIndustry = $v["name"];
            }
        }

        //创建公司数据库
        $url = 'http://saas.new.com/index.php?r=installer/setup/interface-database';
        $data['openid'] = $json_Array['data']['0']['openid'];
        //得到文件名称
        $data['fileName'] = $file['name'];

        $data["mainIndustry"]=$mainIndustry;
        $data["registeredCapital"]=6;

        $cid = $common->curl_post($url,$data);
        $groupname = $data["companyName"]."公司群";
        if($cid){
            $group = json_decode($common->chatgroups($groupname,$groupname,$data['openid']),1);
            if($group["Status"]==200){
                $sql = "UPDATE db_oa_central.e_company  SET groupid ='".$group["Data"]."' where id = ".$cid;
                Yii::$app->db->createCommand($sql)->execute();
            }
        }

        return $this->redirect('?r=management/company');
    }
    //测试创建群组
    public function actionTest(){
        $common = new Common();
        return $common->chatgroups("测试2","测试2","192079412977818081");

    }
    //获取省
    public function actionGetProvince(){
        $filename = "area/province.json";
        $content = file_get_contents($filename);
        //$json = json_decode($content,true);
        /*$common = new Common();
        $url = 'http://220.249.79.2:40000/api/v2/common/province';
        $rec=$common->request_get($url);
        echo $rec;*/
        echo $content;
    }

    //获取城市
    public function actionGetCity(){
        $filename = "area/city.json";
        $content = file_get_contents($filename);
        $json = json_decode($content,true);
        $data = [];
        foreach($json as $k=>$v){
            if(substr($_GET['province'],0,2)==substr($v["zip"],0,2)){
                array_push($data,$v);
            }

        }
        echo json_encode($data);
        /*$common = new Common();
        $url = 'http://220.249.79.2:40000/api/v2/common/city?province='.$_GET['province'];
        $rec=$common->request_get($url);
        echo $rec;*/
    }

    //获取地区
    public function actionGetDistrict(){
        $filename = "area/district.json";
        $content = file_get_contents($filename);
        $json = json_decode($content,true);
        $data = [];
        foreach($json as $k=>$v){
            if(substr($_GET['city'],0,4)==substr($v["zip"],0,4)){
                array_push($data,$v);
            }
        }
        echo json_encode($data);
        /*$common = new Common();
        $url = 'http://220.249.79.2:40000/api/v2/common/district?city='.$_GET['city'];
        $rec=$common->request_get($url);
        echo $rec;*/
    }

    //获取行业
    public function actionGetIndustry(){
        $filename = "area/industry.json";
        $content = file_get_contents($filename);
        echo $content;
        /*$common = new Common();
        $url = 'http://220.249.79.2:40000/api/v2/common/industry';
        $rec=$common->request_get($url);
        echo $rec;*/
    }

    public function actionValidateDomain(){
        $domain = $_GET["domain"];
        $db_oa_central = Yii::getAlias('@db_oa_central');
        $sql= "select * from ".$db_oa_central.".e_company where domain = '".$domain."'";
        $a = Yii::$app->db->createCommand($sql)->execute();
        if(empty($a)){
            echo 0;
        }else{
            echo 1;
        }
    }
    public function actionValidateCompanyName(){
        $companyName = $_GET["companyName"];
        $db_oa_central = Yii::getAlias('@db_oa_central');
        $sql= "select * from ".$db_oa_central.".e_company where companyName = '".$companyName."'";
        $a = Yii::$app->db->createCommand($sql)->execute();
        if(empty($a)){
            echo 0;
        }else{
            echo 1;
        }
    }
    public function actionValidateInnerCode(){
        $innerCode = $_GET["innerCode"];
        $db_oa_central = Yii::getAlias('@db_oa_central');
        $sql= "select * from ".$db_oa_central.".e_company where innerCode = '".$innerCode."'";
        $a = Yii::$app->db->createCommand($sql)->execute();
        if(empty($a)){
            echo 0;
        }else{
            echo 1;
        }
    }
    public function actionValidateMobile(){
        $mobile = $_GET["mobile"];
        $db_oa_central = Yii::getAlias('@db_oa_central');
        $sql= "select * from ".$db_oa_central.".user where mobile = '".$mobile."'";
        $a = Yii::$app->db->createCommand($sql)->execute();
        if(empty($a)){
            echo 0;
        }else{
            echo 1;
        }
    }
    public function actionValidateEmail(){
        $email = $_GET["email"];
        $db_oa_central = Yii::getAlias('@db_oa_central');
        $sql= "select * from ".$db_oa_central.".user where email = '".$email."'";
        $a = Yii::$app->db->createCommand($sql)->execute();
        if(empty($a)){
            echo 0;
        }else{
            echo 1;
        }
    }
}
