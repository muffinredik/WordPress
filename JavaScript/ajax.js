$('.hpat-post-navigation a').live('click', function(e){
    e.preventDefault();
    var link = $(this).attr('href');
    var postsWrapper = $('#hpat-posts-wrapper');
    postsWrapper.load(link+' #hpat-posts'); 
    var offset = postsWrapper.offset().top - 200;
    $(window).scrollTop(offset);
});
