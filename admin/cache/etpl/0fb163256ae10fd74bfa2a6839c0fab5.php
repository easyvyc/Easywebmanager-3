<html>
<head>
<title>easywebmanager <?php echo $templateVariables->vars["easyweb_version"]; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<link rel="stylesheet" type="text/css" href="css/common.css" />
<link rel="stylesheet" type="text/css" href="css/forms.css" />
<link rel="stylesheet" type="text/css" href="css/login.css" />

<script language="javascript" src="js/admin.js"></script>

</head>

<script language="javascript">

if(self!=top){
	top.location.href = self.location.href;
}

</script>

<body>
<table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="0">
	<tr height="100">
		<td class="white"><img src="images/0.gif"></td>
	</tr>
	<tr>
		<td valign="top" style="padding-top:40px;" align="center">

		<table class="form" border="0" cellpadding="0" cellspacing="0">
		  <tr height="70">
		  	<td valign="bottom" align="center" style="padding-bottom:3px;">
		  		<a href="http://www.easywebmanager.com" target="_blank"><img src="images/logo1.jpg" border="0"></a>
		  	</td>
		  </tr>
		  
		  <?php if(!$templateVariables->vars["get.remind"]){ ?>
		  <tr height="25" valign="top">
			<td class="error" align="center"><?php if($templateVariables->vars["bad_login"]){ ?><?php echo $templateVariables->vars["phrases.wrong_login"]; ?>&nbsp;<?php } ?></td>
		  </tr>

		  <tr height="85">
		  	<td valign="top" align="center">
		  
		  
			  <table width="190" border="0" cellpadding="0" cellspacing="0">
			  <form method="post" action="login.php">
			  		

				  <tr height="25">
					<td align="left">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td align="left" class="title">
								<img src="images/lock.gif" border="0"  style="float:left;margin-right:3px;"> <?php echo $templateVariables->vars["phrases.login"]; ?>&nbsp;
							</td>
							<td align="right" class="lang">	
								<a href="login.php?lang=lt">LT</a>
								<a href="login.php?lang=en">EN</a>
							</td>
						</tr>
					</table>
					</td>
				  </tr>
				  
				  

				<?php if($templateVariables->vars["sites"]){ ?>
				  <tr height="25">
					<td>
						<select name="site" class="fo_select" style="width:100%;" onchange="javascript: location='<?php echo $templateVariables->vars["config.admin_site_url"]; ?>login.php?site='+this.options[this.selectedIndex].value;">
						<?php foreach($templateVariables->loops["sites"] as $sites_key => $sites_val){ ?>
						<option value="<?php echo $sites_val["_INDEX"]; ?>" <?php if($sites_val["selected"]){ ?>selected<?php } ?>><?php echo $sites_val["title"]; ?></option>
						<?php } ?>
						</select>
					</td>
				  </tr>
				<?php } ?>
				  
				  <tr height="25">
					<td>
						<input type="hidden" id="login_" value="0" />
						<input type="text" <?php if(!$templateVariables->vars["post.login"]){ ?>value="<?php echo $templateVariables->vars["phrases.login_name"]; ?>" onfocus="javascript: inputFocus(this); " onblur="javascript: inputBlur(this, '<?php echo $templateVariables->vars["phrases.login_name"]; ?>'); "<?php } ?> <?php if($templateVariables->vars["post.login"]){ ?>value="<?php echo $templateVariables->vars["post.login"]; ?>"<?php } ?> name="login"  class="fo_text" style="width:100%;">
					</td>
				  </tr>
				  <tr height="25">
					<td>
						<input type="hidden" id="pass_" value="0" />
						<input type="password" value="<?php echo $templateVariables->vars["phrases.password"]; ?>" onfocus="javascript: inputFocus(this); " onblur="javascript: inputBlur(this, '<?php echo $templateVariables->vars["phrases.password"]; ?>'); " name="pass"  class="fo_text" style="width:116px;height:20px;">
						<input type="submit" name="submit" value="<?php echo $templateVariables->vars["phrases.submit"]; ?> »" class="fo_submit" style="width:70px;">
					</td>
				  </tr>
			  			<input type="hidden" name="action" value="login">
			  </form>
			  </table>
			  
			 </td>
			</tr>
			<tr>
				<td valign="top" align="left" style="padding-left:155px;">
					<a href="login.php?remind=1"><?php echo $templateVariables->vars["phrases.password_remind"]; ?></a>
				</td>
			</tr>
			
			
		</table>


    	</td>
    </tr>
			<?php } ?>
			
			
			<?php if($templateVariables->vars["get.remind"]){ ?>
			
			<?php if($templateVariables->vars["done"]){ ?>
			<?php if($templateVariables->vars["get.code"]){ ?>
			
			<?php if($templateVariables->vars["good"]){ ?>
		  <tr height="25" valign="top">
			<td class="" align="center"><?php echo $templateVariables->vars["phrases.login_data_sent"]; ?>&nbsp;</td>
		  </tr>
		  <?php } ?>
		  
		  <?php if(!$templateVariables->vars["good"]){ ?>
		  <tr height="25" valign="top">
			<td class="error" align="center"><?php echo $templateVariables->vars["phrases.wrong_confirm_code"]; ?>&nbsp;</td>
		  </tr>
		  <?php } ?>
		  
		  <?php } ?>
		  
		  <?php if(!$templateVariables->vars["get.code"]){ ?>
		  <tr height="25" valign="top">
			<td class="" align="center"><?php echo $templateVariables->vars["phrases.confirm_code_sent"]; ?>&nbsp;</td>
		  </tr>
		  <?php } ?>
			<?php } ?>
			
			
			<?php if(!$templateVariables->vars["done"]){ ?>
		  <tr height="25" valign="top">
			<td class="error" align="center"><?php if($templateVariables->vars["bad_login"]){ ?><?php echo $templateVariables->vars["phrases.wrong_remind"]; ?>&nbsp;<?php } ?></td>
		  </tr>

		  <tr height="85">
		  	<td valign="top" align="center">
		  
		  
			  <table width="190" border="0" cellpadding="0" cellspacing="0">
			  <form method="post" action="login.php?remind=1">
			  		

				  <tr height="25">
					<td align="left">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td align="left" class="title">
								<img src="images/lock.gif" border="0"  style="float:left;margin-right:3px;"> <?php echo $templateVariables->vars["phrases.password_remind"]; ?>&nbsp;
							</td>
							<td align="right" class="lang">	
								<a href="login.php?remind=1&lang=lt">LT</a>
								<a href="login.php?remind=1&lang=en">EN</a>
							</td>
						</tr>
					</table>
					</td>
				  </tr>
				  
				  <input type="hidden" name="action" value="remind">

				<?php if($templateVariables->vars["sites"]){ ?>
				  <tr height="25">
					<td>
						<select name="site" class="fo_select" style="width:100%;" onchange="javascript: location='<?php echo $templateVariables->vars["config.admin_site_url"]; ?>login.php?remind=1&site='+this.options[this.selectedIndex].value;">
						<?php foreach($templateVariables->loops["sites"] as $sites_key => $sites_val){ ?>
						<option value="<?php echo $sites_val["_INDEX"]; ?>" <?php if($sites_val["selected"]){ ?>selected<?php } ?>><?php echo $sites_val["title"]; ?></option>
						<?php } ?>
						</select>
					</td>
				  </tr>
				<?php } ?>
				  
				  <tr height="25">
					<td>
						<input type="hidden" id="email_" value="0" />
						<input type="email" value="<?php echo $templateVariables->vars["phrases.email"]; ?>" onfocus="javascript: inputFocus(this); " onblur="javascript: inputBlur(this, '<?php echo $templateVariables->vars["phrases.email"]; ?>'); " name="email"  class="fo_text" style="width:116px;height:20px;">
						<input type="submit" name="submit" value="<?php echo $templateVariables->vars["phrases.remind_submit"]; ?> »" class="fo_submit" style="width:70px;">
					</td>
				  </tr>
			  			
			  </form>
			  </table>
			  
			 </td>
			</tr>
			<?php } ?>
			
			<tr>
				<td valign="top" align="left" style="padding-left:155px;"><a href="login.php"><?php echo $templateVariables->vars["phrases.login"]; ?></a></td>
			</tr>	
			
			
			</table>


    	</td>
    </tr>
    
    		
					
			<?php } ?>
			
			
</table>
    
</body>
</html>
