<?php

namespace app\controllers;

use app\models\Orders;
use app\models\OrdersDetailsSearch;
use app\models\UserOrdersSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserOrdersController реализует действия CRUD для модели Orders (для пользователя)
 */
class UserOrdersController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'order'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Список всех моделей заказов
     * @return mixed
     */
    protected function findModelOrder($id)
    {
        if (($model = Orders::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Просмотр
     */
    public function actionIndex()
    {

        $searchModel = new UserOrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Просмотреть подробно заказ
     */
    public function actionOrder()
    {
        $orderId = Yii::$app->request->get('id');
        $searchModel = new OrdersDetailsSearch();
        $searchModel->orderId = $orderId;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('user-order/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
