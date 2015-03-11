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
 * @package net.buizcore.wgt
 */
class WgtElementContentBox extends WgtAbstract
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var string
   */
  public $label = null;

  /**
   * @var string
   */
  public $content = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return string
   */
  public function render($params = null)
  {

    $id = $this->getId();

    $html = <<<HTML

<section class="wgt-content_box inline wgt-space">

  <header>
    <h2 class="wgt-header-l-2" >{$this->label}</h2>
  </header>

  <div class="content">
{$this->content}
  </div>

</section>

HTML;

    return $html;

  } // end public function render */

} // end class WgtElementContentBox

