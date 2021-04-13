<?php

namespace app\models;

use Yii;
use yii\helpers\VarDumper;

/**
 * Класс модели таблицы "orders".
 *
 * @property int $id
 * @property int $user_id
 * @property string $date
 *
 * @property OrderDetails[] $orderDetails модель OrderDetails
 * @property DrugsDrugsCharacteristicsLink $DrugsDrugsCharacteristicsLink модель DrugsDrugsCharacteristicsLink
 * @property User $user модель User
 * @property $productCart товары добавленные в корзину
 */
class Orders extends \yii\db\ActiveRecord
{
    public $productCart;

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
            [['date', 'drugs_drugs_characteristics_link_id'], 'safe'],
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
            'count' => 'count'
        ];
    }

    /**
     * Связь с  [[OrderDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderDetails()
    {
        return $this->hasMany(OrderDetails::className(), ['orders_id' => 'id']);
    }

    /**
     * Связь с [[DrugsDrugsCharacteristicsLink]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDrugsDrugsCharacteristicsLink()
    {
        return $this->hasOne(DrugsDrugsCharacteristicsLink::className(), ['id' => 'drugs_drugs_characteristics_link_id'])
            ->viaTable('order_details', ['orders_id' => 'id']);
    }

    /**
     * Связь с [[DrugsCharacteristics]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDrugsCharacteristics()
    {
        return $this->hasOne(DrugsCharacteristics::className(), ['id' => 'drugs_characteristics_id'])
            ->viaTable('drugs_drugs_characteristics_link', ['id' => 'drugs_drugs_characteristics_link_id'])
            ->viaTable('order_details', ['orders_id' => 'id']);
    }


    /**
     * Связь с [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            foreach ($this->productCart as $value) {
                $orderDetails = new OrderDetails();
                $orderDetails->drugs_drugs_characteristics_link_id = $value['id'];
                $orderDetails->orders_id = $this->id;
                $orderDetails->count = $value['quantity'];
                $orderDetails->save();
            }
        }

        return true;
    }
}
