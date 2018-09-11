<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\Pagination;
use backend\models\Message;


class MessageController extends Controller
{

    public function actionIndex(){
        $message = new Message();
        if($message->load(Yii::$app->request->post()) && $message->validate()){
            return $this->actionCreate();
        }
        $username = Yii::$app->request->get('username');
       // $username = 'master1';
        return $this->render('index',[
            'message' => $message,
            'username' => $username,
        ]);
    }

    public function actionCreate(){
        $model = new Message();
        if ($model->load(Yii::$app->request->post())) {
            $username = $model->username;
            $title = $model->title;
            $content = $model->content;
            $db_oa_central = Yii::getAlias('@db_oa_central');
            $user = Yii::$app->db->createCommand("select * from ".$db_oa_central.".user")->queryAll();
            $data = Yii::$app->db->createCommand("select * from ".$db_oa_central.".user where username = '".$username."'")
                ->queryOne();

            $id = $data['id'];
            $corp1 = Yii::$app->db->createCommand("select * from ".$db_oa_central.".user_corp where user_id = '".$id."'")
                ->queryOne();
            $corp_id = $corp1['corp_id'];

            $corp2 = Yii::$app->db->createCommand("select * from ".$db_oa_central.".reg_corp where id = '".$corp_id."'")
                ->queryOne();
            $domain = $corp2['domain'];



            //$db_oa_central = 'db_oa_huawei';
            $db_oa_central = "db_oa_".$domain."";


            Yii::$app->db->createCommand("UPDATE ".$db_oa_central.".message  SET title ='1' WHERE id = '22'")
                ->execute();

            $data = Yii::$app->db->createCommand()->insert("$db_oa_central.message", [
                'title' => $title,
                'created_at' =>  date("Y-m-d H:i:s", time()+8*60*60),
                'created_by' =>'0' ,
                'updated_at' => date("Y-m-d H:i:s", time()+8*60*60),
                'updated_by' =>'0',
            ])->execute();

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

            $message_enrty = Yii::$app->db->createCommand()->insert("$db_oa_central.user_message", [
                'message_id' => $message_id,
                'user_id' => $id,
                'is_originator' => '',
                'last_viewed' =>  '',
                'created_at' =>  date("Y-m-d H:i:s", time()+8*60*60) ,
                'created_by' => '' ,
                'updated_at' =>  date("Y-m-d H:i:s", time()+8*60*60),
                'updated_by' => '0',
            ])->execute();
        }
        return $this->redirect(array('message/index'));
    }

}