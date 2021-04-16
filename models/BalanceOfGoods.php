<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "balance_of_goods".
 *
 * @property int $id
 * @property int $pharmacies_id
 * @property int $drugs_drugs_characteristics_link_id
 * @property int $balance
 *
 * @property DrugsDrugsCharacteristicsLink $drugsDrugsCharacteristicsLink
 * @property Pharmacies $pharmacies
 */
class BalanceOfGoods extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'balance_of_goods';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pharmacies_id', 'drugs_drugs_characteristics_link_id', 'balance'], 'required'],
            [['pharmacies_id', 'drugs_drugs_characteristics_link_id', 'balance'], 'integer'],
            [['drugs_drugs_characteristics_link_id'], 'exist', 'skipOnError' => true, 'targetClass' => DrugsDrugsCharacteristicsLink::className(), 'targetAttribute' => ['drugs_drugs_characteristics_link_id' => 'id']],
            [['pharmacies_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pharmacies::className(), 'targetAttribute' => ['pharmacies_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pharmacies_id' => 'Pharmacies ID',
            'drugs_drugs_characteristics_link_id' => 'Drugs Drugs Characteristics Link ID',
            'balance' => 'Balance',
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
     * Gets query for [[Pharmacies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPharmacies()
    {
        return $this->hasOne(Pharmacies::className(), ['id' => 'pharmacies_id']);
    }
}
