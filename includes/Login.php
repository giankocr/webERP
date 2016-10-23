<?php
/* $Id: Login.php 7535 2016-05-20 13:43:16Z rchacon $*/
// Display demo user name and password within login form if $AllowDemoMode is true

//include ('LanguageSetup.php');
if ((isset($AllowDemoMode)) AND ($AllowDemoMode == True) AND (!isset($demo_text))) {
	$demo_text = _('Login as user') .': <i>' . _('admin') . '</i><br />' ._('with password') . ': <i>' . _('weberp') . '</i>' .
		'<br /><a href="../">' . _('Return') . '</a>';// This line is to add a return link.
} elseif (!isset($demo_text)) {
	$demo_text = '';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title>webERP Login screen</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" href="<?php echo $RootPath ;?>/css/WEBootstrap/login.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $RootPath ;?>/css/WEBootstrap/css/bootstrap.css" type="text/css" />
</head>
<body>
    <?php
if (get_magic_quotes_gpc()){
	echo '<p style="background:white">';
	echo _('Your webserver is configured to enable Magic Quotes. This may cause problems if you use punctuation (such as quotes) when doing data entry. You should contact your webmaster to disable Magic Quotes');
	echo '</p>';
}
    ?>
    <div id="container">
        <?php
 if ( $Theme = 'WEBootstrap')
              {

			echo '<div class= "col-xs-4 col-md-4 col-sm-offset-4 col-md-offset-4 text-center">';
			echo '<div id="login_logo"></div>';
			echo '</div>';
		echo '<div class="row">';
        echo '<div class="col-xs-12 text-center">';
        echo '<div class="wrap">';
		   echo '<h1 class="display-3 text-center" style="color:#fff;margin:10px">' . _('Sign In') . ' </h1>';
		}else{echo '<div id="login_logo"></div>';}
        ?>
        <div id="login_box">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8');?>" method="post" class="login">
                <div>
                    <input type="hidden" name="FormID" value="<?php echo $_SESSION['FormID']; ?>" />
                    <span>
                        <?php
	    if (isset($CompanyList) AND is_array($CompanyList)) {
            foreach ($CompanyList as $key => $CompanyEntry){
                if ($DefaultDatabase == $CompanyEntry['database']) {
                    $CompanyNameField = "$key";
                    $DefaultCompany = $CompanyEntry['company'];
                }
            }
	        if ($AllowCompanySelectionBox === 'Hide'){
			    // do not show input or selection box
			    echo '<input type="hidden" class="form-title" name="CompanyNameField"  value="' .  $CompanyNameField . '" />';
		    } elseif ($AllowCompanySelectionBox === 'ShowInputBox'){
			    // show input box
			    echo _('Company') .': <br />' .  '<input type="text" name="DefaultCompany"  autofocus="autofocus" required="required" value="' .  htmlspecialchars($DefaultCompany ,ENT_QUOTES,'UTF-8') . '" disabled="disabled"/>';//use disabled input for display consistency
		        echo '<input type="hidden" name="CompanyNameField"  value="' .  $CompanyNameField . '" />';
		    } else {
                // Show selection box ($AllowCompanySelectionBox == 'ShowSelectionBox')
                if ( $Theme != 'WEBootstrap')	{echo '<span>'. _('Company') .' :</span><br />';}
				echo '<select name="CompanyNameField" class="btn btn-lg col-xs-12">';
                foreach ($CompanyList as $key => $CompanyEntry){
                    if (is_dir('companies/' . $CompanyEntry['database']) ){
                        if ($CompanyEntry['database'] == $DefaultDatabase) {
                            echo '<option class="btn btn-lg col-xs-12" selected="selected" label="'.htmlspecialchars($CompanyEntry['company'],ENT_QUOTES,'UTF-8').'" value="'.$key.'">' . htmlspecialchars($CompanyEntry['company'],ENT_QUOTES,'UTF-8') . '</option>';
                        } else {
                            echo '<option class="btn btn-lg col-xs-12" label="'.htmlspecialchars($CompanyEntry['company'],ENT_QUOTES,'UTF-8').'" value="'.$key.'">' . htmlspecialchars($CompanyEntry['company'],ENT_QUOTES,'UTF-8') . '</option>';
                        }
                    }
                }
                echo '</select>';
            }
	    }
	      else { //provision for backward compat - remove when we have a reliable upgrade for config.php
            if ($AllowCompanySelectionBox === 'Hide'){
			    // do not show input or selection box
			    echo '<input type="hidden" name="CompanyNameField"  value="' . $DefaultCompany . '" />';
		    } else if ($AllowCompanySelectionBox === 'ShowInputBox'){
			    // show input box
			    echo _('Company') . '<input type="text" name="CompanyNameField"  autofocus="autofocus" required="required" value="' . $DefaultCompany . '" />';
		    } else {
      			// Show selection box ($AllowCompanySelectionBox == 'ShowSelectionBox')
    			echo _('Company') . ':<br />';
	    		echo '<select name="CompanyNameField">';
	    		$Companies = scandir('companies/', 0);
			    foreach ($Companies as $CompanyEntry){
                    if (is_dir('companies/' . $CompanyEntry) AND $CompanyEntry != '..' AND $CompanyEntry != '' AND $CompanyEntry!='.svn' AND $CompanyEntry!='.'){
                        if ($CompanyEntry==$DefaultDatabase) {
                            echo '<option selected="selected" label="'.$CompanyEntry.'" value="'.$CompanyEntry.'">' . $CompanyEntry . '</option>';
                        } else {
                            echo '<option label="'.$CompanyEntry.'" value="'.$CompanyEntry.'">' . $CompanyEntry . '</option>';
                        }
                    }
    	        }
    	         echo '</select>';
            }
        } //end provision for backward compat
                        ?>
                    </span>
                    <br />
                    <?php if ( $Theme != 'WEBootstrap')	{echo '<span>'. _('User name') .' :</span><br />';}?>
                    <input type="text" class="lead col-xs-12" style="margin-top:20px" name="UserNameEntryField" required="required" autofocus="autofocus" maxlength="20" placeholder="<?php echo _('User name'); ?>" /><br />
                    <?php if ( $Theme != 'WEBootstrap')	{echo '<span>'. _('Password') .':</span><br />';}?>
                    <input type="password" class="lead  col-xs-12 " style="margin-top:20px" required="required" name="Password" placeholder="<?php echo _('Password'); ?>" /><br />
                    <div id="demo_text">
                        <?php
	if (isset($demo_text)){
		echo $demo_text;
	}
                        ?>
                    </div>
                    <input class="button btn btn-success" type="submit" value="<?php echo _('Login'); ?>" name="SubmitUser" />
                </div>
            </form>
        </div>
        <br />
        <div style="text-align:center" class="wel"><a href="https://sourceforge.net/projects/web-erp"><img src="https://sflogo.sourceforge.net/sflogo.php?group_id=70949&amp;type=8" width="80" height="15" alt="Get webERP Accounting &amp; Business Management at SourceForge.net. Fast, secure and Free Open Source software downloads" /></a></div>
    </div>
    </div>
    </div>
    </div>
    </div>
</body>
</html>