<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\OrderDetails;

/**
 * OrdersDetailsSearch represents the model behind the search form of `app\models\OrderDetails`.
 */
class OrdersDetailsSearch extends OrderDetails
{
    public $orderId;
    public $form;
    public $dosage;
    public $cost;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'orders_id', 'drugs_drugs_characteristics_link_id', 'count'], 'integer'],
            [['form', 'dosage', 'cost'], 'safe'],
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
        $query = OrderDetails::find()
            ->where(['orders_id' => $this->orderId]);
        $query->joinWith(['drugsCharacteristics']);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->setSort([
            'attributes' => [
                'form' => [
                    'asc' => ['drugs_characteristics.form_of_issue' => SORT_ASC],
                    'desc' => ['drugs_characteristics.form_of_issue' => SORT_DESC],
                    'label' => 'Фамилия'
                ],
                'dosage' => [
                    'asc' => ['drugs_characteristics.dosage' => SORT_ASC],
                    'desc' => ['drugs_characteristics.dosage' => SORT_DESC],
                    'label' => 'Дозировка'
                ],
                'cost' => [
                    'asc' => ['drugs_characteristics.cost' => SORT_ASC],
                    'desc' => ['drugs_characteristics.cost' => SORT_DESC],
                    'label' => 'Цена'
                ],
                'count' => [
                    'asc' => ['count' => SORT_ASC],
                    'desc' => ['count' => SORT_DESC],
                    'label' => 'Количество'
                ],

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

            'count' => $this->count,
        ]);
        $query->joinWith(['drugsCharacteristics' => function ($q) {
            $q->where('drugs_characteristics.form_of_issue LIKE "%' . $this->form . '%"');
        }]);
        $query->joinWith(['drugsCharacteristics' => function ($q) {
            $q->where('drugs_characteristics.dosage LIKE "%' . $this->dosage . '%"');
        }]);
        $query->joinWith(['drugsCharacteristics' => function ($q) {
            $q->where('drugs_characteristics.cost LIKE "%' . $this->cost . '%"');
        }]);

        return $dataProvider;
    }
}
