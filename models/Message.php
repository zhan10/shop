<?php
namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "resource".
 *
 * @property integer $id
 * @property string $texture
 * @property string $mark
 * @property string $manufacturers
 * @property integer $price
 */
class Message extends Model
{
    public $username;
    public $title;
    public $content;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username','title','content'], 'required','message'=>'不能为空'],
            [['username'],'validateName']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app','用户名'),
            'title' => Yii::t('app', '标题'),
            'content' => Yii::t('app','内容'),
        ];
    }

    public function validateName($attribute)
    {
        if (!$this->hasErrors()) {
            $db_oa_central = Yii::getAlias('@db_oa_central');
            if(Yii::$app->request->getIsPost()){
                $data = Yii::$app->request->post();
                    $username = $data['Message']['username'];
                    $post = Yii::$app->db->createCommand("select * from ".$db_oa_central.".user where username = '".$username."'")
                        ->queryOne();
                    if ($post  == false) {
                        $this->addError($attribute, '用户名不存在！');
                        return false;
                    }
            }
        }
    }

/*    public function username(){
        if($this->validate()){
            return true;
        }
        return false;
    }
    public function validateUsername($attribute){
        if (!$this->hasErrors()) {
            $db_oa_central = Yii::getAlias('@db_oa_central');
            if(Yii::$app->request->getIsPost()){
                $data = Yii::$app->request->post();
                $username = $data['Message']['username'];
                $post = Yii::$app->db->createCommand("select * from ".$db_oa_central.".user where username = '".$username."'")
                    ->queryOne();
                if (!empty($post)) {
                  return  $this->addError($attribute, '用户名已存在！');
                }
            }
        }
    }*/
}