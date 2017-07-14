i = 0;
jQuery('.item-info').prepend('<div class="addremove"><button class="minus"><i class="fa fa-minus" aria-hidden="true"></i></button><span>' + i + '</span><button class="plus"><i class="fa fa-plus" aria-hidden="true"></i></button></div>');
/**
 *      PLUS FUNCTION
 */
jQuery('.plus').click(function () {
    
    var sprodcount = 1;
    p = jQuery('.mymeels li .min_prod_left span').each(function () {
        sprodcount += parseInt(jQuery(this).html());
        return sprodcount;
    });
    if (parseInt(jQuery(this).parent().find('span').html()) >= 0) {
        jQuery(this).parent().find('span').html(parseInt(jQuery(this).parent().find('span').html()));
    }
});

jQuery('.minus').click(function () {
    if (parseInt(jQuery(this).parent().find('span').html()) > 0) {
        jQuery(this).parent().find('span').html(parseInt(jQuery(this).parent().find('span').html()) - 1)
    }
});
jQuery('.archive.post-type-archive.post-type-archive-product li.product-type-subscription,li.product-type-variable-subscription ').remove();


/**
 *              Count of Meels
 **/
jQuery(document).ready(function () {
    jQuery('#text-6 .textwidget').prepend("<div id='meels_count'><span class='left_your_meels'>Your Meals</span><span class='your_meels_count'>0 of <span class='choos'>6</span></span></div>");
    var count_pr = 0;
    jQuery('.product table tbody td span').each(function (key, value) {
        count_pr += parseInt(jQuery(value).html());
    });
    jQuery(document).find('.your_meels_count').html(count_pr + ' of <span class="choos">6</span>');
})


