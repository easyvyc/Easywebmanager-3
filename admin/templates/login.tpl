<html>
<head>
<title>easywebmanager {easyweb_version}</title>
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
		  
		  <block name="get.remind" no>
		  <tr height="25" valign="top">
			<td class="error" align="center"><block name="bad_login">{phrases.wrong_login}&nbsp;</block name="bad_login"></td>
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
								<img src="images/lock.gif" border="0"  style="float:left;margin-right:3px;"> {phrases.login}&nbsp;
							</td>
							<td align="right" class="lang">	
								<a href="login.php?lang=lt">LT</a>
								<a href="login.php?lang=en">EN</a>
							</td>
						</tr>
					</table>
					</td>
				  </tr>
				  
				  

				<block name="sites">
				  <tr height="25">
					<td>
						<select name="site" class="fo_select" style="width:100%;" onchange="javascript: location='{config.admin_site_url}login.php?site='+this.options[this.selectedIndex].value;">
						<loop name="sites">
						<option value="{sites._INDEX}" <block name="sites.selected">selected</block name="sites.selected">>{sites.title}</option>
						</loop name="sites">
						</select>
					</td>
				  </tr>
				</block name="sites">
				  
				  <tr height="25">
					<td>
						<input type="hidden" id="login_" value="0" />
						<input type="text" <block name="post.login" no>value="{phrases.login_name}" onfocus="javascript: inputFocus(this); " onblur="javascript: inputBlur(this, '{phrases.login_name}'); "</block name="post.login" no> <block name="post.login">value="{post.login}"</block name="post.login"> name="login"  class="fo_text" style="width:100%;">
					</td>
				  </tr>
				  <tr height="25">
					<td>
						<input type="hidden" id="pass_" value="0" />
						<input type="password" value="{phrases.password}" onfocus="javascript: inputFocus(this); " onblur="javascript: inputBlur(this, '{phrases.password}'); " name="pass"  class="fo_text" style="width:116px;height:20px;">
						<input type="submit" name="submit" value="{phrases.submit} »" class="fo_submit" style="width:70px;">
					</td>
				  </tr>
			  			<input type="hidden" name="action" value="login">
			  </form>
			  </table>
			  
			 </td>
			</tr>
			<tr>
				<td valign="top" align="left" style="padding-left:155px;">
					<a href="login.php?remind=1">{phrases.password_remind}</a>
				</td>
			</tr>
			
			
		</table>


    	</td>
    </tr>
			</block name="get.remind" no>
			
			
			<block name="get.remind">
			
			<block name="done">
			<block name="get.code">
			
			<block name="good">
		  <tr height="25" valign="top">
			<td class="" align="center">{phrases.login_data_sent}&nbsp;</td>
		  </tr>
		  </block name="good">
		  
		  <block name="good" no>
		  <tr height="25" valign="top">
			<td class="error" align="center">{phrases.wrong_confirm_code}&nbsp;</td>
		  </tr>
		  </block name="good" no>
		  
		  </block name="get.code">
		  
		  <block name="get.code" no>
		  <tr height="25" valign="top">
			<td class="" align="center">{phrases.confirm_code_sent}&nbsp;</td>
		  </tr>
		  </block name="get.code" no>
			</block name="done">
			
			
			<block name="done" no>
		  <tr height="25" valign="top">
			<td class="error" align="center"><block name="bad_login">{phrases.wrong_remind}&nbsp;</block name="bad_login"></td>
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
								<img src="images/lock.gif" border="0"  style="float:left;margin-right:3px;"> {phrases.password_remind}&nbsp;
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

				<block name="sites">
				  <tr height="25">
					<td>
						<select name="site" class="fo_select" style="width:100%;" onchange="javascript: location='{config.admin_site_url}login.php?remind=1&site='+this.options[this.selectedIndex].value;">
						<loop name="sites">
						<option value="{sites._INDEX}" <block name="sites.selected">selected</block name="sites.selected">>{sites.title}</option>
						</loop name="sites">
						</select>
					</td>
				  </tr>
				</block name="sites">
				  
				  <tr height="25">
					<td>
						<input type="hidden" id="email_" value="0" />
						<input type="email" value="{phrases.email}" onfocus="javascript: inputFocus(this); " onblur="javascript: inputBlur(this, '{phrases.email}'); " name="email"  class="fo_text" style="width:116px;height:20px;">
						<input type="submit" name="submit" value="{phrases.remind_submit} »" class="fo_submit" style="width:70px;">
					</td>
				  </tr>
			  			
			  </form>
			  </table>
			  
			 </td>
			</tr>
			</block name="done" no>
			
			<tr>
				<td valign="top" align="left" style="padding-left:155px;"><a href="login.php">{phrases.login}</a></td>
			</tr>	
			
			
			</table>


    	</td>
    </tr>
    
    		
					
			</block name="get.remind">
			
			
</table>
    
</body>
</html>
