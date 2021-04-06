<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "drugs_drugs_indications_for_use_link".
 *
 * @property int $drugs_id
 * @property int $drugs_indications_for_use_id
 *
 * @property Drugs $drugs
 * @property DrugsIndicationsForUse $drugsIndicationsForUse
 */
class DrugsDrugsIndicationsForUseLink extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'drugs_drugs_indications_for_use_link';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['drugs_id', 'drugs_indications_for_use_id'], 'required'],
            [['drugs_id', 'drugs_indications_for_use_id'], 'integer'],
            [['drugs_id', 'drugs_indications_for_use_id'], 'unique', 'targetAttribute' => ['drugs_id', 'drugs_indications_for_use_id']],
            [['drugs_id'], 'exist', 'skipOnError' => true, 'targetClass' => Drugs::className(), 'targetAttribute' => ['drugs_id' => 'id']],
            [['drugs_indications_for_use_id'], 'exist', 'skipOnError' => true, 'targetClass' => DrugsIndicationsForUse::className(), 'targetAttribute' => ['drugs_indications_for_use_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'drugs_id' => 'Drugs ID',
            'drugs_indications_for_use_id' => 'Drugs Indications For Use ID',
        ];
    }

    /**
     * Gets query for [[Drugs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDrugs()
    {
        return $this->hasOne(Drugs::className(), ['id' => 'drugs_id']);
    }

    /**
     * Gets query for [[DrugsIndicationsForUse]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDrugsIndicationsForUse()
    {
        return $this->hasOne(DrugsIndicationsForUse::className(), ['id' => 'drugs_indications_for_use_id']);
    }
}
