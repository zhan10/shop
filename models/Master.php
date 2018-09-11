<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use backend\models\User;

class Master extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }


    /**
     * @inheritdoc
     */
    public function rules(){
        return [
            [['username'],'required','message'=>'不能为空'],
            [['username'], 'unique'],
            [['username'],'validateUsername'],
        ];
    }

    public function validateUsername($attribute){
        if (!$this->hasErrors()) {
            $data = User::findOne(['username'=>$this->username]);
            if (!$data) {
                $this->addError($attribute, '用户名不存在！');
            }
        }
    }


}