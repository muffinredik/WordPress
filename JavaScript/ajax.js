$('.wu-media-navigation a').live('click', function(e){
    e.preventDefault();
    var link = $(this).attr('href');
    var mediaItemsWrapper = $('#wu-media-items-wrapper');
    mediaItemsWrapper.load(link+' #wu-media-items'); 
    var offset = mediaItemsWrapper.offset().top - 200;
    $(window).scrollTop(offset);
});
