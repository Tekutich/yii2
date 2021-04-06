<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "drugs_characteristics".
 *
 * @property int $id
 * @property string $form_of_issue форма выпуска
 * @property string $dosage дозировка
 * @property float $cost цена
 *
 * @property DrugsDrugsCharacteristicsLink[] $drugsDrugsCharacteristicsLinks
 * @property Drugs[] $drugs
 */
class DrugsCharacteristics extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'drugs_characteristics';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['form_of_issue', 'dosage', 'cost'], 'required'],
            [['cost'], 'number'],
            [['form_of_issue', 'dosage'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'form_of_issue' => 'форма выпуска',
            'dosage' => 'дозировка',
            'cost' => 'цена',
        ];
    }

    /**
     * Gets query for [[DrugsDrugsCharacteristicsLinks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDrugsDrugsCharacteristicsLinks()
    {
        return $this->hasMany(DrugsDrugsCharacteristicsLink::className(), ['drugs_characteristics_id' => 'id']);
    }

    /**
     * Gets query for [[Drugs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDrugs()
    {
        return $this->hasMany(Drugs::className(), ['id' => 'drugs_id'])->viaTable('drugs_drugs_characteristics_link', ['drugs_characteristics_id' => 'id']);
    }
}
