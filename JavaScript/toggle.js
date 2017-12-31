
jQuery(document).ready(function($) {
    //$('.hpat-newsmodul-excerpt').hide();
    
    $('.hpat-newsmodul-title').click(function(){
        var content = $(this).siblings('.hpat-newsmodul-excerpt');
        if(content.is(":hidden")){
            $('.hpat-newsmodul-excerpt').slideUp();
            content.slideDown();
        }
        else {
            content.slideUp();
        }
    });
});
