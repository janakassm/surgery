{$headder}

<script type="text/javascript">
var base_url = "{$base_url}";
var get_url ="{$base_url}xcalls/get/"; 
var selected_pid = "{$category->category_parent_id}";
var selected_level = "{$category->category_level}";
//{literal}
$(document).ready(function(e) {
   
   $("input[name='category_level']").change(function(e) {  
   		var level = $("input[name='category_level']:checked").val();
		GetCategories(level);
	});
	
	if(selected_level=="" || selected_level== 0)
		$("#category-level-0").trigger('change');
	else
		$("#category-level-"+selected_level).trigger('click');
	
	$("#messagebox").dialog({
      resizable: false,
	  autoOpen: false,
	  modal:true,
	  height:215,
	  width:500,
      buttons: {
        "Yes & Delete": function() {
			var delAction = $('<input type="hidden" name="delete" value="1" />');
          	delAction.appendTo("#submitForm");
			$("#submitForm").submit();
			
        },
        "No": function() {
          $( this ).dialog( "close" );
        }
      }
    });
	
	$("#delete-category").click(function(e){
		$("#messagebox").dialog("open");
	});
	
});

function GetCategories(level)
{
	$.post(
		get_url+'getCategoriesAsOptions',
		{'level':level,'selected_id':selected_pid},
		function(respond)
		{
			if(respond.success)
			{
				var optionList = '<option value="0">No parent</option>'+respond.html;
				
				$("#parent-category").html(optionList);
			}
		},
		'json'
	);
}



//{/literal}
</script>
{literal}
<style>
optgroup{
	margin-top:5px;
	margin-bottom:2px;	
}
optgroup option{
	padding-left:10px;
}


</style>
{/literal}
	<div>
    	{$msg}
    </div>
    <div class="clear20"></div>
    <div>
    
        <form method="post" id="submitForm">
            <input id="category-level-0" type="radio" name="category_level"  value="0" checked />Main Menu
            <div class="clear2"></div>
            <input id="category-level-1" type="radio" name="category_level"  value="1" />Side Menu
            <div class="clear2"></div>
            <input id="category-level-2" type="radio" name="category_level"  value="2" />Bottom menu
            <div class="clear10"></div>
        
           
            <label style="width:200px">Parent Category</label>
           	<select id="parent-category" name="category_parent_id" style="width:400px;" class="inputText">
            	
            	
            </select>
            <div class="clear10"></div>
            
            <label style="width:200px">Category title in සිංහල </label><input type="text" name="category_title_sin"  id="category_title_sin" class="inputText" style="width:400px;" value="{$category->category_title_sin}"/>
            <div class="clear5"></div>
            <label style="width:200px">Category title in english </label><input type="text" name="category_title_eng" id="category_title_eng" class="inputText" style="width:400px;" value="{$category->category_title_eng}"/>
            <div class="clear5"></div>
            <a class="grey-btn btn" href="{$base_url}admin/categories">Back</a>
            <button type="submit" name="save" value="1" class="green-btn" style="float:right">Save Category</button>
            <button type="button" id="delete-category" class="red-btn" style="float:right">Delete</button>
            <div class="clear10"></div>
            
        </form>
        
        
        <div>
        	<ul></ul>
        </div>
    </div>
    
<div title="Are you sure?" id="messagebox" >
	<span class="warning message" style="padding-left:72px; vertical-align:middle">By deleting this category you will automatically delete sub categories under this category also. Are you sure you want to continue?</span>
</div>    
{$footer}
