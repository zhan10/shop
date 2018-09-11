<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\Pagination;
use backend\models\Note;


class RegisteredCapitalController extends Controller
{
    public function actionIndex()
    {
        $db_oa_central = Yii::getAlias('@db_oa_central');
        $sql = 'SELECT registeredCapital,count(registeredCapital) as value FROM '.$db_oa_central.'.e_company GROUP BY registeredCapital';
        $registered = Yii::$app->db->createCommand($sql)->queryAll();
        foreach($registered as $k=>$v){
            switch ($v["registeredCapital"]){
                case "1":
                    $data["1"]=$v["value"];
                    break;
                case "2":
                    $data["2"]=$v["value"];
                    break;
                case "3":
                    $data["3"]=$v["value"];
                    break;
                case "4":
                    $data["4"]=$v["value"];
                    break;
                case "5":
                    $data["5"]=$v["value"];
                    break;
                case "6":
                    $data["6"]=$v["value"];
                    break;
            }
        }
        return $this->render('index',["data"=>$data]);
    }
}