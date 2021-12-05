$(document).ready(function() {

//top gal fader
    $('#topgal2').hide();
    $('#topgal3').hide();
    $('#topgal_fadder').fadeOut(1);

    $('#toppic1').hover(function() {
        $('#topgal_fadder').fadeIn(1);
        $('.toppic').hide();
        $('#topgal1').show();
        $('#topgal_fadder').fadeOut(1);
    });

    $('#toppic2').hover(function() {
        $('#topgal_fadder').fadeIn(1);
        $('.toppic').hide();
        $('#topgal2').show();
        $('#topgal_fadder').fadeOut(1);
    });

    $('#toppic3').hover(function() {
        $('#topgal_fadder').fadeIn(1);
        $('.toppic').hide();
        $('#topgal3').show();
        $('#topgal_fadder').fadeOut(1);
    });

    //mid slider
    

});