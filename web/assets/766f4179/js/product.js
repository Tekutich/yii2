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
        console.log(infoProduct);
        if (infoProduct !== undefined) {
            let spanminus = $('<span class="minus" id="' + $(this).val() + '">-</span>');
            let spanplus = $('<span class="plus" id="' + $(this).val() + '">+</span>');
            let quantity = $('<input type="text" class="quantity" value="' + local[infoProduct].quantity + '" readOnly>');
            $(this).parent().append(spanminus);
            $(this).parent().append(quantity);
            $(this).parent().append(spanplus);
            $(this).remove();
        }

    });

    $('body').on('click', '.add-cart', function () {

        let spanminus = $('<span class="minus" id="' + $(this).val() + '">-</span>');
        let spanplus = $('<span class="plus" id="' + $(this).val() + '">+</span>');
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

        $(this).parent().append(spanminus);
        $(this).parent().append(quantity);
        $(this).parent().append(spanplus);
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