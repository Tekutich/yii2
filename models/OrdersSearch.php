<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * OrdersSearch модель для поиска по `app\models\Orders`.
 */
class OrdersSearch extends Orders
{
    public $userSur;
    public $userName;
    public $userPatronymic;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id',], 'integer'],
            [['date', 'user_id', 'userSur', 'userName', 'userPatronymic','id'], 'safe'],
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
        $query = Orders::find();
        $query->joinWith(['user']);
        $query->joinWith(['orderDetails']);
        $query->joinWith(['orderDetails.drugsCharacteristics']);
        $query->joinWith(['orderDetails.drugs']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $dataProvider->setSort([
            'defaultOrder' => [
                'date' => SORT_DESC,
                'id' => SORT_DESC
            ],
            'attributes' => [
                'userSur' => [
                    'asc' => ['users.surname' => SORT_ASC],
                    'desc' => ['users.surname' => SORT_DESC],
                    'label' => 'Фамилия'
                ],
                'id' => [
                    'asc' => ['id' => SORT_ASC],
                    'desc' => ['id' => SORT_DESC],
                    'label' => 'ID'
                ],
                'userName' => [
                    'asc' => ['users.name' => SORT_ASC],
                    'desc' => ['users.name' => SORT_DESC],
                    'label' => 'Имя'
                ],
                'userPatronymic' => [
                    'asc' => ['users.patronymic' => SORT_ASC],
                    'desc' => ['users.patronymic' => SORT_DESC],
                    'label' => 'Отчество'
                ],
                'date' => [
                    'asc' => ['orders.date' => SORT_ASC],
                    'desc' => ['orders.date' => SORT_DESC],
                    'label' => 'Дата'
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);
        $query->andFilterWhere([
            'date' => $this->date ? \Yii::$app->formatter->asDate($this->date, 'yyyy-MM-dd') : null,
        ]);
        $query->joinWith(['user' => function ($q) {
            $q->where('users.surname LIKE "%' . $this->userSur . '%"');
        }]);
        $query->joinWith(['user' => function ($q) {
            $q->where('users.name LIKE "%' . $this->userName . '%"');
        }]);
        $query->joinWith(['user' => function ($q) {
            $q->where('users.patronymic LIKE "%' . $this->userPatronymic . '%"');
        }]);

        return $dataProvider;
    }
}
