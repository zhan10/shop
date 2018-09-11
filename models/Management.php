<?php
namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class Management extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['corp', 'organization_code','business_license','domain','expendamount','username','mobile','email'
            ,'employees_number','company_located','industry','created_at'], 'required'],
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'management';
    }
}
