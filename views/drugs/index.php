<?php

use yii\widgets\ListView;

/** @var  $catalogdataProvider */
echo ListView::widget([
    'dataProvider' => $catalogdataProvider,
    'itemView' => 'list',
    'summary' => '',
    'options' => [
        'tag' => 'div',
        'class' => 'row justify-content-md-center-my-auto row-flex ',

    ],
    'itemOptions' => [
        'tag' => 'div',
        'class' => 'col justify content-center my-auto col-product',
    ],
]);
