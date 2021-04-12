<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order_details".
 *
 * @property int $id
 * @property int $orders_id
 * @property int $drugs_drugs_characteristics_link_id
 * @property int $count
 *
 * @property DrugsDrugsCharacteristicsLink $drugsDrugsCharacteristicsLink
 * @property DrugsCharacteristics $drugsCharacteristics
 * @property Orders $orders
 */
class OrderDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['orders_id', 'drugs_drugs_characteristics_link_id', 'count'], 'required'],
            [['orders_id', 'drugs_drugs_characteristics_link_id', 'count'], 'integer'],
            [['drugs_drugs_characteristics_link_id'], 'exist', 'skipOnError' => true, 'targetClass' => DrugsDrugsCharacteristicsLink::className(), 'targetAttribute' => ['drugs_drugs_characteristics_link_id' => 'id']],
            [['orders_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::className(), 'targetAttribute' => ['orders_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'orders_id' => 'Orders ID',
            'drugs_drugs_characteristics_link_id' => 'Drugs Drugs Characteristics Link ID',
            'count' => 'Количество',
            'form' => 'Форма выпуска',
            'dosage' => 'Дозировка',
            'cost' => 'Цена',
            'tradeName'=>'Препарат',
        ];
    }

    /**
     * Gets query for [[DrugsDrugsCharacteristicsLink]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDrugsDrugsCharacteristicsLink()
    {
        return $this->hasOne(DrugsDrugsCharacteristicsLink::className(), ['id' => 'drugs_drugs_characteristics_link_id']);
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasOne(Orders::className(), ['id' => 'orders_id']);
    }

    public function getDrugsCharacteristics()
    {
        return $this->hasOne(DrugsCharacteristics::className(), ['id' => 'drugs_characteristics_id'])->viaTable('drugs_drugs_characteristics_link', ['id' => 'drugs_drugs_characteristics_link_id']);
    }
    public function getDrugs()
    {
        return $this->hasOne(Drugs::className(), ['id' => 'drugs_id'])->viaTable('drugs_drugs_characteristics_link', ['id' => 'drugs_drugs_characteristics_link_id']);
    }

    public static function pageTotal($provider, $fieldName)
    {
        $total=0;
        foreach($provider as $item){
            $total+=$item[$fieldName];
        }
        return $total;
    }
    public static function getTotalSum($provider)
    {
        $total = 0;
        foreach ($provider as $item) {
           $total += $item->count*$item->drugsCharacteristics->cost;
        }
        return $total;
    }
    public static function getTotalCount($provider)
    {
        $total = 0;
        foreach ($provider as $item) {
            $total += $item->count;
        }
        return $total;
    }

}
