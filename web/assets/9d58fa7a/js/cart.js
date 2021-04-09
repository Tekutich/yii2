$(function () {
    // alert(isGuest);

    function findIndex(array, id) {
        let index;
        $.each(array, function (key, value) {
            if (value.id === id) {
                index = key;
            }
        });
        return index;
    }

    function sumPrice() {
        let local = JSON.parse(localStorage.getItem('productCart'));
        let sum = 0;
        $.each(local, function (key, value) {
            sum += value.cost * value.quantity
        })
        return sum;
    }


    var products = JSON.parse(localStorage.getItem('productCart'));

    if (products === null) {

        let noProducts = $('<h2 class="no-product-text text-center">Ваша корзина пока пуста</h2>');
        $('#container-products-cart').append(noProducts);

    } else {

        $('#cart-col').text(localStorage.getItem('cartsum'));
        products.sort(function (a, b) {
            return (a.name.localeCompare(b.name));
        });

        var iddiv = "products-Cart";

        $.each(products, function (key, value) {

            let divRow = $('<div id=' + iddiv + key + ' class="row hr-bottom"></div>');
            $('#container-products-cart').append(divRow);

            let divColImg = $('<div class="col-lg-2 col-sm-3 col-xs-12 my-auto mx-auto mob-fix text-center"></div>');
            let imgProduct = $('<img  class="img-cart" src =' + value.image + '>');

            let divColName = $('<div class="col-lg-2 col-sm-3 col-xs-12 my-auto mob-fix name-product text-center">' + value.name + '</div>');
            let divColForm = $('<div class="col-lg-2 col-sm-3 col-xs-12 my-auto mob-fix name-product text-center">' + value.form + '</div>');

            let pricevalue = value.cost.toLocaleString('ru') + ' руб.';
            let divColPrice = $('<div class="col-lg-2 col-sm-3 col-xs-12 my-auto mob-fix text-center">' + pricevalue + '</div>');

            let divColQuantity = $('<div class="col-lg-2 col-sm-3 col-xs-12 my-auto mob-fix text-center"></div>');

            let spanminus = $('<span class="minus" id="' + value.id + '">-</span>');
            let spanplus = $('<span class="plus" id="' + value.id + '">+</span>');
            let quantity = $('<input type="text" class="quantity" value=' + value.quantity + ' readOnly></input>');

            let sum = (value.quantity * value.cost).toLocaleString('ru') + ' руб.';
            let divColSum = $('<div class="col-lg-2 col-sm-3 col-xs-12 my-auto mob-fix sum text-center">' + sum + '</div>');


            divRow.append(divColImg);
            divColImg.append(imgProduct);

            divRow.append(divColName);
            divRow.append(divColForm);

            divRow.append(divColPrice);

            divRow.append(divColQuantity);
            divColQuantity.append(spanminus);
            divColQuantity.append(quantity);
            divColQuantity.append(spanplus);

            divRow.append(divColSum);

        });
        //строка итого
        let divRowSum = $('<div id="div-row-sum" class="row"></div>');
        $('#container-products-cart').append(divRowSum);

        let total = 'Итого: ' + sumPrice().toLocaleString('ru') + ' руб.';
        let divColSum = $('<div  class="col  text-right mob-fix total-sum">' + total + '</div>');
        divRowSum.append(divColSum);


        //строка с кнопкой
        let divRow = $('<div id="div-row-buy"  class="row"></div>');
        $('#container-products-cart').append(divRow);


        let divColBuy = $('<div class="col text-center mob-fix"></div>');
        divRow.append(divColBuy);
        if (isGuest === true) {
            let buttonLogin = $('<a id="button-login" class="btn btn-primary cart-button" href="/index.php?r=site%2Flogin">Войти/Зарегистрироваться</a>')
            divColBuy.append(buttonLogin);

        } else {
            let buttonBuy = $('<button id="button-buy" class="btn btn-primary cart-button" data-bs-toggle="modal" data-bs-target="#modal-cart">Оформить заказ</button>')
            divColBuy.append(buttonBuy);
        }
    }

    $('body').on('click', '.minus', function () {
        var $input = $(this).parent().find('input[type=text]');
        var count = parseInt($input.val()) - 1;
        let id = $(this).prop('id');

        if (count < 1) {

            let local = JSON.parse(localStorage.getItem('productCart'));
            let index = findIndex(local, id);
            local.splice(index, 1);
            $(this).closest('.row').remove();


            if (local.length == 0) {

                localStorage.removeItem('productCart');
                $('#div-row-buy').remove();
                $('#div-row-sum').remove();

                let noProducts = $('<h2 class="no-product-text">Ваша корзина пока пуста</h2>');
                $('#container-products-cart').append(noProducts);

            } else {
                localStorage.setItem('productCart', JSON.stringify(local));
                $('#div-row-sum').children('.total-sum').text('Итого: ' + sumPrice().toLocaleString('ru') + ' руб.');
            }


        } else {
            count = count;

            let local = JSON.parse(localStorage.getItem('productCart'));
            let index = findIndex(local, id);

            local[index].quantity = local[index].quantity - 1;
            localStorage.setItem('productCart', JSON.stringify(local));
            $('#div-row-sum').children('.total-sum').text('Итого: ' + sumPrice().toLocaleString('ru') + ' руб.');
            let sum = local[index].quantity * local[index].cost
            $(this).closest('.hr-bottom').find('.sum').text(sum.toLocaleString('ru') + ' руб.');

        }

        $input.val(count);
        $input.change();
        return false;
    });

    $('body').on('click', '.plus', function () {
        var $input = $(this).parent().find('input[type=text]');
        $input.val(parseInt($input.val()) + 1);
        let id = $(this).prop('id');

        let local = JSON.parse(localStorage.getItem('productCart'));
        let index = findIndex(local, id)

        local[index].quantity = local[index].quantity + 1;
        localStorage.setItem('productCart', JSON.stringify(local));

        let sum = local[index].quantity * local[index].cost
        $(this).closest('.hr-bottom').find('.sum').text(sum.toLocaleString('ru') + ' руб.');

        $('#div-row-sum').children('.total-sum').text('Итого: ' + sumPrice().toLocaleString('ru') + ' руб.');
        $input.change();
        return false;
    });

    $('body').on('click', '#button-buy', function () {
        let local = JSON.parse(localStorage.getItem('productCart'));
        $.ajax({
            url: "index.php?r=cart/addorder",
            type: "POST",

            data: {productCart: local},
            success: function (response) {
                alert(response);

                $('#container-products-cart').empty();
                localStorage.removeItem('productCart');
                let noProducts = $('<h2 class="no-product-text text-center">Ваша корзина пока пуста</h2>');
                $('#container-products-cart').append(noProducts);
            },
            error: function () {
                alert("Ошибка при отправке данных: перезагрузите страницу!");
            }
        })

    });

})