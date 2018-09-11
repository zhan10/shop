<?php
namespace backend\controllers;

use backend\models\Role;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\Pagination;
use backend\models\Common;
use backend\models\RoleMenu;

class ApiController extends Controller
{
    public $enableCsrfValidation = false;
    public function actionMenu(){
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $id = Yii::$app->request->get("id");
            if(empty($id)){
                return $this->response(4000,"ID NOT NULL");
            }
            $sql = "select m.key,m.name,m.url,m.login_status from role_menu as r INNER JOIN phone_menu as m on r.mid=m.id WHERE r.rid = ".$id;
            $roleMenu = RoleMenu::findBySql($sql)->asArray()->all();
            return json_encode($roleMenu);
        }else{
            return $this->response(4000,"The requested resource does not support http method '".$_SERVER['REQUEST_METHOD']."'.");
        }
    }
    public function actionRole(){
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $role = Role::find()->asArray()->all();
            return $this->response(200,"find succeed",$role);
        }else{
            return $this->response(4000,"The requested resource does not support http method '".$_SERVER['REQUEST_METHOD']."'.");
        }
    }
    public function response($status, $message,$data=null) {
        $response = array(
            'status' => $status,
            'message' => $message,
            'data' => $data
        );
        return json_encode($response);
    }
}
