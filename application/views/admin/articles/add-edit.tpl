{$headder}

<script type="text/javascript">
var base_url = "{$base_url}";
var get_url ="{$base_url}xcalls/get/";
var set_url ="{$base_url}xcalls/set/"; 
var selectedArticle = "{$article->article_id}";
//{literal}
$(document).ready(function(e) {
   
	
	
	$("input[name='category_level']").change(function(e) {        
		if( $("input[name='category_level']:checked").val() == 1)
		{
			
			$("#parent-category").removeAttr('disabled');
		}
		else
		{
			$("#parent-category").attr('disabled','disabled');
		}
	});
	
	$("input[name='category_level']").trigger('change');
	
	
	/*tinyMCE.init({
		mode : "none",
		height : "80",
		width:'800',
		theme_advanced_resizing : false,
		theme : "advanced",
		content_css : base_url+"css/tinymce.css?"+ new Date().getTime(),
		theme_advanced_font_sizes: "10px,12px,13px,14px,16px,18px",
		font_size_style_values : "10px,12px,13px,14px,16px,18px",
		theme_advanced_fonts : "English=arial,helvetica,sans-serif;Sinhala=fmabhayax",
		relative_urls : false,
		plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,jbimages",		
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,jbimages,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom"
	});*/
	
	
	
	$("#add-topic").click(function(e) {
			$.post( 
					set_url+'newTopic',  
					{ 'articleId': selectedArticle }, 
					function(response) {
						if(response.success)
						{
							var newTopic = $("#new-topic-tpl").clone();
							var selectedTopic = response.topicId;
							
							newTopic.find(".topic_id").val(selectedTopic);
							
							newTopic.find(".save-button").click(function(e) {
								e.preventDefault();
								TopicSaveAction($(this));								
							});
							
							newTopic.find(".delete-button").click(function(e) {
								e.preventDefault();
								TopicDeleteAction($(this));								
							});
							
							newTopic.find(".add-image-button").fineUploader({
								maxConnections:1,
								request: {
									endpoint: base_url+'admin/articles/UploadImage',
									params:{
										'id': $(this).parent().find(".topic_id").val()
										},
									
								}
							})
							.on('submit', function(event, id, filename) {				
				     				$(this).fineUploader('setParams', {'id': $(this).parent().find(".topic_id").val()});
				  			})
							.on('complete', function(event, id, filename, responseJSON){
								
								var imgWrap = $(
									'<div id="image_'+responseJSON.filename_we+'" > '+
									'<img src = "'+base_url+responseJSON.file_url+'" id="img-'+responseJSON.filename_we+'" title="'+responseJSON.filename_we+'" />'+
									'<div class="clear10" style="float:none;"></div>'+
									'<a  class="delete-button AdminBut Delete" title="'+responseJSON.filename_we+'">Delete</a></div>'
								);
								
								imgWrap.find('.delete-button').click(function(e){
									e.preventDefault();
									
									ImageDeleteAction($(this));									
								});
								
								imgWrap.appendTo(newTopic.find(".image-list"));
							});
						
							newTopic.find(".add-video-button").click(function(e){
								e.preventDefault();
								var videoList = $(newTopic.find('.video-list'));
								var url = newTopic.find(".video_link").val();
								videoList.html('');
								var video = $('<embed width="420" height="345" type="application/x-shockwave-flash"></embed>');
								video.attr('src',url);
								videoList.append(video);
							});
							
							newTopic.appendTo("#topic-container");
							
							newTopic.attr('id','new-topic-'+selectedTopic);
							
							newTopic.show();
						}
					},
					'json'
				);
			
			return;
    });
	
	SetupTopics();
	
	
});

function SetupTopics()
{
	$('.article_topic').each(function(index,element)
		{
			var newTopic = $(element);
			
			
			newTopic.find(".save-button").click(function(e) {
								e.preventDefault();
								TopicSaveAction($(this));								
							});
							
			newTopic.find(".delete-button").click(function(e) {
				e.preventDefault();
				TopicDeleteAction($(this));								
			});
			
			newTopic.find(".add-image-button").fineUploader({
				maxConnections:1,
				request: {
					endpoint: base_url+'admin/articles/UploadImage'
				}
			})
			.on('submit', function(event, id, filename) {				
     				$(this).fineUploader('setParams', {'id': $(this).parent().find(".topic_id").val()});
  			})
			.on('complete', function(event, id, filename, responseJSON){
				
				
				var imgWrap = $(
					'<div id="image_'+responseJSON.filename_we+'" > '+
					'<img src = "'+base_url+responseJSON.file_url+'" id="img-'+responseJSON.filename_we+'" title="'+responseJSON.filename_we+'" />'+
					'<div class="clear10" style="float:none;"></div>'+
					'<a  class="delete-button AdminBut Delete" title="'+responseJSON.filename_we+'">Delete</a></div>'
				);
				
				imgWrap.find('.delete-button').click(function(e){
					e.preventDefault();
					ImageDeleteAction($(this));									
				});
				
				imgWrap.appendTo(newTopic.find(".image-list"));
			});
		
			newTopic.find(".add-video-button").click(function(e){
				e.preventDefault();
				var videoList = $(newTopic.find('.video-list'));
				var url = newTopic.find(".video_link").val();
				videoList.html('');
				var video = $('<embed width="420" height="345" type="application/x-shockwave-flash"></embed>');
				video.attr('src',url);
				videoList.append(video);
			});
			
			
		}
	);
}


function TopicSaveAction(element)
{
	var topicId = $(element).parent().find(".topic-id").val();
	var formData = $(element).parent().serialize();
	var formElement =  $(element).parent();
	
	formElement.next().show();
	formElement.hide();
	
	$.post( 
		set_url+'saveTopic',  
		formData, 
		function(response) {
			formElement.next().hide();
			formElement.show();
		},
		'json');
}

function TopicDeleteAction(element)
{
	var formElement =  $(element).parent();
	var formData = formElement.serialize();
	
	$.post( 
		set_url+'deleteTopic',  
		formData, 
		function(response) {
			if(response.success)
			{
				formElement.parent().remove();
			}
			else
				console.log('deletion failed');
		},
		'json');
}

function ImageDeleteAction(element)
{
	var fileId = $(element).attr('title');
	var topicId = $(element).parent().parent().parent().find(".topic-id").val();
	
	$.post( 
		base_url+'admin/articles/DeleteImage',  
		{ 'file': fileId, 'pid':topicId }, 
		function(response) {
			if(response.success)
			{
				$("#image_"+response.fileId).remove();
			}
		},
		'json'
	);
}
//{/literal}
</script>
	<div>
    	{$msg}
    </div>
    <div >
        <form method="post">
        	
            <select id="parent-category" name="article_category" >
            	<option value="0">No parent</option>
            	{foreach $categoryList as $category}
                	{$lvl1childCategories = $category->GetChildCategories()}
                	<option value="{$category->category_id}" class="menu-level-1"><span  class="sinhala " >{$category->category_title_sin}</span></option>
                    {if $lvl1childCategories}
                    	
                    	{foreach $lvl1childCategories as $category}
                        	{$lvl2childCategories = $category->GetChildCategories()}
                			<option value="{$category->category_id}" class="menu-level-2"><span  class="sinhala" >{$category->category_title_sin}</span></option>
                            
                            {if $lvl2childCategories}
                                {foreach $lvl2childCategories as $category}
                                	{$lvl3childCategories = $category->GetChildCategories()}
                                    <option value="{$category->category_id}" class="menu-level-3"><span  class="sinhala" >{$category->category_title_sin}</span></option>
                                    
                                    {if $lvl3childCategories}
                                    	{foreach $lvl3childCategories as $category}
                                    		<option value="{$category->category_id}" class="menu-level-4"><span  class="sinhala" >{$category->category_title_sin}</span></option>
                                        {/foreach}
                                    {/if}
                                    
                            	{/foreach}
                            {/if}
                            
                        {/foreach}
                        
                    {/if}
                {/foreach}
            </select><br />
            
            Article title<input type="text" name="article_title" value="{$article->article_title}" /><br />
            
            <button type="submit" name="save" value="1">Save article</button><br />
        </form>
        <button type="button" id="add-topic">+</button><br />
        
        <div id="topic-container">
        	{foreach $topicList as $topic}
        		{$topic->Refresh()}
        	<div id="new-topic-{$topic->topic_id}" class="article_topic" >
		    	<form class="topic-form">
		            <input type="text" name="topic_heading" value="{$topic->topic_heading}" /><br />
		            <textarea class="topic_body" name="topic_content" >{$topic->topic_content}</textarea><br />
		            <div class="image-list">
		            	{foreach $topic->GetImageList() as $img}
		            	<div id="image_{$img['fileId']}" >
						<img src = "{$base_url}{$img['fileUrl']}" id="img-{$img['fileId']}" title="{$img['fileId']}" />
						<div class="clear10" style="float:none;"></div>
						<a  class="delete-button AdminBut Delete" title="{$img['fileId']}">Delete</a></div>
		            	{/foreach}
		            </div>
		            
		            <div class="add-image-button">Add Image</div>
		            
		            
		            
		            <input class="video_link" />
		            <button class="add-video-button">Add Video</button>
		            
		            <div class="video-list"></div>
		            
		            <br />
		            <button class="save-button">Save</button>
		            <button class="delete-button">Delete</button>
		            <input type="hidden" name="topic_id" class="topic_id" value="{$topic->topic_id}"  />
		        </form>
		        <div class="loading-progrss" style="display:none" >Saving....</div>
		    </div>
        	{/foreach}
        </div>
    
    		
    </div>
   
    
    <div id="new-topic-tpl" style="display:none">
    	<form class="topic-form">
            <input type="text" name="topic_heading" /><br />
            <textarea class="article_body" name="topic_content" ></textarea><br />
            <div class="image-list"></div>
            
            <div class="add-image-button">Add Image</div>
            <input class="video_link" />
            <button class="add-video-button">Add Video</button>
            <div class="video-list"></div>
            <br />
            <button class="save-button">Save</button>
            <button class="delete-button">Delete</button>
            <input type="hidden" name="topic_id" class="topic-id"  />
        </form>
        <div class="loading-progrss" style="display:none" >Saving....</div>
    </div>
    
    

{$footer}
