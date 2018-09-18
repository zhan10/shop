<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\CurrentOnline;
/**
 * Comm controller
 */
class CommController extends Controller
{
    public function init(){
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
    }
}