$("document").ready(function(){
	$(".file_section_display a").click(function ()
        {	type=$(this).attr("action_type");
		url="./includes/file_upload.php";
		url = url + "?action_type=" + type;
				
		result_cont = $("#show_" + type);
		//result_cont = $("#show_" + type).toggle();
		if(result_cont.is(":visible"))
                {
                        result_cont.fadeOut();
                        $(this).removeClass("opened").addClass("closed");
                }
		else
		{	
			result_cont.html("<h3>Loading...</h3>").fadeIn();
			result_cont.load(url);
        		$(this).removeClass("closed").addClass("opened");
		}
	return false;
	});
//var data = "Core Selectors Attributes Traversing Manipulation CSS Events Effects Ajax Utilities".split(" ");
//$("#txt_tags").autocomplete(data);



});

$(".file_tag").live('click',function(){
	parent_tag=$(this).parents('.file_data'); 
	section=parent_tag.find('.section').attr('value');
	sectionID=parent_tag.children('.sectionID').attr('value'); 	
	tag=$(this).text(); 
	result_cont = $("#show_showuploadedfiles");
	$("#file_list").remove(); 
	url="./includes/file_upload.php?action_type=showuploadedfiles&tag="+tag+"&section="+section+"&sectionID="+sectionID; 
	result_cont.load(url);	
}); 

$(".showallfiles").live('click',function(){
//	alert('all'); 
	result_cont = $("#show_showuploadedfiles");
	result_cont.children().remove(); 
	url="./includes/file_upload.php?action_type=showuploadedfiles";
	result_cont.load(url);	

});


$(".tag_delete").live('click',deletetag)
function deletetag()
{
	result_cont=$(this).parents("#tag_item");
	result_cont.fadeOut(function(){ $(this).remove(); });
	if($("#tag_list").children(".tag_item").length==1)
        	$(".tag_title").attr('style','display: none;');
	$("#txt_tags").focus();
}

$('.delete_file').live('click',deletefile);

function deletefile()
{		
	var parent_tag=$(this).parent();
        var parent_id=$(this).parent().attr('id');
	var reply_data={fileID:parent_id , delete_file:1 , }; 
	$.ajax
                ({
                        type:"POST",
                        url:"./includes/file_upload.php",
                        dataType:"json",
                        data:reply_data,
                        timeout:10000,
                        error :function() {},
                        success:function(data)
			{	
				if (data>0) 
				{	result_cont=$(parent_tag).parent();
					parent_tag.fadeOut(function(){ $(this).remove(); });
				}
			}
	});
}


function showFileSection()
{	$('#GoalFeedCont').hide();
        $('#goal-mbti-query').hide();
        $('#file_section').show();
}

$("#add_tag").live('click',function(){
	var check=0; 
	word=$("#txt_tags").attr("value");
	typed = word; typed = typed.replace(/,+$/,""); typed = typed.trim();
        tag_list=$("#tag_list");
        if (typed.length>0)
	{	check=check_duplicate_tags(tag_list,typed);
        	if (check==0)
	        {       content_html=create_tag(word);
        	 	result_cont1=$("#tag_list");
	                result_cont1.append(content_html);
        	        if (result_cont1.children(".tag_item").length>=1)
	                {       if ($(".tag_title").attr('style')=="display: none;")
        	        		$(".tag_title").attr('style','display: inline-block;');
	                }
        	 }
		if (check==0)
       		      $("#txt_tags").val("");
	        $("#txt_tags").focus();
	}
	else 
	{	action_message("No tag entered.","new_tag",10000);	
		$("#txt_tags").focus(); 	
	}
	
});

function show_tag_suggestions(typedkey, word)
{	
	const BACKSPACE=8;
	const ENTER=13;
	const SPACE=32;
	const COMMA=44;
	
	var flag=0;
	var null_word=0;

	if (word.length<1) 
		null_word=1; 
	if ((null_word==1) && ((typedkey.charCode==COMMA)||(typedkey.charCode==SPACE)||(typedkey.keyCode==ENTER))) 
	{	$("#txt_tags").val("");
		return typedkey.preventDefault(); 
	}  
	
	if (typedkey.keyCode==BACKSPACE)
	{	flag=1; 
		if (null_word==1)
		{	$("#tag_list").children(".tag_item").last().remove();
			if($("#tag_list").children(".tag_item").length==0)
				$(".tag_title").attr('style','display: none;');
		}
	}
    	
	if ((typedkey.keyCode==ENTER) || (typedkey.charCode==SPACE) || (typedkey.charCode==COMMA))
	{	flag=1; var check=0; 
		if (null_word==0)
		{	
			typed = word; typed = typed.replace(/,+$/,""); typed = typed.trim();
			tag_list=$("#tag_list"); 
			check=check_duplicate_tags(tag_list,typed);		
			if (check==0)			
			{	content_html=create_tag(word);
				result_cont1=$("#tag_list");
				result_cont1.append(content_html);
				if (result_cont1.children(".tag_item").length>=1)
				{	if ($(".tag_title").attr('style')=="display: none;") 
						$(".tag_title").attr('style','display: inline-block;');
				}	
			}
		}
			typedkey.preventDefault();
			if (check==0) 
				$("#txt_tags").val("");
			$("#txt_tags").focus(); 
	}
}


function get_suggestions(word)
{	
	var result=0; 
	var reply_data={word:word , get_suggestions:1 , };
        $.ajax
                ({
                        type:"POST",
                        url:"./includes/file_upload.php",
                        dataType:"json",
                        data:reply_data,
                        timeout:10000,
                        error :function() {},
                        success:function(data)
                        {	
				var temp_arr= new Array(); 
				for (i=0;i<data.length;i++) {
						temp_arr[i]=data[i].tag; 
				}
				$("#txt_tags").autocomplete(temp_arr);
			}
		});
}

 
function suggestions(word)
{	get_suggestions(word);
	//show_suggestions(val_arr); 
}

function show_suggestions(values)
{	//len=values.length; 
	$("#txt_tags").autocomplete(values);
}

function check_duplicate_tags(tag_list,typed)
{	var check=0;
	tag_list.find(".tag_input").each(function(){
		if (typed==$(this).val())
		{	check=1; 
			action_message("This tag has already been added","tag",10000);
		}
	});

	return check;
	
}

function create_tag(word)
{	content_html="<div id='tag_item' class='tag_item' style='display: inline-block'>"; 
	content_html+="<span class='tag_span'>";
	content_html+="<span class='tag_word'>";
	content_html+="<a id='tag_"+word+"' name='tag_link' class='tag_link' href='#'>" + word + "</a>";
	content_html+="<input type='hidden' id='tag_input_"+word+"' class='tag_input' name='tag_input[]' value='"+word+"' />"; 
	content_html+="</span>";
	content_html+="<span class='tag_delete'>X</span>";
	content_html+="</span>";
	content_html+="</div>"
	return content_html; 
}

function afterUpload(fileID,filename,related_tags,upload_date,filepath,filesize,username,section,sectionID,save_name)
{ 	
	if ($(".opened").attr("action_type")=='showuploadedfiles')
	{	
/*		url="./includes/file_upload.php";
                url = url + "?action_type=showuploadedfiles+param=" + fileID;

                result_cont = $("#file_list");
		result_cont.load(url);  
*/	
		
		content_html="<div id='"+fileID+"' class='file_data' style='display:block;'>";	
		content_html+="<span class='file_name'><a href='"+filepath+save_name+"'>"+filename+"</a></span>";	
		content_html+="<span class='delete_file'>X</span>";
		content_html+="<br>";
		content_html+="<span class='file_owner'>"+username+"</span>";
		content_html+="<span class='file_size'>"+filesize+"</span>";
		content_html+="<span class='file_date'>"+upload_date+"</span>";
		content_html+="<br>";
		content_html+="<span class='small_text'>Tags:</span>";
		content_html+="<span class='file_tags'>"; 
		var temp_arr=related_tags.split(",");
		var a=temp_arr.length; 
		for (i=0; i<a ; i++) 
		{ 		
			content_html+="<span id='tag_"+temp_arr[i]+"' class='file_tag' title='Click to see files with this tag'>"+temp_arr[i]+"</span>";
			if (a>0) 
			{	if ((i>=0) && (i<(a-1)))
					content_html+=" , ";
			}
		} 
		content_html+="</span>";
        	content_html+="<input type='hidden' name='sectionID' class='sectionID' value='"+sectionID+"' />";   // values to be used in TAG SEARCH 
        	content_html+="<input type='hidden' name='section' class='section' value='"+section+"' />";         //   "     "    "        "    " 
        	content_html+="</div>";
		result_cont=$("#file_list"); 
		result_cont.append(content_html).fadeIn(); 
	}
	$("#tag_list").children().remove(); 
	action_message("File Uploaded","message",10000);
	$("#filetoupload").attr("value",""); 
	$("#txt_tags").attr("value","");
	$("#txt_tags").focus(); 
	$("#upload_file").reset();
}

function action_message(message, id, time)
{
	if ($("#action_message").find(".disp_message").length>0)
		$("#action_message").children().remove();
        $("#action_message").append("<p id='"+id+"' class='disp_message'>"+message+"</p>");
	$("#"+id).fadeOut(time,function(){
		$(this).remove(); 	
	});
} 

function validate_submit(event)
{	if ($("#filetoupload").attr("value")=="")
	{	event.preventDefault(); 
		action_message("Error: No File to upload","nofile",10000);
		$("#filetoupload").focus();	
	}
}
