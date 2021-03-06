<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : BuizCore GmbH
* @project     : BuizCore - The Business Core
* @projectUrl  : http://buizcore.net
*
* @licence     : BSD License see: LICENCE/BSD Licence.txt
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

/** Form Class
 *
 * @package net.buizcore.wgt
 */
class WgtProcessFormSlice_Confirm extends WgtProcessFormSlice
{
/*////////////////////////////////////////////////////////////////////////////*/
// public interface attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param WgtProcessForm $processForm
   * @return string
   */
  public function render($processForm)
  {

    $i18n = $this->getI18n();

    $html = <<<HTML

        <div class="slice" >
          <h3>{$i18n->l('Confirmation','wbf.label')} <span class="wgt-required wcm wcm_ui_tip" title="{$i18n->l('Is Required','wbf.label')}" >*</span></h3>
          <div>
            <p>I hereby confirm that the given information is correct.</p>
            <input
              id="wgt-input-{$processForm->process->name}-confirm-{$processForm->process->entity}"
              class="medium asgd-{$processForm->formId}"
              type="checkbox"
              name="{$processForm->process->name}[user_confirm]" >
          </div>
        </div>

HTML;

    return $html;

  }//end public function render */

}//end class WgtProcessFormSlice_Confirm

