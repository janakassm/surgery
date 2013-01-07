<div class="catog_set left"> {if empty($userData)}
  <div class="regisbttn left"> <a href="{$base_url}member/register">Register Now!</a> </div>
  {/if}
  <div class="clear box CategoryBox">
    <ul id="catelog-set">
      {foreach $cats as $lvl0}
      	<li>
        	<span><a href="{$base_url}products/show/cat/{$lvl0->id}">{$lvl0->title}&nbsp;({$lvl0->product_count})</a></span>
            {if $lvl0->lvl1|count > 0}
            <ul>
            {foreach $lvl0->lvl1 as $lvl1}
            
                <li> <span><a href="{$base_url}products/show/cat/{$lvl1->id}">{$lvl1->title}&nbsp;({$lvl1->product_count})</a></span>    
                	{if $lvl1->lvl2|count > 0}            
                        <ul>
                        {foreach $lvl1->lvl2 as $lvl2}
                            <li> <span><a href="{$base_url}products/show/cat/{$lvl2->id}">{$lvl2->title}&nbsp;({$lvl2->product_count})</a></span></li>
                        {/foreach}
                        </ul>
                    {/if}
            	</li>
            {/foreach}
            </ul>
            {/if}
        </li>
      {/foreach}
    </ul>
  </div>
</div>
<script>
$(document).ready(function() {
    $("#catelog-set").treeview({
		animated: "fast",
		collapsed: true,
		unique: true,
		persist: "cookie"		
	});
});

</script>
