<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "role".
 *
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property string $login_status
 * @property string $img
 * @property string $created_at
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'phone_menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [];
    }

    public function attributeLabels(){
        return [
            'name' => '菜单名称',
            'url' => 'URL（原生模块不需要填写）',
            'img' => 'Icon(请上传图片类型是.png，256 * 256像素的图片)',
            'login_status'=>'是否需要登陆'
        ];
    }
}
