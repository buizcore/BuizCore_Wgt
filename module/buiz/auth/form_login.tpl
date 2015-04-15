<div class="wgt-login-mapper"  >
    <div class="wgt-login-container" >
    	<div class="wgt-login-logo">
    	   <img src="static/images/logo/login-logo.png"  alt="Logo" />
    	</div>
    	<div class="wgt_box_login_message"></div>
    	<div class="wgt-form-login" >
    		<form method="post" action="index.php?location=start" >
    			<input type="hidden" name="c" value="Buiz.Auth.login" />
    			<div class="wgt-box input" >
    				<input type="text" placeholder="Username" id="wgt-label-username" class="wgt-input" name="name" />
    			</div>
    			<div  class="wgt-box input" >
    				<input type="password" placeholder="Password" id="wgt-label-password" class="wgt-input" name="passwd" />
    			</div>
    			<div class="do-clear" > </div>
    			<div  class="wgt-box input" >
    				<input type="submit" class="wgt-button" value="<?php echo $this->i18n->l( 'Login', 'wbf.label' ); ?>" />
    			</div>
    			<div class="do-clear" > </div>
    			<?php if( $CONF->getStatus('login.forgot_pwd') ){ ?>
    				<div class="full text_center" >
    					<a href="index.php?c=Buiz.Auth.formForgotPasswd" ><?php echo $this->i18n->l( 'Forgot password?', 'wbf.label' ); ?></a>
    				</div>
    				<div class="do-clear" > </div>
    			<?php } ?>
    		</form>
    	</div>
	</div>
</div>