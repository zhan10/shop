<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\Pagination;
use backend\models\Note;


class IndustryController extends Controller
{
    public function actionIndex()
    {
        $db_oa_central = Yii::getAlias('@db_oa_central');
        $sql = 'select industry as label,count(industry) as value from '.$db_oa_central.'.e_company GROUP BY industry';
        $industry = Yii::$app->db->createCommand($sql)->queryAll();
        $sumSql = 'select COUNT(id) as sum from e_company';
        $sum = Yii::$app->db->createCommand($sumSql)->queryOne();
        for($i=0;$i<count($industry);$i++){
            $industry[$i]["value"] = round($industry[$i]["value"]/$sum["sum"]*100,2);
            $color = '#'.(string)rand(100000,999999);
            $industry[$i]["color"]= $color;
            $industry[$i]["highlight"]= $color;
        }
        return $this->render('index',["industry"=>json_encode($industry)]);
    }
}