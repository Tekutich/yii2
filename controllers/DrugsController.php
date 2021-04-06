<?php

namespace app\controllers;

use app\models\Drugs;
use Yii;
use yii\data\ActiveDataProvider;

class DrugsController extends \yii\web\Controller
{
    public function actionCatalog()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Drugs::find()->orderBy('trade_name '),

        ]);

        $this->view->title = 'Drugs List';

        return $this->render('catalog', ['catalogdataProvider' => $dataProvider]);

    }

    public function actionProduct()
    {
        $productId = Yii::$app->request->get('id');

        $product = Drugs::find()
            ->where(['id' => $productId])
            ->with('drugsIndicationsForUses', 'drugsCharacteristics', 'drugsDrugsCharacteristicsLinks')
            ->asArray()
            ->all();

        foreach ($product as $drugInfo) {
            $drugInfo->drugsIndicationsForUses;
        }

        //$id = $product->trade_name;

        $this->view->title = $drugInfo['trade_name'];

        return $this->render('product', ['drugInfo' => $drugInfo]);

    }


}
