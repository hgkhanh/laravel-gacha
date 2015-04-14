$(function(){
    window.setInterval(function(){
        $(".coin_area").html(parseInt($(".coin_area").html()) + 1);
        $(".coin_area").css('color','green');
    }, 1000);
});