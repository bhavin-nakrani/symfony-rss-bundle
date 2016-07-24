jQuery(document).ready(function() {
    jQuery('.text').hide();

    jQuery('article header').click(function() {
        jQuery(this).parent().children('.text').toggle();
    });

    jQuery('article time').hide();

    jQuery('article').hover(function() {
      jQuery(this).children('header').children('time').show();
    }, function() {
      jQuery(this).children('header').children('time').hide();
    });
});

function setRead(url)
{
    jQuery.ajax({
      url: url,
      cache: false
    }).done(function( response ) {
      console.log(response);
    });
}
