<?php

use app\assets\AppAsset;

$bundle = AppAsset::register($this);

$this->registerJsFile('' . $bundle->baseUrl . '/js/cart.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<script>
    var isGuest = <?=Yii::$app->user->isGuest ? 'true' : 'false' ?>;
</script>
<div id="container-products-cart" class="container mx-center products-cart">

</div>
