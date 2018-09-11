<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "role".
 *
 * @property integer $id
 * @property string $rid
 * @property string $mid
 */
class RoleMenu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'role_menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [];
    }
}
