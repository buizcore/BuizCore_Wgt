<?php echo ($CONTENT?$CONTENT:$this->buildMainContent($TEMPLATE))?>
<?php echo $this->includeTemplate( 'window.front' , 'index' ) ?>