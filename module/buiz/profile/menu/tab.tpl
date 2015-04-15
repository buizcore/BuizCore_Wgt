<div style="position:absolute;top:0px;left:0px;bottom:0px;width:501px;border-right:1px solid silver;overflow-y:auto;overflow-x:hidden;" >

  <?php foreach( $VAR->mainMenuData['root'] as $root ) {?>
  <div id="block-<?php echo $root['rowid'] ?>" class="bw4" >

    <div class="wgt-panel" >
      <span><?php echo $root['label'] ?></span>
      <button class="wgt-button" ><i class="fa fa-plus-circle" ></i> Neue Kategorie</button>
      <button
        class="wcm wcm_req_del wgt-button"
        data-action="ajax.php?c=Buiz.Profile_Menu.deleteMenu&objid=<?php echo $root['rowid'] ?>"
        data-confim="Are your shure you want to delete this menu?" ><i class="fa fa-times-sign" ></i> Menü entfernen</button>
    </div>
    <?php
      if(isset($VAR->mainMenuData[$root['rowid']])) {
        foreach( $VAR->mainMenuData[$root['rowid']] as $subMenu ) { ?>
    <div class="wgt-block" style="margin-left:30px;" >
      <div class="do-clear small" >&nbsp;</div>
      <div>
        <h3 style="display:inline;" ><?php echo $subMenu['label'] ?></h3>
          <a><i class="fa fa-plus-circle" ></i> Neuer Eintrag</a> |
          <a
            class="wcm wcm_req_del"
            href="ajax.php?c=Buiz.Profile_Menu.deleteMenu&objid=<?php echo $subMenu['rowid'] ?>"
            data-confim="Are your shure you want to delete this menu?" ><i class="fa fa-times-sign" ></i> Kategorie entfernen</a>
      </div>
      <ul class="wgt-linklist" style="margin-left:30px;" >
      <?php if(isset($VAR->mainMenuData[$subMenu['rowid']])) {
        foreach( $VAR->mainMenuData[$subMenu['rowid']] as $entry ) { ?>
        <li id="menu-entry-<?php echo $entry['rowid'] ?>"  ><a
          class="wcm wcm_req_ajax"
          href="<?php echo $entry['http_url'] ?>" ><?php echo $entry['label'] ?></a>

          <a
            class="wcm wcm_req_del"
            href="ajax.php?c=Buiz.Profile_Menu.deleteMenu&objid=<?php echo $entry['rowid'] ?>"
            data-confim="Are your shure you want to delete this menu?"  ><i class="fa fa-times-sign" ></i> Eintrag entfernen</a>
          </li>
        <?php }} ?>
      </ul>
      <div class="do-clear" ></div>
    </div>
    <?php }} ?>

  </div>
  <?php } ?>


</div>

<div style="position:absolute;top:0px;left:501px;bottom:0px;right:0px;" >

  <div class="wgt-panel" >
    <button class="wgt-button" ><i class="fa fa-plus-circle" ></i> Neues Hauptmenü</button>
  </div>

</div>


<div class="do-clear small">&nbsp;</div>