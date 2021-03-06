<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%action_log}}".
 *
 * @property int    $id
 * @property int    $user_id
 * @property string $entity_name
 * @property string $entity_id
 * @property string $action_type
 * @property string $old_data
 * @property string $new_data
 * @property int    $apply_time
 */
class ActionLog extends ActiveRecord
{
    const ACTION_TYPE_CREATE = 'create';
    const ACTION_TYPE_UPDATE = 'update';
    const ACTION_TYPE_DELETE = 'delete';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%action_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'entity_name', 'action_type', 'apply_time'], 'required'],
            [['user_id', 'apply_time'], 'integer'],
            [['old_data', 'new_data'], 'string'],
            [['entity_name', 'entity_id'], 'string', 'max' => 45],
            [['action_type'], 'string', 'max' => 15],
            [['entity_id', 'old_data', 'new_data'], 'default', 'value' => ''],
            [
                ['user_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::class,
                'targetAttribute' => ['user_id' => 'id']
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'user_id'     => 'User ID',
            'entity_name' => 'Entity Name',
            'entity_id'   => 'Entity ID',
            'action_type' => 'Action Type',
            'old_data'    => 'Old Data',
            'new_data'    => 'New Data',
            'apply_time'  => 'Apply Time',
        ];
    }

    public static function write(
        string $entityName,
        string $entityId,
        string $actionType,
        $oldData,
        $newData
    ) {
        $newActionLog              = new self();
        $newActionLog->user_id     = empty(Yii::$app->user) ? 1 : Yii::$app->user->getId(); //TODO fix user id
        $newActionLog->entity_name = $entityName;
        $newActionLog->entity_id   = $entityId;
        $newActionLog->action_type = $actionType;
        $newActionLog->old_data    = (is_string($oldData) ? $oldData : serialize($oldData));
        $newActionLog->new_data    = (is_string($newData) ? $newData : serialize($newData));
        $newActionLog->apply_time  = time();

        if (! $newActionLog->validate()) {
            throw new \Exception('Some of action log attribute not valid');
        }

        if (! $newActionLog->save()) {
            throw new \Exception('Can`t save action log');
        }
    }
}
