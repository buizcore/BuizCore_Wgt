<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : BuizCore GmbH <contact@buizcore.com>
* @project     : BuizCore, The core business application plattform
* @projectUrl  : http://buizcore.com
*
* @licence     : BuizCore.com internal only
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

/**
 * @package com.buizcore
 * @author Dominik Bonsch <d.bonsch@buizcore.com>
 */
class BuizMessage_Checklist_Ajax_View extends LibViewAjax
{
/*////////////////////////////////////////////////////////////////////////////*/
// display methodes
/*////////////////////////////////////////////////////////////////////////////*/

  
  /**
   * @param int $msgId
   * @param array $entryIds
   * @param array $entries
   * @param Context $params
   */
  public function displaySave($msgId, $entryIds, $entries, $params)
  {
    
    $tpl = $this->getTpl();
    
    foreach ( $entries as $entry ) {
      
      $isChecked = Wgt::checked('t', $entry['checked']);

      $codeEntry = <<<HTML
	<htmlArea selector="#wgt-kvl-msg-checklist-{$msgId}-{$entryIds[$entry['id']]}"  action="replace" ><![CDATA[
    <li 
      id="wgt-kvl-msg-checklist-{$msgId}-{$entry['id']}" 
      eid="{$entry['id']}" ><p><input 
        name="checklist[{$entry['id']}][flag_checked]" 
        class="asgd-wgt-form-save-kvl-msg-checklist-{$msgId}"
        {$isChecked}
        type="checkbox" /><input 
        name="checklist[{$entry['id']}][vid]"
        value="{$msgId}"
        class="asgd-wgt-form-save-kvl-msg-checklist-{$msgId}"
        type="hidden" /></p><a
          class="kvlac_del"><i class="fa fa-times" ></i></a><span 
            style="width:145px;" 
            name="checklist[{$entry['id']}][label]"
            class="editable" >{$entry['label']}</span></li>]]></htmlArea>
    
HTML;
        
     $tpl->setArea(
        'row-'.$entryIds[$entry['id']],
        $codeEntry
     );
      
    }
    
  }//end public function displaySave */
 

} // end class BuizMessage_Checklist_Ajax_View */

