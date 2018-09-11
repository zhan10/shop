<?php
namespace backend\models;

use Yii;
use yii\base\Model;

class Admin extends \yii\db\ActiveRecord
{
    public $password;
    public $confirmPassword;
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
            [['username','password_hash','confirmPassword','email'],'required','message'=>'不能为空'],
            [['email'],'email'],
            [['confirmPassword'],'compare','compareAttribute' => 'password_hash']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(){
        return [
            'username' => '用户名',
            'password_hash' => '密码',
            'confirmPassword' => '确认密码',
            'email' => '邮箱'
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password_hash);
        $user->generateAuthKey();

        return $user->save() ? $user : null;
    }
}