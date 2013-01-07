{$headder}

<script type="text/javascript">
var base_url = "{$base_url}";
var get_url ="{$base_url}xcalls/get/";
var set_url ="{$base_url}xcalls/set/"; 
var selectedAdvertisement = "{$advertisement->advertisement_id}";
//{literal}
$(document).ready(function(e) {
   
	tinyMCE.init({
		mode : "specific_textareas",
		editor_selector : "advertisement-body",
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
	});
	
	$("#add-image-button").fineUploader({
		maxConnections:1,
		request: {
			endpoint: base_url+'admin/advertisements/UploadImage',
			params:{'id':selectedAdvertisement},
			
		}
	}).on('complete', function(event, id, filename, responseJSON){
		
		
		var imgWrap = $(
			'<div id="image_'+responseJSON.filename_we+'" > '+
			'<img src = "'+base_url+responseJSON.file_url+'" id="img-'+responseJSON.filename_we+'" title="'+responseJSON.filename_we+'" />'+
			'<div class="clear10" style="float:none;"></div>'+
			'<a  class="delete-button AdminBut Delete" title="'+responseJSON.filename_we+'">Delete</a></div>'
		);
		
		imgWrap.find('.delete-button').click(function(){
			
			var fileId = $(this).attr('title');
			
			
			$.post( 
				base_url+'admin/advertisements/DeleteImage',  
				{ 'file': fileId, 'pid':selectedAdvertisement }, 
				function(response) {
					if(response.success)
					{
						$("#image_"+response.fileId).remove();
						$("#add-image-button").show();
					}
				},
				'json'
			);
			
		});
		
		imgWrap.appendTo("#image-list");
		
		$("#add-image-button").hide();
	});
	
	$("#advertisement_start_date").datepicker({
		changeMonth: true,
		changeYear: true,
		minDate: "-1Y", 
		maxDate: "+11M",
		dateFormat: 'dd/mm/yy'
	});
	
	$("#advertisement_expire_date").datepicker({
		changeMonth: true,
		changeYear: true,
		minDate: 0, 
		maxDate: "+23M",
		dateFormat: 'dd/mm/yy'
	});
	
});

//{/literal}
</script>
	<div>
    	{$msg}
    </div>
    <div >
        <form method="post">
            Advertisement title<input type="text" name="advertisement_title" value="{$advertisement->advertisement_title}" /><br />
            Advertisement brief<br />
			<textarea name="advertisement_brief">{$advertisement->advertisement_brief}</textarea><br />
            Advertisement body<br />
			<textarea class="advertisement-body" id="advertisement_body" name="advertisement_body">{$advertisement->advertisement_body|unescape:'html'}</textarea><br />
            
			<div id="start-date-field" >Start date <input type="text" readonly="readonly" name="advertisement_start_date"  id="advertisement_start_date" /></div>
           	
            Is Expiring? <input type="checkbox" name="advertisement_is_expiring"  value="1"  /><br />
			<div id="expire-date-field" >Expire date <input type="text" readonly="readonly" name="advertisement_expire_date"  id="advertisement_expire_date" /></div>
           	
            
            <div id="add-image-button">Add Image</div>
            
            <div id="image-list">
            </div>
            
            
            <button type="submit" name="save" value="1">Save advertisement</button><br />
        </form>
    </div>

{$footer}
