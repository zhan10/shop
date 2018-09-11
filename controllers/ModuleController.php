<?php
namespace backend\controllers;

use backend\models\BaseModule;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\Pagination;
use backend\models\Order;
use backend\models\ModuleOrder;

/**
 * Dashboard controller
 */
class ModuleController extends Controller{
    /**
     *
     * 模块图表
     * @return string
     */
    public function actionIndex(){
        $arr = Yii::$app->db->createCommand('SELECT module_id,COUNT(*) as count FROM `order` GROUP BY module_id')
            ->queryAll();
        $sum_price = Yii::$app->db->createCommand('SELECT module_id,SUM(total_price) as total FROM `order` GROUP BY module_id')
            ->queryAll();
        $rate= Yii::$app->db->createCommand('SELECT *  FROM db_oa_central.module_rate')
            ->queryAll();

        $module_id=Yii::$app->request->get('datas');
        $module = Yii::$app->db->createCommand("SELECT * FROM db_oa_central.base_price where module_id='".$module_id."'")
            ->queryOne();
        $rate= Yii::$app->db->createCommand('SELECT *  FROM db_oa_central.module_rate')
            ->queryAll();
        $query=BaseModule::find();
        $pages = new Pagination([
            'totalCount' => $query->count(),
        ]);
        $baseModule = $query->orderBy('id DESC')
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('index',array('baseModule' => $baseModule,'pages' => $pages,'module'=>$module,'arr'=>$arr,'sum_price'=>$sum_price,'rate'=>$rate));
    }
    /**
     *
     * 模块列表
     * @return string
     */
    public function actionList(){
        $arr = Yii::$app->db->createCommand('SELECT module_id,COUNT(*) as count FROM `order` GROUP BY module_id')
            ->queryAll();
        $sum_price = Yii::$app->db->createCommand('SELECT module_id,SUM(total_price) as total FROM `order` GROUP BY module_id')
            ->queryAll();
        $rate= Yii::$app->db->createCommand('SELECT *  FROM db_oa_central.module_rate')
            ->queryAll();
        $query=BaseModule::find();
        $pages = new Pagination([
            'defaultPageSize' => '10',
            'totalCount' => $query->count(),
        ]);
        $baseModule = $query->orderBy('id asc')
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('list',array('baseModule' => $baseModule,'pages' => $pages,'arr'=>$arr,'sum_price'=>$sum_price,'rate'=>$rate));
    }
    /**
     *
     * 订单历史记录
     * @return string
     */
    public function actionHistory(){
        $query=ModuleOrder::find();

        $pages = new Pagination([
            'defaultPageSize' => '10',
            'totalCount' => $query->count(),
        ]);

        $moduleOrders = $query->orderBy('id asc')
            ->where(" state=1")
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('history',array('moduleOrders' => $moduleOrders,'pages'=>$pages,));
    }
    /**
     *
     * 即将到期
     * @return string
     */
    public function actionHistory1(){
        $query=ModuleOrder::find();
        date_default_timezone_set("Asia/Shanghai");
        $time=date("Y-m-d H:i:s");
        $dayLater = date('Y-m-d',strtotime("$time + 10 day"));

        $sql="end_time in(SELECT max(end_time) FROM  module_order WHERE state=1 GROUP BY module_id,corp) AND end_time>'".$time."' AND state=1 AND end_time<'".$dayLater."'";
        $datas= Yii::$app->db->createCommand("SELECT COUNT(*) as counts FROM module_order WHERE end_time in(SELECT max(end_time) FROM  module_order GROUP BY module_id,corp) AND end_time>'".$time."'  AND end_time<'".$dayLater."'")
            ->queryAll();
        $count=(object)$datas[0];
        $count=$count->counts;
        $pages = new Pagination([
            'defaultPageSize' => '10',
            'totalCount' => $count,
        ]);
        $endOrders = $query->orderBy('id asc')
            ->where($sql)
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('history1',array('endOrders' => $endOrders,'pages'=>$pages));
    }

    /**
     *
     * 已过期
     * @return string
     */
    public function actionHistory2(){
        $query=ModuleOrder::find();
        date_default_timezone_set("Asia/Shanghai");
        $time=date("Y-m-d H:i:s");
        $sql="end_time in(SELECT max(end_time) FROM  module_order WHERE state=1 GROUP BY module_id,corp) AND state=1 AND end_time<'".$time."'";
        $datas= Yii::$app->db->createCommand("SELECT COUNT(*) as counts FROM module_order WHERE end_time in(SELECT max(end_time) FROM  module_order GROUP BY module_id,corp) AND end_time<'".$time."'")
            ->queryAll();
        $count=(object)$datas[0];
        $count=$count->counts;
        $pages = new Pagination([
            'defaultPageSize' => '10',
            'totalCount' => $count,
        ]);
        $endOrders = $query->orderBy('id asc')
            ->where($sql)
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('history2',array('endOrders' => $endOrders,'pages'=>$pages));
    }

    /**
     * 价格修改
     * @return \yii\web\Response
     */
    public function actionSave(){

        $ids=Yii::$app->request->post('ids');
        $base_price=Yii::$app->request->post('base_price');
        if($base_price!=null){
            $rate1=Yii::$app->request->post('rate1')/100;
            $rate2=Yii::$app->request->post('rate2')/100;
            $rate3=Yii::$app->request->post('rate3')/100;
            Yii::$app->db->createCommand("UPDATE db_oa_central.module_rate  SET rate='$rate1' WHERE duration_id=2 AND base_id = '".$ids."'")
                ->execute();
            Yii::$app->db->createCommand("UPDATE db_oa_central.module_rate  SET rate='$rate2' WHERE duration_id=3 AND base_id = '".$ids."'")
                ->execute();
            Yii::$app->db->createCommand("UPDATE db_oa_central.module_rate  SET rate='$rate3' WHERE duration_id=4 AND base_id = '".$ids."'")
                ->execute();
            Yii::$app->db->createCommand("UPDATE db_oa_central.base_price  SET base_price='$base_price' WHERE  id = '".$ids."'")
                ->execute();
        }
        return $this->redirect('index.php?r=module/list');
    }
    /**
     * 图标界面价格修改
     * @return \yii\web\Response
     */
    public function actionSave1(){

        $module_id=Yii::$app->request->post('ids');
        $module=BaseModule::findOne(['module_id'=>$module_id]);
        $ids=$module->id;
        (float)$base_price=Yii::$app->request->post('base_price');
        if($base_price!=null){
            (float) $rate1=Yii::$app->request->post('rate1')/100;
            (float)$rate2=Yii::$app->request->post('rate2')/100;
            (float)$rate3=Yii::$app->request->post('rate3')/100;
            Yii::$app->db->createCommand("UPDATE db_oa_central.module_rate  SET rate='$rate1' WHERE duration_id=2 AND base_id = '".$ids."'")
                ->execute();
            Yii::$app->db->createCommand("UPDATE db_oa_central.module_rate  SET rate='$rate2' WHERE duration_id=3 AND base_id = '".$ids."'")
                ->execute();
            Yii::$app->db->createCommand("UPDATE db_oa_central.module_rate  SET rate='$rate3' WHERE duration_id=4 AND base_id = '".$ids."'")
                ->execute();
            $aa = Yii::$app->db->createCommand("UPDATE db_oa_central.base_price  SET base_price='$base_price' WHERE  id = '".$ids."'")
                ->execute();
        }
        return $this->redirect('index.php?r=module/index');
    }
    public function actionFind(){
        $inputss = Yii::$app->request->get('inputss');
        $inputss=explode(',',$inputss);
        $query=ModuleOrder::find();

        //查询
        $sql="1=1";
        if($inputss[0]!=''){
            $sql .=" and title like '%".$inputss[0]."%'";
        }
        if($inputss[1]!=''){
            $sql .=" and corp like '%".$inputss[1]."%'";
        }
        if($inputss[2]!=''){
            $sql .=" and start_time like '%".$inputss[2]."%'";
        }
        if($inputss[3]!=''){
            $sql .=" and end_time like '%".$inputss[3]."%'";
        }
        if($inputss[4]!=''){
            $sql .=" and order_num like '%".$inputss[4]."%'";
        }

        //分页
        $moduleOrders1 = $query->where($sql)->all();
        $pages = new Pagination([
            'defaultPageSize' => '10',
            'totalCount' => (string)count($moduleOrders1),
        ]);

        $moduleOrders = $query->where($sql)->orderBy('id ASC')
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('history',array('moduleOrders' => $moduleOrders,'pages'=>$pages));
    }
    public function actionManagesss(){
        $query=ModuleOrder::find();
        $pages = new Pagination([
            'defaultPageSize' => '10',
            'totalCount' => $query->count(),
        ]);

        //排序
        $it = Yii::$app->request->get('it');

        $moduleOrders = $query->orderBy($it)
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('history',array('moduleOrders' => $moduleOrders,'pages'=>$pages));
    }
    public function actionFind1(){
        $inputss = Yii::$app->request->get('inputss');
        $inputss=explode(',',$inputss);
        $query=ModuleOrder::find();
        date_default_timezone_set("Asia/Shanghai");
        $time=date("Y-m-d H:i:s");
        $dayLater = date('Y-m-d',strtotime("$time + 10 day"));
        //查询
        $sql="end_time in(SELECT max(end_time) FROM  module_order GROUP BY module_id,corp) AND end_time>'".$time."' AND end_time<'".$dayLater."' AND 1=1";

        if($inputss[0]!=''){
            $sql .=" and title like '%".$inputss[0]."%'";
        }
        if($inputss[1]!=''){
            $sql .=" and corp like '%".$inputss[1]."%'";
        }
        if($inputss[2]!=''){
            $sql .=" and start_time like '%".$inputss[2]."%'";
        }
        if($inputss[3]!=''){
            $sql .=" and end_time like '%".$inputss[3]."%'";
        }
        if($inputss[4]!=''){
            $sql .=" and order_num like '%".$inputss[4]."%'";
        }

        //分页
        $endOrders1 = $query->where($sql)->all();
        $pages = new Pagination([
            'defaultPageSize' => '10',
            'totalCount' => (string)count($endOrders1),
        ]);

        $endOrders = $query->where($sql)->orderBy('id ASC')
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('history1',array('endOrders' => $endOrders,'pages'=>$pages));
    }
    public function actionManages1(){
        $query=ModuleOrder::find();
        date_default_timezone_set("Asia/Shanghai");
        $time=date("Y-m-d H:i:s");
        $dayLater = date('Y-m-d',strtotime("$time + 10 day"));
        //排序
        $it = Yii::$app->request->get('it');
        $sql="end_time in(SELECT max(end_time) FROM  module_order GROUP BY module_id,corp) AND end_time>'".$time."' AND end_time<'".$dayLater."' AND 1=1";
        //分页
        $endOrders1 = $query->where($sql)->all();
        $pages = new Pagination([
            'defaultPageSize' => '10',
            'totalCount' => (string)count($endOrders1),
        ]);

        $endOrders = $query->where($sql)->orderBy($it)
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('history1',array('endOrders' => $endOrders,'pages'=>$pages));
    }
    public function actionFind2(){
        $inputss = Yii::$app->request->get('inputss');
        $inputss=explode(',',$inputss);
        $query=ModuleOrder::find();
        date_default_timezone_set("Asia/Shanghai");
        $time=date("Y-m-d H:i:s");
        $dayLater = date('Y-m-d',strtotime("$time + 10 day"));
        //查询
        $sql="end_time in(SELECT max(end_time) FROM  module_order GROUP BY module_id,corp) AND end_time<'".$time."' AND 1=1";

        if($inputss[0]!=''){
            $sql .=" and title like '%".$inputss[0]."%'";
        }
        if($inputss[1]!=''){
            $sql .=" and corp like '%".$inputss[1]."%'";
        }
        if($inputss[2]!=''){
            $sql .=" and start_time like '%".$inputss[2]."%'";
        }
        if($inputss[3]!=''){
            $sql .=" and end_time like '%".$inputss[3]."%'";
        }
        if($inputss[4]!=''){
            $sql .=" and order_num like '%".$inputss[4]."%'";
        }

        //分页
        $endOrders1 = $query->where($sql)->all();
        $pages = new Pagination([
            'defaultPageSize' => '10',
            'totalCount' => (string)count($endOrders1),
        ]);

        $endOrders = $query->where($sql)->orderBy('id ASC')
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('history2',array('endOrders' => $endOrders,'pages'=>$pages));
    }
    public function actionManages2(){
        $query=ModuleOrder::find();
        date_default_timezone_set("Asia/Shanghai");
        $time=date("Y-m-d H:i:s");
        $dayLater = date('Y-m-d',strtotime("$time + 10 day"));
        //排序
        $it = Yii::$app->request->get('it');
        $sql="end_time in(SELECT max(end_time) FROM  module_order GROUP BY module_id,corp) AND end_time<'".$time."' AND 1=1";
        //分页
        $endOrders1 = $query->where($sql)->all();
        $pages = new Pagination([
            'defaultPageSize' => '10',
            'totalCount' => (string)count($endOrders1),
        ]);

        $endOrders = $query->where($sql)->orderBy($it)
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('history2',array('endOrders' => $endOrders,'pages'=>$pages));
    }
}