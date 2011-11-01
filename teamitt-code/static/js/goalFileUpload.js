$("document").ready(function(){


	$(".file_section_display a").click(function () 
	{
		type=$(this).attr("action_type");
		url="./includes/file_upload.php"; 
		url = url + "?action_type=" + type;

		result_cont = $("#show_" + type);
		if(result_cont.is(":visible"))
		{
			result_cont.fadeOut();
			$(this).removeClass("opened").addClass("closed");
		}	
		else
		{
			result_cont.html("<h3></h3>").fadeIn();
		    if (type=='uploadfile')
		    {	content_html="<div id='show_upload_form' class='upload_form'>"; 
			content_html=content_html+"<form id='upload' name='upload' method='POST' enctype='multipart/form-data' target='upload_target' action='./includes/file_upload.php'>"; 
		        content_html=content_html+"Categories:<select id='category_list' name='category_list'> </select>";
        		content_html=content_html+"<br/>"; 
                	content_html=content_html+"File:<input type='file' name='filetoupload' id='filetoupload' /><br/>";
                        content_html=content_html+"<input type='submit' name='submit1' value='Upload' id='uploadbutton' />"; 
			content_html=content_html+"<input type='hidden' name='submit' />";
	                content_html=content_html+"<iframe id='upload_target' name='upload_target' src='' style='width:0;height:0;border:0px solid #fff;'></iframe>";
			content_html=content_html+"</form>"; 
        	        //content_html=content_html+"<div id='message' style='display:none;'></div>"; 
        		content_html=content_html+"</div>";
			result_cont.append(content_html);
			$(this).removeClass("closed").addClass("opened");
			result_cont=$("#category_list") ; 
			url="./includes/file_upload.php?action=1";
			result_cont.load(url); 
			$("#category_list").focus(); 
			
		     } 
		     if (type=='addcategory') 
		     {  content_html="<div id='add_category' class='upload_form'>";
			content_html=content_html+"<input id='new_category' type='text' name='category' />"; 
			content_html=content_html+"<br><input onclick='AddNewCategory();' type='button' value='Add' />";
			//content_html=content_html+"<div id='cat_message' style='display:none;'></div>";
			content_html=content_html+"</div>";	
			result_cont.append(content_html); 	
			$(this).removeClass("closed").addClass("opened");
			$("#new_category").focus(); 
		     } 			
		     if (type=='showuploadedfiles') 
		     {	
			content_html="<div id='file_list' class='file_list'> </div>";
			result_cont.append(content_html);
                        $(this).removeClass("closed").addClass("opened");
			result_cont=$("#file_list"); 
			url="./includes/file_upload.php?action=2";
                        result_cont.load(url);		
			
                     }	
		}
		
		return false;

	});

});

function afterUpload(uploadID,filename,uploadCategoryID,timestamp,filepath,filesize,userID)
{	
	 if ($(".opened").attr("action_type")=='showuploadedfiles')
	{ 	
		content_html="<div id="+uploadID+" class='each_file'>";
		content_html=content_html+ "<span class='download_file'><a href='"+filepath+filename+"'>"+filename+" </a></span>";
                content_html=content_html+ "<span class='delete_file'> X </span>";
                content_html=content_html+ "<span class='upload_from_user'>"+userID+" </span>";
                content_html=content_html+ "<span class='file_upload_date'>"+timestamp +" </span>";
                content_html=content_html+ "<span class='filesize'>"+filesize +" </span>";
                content_html=content_html+ "</div>";
		
		result_cont=$("#file_list").find("#"+uploadCategoryID);
		if (result_cont.find('#no_file').length) 
		{	temp=result_cont.find('#no_file'); 
			temp.fadeOut(function(){ $(this).remove(); }); 
		}
		result_cont.find(".category_data").append(content_html); 
	}
	$("#upload")[0].reset();
	$("#category_list").focus(); 	 
	$("#action_message").append("<p id='action_text' class='action_text'>File Uploaded Successfully </p>").fadeIn(25000);
	$("#action_text").fadeOut(15000, function(){$(this).remove();}); 
	
} 

function AddNewCategory()
{	/* Add new cateogry to the DATABASE */
	value=$("input#new_category").attr('value'); 
	var reply_data={ new_category:value  } 
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
			{	$("#cat_message").html("<h3> category added</h3>");
				result_cont=$(".file_section_display").find(".opened");
				//alert(result_cont.length);
				result_cont.each(function(){ 
					var action=$(this).attr('action_type');
				if (action=='uploadfile')	
			//	if ($(".opened").attr("action_type")=='uploadfile')
				{// 	alert('c'); 	
					content_html="<option value='"+data+"'>"+value+"</option><br/>";
					result_cont=$("#category_list");
					result_cont.append(content_html); 
//					result=1;
				}
				if (action=='showuploadedfiles')
//				if ($(".opened").attr("action_type")=='showuploadedfiles')
				{//	alert('f'); 
					content_html= "<div id="+ data +" class='each_category'>";
                        		content_html=content_html + "<span class='category_heading'>"+value+"</span>";
                        		content_html=content_html + "<span class='category_data'>";
					content_html=content_html + "<div id='no_file' class='no_file'>No File uploaded in this category.</div>";
					content_html=content_html + "</span>";
					content_html=content_html + "</div>";
					result_contA=$("#file_list"); 
					result_contA.append(content_html); 						
				}
				});
			}
			if (data==0) 
				$("#cat_message").html("<h3> error </h3>");
			if (data=='-1')
				$("#cat_message").html("<h3> category already exists</h3>");
			$("input#new_category").attr('value',"");
			$("input#new_category").focus();		
			$("#action_message").append("<p id='action_text' class='action_text'>File Uploaded Successfully </p>").fadeIn(25000);
        		$("#action_text").fadeOut(15000, function(){$(this).remove();});
		} 
	});
	 
}

		/*var reply_data= { upload:1 , filename:filename, } 
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
				alert(data); 
			}
		});
		*/
		
function showFileSection() 
{	$('#GoalFeedCont').hide(); 
	$('#goal-mbti-query').hide();
	$('#file_section').show(); 
} 

$('.delete_file').live('click',deleteFile);

function deleteFile()
{ 	
	var parent_tag=$(this).parent('.each_file');
	var parent_id=$(this).parent('.each_file').attr('id');
	var reply_data={ file_id:parent_id , delete_file:1 , } 
	$.ajax
                ({
                        type:"POST",
                        url:"./includes/file_upload.php",
                        dataType:"json",
                        data:reply_data,
                        timeout:10000,
                        error :function() {},
                        success:function(data)
                        {	result_cont=$(parent_tag).parent(); 
                   		parent_tag.fadeOut(function(){ $(this).remove(); }); 
				var children=result_cont.children();
//				alert(children.length);
				if (children.length==1)
					result_cont.append("<div id='no_file' class='no_file'>No File uploaded in this category.</div>");
                        }
                });
}

/*

*/ 
