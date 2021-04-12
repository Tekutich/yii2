<?php

namespace app\controllers;

use app\models\OrderDetails;
use app\models\Orders;

use DateTime;
use Yii;
use yii\debug\models\search\Debug;

class CartController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $this->view->title = 'Корзина';
        return $this->render('index');
    }

    public function actionOrder()
    {
        $productCart = Yii::$app->getRequest()->post('productCart');

        if (Yii::$app->request->isAjax) {

            $date = new DateTime();
            $date = $date->format('Y-m-d');

            $db = Yii::$app->db;
            $transaction = $db->beginTransaction();
            try {
                $order = new Orders();
                $order->user_id = Yii::$app->user->id;
                $order->date = $date;
                $order->save();

                foreach ($productCart as $value) {
                    $orderDetails = new OrderDetails();
                    $orderDetails->drugs_drugs_characteristics_link_id = $value['id'];
                    $orderDetails->orders_id = $order->id;
                    $orderDetails->count = $value['quantity'];
                    $orderDetails->save();
                }

                $response = "Ваш заказ оформлен. Спасибо!";
                $transaction->commit();
            } catch (\Exception $e) {
                $response = "Ошибка создания заказа";
                $transaction->rollBack();
                throw $e;
            } catch (\Throwable $e) {
                $response = "Ошибка создания заказа";
                $transaction->rollBack();
            }

            return ($response);
        }
        return $this->render('index');
    }
}
