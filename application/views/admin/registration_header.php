<style type="text/css">
	.social_icon div{
		display: inline;
	}
	.divPadding{padding-right: 0px; padding-left: 0px;}
	/*.set_icons a img{height: 50px;}*/
	.social_icon div a i{
		color: #fff;
		
	}
	.bdr{border: 1px solid red;}
	.social_icon{padding: 10px 0;}
	.social_icon a{
	    font-size: 20px;
	    background: #fff !important;
	    padding: 2px 12px;
	    border-radius: 10px;
	}
	.img1{height: 48px;}
	.img2{height: 44px;}
	.img3{height: 44px;}
	.social_icon a{border-radius: 50% !important; padding: 4px 0px !important; margin-left: 5px;}
	.logoimg{height: 80px; float: left;}
	/* media query for respoinsive */
	@media (min-width: 200px) and (max-width: 767px) {
		
		.set_outer_footer{position: absolute;}
		.set_outer_footer .col-xs-12.col-sm-4, .sets_icons{text-align: center;}
	} 
	@media (min-width: 768px) {
		.sets_icons{
			text-align: right;
		}
		.set_outer_footer{position: fixed; bottom: 0}
	}
	body{
		font-family: Graphik LCG Web, Graphik Arabic Web Regular, -apple-system, BlinkMacSystemFont, Helvetica Neue, Helvetica, Arial, Lucida Grande, Sans-Serif;
	}
</style>

<?php 
	$fun_name = $this->uri->segment(2);
?>
<div class="col-xs-12 col-sm-12 divPadding sets_icons">
	<div class="col-xs-12 col-sm-12 divPadding social_icon">
		<?php 
			if ($fun_name == 'AddFacility' || $fun_name == 'AddStaff') {
		?>
		<div class="set_logo_top">
			<img src="<?php echo base_url(); ?>assets/uplogo.png" class="logoimg">
			<img src="<?php echo base_url(); ?>assets/helth.png" class="logoimg" style="margin-left: 5px;">
		</div>
		<?php } ?>
		<div class="set_icons" style="float: right;">
			<img src="<?php echo base_url(); ?>assets/logo.png" class="logoimg">
		</div>
	</div>
</div>