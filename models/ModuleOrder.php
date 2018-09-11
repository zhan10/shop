<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property string $module_id
 * @property string $corp
 * @property string $domain
 * @property string $username
 * @property string $mobile
 * @property string $email
 * @property string $order_num
 * @property string $total_price
 * @property string $start_time
 * @property string $end_time
 * @property integer $state
 * @property string $title
 * @property string $base_price
 * @property string $duration
 */
class ModuleOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'module_order';
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
