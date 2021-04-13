<?php

namespace app\controllers;

use app\models\Drugs;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * Контроллер каталога лекарств
 */
class DrugsController extends \yii\web\Controller
{
    /**
     * просмотр всех лекарств
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Drugs::find()->orderBy('trade_name '),
        ]);

        $this->view->title = 'Каталог';

        return $this->render('index', ['catalogdataProvider' => $dataProvider]);
    }

    /**
     * Просмотр определенного лекарства
     */
    public function actionView()
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

        $this->view->title = $drugInfo['trade_name'];

        return $this->render('view', ['drugInfo' => $drugInfo]);
    }
}
