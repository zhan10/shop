<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property string $module_id
 * @property string $order_num
 * @property string $total_price
 * @property string $start_time
 * @property string $end_time
 * @property string $duration
 * @property string $state
 * @property string $corp_id
 * @property string $corp
 * @property string $user_id
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['module_id'], 'string'],
        ];
    }

}
