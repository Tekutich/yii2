<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pharmacies".
 *
 * @property int $id
 * @property string $name
 * @property string $address
 *
 * @property BalanceOfGoods[] $balanceOfGoods
 */
class Pharmacies extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pharmacies';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'address'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['address'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'address' => 'Address',
        ];
    }

    /**
     * Gets query for [[BalanceOfGoods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBalanceOfGoods()
    {
        return $this->hasMany(BalanceOfGoods::className(), ['pharmacies_id' => 'id']);
    }
}
