<style>
	footer{
		bottom: 0px;
	    width: 100%;
	}
	.Footer_Container{
		min-height:100px;
		width:100%;
		display: grid;
		grid-template-rows: auto auto;
	}
	.Footer_Items_box{
	    width: 100%;
	    min-height: 50px;
	    height: 100%;
	    display: grid;
	    grid-template-columns: 1fr 280px 1fr;
	    background: #224579;
	}
	.Footer_Items{
		display:grid;
		grid-template-columns: repeat(4, 1fr);
	}
	.Footer_Items_Shape{
		width: calc(60% - 1px);
	    height: calc(80% - 1px);
	    margin: 7%;
	    border-radius: 50%;
	    border: 1px solid darkgray;
	    text-align: center;
	    overflow: hidden;
	    background: white;
	    cursor:pointer;
	}
	.Footer_Item_Image{
		height:25px;
		margin-top:8px;
	}
	.Footer_Rights{
		width: 100%;
	    background: #092b5d;
	    color: white;
	}
	.Footer_Rights_string{
		text-align: center;
	    margin-top: 10px;
	    font-size: 18px;
	}
	@media(min-width:150px) and (max-width: 450px){
		.Footer_Items_box{
			grid-template-columns: 0px 100% 0px;
		}
		.Footer_Rights_string{
			font-size:16px;
			margin-top:7px;
		}
	}
</style>
<footer>
	<div class="Footer_Container">
		<div class="Footer_Items_box">
			<div></div>
			<div class="Footer_Items">
				<div class="Footer_Items_Shape">
					<img class="Footer_Item_Image" src="<?php echo RootPath; ?>Image_store/FacebookBlueIcon_48px.png"/>
				</div>
				<div class="Footer_Items_Shape">
					<img class="Footer_Item_Image" src="<?php echo RootPath; ?>Image_store/TwitterBlueIcon_48px.png"/>
				</div>
				<div class="Footer_Items_Shape">
					<img class="Footer_Item_Image" src="<?php echo RootPath; ?>Image_store/InstagramRedIcon_48px.png"/>
				</div>
				<div class="Footer_Items_Shape">
					<img class="Footer_Item_Image" src="<?php echo RootPath; ?>Image_store/LinkedinBlueIcon_48px.png"/>
				</div>
			</div>
			<div></div>
		</div>
			<div class="Footer_Rights">
				<?php date_default_timezone_set('Asia/Kolkata');?>
				<p class="Footer_Rights_string">Copyright <?php echo date("Y"); ?>. All rights reserved by Site Name</p>
			</div>
			<div></div>
		</div>
	</div>
</footer>