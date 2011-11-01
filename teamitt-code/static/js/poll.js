// Global variable definitions
// DB column numbers
var POLL_RSLT;
var POLL_VOTE;
var OPT_ID = 'option_id';
var OPT_TITLE = 'option_text';
var OPT_VOTES = 'option_vote';
var FB_NAME = 'facebook_name';
var votedID;
var QUES_TEXT,OPT_TEXT;
var QUES_ID;

$(document).ready(function(){
  $(".poll").submit(formProcess); // setup the submit handler
  
  if ($("#poll-results").length > 0 ) {
    animateResults();
  }
  
 /* if ($.cookie('vote_id')) {
    $("#poll-container").empty();
    votedID = $.cookie('vote_id');
    $.getJSON("poll.php?vote=none",loadResults);
  }*/
});
function formProcess(event){
  event.preventDefault();
var form_id =  $(this).attr('id');
  var id = $("#"+form_id+" > input[@name='poll']:checked").attr("value");
  QUES_TEXT = $("#"+form_id).find('p').text();
  OPT_TEXT = $("#"+form_id+" > input[@name='poll']:checked").nextAll('label:first').text();
  id = id.replace("option",'');
 QUES_ID =  $("#"+form_id).parents('.poll-container').attr('id');
  $('#'+QUES_ID).fadeOut("slow",function(){
    $(this).empty();
    
    votedID = id;
    var voter_fbid = FB.getSession().uid;
    $.getJSON("includes/poll.php?vote="+id+"&voter_id="+voter_fbid,loadResults);
    
    //$.cookie('vote_id', id, {expires: 365});
    });
}

function animateResults(){
  $(".graph div").each(function(){
      var percentage = $(this).next().text();
      $(this).css({width: "0%"}).animate({
				width: percentage}, 'slow');
  });
}

function loadResults(data) {
POLL_RSLT = data;
data = data[0];
var data_len = data.length;
var total_votes = 0;
var percent;
for( i = 0 ; i < data_len ; i++)
{
	total_votes = parseInt(data[i][OPT_VOTES])+total_votes;
}
POLL_VOTE = total_votes;
 //var results_html = "<div id='poll-results'><div id='poll_result_header'><h3 class = 'poll_h3'>Poll Results</h3><div id='poll_post_div'><input type = 'button' id = 'poll_post' value = 'Share'/></div></div>\n<dl class='graph'>\n";
 
var results_html = "<div id='poll-results'><div id='poll_result_header'><h3 class = 'poll_h3'>Poll Results</h3><div id='poll_post_div'><input type = 'button' id = 'poll_post' value = 'Share'/></div></div>\n<dl class='graph'>\n";
for( id = 0 ; id < data_len ; id++)
{
    percent = Math.round((parseInt(data[id][OPT_VOTES])/parseInt(total_votes))*100);
    if (data[id][OPT_ID] !== votedID) {
      results_html = results_html+"<dt class='bar-title'>"+data[id][OPT_TITLE]+"</dt><dd class='bar-container'><div id='bar"+data[id][OPT_ID]+"'style='width:0%;'>&nbsp;</div><strong>"+percent+"%</strong></dd>\n";
    } else {
      results_html = results_html+"<dt class='bar-title'>"+data[id][OPT_TITLE]+"</dt><dd class='bar-container'><div id='bar"+data[id][OPT_ID]+"'style='width:0%;background-color:#0066cc;'>&nbsp;</div><strong>"+percent+"%</strong></dd>\n";
    }
  }
  
  results_html = results_html+"</dl><p>Total Votes: "+total_votes+"</p></div>\n";
   
  $("#"+QUES_ID).append(results_html).fadeIn("slow",function(){
    animateResults();});
}
