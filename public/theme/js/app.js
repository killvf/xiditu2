/**
 * 得到购物车物品数量
 */
function recalc_shopcart_count() {
    var shopcart = $.cookie('shopcart'),
        count=0;
    if(shopcart) {
        shopcart = JSON.parse(shopcart);
        for(var item in shopcart) {
            count += parseInt(shopcart[item]);
        }
    }
    return count;
}