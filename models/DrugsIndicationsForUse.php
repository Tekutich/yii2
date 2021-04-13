<?php

namespace app\models;

use Yii;

/**
 * Класс модели таблицы "drugs_indications_for_use".
 *
 * @property int $id
 * @property string $indication показания к применению
 *
 * @property DrugsDrugsIndicationsForUseLink[] $drugsDrugsIndicationsForUseLinks модель DrugsDrugsIndicationsForUseLink
 * @property Drugs[] $drugs модель Drugs
 */
class DrugsIndicationsForUse extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'drugs_indications_for_use';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['indication'], 'required'],
            [['indication'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'indication' => 'показания к применению',
        ];
    }

    /**
     * Связь с [[DrugsDrugsIndicationsForUseLinks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDrugsDrugsIndicationsForUseLinks()
    {
        return $this->hasMany(DrugsDrugsIndicationsForUseLink::className(), ['drugs_indications_for_use_id' => 'id']);
    }

    /**
     * Связь с [[Drugs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDrugs()
    {
        return $this->hasMany(Drugs::className(), ['id' => 'drugs_id'])->viaTable('drugs_drugs_indications_for_use_link', ['drugs_indications_for_use_id' => 'id']);
    }
}
