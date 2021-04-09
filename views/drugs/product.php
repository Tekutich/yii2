<?php

use app\assets\AppAsset;

/** @var  $drugInfo */

$bundle = AppAsset::register($this);
$tradeName = $drugInfo['trade_name'];
$internationalName = $drugInfo['international_name'];

foreach ($drugInfo['drugsIndicationsForUses'] as $value) {
    $indication .= $value['indication'];
}

$this->registerJsFile('' . $bundle->baseUrl . '/js/product.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<img class="img-fluid mx-auto d-block img-product" src="<?= $bundle->baseUrl ?>/images/tabletki.png" alt="">
<div class="text-center">
    <p class="name-product"><?= $tradeName ?></p>
    <p class="name-product1">МНН: <?= $internationalName ?></p>
</div>
<h5 class="text-start">Показания к применению:</h5>
<p class="text-start"><?= $indication ?></p>
<h5 class="text-start">Формы выпуска:</h5>
<?php

foreach ($drugInfo['drugsCharacteristics'] as $key => $value):
    $form_of_issue = $value['form_of_issue'];
    $dosage = $value['dosage'];
    $cost = $value['cost'];
    ?>
    <!--вывод форм выпуска-->
    <div id="products-Characteristics"
         class="row justify-content-md-center-my-auto row-flex text-center border-up">
        <div class="col justify  content-center my-auto ">
            <h6>Форма выпуска:</h6>
            <p class="form"><?= $form_of_issue ?></p>
        </div>
        <div class="col justify  content-center my-auto ">
            <h6>Дозировка:</h6>
            <p><?= $dosage ?></p>
        </div>
        <div class="col justify  content-center my-auto ">
            <h6>Цена:</h6>
            <p class="cost"><?= $cost ?> руб.</p>
        </div>
        <div class="col justify  content-center my-auto ">
            <button class="btn btn-primary add-cart"
                    value="<?= $drugInfo['drugsDrugsCharacteristicsLinks'][$key]['id'] ?>">В корзину
            </button>
        </div>
    </div>
<? endforeach; ?>

