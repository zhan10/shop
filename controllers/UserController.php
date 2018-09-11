<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\Pagination;
use common\models\User;
use backend\models\Master;
use backend\models\Admin;

class UserController extends Controller{
    public function actionList(){
        $username = Yii::$app->request->post('username');
        $email = Yii::$app->request->post('email');

        //查询
        $sql="1=1";
        if($username != null){
            $sql .=" and username like '%".$username."%'";
        }
        if($email != null){
            $sql .=" and email like '%".$email."%'";
        }


        $query = User::find();
        $pages = new Pagination([
            'defaultPageSize' => '10',
            'totalCount' => $query->count(),
        ]);

        $user = $query->where($sql)->orderBy('id ASC')
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('list',[
            'user' => $user,
            'pages' => $pages,
        ]);
    }

    public function actionIndex(){
        $admin = new Admin();
        return $this->render('add',[
            'admin' => $admin
        ]);
    }

    public function actionAdd(){
        $user = new Admin();
        if($user->load(Yii::$app->request->post() )){
            $model = $user->signup();
        }
        return $this->redirect(array('user/list'));
    }

    public function actionUpdate($id = ''){
        if($id){
            $user = Admin::findOne($id);
            $id =  Yii::$app->request->get('id');
            return $this->render('update',[
                'user' => $user,
                'id' => $id,
            ]);
        }
    }


    public function actionEdit(){
        $user = new User();
        $id = Yii::$app->request->post('Admin')['id'];
        $username = Yii::$app->request->post('Admin')['username'];
        $email = Yii::$app->request->post('Admin')['email'];

        $user = User::findOne($id);
        $user->username =$username;
        $user->email = $email;

        $user->save();
        return $this->redirect(array('user/list'));
    }

    public function actionDelete($id){
        User::findOne($id)->delete();
        return $this->redirect(array('user/list'));
    }

    protected function findModel($id){
        if($model = User::findOne($id) !== null){
            return $model;
        }
    }
}