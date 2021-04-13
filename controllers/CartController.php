<?php

namespace app\controllers;

use app\models\Orders;
use DateTime;
use Yii;

/**
 * Контроллер корзины
 */
class CartController extends \yii\web\Controller
{

    /**
     * Просмотр корзины
     */
    public function actionIndex()
    {
        $this->view->title = 'Корзина';
        return $this->render('index');
    }

    /**
     * Сохранение заказа
     */
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
                $order->productCart=$productCart;
                $order->save();
                if (!$order->save()){
                    $response = "Ошибка создания заказа";
                }else{
                    $response = "Ваш заказ оформлен. Спасибо!";
                }

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
