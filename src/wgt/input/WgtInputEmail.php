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
 * Objekt zum generieren einer Inputbox
 * @package net.buizcore.wgt
 */
class WgtInputEmail extends WgtInput
{

  /**
   * @param array
   * @return string
   */
  public function build($attributes = array())
  {

    // ist immer ein text attribute
    if (!isset($attributes['type']))
      $attributes['type'] = 'text';

    $this->texts->afterInput = '<i class="fa fa-envelop-alt" ></i>';

    return parent::build($attributes);

  } // end public function build */

} // end class WgtInputText

