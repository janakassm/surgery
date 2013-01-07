</div>
</body>

<!--load custom css links -->
{foreach $csslinks as $csslink}
<link href="{$base_url}css/{$csslink}" rel="stylesheet" type="text/css" />
{/foreach}
<!--end of loading custom css links -->

<!--load custom js links -->
{foreach $jslinks as $jslink}
<script src="{$base_url}js/{$jslink}" type="text/javascript"></script>
{/foreach}
<!--end of loading custom js links -->

</html>
