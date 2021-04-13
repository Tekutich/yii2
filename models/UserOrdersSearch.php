<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * OrdersSearch модель для поиска по `app\models\Orders`.
 */
class UserOrdersSearch extends Orders
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id',], 'integer'],
            [['date', 'user_id'], 'safe'],


        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Создает экземпляр поставщика данных(DataProvider) с примененным поисковым запросом
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Orders::find()->where(['user_id' => \Yii::$app->user->identity->id]);
        $query->joinWith(['user']);
        $query->joinWith(['orderDetails']);
        $query->joinWith(['orderDetails.drugsCharacteristics']);
        $query->joinWith(['orderDetails.drugs']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $dataProvider->setSort([
            'defaultOrder' => [
                'date' => SORT_DESC
            ],
            'attributes' => [
                'date' => [
                    'asc' => ['orders.date' => SORT_ASC],
                    'desc' => ['orders.date' => SORT_DESC],
                    'label' => 'Дата'
                ],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'date' => $this->date ? \Yii::$app->formatter->asDate($this->date, 'yyyy-MM-dd') : null,
        ]);
        return $dataProvider;
    }
}
