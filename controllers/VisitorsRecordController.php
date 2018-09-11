<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\Pagination;
use backend\models\Common;

/**
 * Dashboard controller
 */
class VisitorsRecordController extends Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex(){
        return $this->render('index');
    }
    public function actionGetList(){
        $par = Yii::$app->request->post();
        $common = new Common();
        $url = "http://118.31.73.141:8084/AccessControl/v2/vistor/log";
        $headers = array(
            'Content-Type: application/json; charset=utf-8'
        );
        if(!empty($par["searchPhrase"])){
            $data["buildingname"]=$par["searchPhrase"];
            $data["username"]=$par["searchPhrase"];
        }
        $data["pageindex"]=$par["current"];
        $data["pagesize"]=$par["rowCount"];
        $json_array = json_decode($common->curl_post($url,json_encode($data),$headers),1);
        $result = array(
            'current' => $par["current"],
            'rowCount' => $par["rowCount"],
            'rows' => $json_array["Data"]["List"],
            "total" => $json_array["Data"]["Total"]
        );
        return json_encode($result);
    }
}
