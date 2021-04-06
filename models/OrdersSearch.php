<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Orders;

/**
 * OrdersSearch represents the model behind the search form of `app\models\Orders`.
 */
class OrdersSearch extends Orders
{
    public $userSurname;
    public $userName;
    public $userPatronymic;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id',], 'integer'],
            [['date', 'user_id', 'userSurname', 'userName', 'userPatronymic'], 'safe'],
//            [['date',], 'format' => ['date', 'd.mm.y']],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Orders::find();
        $query->joinWith(['user']);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'userSurname' => [
                    'asc' => ['users.surname' => SORT_ASC],
                    'desc' => ['users.surname' => SORT_DESC],
                    'label' => 'Фамилия'
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
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'date' => $this->date,


        ]);
        $query->joinWith(['user' => function ($q) {
            $q->where('users.surname LIKE "%' . $this->userSurname . '%"');
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
