$('.carousel').carousel({
    interval: 5000 //changes the speed
})

$(window).load(function(){
 $('.container').find('img').each(function(){
  var imgClass = (this.width/this.height > 1) ? 'wide' : 'tall';
  $(this).addClass(imgClass);
 })
})