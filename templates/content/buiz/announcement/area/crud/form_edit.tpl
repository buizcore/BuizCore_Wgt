<!-- elements are assigned via class asgd-<?php echo $VAR->formId?> -->
<form
  method="post"
  accept-charset="utf-8"
  class="<?php echo $VAR->formClass?>"
  id="<?php echo $VAR->formId?>"
  action="<?php echo $VAR->formAction?>" ></form>

<fieldset class="wgt-space bw61" >
  <legend>
    <span onclick="$S('#wgt-box-buiz_announcement-default').iconToggle(this);">
      <i class="fa fa-folder-o" ></i>
    </span>
    Announcement
  </legend>
  <div id="wgt-box-buiz_announcement-default" >

    <div class="left bw6" >
      <?php echo $ITEM->inputBuizAnnouncementTitle?>
    </div>
    <div class="left bw3" >
      <?php echo $ITEM->inputBuizAnnouncementIdType?>
      <?php echo $ITEM->inputBuizAnnouncementImportance?>
    </div>
    <div class="inline bw3" >
      <?php echo $ITEM->inputBuizAnnouncementDateStart?>
      <?php echo $ITEM->inputBuizAnnouncementDateEnd?>
    </div>
    <div class="left bw6" >
      <?php echo $ITEM->inputBuizAnnouncementMessage?>
    </div>

    <div class="do-clear small">&nbsp;</div>

    <div class="left bw6" >
      <button class="wgt-button" onclick="$R.form('<?php echo $VAR->formId?>');" >Edit</button>
    </div>

    <div class="do-clear small">&nbsp;</div>
  </div>
</fieldset>

<div id="wgt-box-buiz_announcement-meta" class="bw61" style="display:none" >
  <div class="left bw3" >
    <?php echo $ITEM->inputBuizAnnouncementRowid?>
    <?php echo $ITEM->inputBuizAnnouncementMUuid?>
    <?php echo $ITEM->inputBuizAnnouncementMVersion?>
  </div>
</div>