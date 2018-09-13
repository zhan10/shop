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
    public function actionIndex(){
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        return $this->render('show');
    }
}