<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property int $user_id
 * @property string $date
 *
 * @property OrderDetails[] $orderDetails
 * @property DrugsDrugsCharacteristicsLink $DrugsDrugsCharacteristicsLink
 * @property User $user
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'date'], 'required'],
            [['user_id'], 'integer'],
            [['date'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'date' => 'Дата',
            'count'=>'count'
        ];
    }

    /**
     * Gets query for [[OrderDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderDetails()
    {
        return $this->hasMany(OrderDetails::className(), ['orders_id' => 'id']);
    }

    public function getDrugsDrugsCharacteristicsLink()
    {
        return $this->hasOne(DrugsDrugsCharacteristicsLink::className(), ['id' => 'drugs_drugs_characteristics_link_id'])
            ->viaTable('order_details', ['orders_id' => 'id']);
    }
    public function getDrugsCharacteristics()
    {
        return $this->hasOne(DrugsCharacteristics::className(), ['id' => 'drugs_characteristics_id'])
            ->viaTable('drugs_drugs_characteristics_link', ['id' => 'drugs_drugs_characteristics_link_id'])
            ->viaTable('order_details', ['orders_id' => 'id']);
    }


    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

//    /* Геттеры для фио */
//    public function getUserSurname()
//    {
//        return $this->user->surname;
//    }
//
//    public function getUserName()
//    {
//        return $this->user->name;
//    }
//
//    public function getUserPatronymic()
//    {
//        return $this->user->patronymic;
//    }
}
