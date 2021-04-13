<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * OrdersDetailsSearch модель для поиска по `app\models\OrderDetails`.
 */
class OrdersDetailsSearch extends OrderDetails
{
    public $tradeName;
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
            [['tradeName', 'form', 'dosage', 'cost'], 'safe'],
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
     * создает экземпляр поставщика данных(DataProvider) с примененным поисковым запросом
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
        $query->joinWith(['drugs']);

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
                'tradeName' => [
                    'asc' => ['drugs.trade_name' => SORT_ASC],
                    'desc' => ['drugs.trade_name' => SORT_DESC],
                ],

            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

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
        $query->joinWith(['drugs' => function ($q) {
            $q->where('drugs.trade_name LIKE "%' . $this->tradeName . '%"');
        }]);

        return $dataProvider;
    }
}
