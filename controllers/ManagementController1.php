<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\Pagination;
use backend\models\Management;
use backend\models\CompanyModule;
use backend\models\Common;

/**
 * Dashboard controller
 */
class ManagementController extends Controller
{
    public $enableCsrfValidation = false;
    public function actionDemo(){
        $url = 'http://220.249.79.2:40000/api/v2/common/province';
        $rec=$this->request_get($url);
        return $this->render('demo',['rec'=>json_decode($rec,1)]);
    }
    public function actionData(){
        $current = 0;
        $sort = '';
        $parameters = Yii::$app->request->post();
        $db_oa_central = Yii::getAlias('@db_oa_central');
        $rows = (new \yii\db\Query())->select('*')->from($db_oa_central.".e_company");
        foreach($parameters["sort"] as $k=>$v){
            $sort = $k." ".$v;
        }
        if ($parameters["current"]!=2){
            $current = $parameters["current"]+($parameters["current"]*$parameters["rowCount"]-$parameters["rowCount"])-$parameters["current"];
        }else if($parameters["current"]==2) {
            $current = $parameters["current"] + $parameters["rowCount"] - $parameters["current"];
        }
        $data = $rows->orderBy($sort)->offset($current)->limit($parameters["rowCount"])->all();
        $result = array(
            'current' => $parameters["current"],
            'rowCount' => $parameters["rowCount"],
            'rows' => $data,
            "total" => $rows->count()
        );
        $json_data = json_encode($result);
        echo $json_data;
    }

    public function actionManage(){
            $query = Management::find();
            $pages = new Pagination([
                'defaultPageSize' => '8',
                'totalCount' => $query->count(),
            ]);

            $management = $query->orderBy('id DESC')
                ->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
            $query1=null;

            return $this->render('manage',[
                'management' => $management,
                'query1'=> $query1,
                'pages' => $pages,
            ]);
    }


    public function actionManages(){
    $query = Management::find();
    $pages = new Pagination([
       'defaultPageSize' => '8',
        'totalCount' => $query->count(),
    ]);

   $management = $query->orderBy('id DESC')
        ->offset($pages->offset)
       ->limit($pages->limit)
        ->all();



    $datas = Yii::$app->request->get('datas');
    $db_oa_central = Yii::getAlias('@db_oa_central');
    $query1=Yii::$app->db->createCommand("
         SELECT
         ".$db_oa_central.".reg_corp.corp as corp,
         ".$db_oa_central.".order.module_id as module_id,
         ".$db_oa_central.".order.order_num as order_num,
         ".$db_oa_central.".order.total_price as total_price,
         ".$db_oa_central.".order.duration as duration,
         ".$db_oa_central.".order.start_time as start_time,
         ".$db_oa_central.".order.end_time as end_time
         FROM
         ".$db_oa_central.".order
        INNER JOIN ".$db_oa_central.".reg_corp ON ".$db_oa_central.".reg_corp.id = ".$db_oa_central.".order.corp_id
         WHERE ".$db_oa_central.".order.corp_id='".$datas."'
         ")->queryAll();
    return $this->render('manage',[
        'management' => $management,
        'query1' => $query1,
        'pages' => $pages,
    ]);
}
    public function actionManagess(){
        $inputss = Yii::$app->request->get('inputss');
        $inputss=explode(',',$inputss);
        $inputss[3]=intval($inputss[3]);

        $query = Management::find();


        //查询
        $sql="1=1";
        if($inputss[0]!=''){
            $sql .=" and corp like '%".$inputss[0]."%'";
        }
        if($inputss[1]!=''){
            $sql .=" and domain like '%".$inputss[1]."%'";
        }
        if($inputss[2]!=''){
            $sql .=" and username like '%".$inputss[2]."%'";
        }
        if($inputss[3]!=''){
            $sql .=" and mobile = ".$inputss[3];
        }
        if($inputss[4]!=''){
            $sql .=" and email like '%".$inputss[4]."%'";
        }

        //分页
        $management1 = $query->where($sql)->all();
        $pages = new Pagination([
            'defaultPageSize' => '8',
            'totalCount' => (string)count($management1),
        ]);

        $management = $query->where($sql)->orderBy('id DESC')
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        $datas = Yii::$app->request->get('datas');
        $db_oa_central = Yii::getAlias('@db_oa_central');
        $query1=Yii::$app->db->createCommand("
         SELECT
         ".$db_oa_central.".reg_corp.corp as corp,
         ".$db_oa_central.".order.module_id as module_id,
         ".$db_oa_central.".order.order_num as order_num,
         ".$db_oa_central.".order.total_price as total_price,
         ".$db_oa_central.".order.duration as duration,
         ".$db_oa_central.".order.start_time as start_time,
         ".$db_oa_central.".order.end_time as end_time
         FROM
         ".$db_oa_central.".order
        INNER JOIN ".$db_oa_central.".reg_corp ON ".$db_oa_central.".reg_corp.id = ".$db_oa_central.".order.corp_id
         WHERE ".$db_oa_central.".order.corp_id='".$datas."'
         ")->queryAll();
        return $this->render('manage',[
            'management' => $management,
            'query1' => $query1,
            'pages' => $pages,
        ]);
    }
    public function actionManagesss(){
        $query = Management::find();
        $pages = new Pagination([
            'defaultPageSize' => '8',
            'totalCount' => $query->count(),
        ]);

        //排序
        $it = Yii::$app->request->get('it');

        $management = $query->orderBy($it)
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();



        $datas = Yii::$app->request->get('datas');
        $db_oa_central = Yii::getAlias('@db_oa_central');
        $query1=Yii::$app->db->createCommand("
         SELECT
         ".$db_oa_central.".reg_corp.corp as corp,
         ".$db_oa_central.".order.module_id as module_id,
         ".$db_oa_central.".order.order_num as order_num,
         ".$db_oa_central.".order.total_price as total_price,
         ".$db_oa_central.".order.duration as duration,
         ".$db_oa_central.".order.start_time as start_time,
         ".$db_oa_central.".order.end_time as end_time
         FROM
         ".$db_oa_central.".order
        INNER JOIN ".$db_oa_central.".reg_corp ON ".$db_oa_central.".reg_corp.id = ".$db_oa_central.".order.corp_id
         WHERE ".$db_oa_central.".order.corp_id='".$datas."'
         ")->queryAll();
        return $this->render('manage',[
            'management' => $management,
            'query1' => $query1,
            'pages' => $pages,
        ]);
    }
    public function actionOpen(){
        $id = 986;
        $db_oa_central = Yii::getAlias('@db_oa_central');
        $sql = "SELECT * FROM ".$db_oa_central.".e_company
        INNER JOIN ".$db_oa_central.".user ON ".$db_oa_central.".user.cid = ".$db_oa_central.".e_company.id
        WHERE ".$db_oa_central.".e_company.id='".$id."'";
        $query=Yii::$app->db->createCommand($sql)->queryAll();
        echo json_encode($query);
    }
    public function actionEdit(){
        $data = Yii::$app->request->post();
    }
    public function actionAdd(){
        $data = Yii::$app->request->post();

        $json_Array = json_decode($this->registerUcenterUser($data["mobile"],$data["name"]),true);

        $file = $_FILES['orgCodeImg'];//得到图片传输的数据

        $url = 'http://saas.humhub.com/index.php?r=installer/setup/interface-database';
        $data['openid'] = $json_Array['data']['0']['openid'];
        //得到文件名称
        $data['fileName'] = $file['name'];
        $o = "";
        foreach( $data as $k => $v )
        {
            $o.= "$k=" . urlencode( $v ). "&" ;
        }
        $post_data = substr($o,0,-1);

        $res = $this->request_post($url,$post_data);

        return $this->redirect('?r=management%2Fdemo');
    }

    //获取城市
    public function actionGetCity(){
        $url = 'http://220.249.79.2:40000/api/v2/common/city?province='.$_GET['province'];
        $rec=$this->request_get($url);
        echo $rec;
    }

    //获取地区
    public function actionGetDistrict(){
        $url = 'http://220.249.79.2:40000/api/v2/common/district?city='.$_GET['city'];
        $rec=$this->request_get($url);
        echo $rec;
    }
}
