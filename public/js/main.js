tinymce.init({
    selector : ".form-news-body",
    plugins : ["advlist autolink lists link image charmap print preview anchor", "searchreplace visualblocks code fullscreen", "insertdatetime media table contextmenu paste"],
    toolbar : "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
});

const $jq = jQuery.noConflict();
$jq(document).ready(function() {
    $jq('.slider').slick({
        autoplay: true,
        autoplaySpeed: 5000,
        prevArrow: null,
        nextArrow: null,
        speed: 3000,
    })
    .on('setPosition', function (event, slick) { //Одиноковая высота для слайдов
        slick.$slides.css('height', slick.$slideTrack.height() + 'px');
    });
});


