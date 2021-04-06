<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "drugs".
 *
 * @property int $id
 * @property string $trade_name торговое название препарата
 * @property string $international_name международное непатентованное название
 */
class Drugs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'drugs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['trade_name', 'international_name'], 'required'],
            [['trade_name', 'international_name'], 'string', 'max' => 255],
        ];
    }

//    /**
//     * {@inheritdoc}
//     */
//    public function attributeLabels()
//    {
//        return [
//            'id' => 'ID',
//            'trade_name' => 'trade_name',
//            'international_name' => 'международное непатентованное название',
//        ];
//    }


    /**
     * Gets query for [[DrugsDrugsCharacteristicsLinks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDrugsDrugsCharacteristicsLinks()
    {
        return $this->hasMany(DrugsDrugsCharacteristicsLink::className(), ['drugs_id' => 'id']);
    }

    /**
     * Gets query for [[DrugsCharacteristics]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDrugsCharacteristics()
    {
        return $this->hasMany(DrugsCharacteristics::className(), ['id' => 'drugs_characteristics_id'])->viaTable('drugs_drugs_characteristics_link', ['drugs_id' => 'id']);

    }

    /**
     * Gets query for [[DrugsDrugsIndicationsForUseLinks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDrugsDrugsIndicationsForUseLinks()
    {

        return $this->hasMany(DrugsDrugsIndicationsForUseLink::className(), ['drugs_id' => 'id']);
    }

    /**
     * Gets query for [[DrugsIndicationsForUses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDrugsIndicationsForUses()
    {
        return $this->hasMany(DrugsIndicationsForUse::className(), ['id' => 'drugs_indications_for_use_id'])->viaTable('drugs_drugs_indications_for_use_link', ['drugs_id' => 'id']);
    }

}
