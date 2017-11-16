
jQuery(document).ready(function($) {
    //$('.medani-newsmodul-excerpt').hide();
    
    $('.medani-newsmodul-title').click(function(){
        var content = $(this).siblings('.medani-newsmodul-excerpt');
        if(content.is(":hidden")){
            $('.medani-newsmodul-excerpt').slideUp();
            content.slideDown();
        }
        else {
            content.slideUp();
        }
    });
});
