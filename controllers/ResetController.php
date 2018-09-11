<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\Master;
use common\models\User;

/**
 * Site controller
 */
class ResetController extends Controller
{
    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $model = new Master();

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionReset()
    {
            $user = new Master();
            $username = Yii::$app->request->get('username');
            $password = '123456';

            $user = new User();
            $user->setPassword($password);
            $password_hash = $user->password_hash;
            $user->generateAuthKey();
            $auth_key = $user ->auth_key;

            $info = User::findOne(['username'=>$username]);
            $info->password_hash = $password_hash;
            $info->auth_key = $auth_key;
            $info->save();

            return $this->redirect(array('user/list'));

        }
}
