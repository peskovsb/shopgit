/**
 * @author Peskov Sergey
 * @date 17.09.2016
 * Функция добавления товара в корзину
 * @params url - путь к Ajax сценарию,
 * id - идентификатор блока с товаром
 * @return записть в базу данных
 */

function ajaxAddToCart (url,id) {
    basePrise = $('#bcb_base_sum').val();
    count = $('.good_id-'+id).find('.countGood').val();
    prise = $('.good_id-'+id).find('.bsb_prise_prod').val();
    readyPrise = parseInt(basePrise) + (parseInt(prise)*count);
    //console.log(readyPrise);
    $('#bcb_base_sum').val(readyPrise);
    //console.log('count: ',count);

    var exists = 0;
    for(var i=0;i<goods.length;i++){
        if(goods[i]==parseInt(id)){
            exists = 1;
            break;
        }
    }
    if(exists!=1){
        goods.push(parseInt(id))
    }
    baseCount = goods.length;
    $('#bcb_base_quantity').val(baseCount);
    $('#prise-out').text(readyPrise);
    $('#quantity-out').text(baseCount);
    //console.log(goods);

    if(count==0 || count ==''){
        alert('Поле с количеством должно быть заполнено и не должно быть равно 0');
        return false;
    }else{
        $.ajax({
            type: "POST",
            url: url,
            data: {'id':id,'count':count},
            success: function(data){
                $('#cartTop').html(data);
            }
        });
    }
}

$('.countGood').bind("change keyup input click", function() {
    if (this.value.match(/[^0-9]/g)) {
        this.value = this.value.replace(/[^0-9]/g, '');
    }
});

/**
 * @author Peskov Sergey
 * @date 17.09.2016
 * Функции изменения количества
 * @params id - идентификатор блока с товаром
 * @return изменение поля goodCount
 */
function countMinus(id){
    count = $('.good_id-'+id).children('.countGood').val();
    if(count <= 1){
        return false;
    }else{
        count = parseInt(count) - 1;
    }
    $('.good_id-'+id).children('.countGood').val(count)
}

function countPlus(id){
    count = $('.good_id-'+id).children('.countGood').val();
    count = parseInt(count) + 1;
    $('.good_id-'+id).children('.countGood').val(count)
}

/**
 * @author Peskov Sergey
 * @date 17.09.2016
 * Функции работы с корзиной
 * @params id - идентификатор блока с товаром
 * @return изменение поля goodCount
 */
function cartCorrect(url,id,classCart){
    count = $('.'+classCart+'_id-'+id).children('.countCart').val();
    if(count <= 0){
        //alert('ошибка');
    }else{
        $.ajax({
            type: "POST",
            url: url,
            data: {'id':id,'count':count},
        });
    }

}

function cartPlus(url,id){
    count = $('.countCart[data-id='+id+']').val();
    count = parseInt(count)+1;
    $.ajax({
        type: "POST",
        url: url,
        data: {'id':id,'count':count},
    });
}

function cartMinus(url,id){
    count = $('.countCart[data-id='+id+']').val();
    if(count <= 1){
        return false;
    }else{
        count = parseInt(count) - 1;
    }
    $.ajax({
        type: "POST",
        url: url,
        data: {'id':id,'count':count},
    });
}

function cartDelete(url,id){
    $.ajax({
        type: "POST",
        url: url,
        data: {'id':id},
    });
}

/**
 * @author Peskov Sergey
 * @date 18.09.2016
 * Фронтенд на Jquery, чтобы переключалось как в корзине
 * так и на странице оформления заказа
 * @return изменение поля cartCount
 */
$(document).on('keyup','.countCart',function(){
    id = $(this).attr('data-id');
    priseInfo = $('#priseInfo').text();
    count = $(this).val();
    if(count <= 0){
        return false;
    }
    prise = $(this).next().text();
    priseModifyOrigin = $(this).next().next().text();
    finalPrise = parseInt(prise)*count;
    devidePrise = finalPrise-parseInt(priseModifyOrigin);
    $('#priseInfo').text(parseInt(priseInfo)+devidePrise);

    $('.countCart[data-id='+id+']').val(count);
    $('.priseModifyCart[data-id='+id+']').text(finalPrise);
});

$(document).on('click','.cartPlus',function(){
    id = $(this).attr('data-id');
    currentCount = $('.countCart[data-id='+id+']').val();
    prise = $('.cart_id-'+id).children('.priseCart').text();
    currentCount = parseInt(currentCount)+1;
    finalPrise = parseInt(prise)*currentCount;
    priseInfo = $('#priseInfo').text();
    $('#priseInfo').text(parseInt(priseInfo)+parseInt(prise));
    $('.priseModifyCart[data-id='+id+']').text(finalPrise);
    $('.countCart[data-id='+id+']').val(currentCount);
});

$(document).on('click','.cartMinus',function(){
    id = $(this).attr('data-id');
    currentCount = $('.countCart[data-id='+id+']').val();
    if(currentCount <= 1){
        return false;
    }else{
        currentCount = parseInt(currentCount) - 1;
    }
    priseInfo = $('#priseInfo').text();
    prise = $('.cart_id-'+id).children('.priseCart').text();
    finalPrise = parseInt(prise)*currentCount;
    $('#priseInfo').text(parseInt(priseInfo)-parseInt(prise));
    $('.priseModifyCart[data-id='+id+']').text(finalPrise);
    $('.countCart[data-id='+id+']').val(currentCount);
});

$(document).on('click','.cartDelete',function(){
    id = $(this).attr('data-id');
    countInfo = $('#countInfo').text();
    priseInfo = $('#priseInfo').text();
    modifyPrise = $(this).parent().children('.priseModifyCart').text();
    $('#countInfo').text(parseInt(countInfo)-1);
    $('#priseInfo').text(parseInt(priseInfo)-parseInt(modifyPrise));
    $('.cartDelete[data-id="'+id+'"]').parent().remove();
});