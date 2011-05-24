<?php disallow_direct_load('footer.php');?>
		</div>
		<div class='clear'><!-- --></div>
	</div>
	<?php thematic_abovefooter();?>
	<div id="footer">
		<div class="wrap"> 
			<div class="span-6"> 
				<h2><a href="http://admissions.ucf.edu/contact/">Contact Us</a></h2> 
				<dl> 
					<dt>Mailing Address:</dt> 
					<dd> 
						Undergraduate Admissions<br> 
						P.O. Box 160111<br> 
						Orlando, FL 32816-0111
					</dd> 
					<dt>Contact:</dt> 
					<dd> 
						E-mail: <a href="mailto:admission@mail.ucf.edu">admission@mail.ucf.edu</a><br> 
						Phone: <a href="tel:4078233000">(407) 823-3000</a><br> 
						Fax: <a href="tel:4078235625">(407) 823-5625</a> 
					</dd> 
					<dt>Office Hours:</dt> 
					<dd> 
						Mon &amp; Thurs: 9AM - 6PM<br> 
						Tues, Wed, &amp; Fri: 9AM - 5PM<br> 
						Closed Weekends &amp; Holidays
					</dd> 
				</dl> 
			</div> 
			
			<div class="span-6"> 
				<h2>Application Deadlines</h2> 
				<dl> 
					<dt>Freshmen Applicants:</dt> 
					<dd> 
						Fall: May 1st<br /> 
						Spring: November 1st<br /> 
						Summer: March 1st
					</dd> 
					<dt>Transfer Applicants:</dt> 
					<dd> 
						Fall: July 1st<br /> 
						Spring: November 1st<br /> 
						Summer: March 1st
					</dd> 
					<dt>International Applicants:</dt> 
					<dd> 
						Fall: March 1st<br /> 
						Spring: September 1st<br /> 
						Summer: January 1st
					</dd> 
				</dl> 
			</div> 
			
			<div class="span-4">
				<?php
					$links   = array(
						# Link Title              URL
						'Academics'            => '/', #get_url('Academics'),
						'Visit'                => '/', #get_url('Visit UCF'),
						'Cost &amp; Aid'       => '/', #get_url('Cost and Aid'),
						'Why UCF?'             => '/', #get_url('Why UCF?'),
						'Media'                => '/', #get_url('Media'),
						'Contact'              => '/', #get_url('Contact Us'),
						'For Counselors'       => '/', #get_url('For Counselors'),
						'For Parents'          => '/', #get_url('For Parents'),
						'Apply Now'            => 'https://admissions.ucf.edu/application/',
						'Prospective Students' => '/', #get_url('Prospective Students'),
						'Forms'                => '/', #get_url('Admission Forms'),
						'Check Status'         => 'http://my.ucf.edu',
						'Admitted Students'    => '/', #get_url('Admitted Students'),
						'FAQs'                 => '/', #get_url('Frequently Asked Questions'),
					);
					$hrs = array('Contact', 'For Parents');
				?>
				<h2>Site Map</h2>
				<ul> 
					<?php foreach($links as $title=>$url):?>
					<li<?php if(in_array($title, $hrs)):?> class="hr"<?endif;?>><a href="<?=$url?>"><?=$title?></a></li>
					<?php endforeach;?>
				</ul> 
			</div>	  
			<div class="span-8 last"></div>		   
		</div> 
		<div class="clear"></div> 
	</div><!-- /footer --> 
	<?php thematic_belowfooter();?>
	<?php thematic_after();?>
</body>
</html>