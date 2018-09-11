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
class Note extends Model
{
    public $title;
    public $content;
    public $company;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username','title','content'], 'required','message'=>'不能为空'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'company' => Yii::t('app','公司名称'),
            'title' => Yii::t('app', '标题'),
            'content' => Yii::t('app','内容'),
        ];
    }
}