<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\RegadminForm;
use common\models\User;


class UpdatepwdController extends Controller
{
    public function actionFind(){
        $regadmin = new RegadminForm();
        $session = Yii::$app->session;
        $username = $session['username'];
        $regadmin['username'] =$username;
         if($regadmin->load(Yii::$app->request->post()) && $regadmin->login()){
           $data = User::findOne(['username'=>$username]);
           $id = $data['id'];
           $pwd = $data['password_hash'];
           $password = Yii::$app->request->post('RegadminForm')['newsPassword'];

             $user = new User();
             $user->setPassword($password);
             $password_hash = $user->password_hash;
             $user->generateAuthKey();
             $auth_key = $user ->auth_key;

             $info = User::findOne($id);
             $info->password_hash = $password_hash;
             $info->auth_key = $auth_key;
             $info->save();

         }
        return $this->render('index',[
            'regadmin' => $regadmin,
            'username'=>$username,
        ]);
    }
}