<?php
namespace backend\models;

use Yii;
use yii\base\Model;


class RegadminForm extends Model{
    public $username;
    public $password;
    public $newsPassword;
    public $confirmPassword;

    private $_user;

    public function rules(){
        return [
            [['password','newsPassword','confirmPassword'],'required','message'=>'不能为空'],
            [['password'],'validatePassword'],
            [['confirmPassword'], 'compare', 'compareAttribute' => 'newsPassword','message'=> '新密码与确认密码不一致！'],
            [['confirmPassword'], 'compare', 'compareAttribute' => 'newsPassword',],
        ];
    }
    public function attributeLabels(){
        return [
            'username' => '用户名',
            'password' => '旧密码',
            'newsPassword' => '新密码',
            'confirmPassword' => '确认密码',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user->validatePassword($this->password)) {
                $this->addError($attribute, '旧密码输入错误');
            }
        }
    }

    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser());
        } else {
            return false;
        }
    }


    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this['username']);
        }

        return $this->_user;
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
        $user->setPassword($this->password);
        $user->generateAuthKey();

        return $user->save() ? $user : null;
    }
}