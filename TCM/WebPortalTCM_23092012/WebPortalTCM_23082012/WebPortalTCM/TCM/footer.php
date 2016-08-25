
<div class="cont_bot"></div>
    <!-- content ends --> 
    <div style="height:15px"></div>
    <!-- bottom begin -->
    <div id="bottom_bot">
        <div id="bottom">
			<div id="b_col1">
				<h1>Useful Resources</h1>
                <div style="height:10px"></div>
				<ul class="spis_bot">
					<li><a href="docs/Technology Change Management v5.1.doc">Technology Change Management Process (.doc)</a></li>
					<li><a href="docs/CM process Description v2.2.ppt">Technology Change Management Process (.ppt)</a></li>
					<li><a href="docs/Change-User-Guide-700.pdf">Remedy Change Management User Guide (.pdf)</a></li>
				</ul>
            </div>
			<div id="b_col2">
				<h1>Contact Information</h1>
				<div style="height:20px"></div>
				<div style="padding-left:10px">
					<div  class="box_us">
						  <div  class="box_us_l">
							<img src="images/fish_us1.png" alt="" />
						  </div>
						  <div  class="box_us_r">
								<b class="lh">Smart Village - C3 - Zone B</b>
						  </div>
						  <div style="clear: both; height:10px;"></div>
					</div>
					
					<div  class="box_us">
						  <div  class="box_us_l">
							<img src="images/fish_us3.png" alt="" />
						  </div>
						  <div  class="box_us_r">
								<b class="lh">Distribution List: TechnologyChangeManagement@voda.com</b>
						  </div>
						  <div style="clear: both; height:10px;"></div>
					</div>
					<div  class="box_us">
						  <div  class="box_us_l">
							<img src="images/fish_us3.png" alt="" />
						  </div>
						  <div  class="box_us_r">
								<b class="lh">MailBox: TechnologyChange.ManagementMailbox@vodafone.com</b>
						  </div>
						  <div style="clear: both; height:10px;"></div>
					</div>
				</div>
            </div>
    
            <div id="b_col3">
            	<h1>Share with Others</h1>
              	<div style="height:15px"></div>
                    <ul>
                        <li><img src="images/fu_i2.png" class=" fu_i" alt="" /><a href="https://www.facebook.com/Vodafone.Egypt">Be a fan on Facebook</a></li>
                        <li><img src="images/fu_i3_voda.jpg" class=" fu_i" alt="" /><a href="http://www.vodafone.com.eg/en/Home/index.htm">Vodafone Website</a></li>
                        <li><img src="images/fu_i4.png" class=" fu_i" alt="" /><a href="https://twitter.com/#!/VodafoneEgypt">Follow us on Twitter</a></li>
                    </ul>  
                        
                </div>
          	<div style="clear: both; height:20px;"></div>
        </div>
    </div>
<!-- bottom end --> 
<!-- footer begins -->
            <div id="footer">
          		Copyright  2011. <!-- Do not remove -->Designed by <a href="http://www.metamorphozis.com/free_templates/free_templates.php" title="Free Web Templates">Free Web Templates</a>, coded by <a href="http://www.myfreecsstemplates.com/" title="Free CSS Templates">Free CSS Templates</a><!-- end --><br />
                <a href="#">Privacy Policy</a> | <a href="#">Terms of Use</a> | <a href="http://validator.w3.org/check/referer" title="This page validates as XHTML 1.0 Transitional"><abbr title="eXtensible HyperText Markup Language">XHTML</abbr></a> | <a href="http://jigsaw.w3.org/css-validator/check/referer" title="This page validates as CSS"><abbr title="Cascading Style Sheets">CSS</abbr></a>
             </div>
        <!-- footer ends -->
</div>

</div>
</body>
</html>
<?php
	$myFile = "txt/login.log";
	$fh = fopen($myFile, 'a') or die("can't open file");
	$stringData = 	date('d-m-Y H:i:s')						." | ". 
					$_SERVER['REMOTE_ADDR']					." | ". 
					gethostbyaddr($_SERVER['REMOTE_ADDR']) 	." | ".
					//$_SERVER['REMOTE_USER']				." | ".
					//$_SERVER['LOGON_USER']				." | ".
					//$_SERVER['AUTH_USER']					." | ".
					$_SERVER['PHP_SELF'];
	
	fwrite($fh, $stringData. "\r\n");
	fclose($fh);

?>