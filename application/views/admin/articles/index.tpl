{$headder}

<script type="text/javascript">
//{literal}
$(document).ready(function(e) {
	
});
//{/literal}
</script>

<a href="{$base_url}admin/articles/add">Add Article</a>
<div class="clear"></div>
{foreach $articleList as $article}
<div>
	<span>{$article->article_title}</span>-<span>{$article->GetArticleCategoryTitle()}</span>
	<div class="buttonSection">
		<a href="{$base_url}admin/articles/edit?id={$article->article_id}">Edit</a>
		<a href="{$base_url}admin/articles/delete?id={$article->article_id}">Delete</a>
	</div>
</div>
<div class="clear"></div>
{/foreach}

{$footer}