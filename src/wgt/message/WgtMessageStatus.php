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

/**
 * Eine kleine Message Box für Status Messages
 *
 * @package net.buizcore.wgt
 */
class WgtMessageStatus
{

  public $id = null;

  public $title = null;

  public $message = null;


  /**
   * Rendern der Message Box
   */
  public function render()
  {


    $html = <<<HTML

<div class="wgt-box" >
	<div class="head" >
		<div class="left bw3" >
			<h2>{$this->title}</h2>
	  </div>
  </div>
	<div class="content" >
		{$this->message}
	</div>
</div>

HTML;

		return $html;

  }//end public function render */


}//end class WgtMessageStatus

