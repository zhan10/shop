<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\Pagination;
use backend\models\Note;


class NoteController extends Controller
{
    public function actionIndex(){
        $model = new Note();
        return $this->render('index',[
            'model' => $model
        ]);
    }

    public function actionCreate(){
        $news = new Note();
        if($news->load(Yii::$app->request->post())){
            $title = $news->title;
            $content = $news->content;

            $db_oa_central = Yii::getAlias('@db_oa_central');

            //查询所有公司
            $corp = Yii::$app->db->createCommand("select * from ".$db_oa_central.".reg_corp")
                ->queryAll();

            //遍历所有公司名称
            $corp_domain = array();
            foreach($corp as $key => $value) {
                $corp_domain[] = $value['domain'];
            }
                foreach($corp_domain as $k => $v){
                    //取得公司名称
                    $db_oa_central = "db_oa_".$v."";

                    //查询服务器上的所有库
                    $sql = "select `SCHEMA_NAME` from `information_schema`.`SCHEMATA`";
                    $data = Yii::$app->db->createCommand($sql)
                        ->queryAll();

                    $data_info = array();
                    foreach($data as $k1 => $v1){
                        $data_info[] = $v1['SCHEMA_NAME'];
                    }

                    if(in_array($db_oa_central,$data_info)){
                        $corp_user = Yii::$app->db->createCommand("select * from ".$db_oa_central.".user")
                            ->queryAll();

                        //遍历所有用户
                        $user_info = array();
                        foreach($corp_user as $user => $info) {
                            $user_info[] = $info['id'];
                        }
                        //遍历所有用户的id
                        foreach($user_info as $user1 => $info1){
                            $data = Yii::$app->db->createCommand()->insert("$db_oa_central.message", [
                                'title' => $title,
                                'created_at' =>  date("Y-m-d H:i:s", time()+8*60*60),
                                'created_by' =>'0' ,
                                'updated_at' => date("Y-m-d H:i:s", time()+8*60*60),
                                'updated_by' =>'0',
                            ])->execute();

                            //获取message_id
                            $message_id = Yii::$app->db->getLastInsertID();

                            $message_enrty = Yii::$app->db->createCommand()->insert("$db_oa_central.message_entry", [
                                'message_id' => $message_id,
                                'user_id' =>'0',
                                'file_id' => '' ,
                                'content' => $content,
                                'created_at' =>  date("Y-m-d H:i:s", time()+8*60*60) ,
                                'created_by' => '0' ,
                                'updated_at' =>  date("Y-m-d H:i:s", time()+8*60*60),
                                'updated_by' => '0',
                            ])->execute();

                            //$user_id = 625;
                            $message_enrty = Yii::$app->db->createCommand()->insert("$db_oa_central.user_message", [
                                'message_id' => $message_id,
                                'user_id' => $info1,
                                'is_originator' => '',
                                'last_viewed' =>  '',
                                'created_at' =>  date("Y-m-d H:i:s", time()+8*60*60) ,
                                'created_by' => '' ,
                                'updated_at' =>  date("Y-m-d H:i:s", time()+8*60*60),
                                'updated_by' => '0',
                            ])->execute();
                        }
                    }else{
                        unset($k);
                    }
                }
        }
        return $this->redirect(array('note/index'));
    }
}