<?php

namespace backend\models;

use Yii;

/**
 *
 * @property integer $id
 * @property string $insert_time
 * @property string $current_online
 */
class CurrentOnline extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'highest_current_online';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

        ];
    }

}
