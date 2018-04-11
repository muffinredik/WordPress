
jQuery(document).ready(function($) {
	$('#mwd_dsgvo_version_confirmation').change(function(){
		if($(this).is(":checked")) {
			$('.submit input').val('Version ansehen');
			$('#mwd-dsgvo-form').attr('target', '_blank');
		}
		else {
			$('.submit input').val('speichern');
			$('#mwd-dsgvo-form').attr('target', '_self');
        }
    });

	$('.mwd-dsgvo-section-checkbox').change(function(){
		if($(this).is(":checked")) {
			$(this).prev().val('1');
			$(this).parent().parent().parent().find('.hidden-section-field').css( 'display', 'table-row' );
			$('.hidden').css( 'display', 'none' );
		}
		else {
			$(this).prev().val('0');
			$(this).parent().parent().parent().find('.hidden-section-field').css( 'display', 'none' );
        }
    });

	$('.mwd-dsgvo-section-checkbox').each(function(){
		if($(this).is(":checked")) {
			$(this).parent().parent().parent().find('.hidden-section-field').css( 'display', 'table-row' );
			$('.hidden').css( 'display', 'none' );
		}
	});

	$('.mwd-dsgvo-reset-text').click(function() {
		if ( $(this).next().css('display') == 'none' ) {
			$( this ).next().css( 'display', 'inline-block' );
			$( this ).next().next().css( 'display', 'block' );
			$( this ).val( 'verstecken' );
		}
		else {
			$( this ).next().css( 'display', 'none' );
			$( this ).next().next().css( 'display', 'none' );
			$( this ).val( 'anzeigen' );
		}
	});

	$('.mwd-dsgvo-copy-default-text').click(function() {
		var $temp = $("<input>");
		$('body').append($temp);
		$temp.val($( this ).next().text()).select();
		document.execCommand("copy");
		$temp.remove();
	});
    
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