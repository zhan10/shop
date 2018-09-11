<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property string $module_id
 * @property string $title
 * @property string $base_price
 * @property string $state
 */
class BaseModule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(){
        return 'base_module';
    }

    /**
     * @inheritdoc
     */
    public function rules(){
        return [
            [['module_id'], 'string'],
        ];
    }

}
