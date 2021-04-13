<?php

namespace app\models;

use Yii;

/**
 * Класс модели таблицы "drugs" "drugs_drugs_characteristics_link".
 *
 * @property int $drugs_id
 * @property int $drugs_characteristics_id
 * @property int $id
 *
 * @property Drugs $drugs модель Drugs
 * @property DrugsCharacteristics $drugsCharacteristics модель DrugsCharacteristics
 * @property OrderDetails[] $orderDetails модель OrderDetails
 */
class DrugsDrugsCharacteristicsLink extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'drugs_drugs_characteristics_link';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['drugs_id', 'drugs_characteristics_id'], 'required'],
            [['drugs_id', 'drugs_characteristics_id'], 'integer'],
            [['drugs_id'], 'exist', 'skipOnError' => true, 'targetClass' => Drugs::className(), 'targetAttribute' => ['drugs_id' => 'id']],
            [['drugs_characteristics_id'], 'exist', 'skipOnError' => true, 'targetClass' => DrugsCharacteristics::className(), 'targetAttribute' => ['drugs_characteristics_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'drugs_id' => 'Drugs ID',
            'drugs_characteristics_id' => 'Drugs Characteristics ID',
            'id' => 'ID',
        ];
    }

    /**
     * Связь с[[Drugs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDrugs()
    {
        return $this->hasOne(Drugs::className(), ['id' => 'drugs_id']);
    }

    /**
     * Связь с [[DrugsCharacteristics]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDrugsCharacteristics()
    {
        return $this->hasOne(DrugsCharacteristics::className(), ['id' => 'drugs_characteristics_id']);
    }

    /**
     * Связь с [[OrderDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderDetails()
    {
        return $this->hasMany(OrderDetails::className(), ['drugs_drugs_characteristics_link_id' => 'id']);
    }
}
