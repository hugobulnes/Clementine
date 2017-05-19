//carousel
var wheight = $(window).height();

$('.carousel').carousel({
    pause: "false"
});

//adjust when resize
/* Another aproache
$('.fullheight').css('height', wheight);
$(window).resize(function() {
    wheight = $(window).height();
    $('.fullheight').css('height', wheight);
});
*/
//replace carousel images for responsive
$('#featured .item img').each(function() {
    var imgSrc = $(this).attr('src');
    $(this).parent().css({'background-image': 'url('+imgSrc+')'});
    $(this).remove();
});

$( "#profile000001:first-child" ).click(function() {
	var config = $("<div id="profile000001">
	<img class="button" src="images/test.jpg"/>
	</div>"
	$("#nav000001").afterconfigPixeden
});

