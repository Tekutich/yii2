<?php

namespace app\controllers;

use app\models\Orders;
use app\models\OrdersDetailsSearch;
use app\models\OrdersSearch;
use Yii;
use app\models\User;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrdersController реализует действия CRUD для модели Orders (для администратора).
 */
class OrdersController extends Controller
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
                        'actions' => ['index', 'update', 'orders', 'order', 'create', 'view', 'delete', 'delete-order'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return User::isUserAdmin(Yii::$app->user->identity->email);
                        }
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
     * Список всех моделей заказов.
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
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Удалить заказ
     */
    public function actionDeleteOrder()
    {
        $id = Yii::$app->request->get('id');
        try {
            $this->findModelOrder($id)->delete();
            Yii::$app->session->setFlash('success', Yii::t('app', 'Заказ удален'));
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Невозможно удалить заказ' . $e));
        }

        return $this->redirect(['orders']);
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

        return $this->render('order/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
