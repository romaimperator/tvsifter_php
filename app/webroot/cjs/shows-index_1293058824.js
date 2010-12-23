/* shows/index.js (49%) */
$(document).ready(function(){$('.unfollow').hide();$('.unfollow').click(function(e){unfollow($(this).parent().attr('id'));});});function unfollow_show(){$('.unfollow').toggle();}
function unfollow(id){$.get('/shows/unfollow/'+id,function(result,textStatus){if(textStatus=='success'){$('#'+id).fadeOut();}});}