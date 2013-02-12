{$headder}

<script type="text/javascript">
var base_url = "{$base_url}";
var get_url ="{$base_url}xcalls/get/";
var set_url ="{$base_url}xcalls/set/"; 
var selectedArticle = "{$article->article_id}";
var convertText =  false;
//{literal}
$(document).ready(function(e) {
   	$("textarea").autosize();
   
	$("input[type=text]").bind("keyup select change",function(e){
		$(this).val(TextFormat($(this).val()));
	});
	
	$("textarea").bind("keyup select change",function(e){
		$(this).val(TextFormat($(this).val()));
	});
	
	$("#usingAbhaya").change(function(e){
		convertText = $(this).is(':checked');
	});
	$(document).bind('keydown', 'ctrl+q', function(e) {
		if((e.which==113 || e.which==81) && e.ctrlKey){ 
			$("#usingAbhaya").click(); 
		}
	});
	
	
	
	
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
					{ 'article_id': selectedArticle }, 
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
							
							newTopic.find(".topic-delete-button").click(function(e) {
								e.preventDefault();
								TopicDeleteAction($(this));								
							});
							
							newTopic.find(".add-image-button").fineUploader({
								maxConnections:1,
								text:{
									'uploadButton':'<span class="add-icon icon"></span>Add Image'
								},
								failedUploadTextDisplay : {
									mode:'none'
								},
								retry : {
									showButton : false,
									showAutoRetryNote : false
								},
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
								
								if(responseJSON.error != null || responseJSON.success == null)
								{
									alert('Error: ' + responseJSON.error);
									return;
								}
								
								var imgWrap = $(
									'<div id="image_'+responseJSON.filename_we+'" class="image-container" > '+
									'<img src = "'+base_url+responseJSON.file_url+'" id="img-'+responseJSON.filename_we+'" title="'+responseJSON.filename_we+'" />'+
									'<a  class="delete-button Delete delete-icon" title="'+responseJSON.filename_we+'"></a></div>'
								);
								
								imgWrap.find('.delete-button').click(function(e){
									e.preventDefault();
									
									ImageDeleteAction($(this));									
								});
								
								imgWrap.appendTo(newTopic.find(".image-list"));
							});
						
							newTopic.find(".add-video-button").click(function(e){
								e.preventDefault();
								AddVideoAction(this);
								/*
								var videoList = $(newTopic.find('.video-list'));
								var url = newTopic.find(".video_link").val();
								
								
								
								videoList.html('');
								var video = $('<embed width="420" height="345" type="application/x-shockwave-flash"></embed>');
								video.attr('src',url);
								videoList.append(video);
								*/
							});
							
							newTopic.appendTo("#topic-container");
							
							newTopic.attr('id','new-topic-'+selectedTopic);
							
							newTopic.find("input[type=text]").bind("keyup select change",function(e){
								$(this).val(TextFormat($(this).val()));
							});
							
							newTopic.find("textarea").bind("keyup select change",function(e){
								$(this).val(TextFormat($(this).val()));
							});
							
							newTopic.find("textarea").autosize();
							
							newTopic.show();
							
							newTopic.find('input[name=topic_heading]').focus();
						}
					},
					'json'
				);
			
			return;
    });
	
	
	$("#add-category").click(function(e){
		e.preventDefault();
		
		var selectedCat = parseInt($("#article-category").val());
		
		if(selectedCat != 0 || selectedCat != "")
		{
			$.post(
				set_url+'addArticleCategory',  
				{ 'article_id': selectedArticle, 'cat_id':selectedCat }, 
				function(response) {
					if(response.success)
					{
					
						var articleCatWrap = $('<div id="article_cat_'+response.category_id+'" class="article_cat">'+response.category_title_sin+'<a class="delete-button Delete minus-icon" title="'+response.category_id+'"></a></div>');
						articleCatWrap.find(".delete-button").click(function(e) {
							e.preventDefault();
							CategoryDeleteAction($(this));								
						});
						articleCatWrap.appendTo('#category-container');
					}
					else
					{
						alert(response.error);
					}
				},
				'json'
			);
		}
		else
		{
			alert('Please select a category');
		}
		
	});
	
	 $("input[name='category_level']").change(function(e) {  
   		var level = $("input[name='category_level']:checked").val();
		GetCategories(level);
	});
	
	$('#init_category_level').trigger('change');
	
	SetupTopics();
	SetupArticleCats();
	
	
	
	
});

function SetupArticleCats()
{
	$('#category-container').find(".delete-button").click(function(e) {
		e.preventDefault();
		CategoryDeleteAction($(this));								
	});
}

function SetupTopics()
{
	$('.article_topic').each(function(index,element)
		{
			var newTopic = $(element);
			
			
			newTopic.find(".save-button").click(function(e) {
								e.preventDefault();
								TopicSaveAction($(this));								
							});
							
			newTopic.find(".topic-delete-button").click(function(e) {
				e.preventDefault();
				TopicDeleteAction($(this));								
			});
			
			
			
			newTopic.find('.image-list').find(".delete-button").click(function(e) {
				e.preventDefault();
				ImageDeleteAction($(this));								
			});
			
			newTopic.find('.video-list').find(".delete-button").click(function(e) {
				e.preventDefault();
					VideoDeleteAction($(this));								
			});
			
			newTopic.find(".add-image-button").fineUploader({
				maxConnections:1,
				text:{
					'uploadButton':'<span class="add-icon icon"></span>Add Image'
				},
				failedUploadTextDisplay : {
					mode:'none'
				},
				retry : {
					showButton : false,
					showAutoRetryNote : false
				},
				request: {
					endpoint: base_url+'admin/articles/UploadImage'
				}
			})
			.on('submit', function(event, id, filename) {				
     				$(this).fineUploader('setParams', {'id': $(this).parent().find(".topic_id").val()});
  			})
			.on('complete', function(event, id, filename, responseJSON){
				
				if(responseJSON.error != null || responseJSON.success == null)
				{
					alert('Error: ' + responseJSON.error);
					return;
				}
				var imgWrap = $(
					'<div id="image_'+responseJSON.filename_we+'"  class="image-container" > '+
					'<img src = "'+base_url+responseJSON.file_url+'" id="img-'+responseJSON.filename_we+'" title="'+responseJSON.filename_we+'" />'+
					'<a  class="delete-button Delete delete-icon" title="'+responseJSON.filename_we+'"></a></div>'
				);
				
				imgWrap.find('.delete-button').click(function(e){
					e.preventDefault();
					ImageDeleteAction($(this));									
				});
				
				imgWrap.appendTo(newTopic.find(".image-list"));
			});
		
			newTopic.find(".add-video-button").click(function(e){
				e.preventDefault();
				AddVideoAction(this);
				/*
				var videoList = $(newTopic.find('.video-list'));
				var url = newTopic.find(".video_link").val();
				videoList.html('');
				var video = $('<embed width="420" height="345" type="application/x-shockwave-flash"></embed>');
				video.attr('src',url);
				videoList.append(video);
				*/
			});
			
			
		}
	);
	
	
	
	
}


function TopicSaveAction(element)
{
	var topicId = $(element).parent().find(".topic_id").val();
	var formData = $(element).parent().serialize();
	var formElement =  $(element).parent();
	
	formElement.next().show();
	//formElement.hide();
	
	$.post( 
		set_url+'saveTopic',  
		formData, 
		function(response) {
			formElement.next().hide();
			//formElement.show();
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
				$('#topic-container .article_topic:last').find('input[name=topic_heading]').focus();
			}
			else
				alert('Topic deletion failed');
		},
		'json');
}

function ImageDeleteAction(element)
{
	var fileId = $(element).attr('title');
	var topicId = $(element).parent().parent().parent().find(".topic_id").val();
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


function AddVideoAction(element)
{
	var urlString = $(element).parent().find('.video_link').val();
	var topicId = $(element).parent().find(".topic_id").val();
	var videoListElement =  $(element).parent().find(".video-list");
	
	$.post( 
	set_url+'addTopicVideo',  
	{ 'url': urlString, 'topic_id':topicId },
	function(response) {
		if(response.success)
		{
			
			var video = $('<div id="video_'+response.video_id+'" class="video-container" > '+
						 	'<iframe frameborder="0" allowfullscreen width="200" height="200" '+
							'src="'+response.url+'"></iframe>' +
							'<a  class="delete-button Delete delete-icon" title="'+response.video_id+'"></a></div>')
							
			video.find('.delete-button').click(function(e){
					e.preventDefault();
					VideoDeleteAction($(this));									
				});				
			
			videoListElement.append(video);
			
			$(element).parent().find('.video_link').val('');
		}
		else
			alert('Invalid youtube video id');
	},
	'json');
}
function VideoDeleteAction(element)
{
	var video_id = $(element).attr('title');
	var topicId = $(element).parent().parent().parent().find(".topic_id").val();
	
	$.post( 
		set_url+'deleteTopicVideo',  
		{ 'video_id': video_id, 'topic_id':topicId }, 
		function(response) {
			if(response.success)
			{
				$("#video_"+response.video_id).remove();
			}
		},
		'json'
	);
}


function CategoryDeleteAction(element)
{
	var cat_id = $(element).attr('title');
	var article_id = selectedArticle;
	
	$.post( 
		set_url+'deleteArticleCategory',  
		{ 'cat_id': cat_id, 'article_id':article_id }, 
		function(response) {
			if(response.success)
			{
				$("#article_cat_"+response.category_id).remove();
			}
		},
		'json'
	);
}
function GetCategories(level)
{
	$.post(
		get_url+'getCategoriesAsOptions',
		{'level':level,'selected_id':null},
		function(respond)
		{
			if(respond.success)
			{
				var optionList = '<option value="0">No parent</option>'+respond.html;
				
				$("#article-category").html(optionList);
			}
		},
		'json'
	);
}

function TextFormat(text)
{
	if(convertText)
		return convertFromAbaya(text); //decleared in unicode-convert.js
	else
		return text;
}

//{/literal}
</script>
	<div>
    	{$msg}
    </div>
    <div >
    	<div class="right-static-menu">
        	
        	<input type="checkbox" id="usingAbhaya" value="1" /> I'm using Abhaya font
            <div class="lineBreak"></div>
            <button type="button" id="add-topic" class="white-btn"><span class="add-icon icon"></span>Add topic</button>
        </div>
        
        
       
        <label>Main menu</label><input  type="radio" name="category_level" id="init_category_level"  value="0" checked />
        <label>Side menu</label><input type="radio" name="category_level"  value="1" />
        <label>Bottom menu</label><input type="radio" name="category_level"  value="2" />
        <div class="clear5">
        
        <select id="article-category" >
            
        </select>
        
        <button type="button" id="add-category" class="white-btn"><span class="add-icon icon"></span>Add Category</button>
        
        <div class="clear10"></div>
        
        <div id="category-container">
        	{foreach $article->GetCategoryList() as $cat}
        	<div id="article_cat_{$cat->category_id}" class="article_cat">{$cat->category_title_sin}<a class="delete-button Delete minus-icon" title="{$cat->category_id}"></a></div>
            {/foreach}
        </div>
        
        <div class="clear20"></div>
        <form method="post">
        	
           
            
            <label>Article title</label> <input type="text" name="article_title" value="{$article->article_title}" class="inputText" />
            
            <button class="green-btn save-button" type="submit" name="save" value="1">Save article</button>
        </form>
        <div class="clear20"></div>
        
        <div class="clear10"></div>
        
        <div id="topic-container">
        	{foreach $topicList as $topic}
        		{$topic->Refresh()}
        	<div id="new-topic-{$topic->topic_id}" class="article_topic box" >
		    	<form class="topic-form">
		            <label style="width:70px">Title</label><input type="text" name="topic_heading" value="{$topic->topic_heading}" class="topic_heading inputText" />
                    <div class="clear5"></div>
		            <label style="width:70px">Content</label><textarea class="topic_body inputText" name="topic_content" >{$topic->topic_content}</textarea>
                    <div class="clear5"></div>
                    <div class="add-image-button add-image-video-button"></div>
		            <div class="clear10"></div>
                    
		            <div class="image-list">
		            	{foreach $topic->GetImageList() as $img}
                       
		            	<div id="image_{$img['fileIndex']}" class="image-container" >
						<img src = "{$base_url}{$img['fileUrl']}" id="img-{$img['fileIndex']}" title="{$img['fileIndex']}" />
						<a  class="delete-button Delete delete-icon" title="{$img['fileIndex']}"></a>
                        </div>
		            	{/foreach}
		            </div>
		            <div class="clear5"></div>
		           
		            
		            <label>Youtube Video Id</label><input class="video_link inputText" />
		            <button class="add-video-button add-image-video-button"><span class="add-icon icon"></span>Add Video</button>
                    <div class="clear2"></div>
                    <span class="note">If the url is http://www.youtube.com/watch?v=AcYmUIACfhs then the id is AcYmUIACfhs (part after v=)</span>
		           
		            <div class="clear10"></div>
		            <div class="video-list">
                    {foreach $topic->GetVideoList() as $video}
                    	<div id="video_{$video->video_id}" class="video-container" >
                        	<iframe frameborder="0" allowfullscreen width="200" height="200" src="{$video->video_url}"></iframe>
                            <a  class="delete-button Delete delete-icon" title="{$video->video_id}"></a>
                        </div>
                    {/foreach}
                    </div>
		            <div class="clear10"></div>
		            <button class="save-button green-btn">Save Topic</button>
		            <button class="topic-delete-button red-btn">Delete Topic</button>
		            <input type="hidden" name="topic_id" class="topic_id" value="{$topic->topic_id}"  />
		        </form>
		        <div class="loading-progrss" style="display:none" ><div class="busy-ani saving-ani">Saving</div></div>
                <div class="clear"></div>
		    </div>
            
        	{/foreach}
        </div>
    	<div class="clear20"></div>
        <select>
            <option value="0">No Advertisement</option>
            {foreach $advertisementList as $advertisement }
                <option value="{$advertisement->advertisement_id}">{$advertisement->advertisement_title}</option>
            {/foreach}
        </select>
        <button type="button" id="add-advertisement" class="white-btn"><span class="add-icon icon"></span>Add Advertisement</button>
        
        <div id="adverticement-container">
        	
        </div>
    </div>
   
    
    <div id="new-topic-tpl" style="display:none" class="article_topic box">
    	<form class="topic-form">
        	<label style="width:70px">Title</label><input type="text" name="topic_heading" value="" class="topic_heading inputText" />
            <div class="clear5"></div>
            <label style="width:70px">Content</label><textarea class="topic_body inputText" name="topic_content" ></textarea>
            
            <div class="clear5"></div>
            <div class="add-image-button"></div>
            <div class="clear10"></div>
            
            <div class="image-list"></div>
            <div class="clear5"></div>
           
            
            
            <label>Youtube Video Id</label><input class="video_link inputText" />
            <button class="add-video-button add-image-video-button"><span class="add-icon icon"></span>Add Video</button>
            <div class="clear2"></div>
            <span class="note">If the url is http://www.youtube.com/watch?v=AcYmUIACfhs then the id is AcYmUIACfhs (part after v=)</span>
            <div class="clear10"></div>
            <div class="video-list"></div>
            <div class="clear10"></div>
            <button class="save-button green-btn">Save Topic</button>
            <button class="topic-delete-button red-btn">Delete Topic</button>
            <input type="hidden" name="topic_id" class="topic_id" value="{$topic->topic_id}"  />
        </form>
        <div class="loading-progrss" style="display:none" ><div class="busy-ani saving-ani">Saving</div></div>
        <div class="clear"></div>
    </div>
    
    

{$footer}
