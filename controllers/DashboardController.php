<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\Management;
use backend\models\CurrentOnline;
use Zend\Validator\File\Count;

/**
 * Dashboard controller
 */
class DashboardController extends Controller
{
    public $enableCsrfValidation = false;
    public function actionShow(){
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $db_oa_central = Yii::getAlias('@db_oa_central');
        //获取内存
        $memory = (int)((memory_get_usage()/1024)/8192*100);
        //查询所有公司
        $company = Management::find()->all();
        //查询所有用户
        $user = Yii::$app->db->createCommand("select * from ".$db_oa_central.".user")->queryAll();
        //查询当月营业额
        $dataTurnover = Yii::$app->db->createCommand("select DATE_FORMAT(start_time,'%Y-%m') as time,ROUND(sum(total_price),2) as total from ".$db_oa_central.".order where state =1 GROUP BY time HAVING time = DATE_FORMAT(NOW(),'%Y-%m')")->queryAll();
        //查询当月新增公司
        $createAt = date("Y-m",time());
        $thisDateNewCompany = Management::find()->where(['DATE_FORMAT(created_at,\'%Y-%m\')'=>$createAt])->all();
        //查询当前在线人数
        $currentOnlineNumber = Yii::$app->db->createCommand("select * from ".$db_oa_central.".user_http_session")->queryAll();
        $CurrentOnline = new CurrentOnline();
        $CurrentOnline->insert_time = date("Y-m-d",time())." ".(date("H",time())+8).date(":i:s",time());
        $CurrentOnline->current_online = count($currentOnlineNumber);
        $CurrentOnline->save();
        //查询最高在线人数
        $sql = "select MAX(current_online) AS current_online from highest_current_online";
        $highestCurrentOnline = Yii::$app->db->createCommand($sql)->queryOne();
        //查询每月新增收入额
        //$sql = "select DATE_FORMAT(start_time,'%Y-%m') as time,ROUND(sum(total_price),2) as total,max(state) as state from `order` GROUP BY time HAVING time > DATE_FORMAT(DATE_ADD(NOW(),INTERVAL -1 YEAR),'%Y-%m') and state=1";
        $sql ="select DATE_FORMAT(start_time,'%Y-%m') as time, ROUND(sum(total_price),2) as total from `order` where state =1 GROUP BY time HAVING time > DATE_FORMAT(DATE_ADD(NOW(),INTERVAL -1 YEAR),'%Y-%m')";
        $monthTurnover = Yii::$app->db->createCommand($sql)->queryAll();
        $turnover = [];
        $turnoverDate = [];
        for($i=0;$i<count($monthTurnover);$i++){
            $turnover[]=$monthTurnover[$i]['total'];
            $turnoverDate[]=substr($monthTurnover[$i]['time'],-2);
        }
        //查询各模块每月收入
        $sql = "select module_id,title from ".$db_oa_central.".base_price where state =1 ";
        $modules = Yii::$app->db->createCommand($sql)->queryAll();
        $array = [];
        $moduleArray = [];
        $color = [];
        $moduleDate =  [];
        for($i=0;$i<count($modules);$i++){
            $sql = "select DATE_FORMAT(start_time,'%Y-%m') as time,ROUND(sum(total_price),2) as total,module_id from `order` where state=1 GROUP BY time,module_id HAVING time > DATE_FORMAT(DATE_ADD(NOW(),INTERVAL -1 YEAR),'%Y-%m') and module_id="."'".$modules[$i]['module_id']."'";
            $moduleData = Yii::$app->db->createCommand($sql)->queryAll();
            $moduleTotal = [];
            for($j=0;$j<count($moduleData);$j++){
                $moduleTotal[]=$moduleData[$j]['total'];
                $moduleDate[$j]=substr($moduleData[$j]['time'],-2);
            }
            $color[$modules[$i]['title']] = '#'.(string)rand(100000,999999);
            $moduleArray[$modules[$i]['title']] = json_encode($moduleTotal);
        }

        $array['userTotal'] = count($user);
        $array['companyTotal'] = count($company);
        if($dataTurnover==null){
            $array['dataTurnover']=0;
        }else {
            $array['dataTurnover'] = $dataTurnover['0']['total'];
        }
        $array['thisDateNewCompany'] = count($thisDateNewCompany);
        $array['currentOnline'] = count($currentOnlineNumber);
        $array['highestCurrentOnline'] = $highestCurrentOnline['current_online'];
        return $this->render('show',[
            'array'=>$array,
            'turnover'=>$turnover,
            'turnoverDate'=>$turnoverDate,
            'moduleArray'=>$moduleArray,
            'color'=>$color,
            'date'=>$moduleDate,
            'memory'=>$memory
        ]);
    }

    //查询每月注册会员数量
    public function actionFindLevel(){
        $db_oa_central = Yii::getAlias('@db_oa_central');
        $sql = "select
                DATE_FORMAT(createTime,'%Y-%m') as time,
                sum(case `level` when 10 then 1 else 0 end) AS '10'
                ,sum(case when `level`=20 then 1 else 0 end) AS '20'
                ,sum(case when `level`=30 then 1 else 0 end) AS '30'
                ,sum(case when `level`=40 then 1 else 0 end) AS '40'
                from ".$db_oa_central.".e_company
                GROUP BY time";
        $modules = Yii::$app->db->createCommand($sql)->queryAll();
        echo json_encode($modules);
    }

    //最新入住企业
    public function actionFindNewCorp(){
        $db_oa_central = Yii::getAlias('@db_oa_central');
        $sql = "select @rownum:=@rownum+1 as rownum,companyName,createTime,isQualified
              from (SELECT @rownum:=0) r,".$db_oa_central.".e_company
              order by createTime desc limit 0,10";
        $modules = Yii::$app->db->createCommand($sql)->queryAll();
        $json_data = json_encode($modules);
        echo $json_data;
    }
}