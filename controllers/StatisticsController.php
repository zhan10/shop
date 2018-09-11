<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Dashboard controller
 */
class StatisticsController extends Controller
{
    public function actionCompany(){
        $db_oa_central = Yii::getAlias('@db_oa_central');
        //查询12个月注册公司数量
        $sql = 'SELECT DATE_FORMAT(created_at,\'%Y-%m\') as time,COUNT(id) AS cnt from '.$db_oa_central.'.user WHERE super_admin=\'1\' GROUP BY time HAVING time > DATE_FORMAT(DATE_ADD(NOW(),INTERVAL -1 YEAR),\'%Y-%m\')';
        $monthCompany = Yii::$app->db->createCommand($sql)->queryAll();
        $array1 = [];
        $turnoverDate = [];
        for($i=0;$i<count($monthCompany);$i++){
            $array1[]=$monthCompany[$i]['cnt'];
            $turnoverDate[]=substr($monthCompany[$i]['time'],-2);
        }
        return $this->render('company',['array1'=>$array1,'turnoverDate'=>$turnoverDate]);
    }
    public function actionUser(){
        //查询12个月注册用户数量
        $db_oa_central = Yii::getAlias('@db_oa_central');
        $sql = 'SELECT DATE_FORMAT(created_at,\'%Y-%m\') as time,COUNT(id) AS cnt from '.$db_oa_central.'.user  GROUP BY time HAVING time > DATE_FORMAT(DATE_ADD(NOW(),INTERVAL -1 YEAR),\'%Y-%m\')';
        $monthUser = Yii::$app->db->createCommand($sql)->queryAll();
        $array1 = [];
        $turnoverDate = [];
        for($i=0;$i<count($monthUser);$i++){
            $array1[]=$monthUser[$i]['cnt'];
            $turnoverDate[]=substr($monthUser[$i]['time'],-2);
        }
        return $this->render('user',['array1'=>$array1,'turnoverDate'=>$turnoverDate]);
    }
    public function actionFunc(){
        $db_oa_central = Yii::getAlias('@db_oa_central');
        //功能每月付费统计走势图
        //wiki
        $sqlWiki='SELECT DATE_FORMAT(start_time,\'%Y-%m\') as time,COUNT(id) AS cnt,module_id as moud from '.$db_oa_central.'.order WHERE module_id=\'Wiki\' AND state=\'1\' GROUP BY time,module_id HAVING time > DATE_FORMAT(DATE_ADD(NOW(),INTERVAL -1 YEAR),\'%Y-%m\')';
        $monthWiki = Yii::$app->db->createCommand($sqlWiki)->queryAll();
        $wiki = [];
        $turnoverDate = [];
        for($i=0;$i<count($monthWiki);$i++){
            $wiki[]=$monthWiki[$i]['cnt'];
            $turnoverDate[]=substr($monthWiki[$i]['time'],-2);
        }
        //polls
        $sqlPolls='SELECT DATE_FORMAT(start_time,\'%Y-%m\') as time,COUNT(id) AS cnt,module_id as moud from '.$db_oa_central.'.order WHERE module_id=\'Polls\' AND state=\'1\' GROUP BY time,module_id HAVING time > DATE_FORMAT(DATE_ADD(NOW(),INTERVAL -1 YEAR),\'%Y-%m\')';
        $monthPolls = Yii::$app->db->createCommand($sqlPolls)->queryAll();
        $polls = [];
        for($i=0;$i<count($monthPolls);$i++){
            $polls[]=$monthPolls[$i]['cnt'];
        }
        //task
        $sqlTask='SELECT DATE_FORMAT(start_time,\'%Y-%m\') as time,COUNT(id) AS cnt,module_id as moud from '.$db_oa_central.'.order WHERE module_id=\'Tasks\' AND state=\'1\' GROUP BY time,module_id HAVING time > DATE_FORMAT(DATE_ADD(NOW(),INTERVAL -1 YEAR),\'%Y-%m\')';
        $monthTask = Yii::$app->db->createCommand($sqlTask)->queryAll();
        $task = [];
        for($i=0;$i<count($monthTask);$i++){
            $task[]=$monthTask[$i]['cnt'];
        }
        //breakingnews
        $sqlBreakingNews='SELECT DATE_FORMAT(start_time,\'%Y-%m\') as time,COUNT(id) AS cnt,module_id as moud from '.$db_oa_central.'.order WHERE module_id=\'breakingnews\' AND state=\'1\' GROUP BY time,module_id HAVING time > DATE_FORMAT(DATE_ADD(NOW(),INTERVAL -1 YEAR),\'%Y-%m\')';
        $monthBreakingNews = Yii::$app->db->createCommand($sqlBreakingNews)->queryAll();
        $breakingNews = [];
        for($i=0;$i<count($monthBreakingNews);$i++){
            $breakingNews[]=$monthBreakingNews[$i]['cnt'];
        }
        //查询各个收费功能总共有多少家公司购买
        $sqlall = 'SELECT module_id,count(id) as cnt from  '.$db_oa_central.'.order WHERE  state=\'1\' GROUP BY module_id';
        $sqldate = Yii::$app->db->createCommand($sqlall)->queryAll();
        // 查询每个功能总共收费多少钱
        $sqlmoney = ' SELECT module_id,sum(CEIL(total_price)) as summ from   '.$db_oa_central.'.order WHERE state=\'1\' GROUP BY module_id';
        $sqlfun = Yii::$app->db->createCommand($sqlmoney)->queryAll();
        $func = [];
        for($i=0;$i<count($sqlfun);$i++){
            $func[]=$sqlfun[$i]['summ'];
        }
        return $this->render('func',['wiki'=>$wiki,'polls'=>$polls,'task'=>$task,'breakingnews'=>$breakingNews,'sqldate'=>$sqldate,'func'=>$func,'turnoverDate'=>$turnoverDate]);
    }
}