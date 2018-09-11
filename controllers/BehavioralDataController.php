<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\Pagination;
use backend\models\Common;
class BehavioralDataController extends Controller
{
    public $enableCsrfValidation = false;
    public function actionDoor(){
        return $this->render('door');
    }
    public function actionPark(){
        return $this->render('park');
    }
    public function actionGetDoorList(){
        $par = Yii::$app->request->post();
        $db_oa_central = Yii::getAlias('@db_oa_central');
        $common = new Common();
        $rows = [];
        //获取总数量
        $total = (new \yii\db\Query())->select('*')->from($db_oa_central.".e_company")->where("companyName like '%".$par['searchPhrase']. "%'")->count();
        //获取公司
        $allCorp = $this->getCorp($par["current"],$par["rowCount"],$par['searchPhrase']);
        foreach($allCorp as $k=>$v){
            //获取所有用户
            $allUser = $this->getUser($v["id"]);
            //用户总数
            $sum = count(json_decode($allUser,1));
            //查询开门记录
            $url = APi_URL."/AccessControl/v2/sl/door/totalcount";
            $headers = array(
                'Content-Type: application/json; charset=utf-8'
            );
            $json_array = json_decode($common->curl_post($url,$allUser,$headers),1);
            if($json_array["Status"]==200){
                $data["name"] = $v["companyName"];
                $data["number"] = $json_array["Data"];
                $data["ratio"] = round($json_array["Data"]/$sum*100,2);
                array_push($rows,$data);
            }
        }
        $result = array(
            'current' => $par["current"],
            'rowCount' => $par["rowCount"],
            'rows' => $rows,
            "total" => $total
        );
        return json_encode($result);
    }
    public function actionGetParkList(){
        $par = Yii::$app->request->post();
        $db_oa_central = Yii::getAlias('@db_oa_central');
        $common = new Common();
        $rows = [];
        //获取总数量
        $total = (new \yii\db\Query())->select('*')->from($db_oa_central.".e_company")->where("companyName like '%".$par['searchPhrase']. "%'")->count();
        //获取公司
        $allCorp = $this->getCorp($par["current"],$par["rowCount"],$par['searchPhrase']);
        foreach($allCorp as $k=>$v){
            //获取所有用户
            $allUser = $this->getUser($v["id"]);
            //用户总数
            $sum = count(json_decode($allUser,1));
            //查询记录
            $url = ORDER_APi_URL."/CommonData/v2/sl/carin/totalcount";
            $headers = array(
                'Content-Type: application/json; charset=utf-8'
            );
            $json_array = json_decode($common->curl_post($url,$allUser,$headers),1);
            if($json_array["Status"]==200){
                $data["name"] = $v["companyName"];
                $data["number"] = $json_array["Data"];
                $data["ratio"] = round($json_array["Data"]/$sum*100,2);
                array_push($rows,$data);
            }
        }
        $result = array(
            'current' => $par["current"],
            'rowCount' => $par["rowCount"],
            'rows' => $rows,
            "total" => $total
        );
        return json_encode($result);
    }
    public function getCorp($start,$limit,$where){
        $db_oa_central = Yii::getAlias('@db_oa_central');
        $sql = 'select id,companyName FROM '.$db_oa_central.'.e_company WHERE companyName LIKE "%'.$where.'%" limit '.(($start-1)*10).','.$limit;
        $allCorp = Yii::$app->db->createCommand($sql)->queryAll();
        return $allCorp;
    }
    public function getUser($cid){
        $db_oa_central = Yii::getAlias('@db_oa_central');
        $userSql = 'select u.openid as id from '.$db_oa_central.'.user_corp as uc INNER JOIN '.$db_oa_central.'.`user` as u ON uc.uid = u.id where uc.cid = '.$cid;
        $allUser = Yii::$app->db->createCommand($userSql)->queryAll();
        return json_encode($allUser);
    }
}
