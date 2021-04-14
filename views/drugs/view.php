<?php

use app\assets\AppAsset;

/** @var  $drugInfo */

$bundle = AppAsset::register($this);
$tradeName = $drugInfo['trade_name'];
$internationalName = $drugInfo['international_name'];

foreach ($drugInfo['drugsIndicationsForUses'] as $value) {
    $indication .= $value['indication'];
}
$this->title = $drugInfo['trade_name'];
?>
<script>
    $(function () {
        function findIndex(array, id) {
            let index;
            $.each(array, function (key, value) {
                if (value.id === id) {
                    index = key;
                }
            });
            return index;
        }

        $(".add-cart").each(function (index, el) {
            let local = JSON.parse(localStorage.getItem('productCart'));
            let infoProduct = findIndex(local, $(this).val())

            if (infoProduct !== undefined) {
                let spanMinus = $('<span class="minus" id="' + $(this).val() + '">-</span>');
                let spanPlus = $('<span class="plus" id="' + $(this).val() + '">+</span>');
                let quantity = $('<input type="text" class="quantity" value="' + local[infoProduct].quantity + '" readOnly>');
                $(this).parent().append(spanMinus);
                $(this).parent().append(quantity);
                $(this).parent().append(spanPlus);
                $(this).remove();
            }
        });

        $('body').on('click', '.add-cart', function () {
            let spanMinus = $('<span class="minus" id="' + $(this).val() + '">-</span>');
            let spanPlus = $('<span class="plus" id="' + $(this).val() + '">+</span>');
            let quantity = $('<input type="text" class="quantity" value="1" readOnly>');

            let nameProduct = $(this).closest('.container').find('.name-product').text();
            let formProduct = $(this).closest('.row').find('.form').text();
            let costProduct = parseFloat($(this).closest('.row').find('.cost').text());
            let imageProduct = $(this).closest('.container').find('.img-product').prop('src');

            if (localStorage.getItem('productCart') != null) {
                let productCart =
                    {
                        id: $(this).val(),
                        image: imageProduct,
                        name: nameProduct,
                        form: formProduct,
                        cost: costProduct,
                        quantity: 1,
                    };
                let local = JSON.parse(localStorage.getItem('productCart'));
                local.push(productCart);
                localStorage.setItem('productCart', JSON.stringify(local));
            } else {
                let productCart = [
                    {
                        id: $(this).val(),
                        image: imageProduct,
                        name: nameProduct,
                        form: formProduct,
                        cost: costProduct,
                        quantity: 1,
                    }];
                localStorage.setItem('productCart', JSON.stringify(productCart));
            }

            $(this).parent().append(spanMinus);
            $(this).parent().append(quantity);
            $(this).parent().append(spanPlus);
            $(this).remove();
        });

        $('body').on('click', '.plus', function () {
            let $input = $(this).parent().find('input[type=text]');
            $input.val(parseInt($input.val()) + 1);
            let id = $(this).prop('id');

            let local = JSON.parse(localStorage.getItem('productCart'));
            let index = findIndex(local, id)
            local[index].quantity = local[index].quantity + 1;
            localStorage.setItem('productCart', JSON.stringify(local));

            $input.change();
            return false;
        });

        $('body').on('click', '.minus', function () {
            let $input = $(this).parent().find('input[type=text]');
            let count = parseInt($input.val()) - 1;
            let id = $(this).prop('id');

            if (count < 1) {
                let buttonBuy = $('<button class="btn btn-primary add-cart" value="' + id + '">В корзину</button>')

                $(this).closest('.plus').remove();
                $(this).parent().html(buttonBuy);

                let local = JSON.parse(localStorage.getItem('productCart'));
                let index = findIndex(local, id);
                local.splice(index, 1);

                if (local.length == 0) {
                    localStorage.removeItem('productCart');
                } else {
                    localStorage.setItem('productCart', JSON.stringify(local));
                }
            } else {
                count = count;

                let local = JSON.parse(localStorage.getItem('productCart'));
                let index = findIndex(local, id);
                local[index].quantity = local[index].quantity - 1;
                localStorage.setItem('productCart', JSON.stringify(local));
            }

            $input.val(count);
            $input.change();
            return false;
        });
    })
</script>
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
        <div class="col justify content-center my-auto ">
            <h6>Форма выпуска:</h6>
            <p class="form"><?= $form_of_issue ?></p>
        </div>
        <div class="col justify content-center my-auto ">
            <h6>Дозировка:</h6>
            <p><?= $dosage ?></p>
        </div>
        <div class="col justify content-center my-auto ">
            <h6>Цена:</h6>
            <p class="cost"><?= $cost ?> руб.</p>
        </div>
        <div class="col justify content-center my-auto ">
            <button class="btn btn-primary add-cart"
                    value="<?= $drugInfo['drugsDrugsCharacteristicsLinks'][$key]['id'] ?>">В корзину
            </button>
        </div>
    </div>
<? endforeach; ?>

