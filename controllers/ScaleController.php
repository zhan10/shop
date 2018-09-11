<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\Pagination;
use backend\models\Note;


class ScaleController extends Controller
{
    public function actionIndex()
    {
        $db_oa_central = Yii::getAlias('@db_oa_central');
        $sql = 'select count(uid) as value FROM '.$db_oa_central.'.user_corp GROUP BY cid';
        $scale = Yii::$app->db->createCommand($sql)->queryAll();
        //1、<10人  2、10~30人  3、30~50人
        //4、50~100人  5、100~300人  6、300~500人
        //7、≥500人
        $data = ["1"=>0,"2"=>0,"3"=>0,"4"=>0,"5"=>0,"6"=>0,"7"=>0];
        foreach($scale as $k=>$v){
            $value = $v["value"]*10;
            switch ($value){
                case $value<10:
                    $data["1"]=$data["1"]+1;
                    break;
                case $value<=10 and $value<30:
                    $data["2"]=$data["2"]+1;
                    break;
                case $value<=30 and $value<50:
                    $data["3"]=$data["3"]+1;
                    break;
                case $value<=50 and $value<100:
                    $data["4"]=$data["4"]+1;
                    break;
                case $value<=100 and $value<300:
                    $data["5"]=$data["5"]+1;
                    break;
                case $value<=300 and $value<500:
                    $data["6"]=$data["6"]+1;
                    break;
                case $value>=500:
                    $data["7"]=$data["7"]+1;
                    break;
            }
        }
        $sum = array_sum($data);
        return $this->render('index',["data"=>$data,"sum"=>$sum]);
    }
}