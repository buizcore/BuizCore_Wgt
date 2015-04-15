<div class="do-clear medium" ></div>


<form method="post"
      accept-charset="utf-8"
      action="index.php?c=Buiz.Login.login" >
      
   

  <div class="wgt_box login"  >

    <h2>Login</h2>
    <div >

      <div id="wgt_box_input_buiz_login">
        <label for="wgt-input_buiz_login" class="wgt-label">Login </label>
        <div class="wgt-input"><?php echo $ITEM->inputLoginname?></div>
      </div>

      <div id="wgt_box_input_buiz_password">
        <label for="wgt-input_buiz_password" class="wgt-label">Passwort </label>
        <div class="wgt-input"><?php echo $ITEM->inputPasswd?></div>
      </div>

      <div class="do-clear medium" ></div>

      <div><?php echo $ITEM->inputSubmit?></div>


      <div class="do-clear small" ></div>
    </div>
 </div>

</form>



