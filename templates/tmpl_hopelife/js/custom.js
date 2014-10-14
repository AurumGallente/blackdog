// JavaScript Document
$(document).ready(function() {
	
		var pTags = $("ul.sub");
	var pTags1 = $("ul.more_sub");
	if ( pTags.parent().is("div") ) {
		pTags.unwrap();
	}
	if ( pTags1.parent().is("div") ) {
		pTags1.unwrap();
	}	
$('.topMenu td ul').removeClass('sub');
$('.topMenu td ul').removeClass('more_sub');
$('.topMenu td ul').removeClass('main_elements');
var ul = $("<div class='mainmenu clearfix'><div class='menu-button'>Menu</div>");
    $(".topMenu tr").each(function(){
        var li = $("<ul data-breakpoint='800' class='flexnav'>");
        $("th, td", this).each(function(){
		var active=$(this).attr('id');
        if($(this).attr('id')){
			var p = $("<li class='active'>").html(this.innerHTML);
		}else
		{
			 var p = $("<li>").html(this.innerHTML);
		}
		li.append(p);
		});
		ul.append(li);
	});
  $(".topMenu").replaceWith(ul); 

$(".flexnav").flexNav();

/*======add and remove class=====*/
$(".flexnav li:first-child").addClass('first');
$(".flexnav li:last-child").addClass('last');
$(".homepaged").parents('body').addClass('homepage');
$(".bx_photos_search_unit").parents('.bx-def-bc-margin-thd').addClass('photoblock')
	    $('.quick_links_elink').each(function(){
	   $(this).parents(':eq(1)').addClass('width100');
		});


/*============column dispatch==========*/

$('.page_column_single, .main_footer_block').removeAttr('style');
$('.page_column_single').addClass('span12 marginnone');

var pagecount;
pagecount=parseInt($('.page_column').length);
vartotal=0;
if(pagecount==2)
{
$('.page_column').each(function(){
 vartotal=vartotal+parseInt($(this).css("width"),10); 
 $(this).addClass('col2page');
});
var colfirst=parseInt($(".page_column_first").css("width"),10)/vartotal*98.5;
var collast=parseInt($(".page_column_last").css("width"),10)/vartotal*98.5;
$(".page_column_first").css('width',colfirst+'%');
$(".page_column_last").css('width',collast+'%');;
$(".page_column_first").addClass('colsecond');
}
else if(pagecount==3)
{
	var yes=$('.page_column').hasClass('span12 marginnone');
	if(yes)
	{
		vartotal=parseInt($('.page_column_first').css("width"),10)+parseInt($('.page_column_last').css("width"),10);
		var colfirst=parseInt($(".page_column_first").css("width"),10)/vartotal*98.5;
        var collast=parseInt($(".page_column_last").css("width"),10)/vartotal*98.5;
        $(".page_column_first").css('width',colfirst+'%');
        $(".page_column_last").css('width',collast+'%');
		$(".page_column_first, .page_column_last").addClass('col2page');
		$(".page_column_first").addClass('colsecond');
	}
	else
	{
	  
	  vartotal=parseInt($('.page_column_first').css("width"),10)+parseInt($('#page_column_2').css("width"),10)+parseInt($('.page_column_last').css("width"),10);
	  var colfirst=parseInt($(".page_column_first").css("width"),10)/vartotal*97;
	  var colsec=parseInt($("#page_column_2").css("width"),10)/vartotal*97;
      var collast=parseInt($(".page_column_last").css("width"),10)/vartotal*97;
	  $(".page_column_first").css('width',colfirst+'%');
      $("#page_column_2").css('width',colsec+'%');
      $(".page_column_last").css('width',collast+'%');;
	  $("#page_column_2, .page_column_last, .page_column_first").addClass('col3page');
	  $(".page_column_first").addClass('colfirstn');
	}
}
else if(pagecount==4)
{
	$('body').addClass('col3');
	  var yes=$('.page_column').hasClass('page_column_single');
	if(yes)
	{
		
	  vartotal=parseInt($('.page_column_first').css("width"),10)+parseInt($('#page_column_2').css("width"),10)+parseInt($('.page_column_last').css("width"),10);
	  var colfirst=parseInt($(".page_column_first").css("width"),10)/vartotal*97;
	  var colsec=parseInt($("#page_column_2").css("width"),10)/vartotal*97;
      var collast=parseInt($(".page_column_last").css("width"),10)/vartotal*97;
	  $(".page_column_first").css('width',colfirst+'%');
      $("#page_column_2").css('width',colsec+'%');
      $(".page_column_last").css('width',collast+'%');;
	  $("#page_column_2, .page_column_last, .page_column_first").addClass('col3page');
	  $(".page_column_first").addClass('colfirstn');
		
	}
	else
	{
	  vartotal=parseInt($('#page_column_1').css("width"),10)+parseInt($('#page_column_2').css("width"),10)+parseInt($('#page_column_3').css("width"),10)+parseInt($('#page_column_4').css("width"),10);
	  var col1=parseInt($("#page_column_1").css("width"),10)/vartotal*95.5;
	  var col2=parseInt($("#page_column_2").css("width"),10)/vartotal*95.5;
	  var col3=parseInt($("#page_column_3").css("width"),10)/vartotal*95.5;
      var col4=parseInt($("#page_column_4").css("width"),10)/vartotal*95.5;
	  $("#page_column_1").css('width',col1+'%');
      $("#page_column_2").css('width',col2+'%');
      $("#page_column_3").css('width',col3+'%');
      $("#page_column_4").css('width',col4+'%');
	  $("#page_column_1, #page_column_2,#page_column_3, #page_column_4").addClass('col3page')
	  $("#page_column_1").addClass('colfirstn');

	}
}





	
/*----------design box shadow checking-------------*/
$('.sys_main_content .disignBoxFirst').each(function(){
	var yes=$(this).children().hasClass('bottomleft')
	if(yes){}else{
			$(this).append('<div class="bottomleft bottomleft1"></div><div class="bottomright bottomright1"></div>');
	}
});


$('.topsearcha').click(function(e){
	e.preventDefault();
	$('#sys_search_wrapper').slideToggle();
	$(this).toggleClass('topsearcha1');
});
$('#extra_top_menu').parents('body').addClass('memberin');

	  var div = $('.sys_main_menu');
     var start = $(div).offset().top;
 
    $.event.add(window, "scroll", function() {
        var p = $(window).scrollTop();
        $(div).css('position',((p)>start) ? 'fixed' : 'relative');
        $(div).css('top',((p)>start) ? '0px' : '');
    });
$('.bannerblock').parents('body').addClass('bannertrue');

$('.form_advanced_table').parent('.dbContent').addClass('margintopnone')

});




/*--------calculating menu width-----------*/
$(document).ready(function(){
function adjustStyle(width) {
$('.flexnav li a span').removeAttr('style');
var test=0;
var licount=0;
var paddingli=0;
    width = parseInt(width);
    if (width >= 1200) {
$(".flexnav > li").each(function(){
	test+=parseInt($(this).outerWidth());
});
licount=$(".flexnav > li").length
test=(1160-test)/parseInt(licount);
paddingli=test/2; 
if(paddingli<=25)
{
$(".flexnav > li a span").css({"padding-left":paddingli});
$(".flexnav > li a span").css({"padding-right":paddingli});
}
else
{
$(".flexnav > li a span").css({"padding-left":25});
$(".flexnav > li a span").css({"padding-right":25});
}
	}}
		   $(function() {
    adjustStyle($(this).width());
    $(window).resize(function() {
        adjustStyle($(this).width());
    });
		   });
		   
	/*=====================back to top */		   
 $('#back-to-top').click(function () {
   $('body,html').animate({
    scrollTop: 0
   }, 800);
   return false;
  });		   
		   
});


   $(window).scroll(function () {
   if ($(this).scrollTop() > 100) {
    $('#back-to-top').fadeIn();
   } else {
    $('#back-to-top').fadeOut();
   }
  });