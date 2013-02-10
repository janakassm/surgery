		</div>
    </div>
    <div class="rightWrapper">
    	<div class="socialMediaBlock"></div>
        <div class="subscriberBlock">
        	<div class="subscriberBlockMessage"></div>
            <div class="subscriberBlockContent">
            	<input class="inputText emailBox" type="text" value="Enter your email address"  />
                <div class="clear5"></div>
                <input class="subscribeButton inputButton"  type="button" value="Subscribe Now!!!" />
            </div>
        </div>
        <div class="clear10"></div>
	</div>
</div>
<div class="addonImage"><img src="{$base_url}images/common/stethoscope.png" width="373" height="148" /></div>
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
