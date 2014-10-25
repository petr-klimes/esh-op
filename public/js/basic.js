
centerWidth = $('#center').width() + 'px';
$('nav ul li .nav-content').css({'width': centerWidth, 'right': '-' + centerWidth});
$('nav ul li').mouseenter(function(){
  var selfe = $(this);
  var width = $('#center').width() + 'px';

  if(centerWidth != width){
    showNavContent(selfe, $('nav ul li .nav-content'),{'width': width, 'right': '-' + width});
    centerWidth = width;
  }else{
    showNavContent(selfe);  
  }
});

$('nav ul li').mouseleave(function(){
  $(this).removeClass('active');
});

$('#top-menu ul li').mouseenter(function(){
  $(this).addClass('active');
});

$('#top-menu ul li').mouseleave(function(){
  $(this).removeClass('active');
 });






// funkce pro zobrazeni nav contentu - rozjizdeci menicka 
function showNavContent(item, contents, contentsCss){
  if (contentsCss !== undefined && contents !== undefined){
    contents.css(contentsCss);  
  }
  item.addClass('active');
}