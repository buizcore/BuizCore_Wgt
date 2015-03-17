
<div id="wgt_progress_bar" style="display:none;position:absolute;left:50%;margin-left:-50px;top:50%;margin-top:-50px;" >
  <?php echo Wgt::image('wgt/loader.gif',array('alt'=>'progress'),true); ?>
</div>

<div id="wgt_template_container" style="display:none;" class="meta" >

  <div id="wgt-template-dialog" >
    <div title="{$title}" >
      <p>{$message}</p>
    </div>
  </div>

  <div id="dialogTemplate" class="template window ui-corner-all" >
    <div class="content"></div>
    <div class="wgt-container-buttons"><button class="standard template"></button></div>
    <button class="close" title="Close Window">X</button>
    <div class="wgt-window-layer inactive"></div>
  </div>

  <div id="wgt_template_tab_container"  >
    <div class="wgt-container-controls">
      <div class="wgt-container-buttons"></div>
      <div class="tab_outer_container">
        <div class="tab_scroll" >
          <div class="tab_container" >&nbsp;</div>
        </div>
      </div>
    </div>
  </div>

  <div id="wgt_template_tab_head" >
    <span class="tab ui-corner-top" >
      <span class="label" ><a></a></span>
    </span>
  </div>

  <div id="wgt_template_tab-list-head" >
    <li class="tab" >
      <a></a>
    </li>
  </div>

  <div id="wgtidFileUpload" class="meta" >
    <iframe id="wgtidFrameUpload" name="fileUpload" ></iframe>
  </div>

</div>

<iframe id="wgt-local-pipe" name="wgt_local_pipe" class="meta" ></iframe>

<div id="wgt_data_container" class="meta" ></div>

<div id="wgt_tmp_container" class="meta" ></div>

<div id="wgt_context_container"  ></div>


