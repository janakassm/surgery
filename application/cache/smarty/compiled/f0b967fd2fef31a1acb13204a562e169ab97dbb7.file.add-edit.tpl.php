<?php /* Smarty version Smarty-3.1.7, created on 
         compiled from "application\views\admin\articles\add-edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6215477a606b89a8e3-37478182%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f0b967fd2fef31a1acb13204a562e169ab97dbb7' => 
    array (
      0 => 'application\\views\\admin\\articles\\add-edit.tpl',
      1 => 1360432088,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6215477a606b89a8e3-37478182',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_477a606b9472a',
  'variables' => 
  array (
    'headder' => 0,
    'base_url' => 0,
    'article' => 0,
    'msg' => 0,
    'categoryList' => 0,
    'category' => 0,
    'lvl1childCategories' => 0,
    'lvl2childCategories' => 0,
    'lvl3childCategories' => 0,
    'topicList' => 0,
    'topic' => 0,
    'img' => 0,
    'advertisementList' => 0,
    'advertisement' => 0,
    'footer' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_477a606b9472a')) {function content_477a606b9472a($_smarty_tpl) {?><?php echo $_smarty_tpl->tpl_vars['headder']->value;?>


<script type="text/javascript">
var base_url = "<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
";
var get_url ="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
xcalls/get/";
var set_url ="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
xcalls/set/"; 
var selectedArticle = "<?php echo $_smarty_tpl->tpl_vars['article']->value->article_id;?>
";
var convertText =  false;
//
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
							
							newTopic.find(".topic-delete-button").click(function(e) {
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
							
							newTopic.find("input[type=text]").bind("keyup select change",function(e){
								$(this).val(TextFormat($(this).val()));
							});
							
							newTopic.find("textarea").bind("keyup select change",function(e){
								$(this).val(TextFormat($(this).val()));
							});
							
							newTopic.find("textarea").autosize();
							
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
							
			newTopic.find(".topic-delete-button").click(function(e) {
				e.preventDefault();
				TopicDeleteAction($(this));								
			});
			
			newTopic.find('.image-list').find(".delete-button").click(function(e) {
				e.preventDefault();
				ImageDeleteAction($(this));								
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
				alert('deletion failed');
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
			
			videoListElement.html('');
			var video = $('<div id="video_'+response.id+'" > '+
							'<embed width="420" height="345" src="'+response.url+'" type="application/x-shockwave-flash"></embed>'+
							'<div class="clear10" style="float:none;"></div>'+
							'<a  class="delete-button AdminBut Delete" title="'+response.id+'">Delete</a></div>');
							
			video.find('.delete-button').click(function(e){
					e.preventDefault();
					VideoDeleteAction($(this));									
				});				
			
			videoListElement.append(video);
		}
		else
			console.log('adding failed');
	},
	'json');
}


function TextFormat(text)
{
	if(convertText)
		return convertFromAbaya(text); //decleared in unicode-convert.js
	else
		return text;
}

//
</script>
	<div>
    	<?php echo $_smarty_tpl->tpl_vars['msg']->value;?>

    </div>
    <div >
    	<div><input type="checkbox" id="usingAbhaya" value="1" /> I'm using Abhaya font</div>
        <form method="post">
        	
            <select id="parent-category" name="article_category" >
            	<option value="0">No Category</option>
            	<?php  $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['category']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['categoryList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['category']->key => $_smarty_tpl->tpl_vars['category']->value){
$_smarty_tpl->tpl_vars['category']->_loop = true;
?>
                	<?php $_smarty_tpl->tpl_vars['lvl1childCategories'] = new Smarty_variable($_smarty_tpl->tpl_vars['category']->value->GetChildCategories(), null, 0);?>
                	<option value="<?php echo $_smarty_tpl->tpl_vars['category']->value->category_id;?>
" class="menu-level-1"><span  class="sinhala " ><?php echo $_smarty_tpl->tpl_vars['category']->value->category_title_sin;?>
</span></option>
                    <?php if ($_smarty_tpl->tpl_vars['lvl1childCategories']->value){?>
                    	
                    	<?php  $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['category']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['lvl1childCategories']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['category']->key => $_smarty_tpl->tpl_vars['category']->value){
$_smarty_tpl->tpl_vars['category']->_loop = true;
?>
                        	<?php $_smarty_tpl->tpl_vars['lvl2childCategories'] = new Smarty_variable($_smarty_tpl->tpl_vars['category']->value->GetChildCategories(), null, 0);?>
                			<option value="<?php echo $_smarty_tpl->tpl_vars['category']->value->category_id;?>
" class="menu-level-2"><span  class="sinhala" ><?php echo $_smarty_tpl->tpl_vars['category']->value->category_title_sin;?>
</span></option>
                            
                            <?php if ($_smarty_tpl->tpl_vars['lvl2childCategories']->value){?>
                                <?php  $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['category']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['lvl2childCategories']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['category']->key => $_smarty_tpl->tpl_vars['category']->value){
$_smarty_tpl->tpl_vars['category']->_loop = true;
?>
                                	<?php $_smarty_tpl->tpl_vars['lvl3childCategories'] = new Smarty_variable($_smarty_tpl->tpl_vars['category']->value->GetChildCategories(), null, 0);?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['category']->value->category_id;?>
" class="menu-level-3"><span  class="sinhala" ><?php echo $_smarty_tpl->tpl_vars['category']->value->category_title_sin;?>
</span></option>
                                    
                                    <?php if ($_smarty_tpl->tpl_vars['lvl3childCategories']->value){?>
                                    	<?php  $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['category']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['lvl3childCategories']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['category']->key => $_smarty_tpl->tpl_vars['category']->value){
$_smarty_tpl->tpl_vars['category']->_loop = true;
?>
                                    		<option value="<?php echo $_smarty_tpl->tpl_vars['category']->value->category_id;?>
" class="menu-level-4"><span  class="sinhala" ><?php echo $_smarty_tpl->tpl_vars['category']->value->category_title_sin;?>
</span></option>
                                        <?php } ?>
                                    <?php }?>
                                    
                            	<?php } ?>
                            <?php }?>
                            
                        <?php } ?>
                        
                    <?php }?>
                <?php } ?>
            </select><br />
            
            Article title<input type="text" name="article_title" value="<?php echo $_smarty_tpl->tpl_vars['article']->value->article_title;?>
" class="inputText" /><br />
            
            <button type="submit" name="save" value="1">Save article</button><br />
        </form>
        <button type="button" id="add-topic">+</button><br />
        
        <div id="topic-container">
        	<?php  $_smarty_tpl->tpl_vars['topic'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['topic']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['topicList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['topic']->key => $_smarty_tpl->tpl_vars['topic']->value){
$_smarty_tpl->tpl_vars['topic']->_loop = true;
?>
        		<?php echo $_smarty_tpl->tpl_vars['topic']->value->Refresh();?>

        	<div id="new-topic-<?php echo $_smarty_tpl->tpl_vars['topic']->value->topic_id;?>
" class="article_topic" >
		    	<form class="topic-form">
		            <input type="text" name="topic_heading" value="<?php echo $_smarty_tpl->tpl_vars['topic']->value->topic_heading;?>
" class="inputText" /><br />
		            <textarea class="topic_body inputText" name="topic_content" ><?php echo $_smarty_tpl->tpl_vars['topic']->value->topic_content;?>
</textarea><br />
		            <div class="image-list">
		            	<?php  $_smarty_tpl->tpl_vars['img'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['img']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['topic']->value->GetImageList(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['img']->key => $_smarty_tpl->tpl_vars['img']->value){
$_smarty_tpl->tpl_vars['img']->_loop = true;
?>
		            	<div id="image_<?php echo $_smarty_tpl->tpl_vars['img']->value['fileIndex'];?>
" >
						<img src = "<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
<?php echo $_smarty_tpl->tpl_vars['img']->value['fileUrl'];?>
" id="img-<?php echo $_smarty_tpl->tpl_vars['img']->value['fileIndex'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['img']->value['fileIndex'];?>
" />
						<div class="clear10" style="float:none;"></div>
						<a  class="delete-button AdminBut Delete" title="<?php echo $_smarty_tpl->tpl_vars['img']->value['fileIndex'];?>
">Delete</a></div>
		            	<?php } ?>
		            </div>
		            
		            <div class="add-image-button">Add Image</div>
		            
		            
		            
		            <input class="video_link" />
		            <button class="add-video-button">Add Video</button>
		            
		            <div class="video-list"></div>
		            
		            <br />
		            <button class="save-button">Save</button>
		            <button class="topic-delete-button">Delete</button>
		            <input type="hidden" name="topic_id" class="topic_id" value="<?php echo $_smarty_tpl->tpl_vars['topic']->value->topic_id;?>
"  />
		        </form>
		        <div class="loading-progrss" style="display:none" >Saving....</div>
		    </div>
        	<?php } ?>
        </div>
    
    	<div>
        	<select>
            	<option value="0">No Advertisement</option>
                <?php  $_smarty_tpl->tpl_vars['advertisement'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['advertisement']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['advertisementList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['advertisement']->key => $_smarty_tpl->tpl_vars['advertisement']->value){
$_smarty_tpl->tpl_vars['advertisement']->_loop = true;
?>
                    <option value="<?php echo $_smarty_tpl->tpl_vars['advertisement']->value->advertisement_id;?>
"><?php echo $_smarty_tpl->tpl_vars['advertisement']->value->advertisement_title;?>
</option>
                <?php } ?>
            </select>
        </div>
    	<button type="button" id="add-advertisement">+</button><br />
        
        <div id="adverticement-container">
        	
        </div>
    </div>
   
    
    <div id="new-topic-tpl" style="display:none">
    	<form class="topic-form">
            <input type="text" name="topic_heading" class="inputText" /><br />
            <textarea class="article_body inputText" name="topic_content"  ></textarea><br />
            <div class="image-list"></div>
            
            <div class="add-image-button">Add Image</div>
            <input class="video_link" />
            <button class="add-video-button">Add Video</button>
            <div class="video-list"></div>
            <br />
            <button class="save-button">Save</button>
            <button class="topic-delete-button">Delete</button>
            <input type="hidden" name="topic_id" class="topic_id"  />
        </form>
        <div class="loading-progrss" style="display:none" >Saving....</div>
    </div>
    
    

<?php echo $_smarty_tpl->tpl_vars['footer']->value;?>

<?php }} ?>