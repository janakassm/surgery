{$headder}

<script type="text/javascript">
var base_url = "{$base_url}";
var get_url ="{$base_url}xcalls/get/"; 
//{literal}
$(document).ready(function(e) {
   
   $("input[name='category_level']").change(function(e) {        
		if( $("input[name='category_level']:checked").val() != 0)
		{
			$("#parent-category").removeAttr('disabled');
		}
		else
		{
			$("#parent-category").attr('disabled','disabled');
		}
	});
	
	$("input[name='category_level']").trigger('change');
	
	
});

//{/literal}
</script>

<style>
optgroup{
	margin-top:5px;
	margin-bottom:2px;	
}
optgroup option{
	padding-left:10px;
}

</style>

    <div>
    
        <form method="post">
            <input type="radio" name="category_level"  value="0" checked />Level 0<br />
            <input type="radio" name="category_level"  value="1" />Level 1<br />
            <input type="radio" name="category_level"  value="2" />Level 2<br />
            <input type="radio" name="category_level"  value="3" />Level 3<br />
            
            <input type="radio" name="category_level"  value="-1" />Bottom menu<br />
        
            <!--<select id="parent-category" name="category_parent_id" >
            	<option value="0">No parent</option>
                {$prvId = 0}
                {$opened = false}
            	{foreach $categoryList as $category}
                	{if $prvId != $category->category_parent_id}
                    	{$prvId = $category->category_parent_id}
                    	{$parentCategory = $category->GetPatrentDetails()}
                        {$opened = true}
                    <optgroup label="{$parentCategory->category_title_sin}">
                    {/if}
                		<option value="{$category->category_id}"><span  class="sinhala" >{$category->category_title_sin}</span></option>
                    {if $prvId != $category->category_parent_id && $opened}
                    	{$opened = false}
                    </optgroup>	
                    {/if}
                {/foreach}
            </select><br />-->
            
           	<select id="parent-category" name="category_parent_id" >
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
            
            <label>Category title in (<span class="sinhala" >සිංහල</span>) </label><input type="text" name="category_title_sin"  id="category_title_sin"/>
            <label>Category title in english </label><input type="text" name="category_title_eng" id="category_title_eng"/><br>
            
            
            
            <button type="submit" name="add_new" value="1">Add category</button>
            
        </form>
        
        
        <div>
        	<ul></ul>
        </div>
    </div>
    
    
{$footer}
