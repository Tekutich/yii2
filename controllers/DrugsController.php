<?php

namespace app\controllers;

use app\models\Drugs;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

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
     *
     * @throws NotFoundHttpException
     */
    public function actionView()
    {
        $productId = Yii::$app->request->get('id');

        $product=$this->findModel($productId);

        return $this->render('view', ['product' => $product]);
    }

    /**
     *  Поиск модели
     * @throws NotFoundHttpException
     */
    protected function findModel($productId)
    {
        $model = Drugs::find()
            ->where(['id' => $productId])
            ->with('drugsIndicationsForUses', 'drugsCharacteristics', 'drugsDrugsCharacteristicsLinks')
            ->one();
        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Такой страницы не существует');
    }
}
