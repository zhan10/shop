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
class DashboardController extends CommController
{
    public function actionIndex(){
        $a = Yii::$app->request->post();
        return $this->render('show');
    }
}