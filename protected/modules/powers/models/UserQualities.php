<?php

namespace app\modules\powers\models;

use Yii;
use humhub\modules\user\models\User;
use app\modules\matching_questions\models\Qualities;

/**
 * This is the model class for table "user_qualities".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $quality_id
 * @property integer $total_value
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Qualities $quality
 * @property User $user
 */
class UserQualities extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_qualities';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'quality_id', 'total_value'], 'required'],
            [['user_id', 'quality_id', 'total_value'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['quality_id'], 'exist', 'skipOnError' => true, 'targetClass' => Qualities::className(), 'targetAttribute' => ['quality_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('PowersModule.base', 'ID'),
            'user_id' => Yii::t('PowersModule.base', 'User ID'),
            'quality_id' => Yii::t('PowersModule.base', 'Quality ID'),
            'total_value' => Yii::t('PowersModule.base', 'Total Value'),
            'created_at' => Yii::t('PowersModule.base', 'Created At'),
            'updated_at' => Yii::t('PowersModule.base', 'Modified At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuality()
    {
        return $this->hasOne(Qualities::className(), ['id' => 'quality_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}