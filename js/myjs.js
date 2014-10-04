$(this).find('input:text')[0].focus();
$('#example').tooltip(options);
//Carousel of images for Gallery
$('.carousel').carousel()
$( document ).ready(function() {
	$('#mycarousel').carousel();

	$('#myTab a').click(function (e) {
	  	e.preventDefault();
	  	$(this).tab('show');
	});
	$('#myTab a[href="#profile"]').tab('show');
	$('#example').tooltip();
	$('#identifier').popover();
	$(document).ready(function () {
    var $container = $('.container');

    $container.imagesLoaded(function () {
        $container.masonry({
            itemSelector: '.post-box',
            columnWidth: '.post-box',
            transitionDuration: 0;
        });
    });
});