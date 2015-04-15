
<fieldset class="nearly_full" >
  <legend>Bookmarks</legend>
  <?php echo$ITEM->tableBuizBookmark; ?>
</fieldset>

<div class="do-clear medium">&nbsp;</div>

<script type="application/javascript">
<?php foreach( $this->jsItems as $jsItem ){ ?>
  <?php echo$ITEM->$jsItem->jsCode?>
<?php } ?>
</script>
