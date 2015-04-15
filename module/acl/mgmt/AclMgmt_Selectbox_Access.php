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
class AclMgmt_Selectbox_Access extends WgtSelectbox
{

  /**
   *
   */
  public function element($attributes = [])
  {

    $attributes = $this->asmAttributes();

    $select = '<select '.$attributes.' >'.NL;

    if (!is_null($this->firstFree))
      $select .= '<option value=" " >'.$this->firstFree.'</option>'.NL;

    foreach (Acl::$accessLevels as $value => $id) {

      if ($this->activ == $id) {
        $select .= '<option selected="selected" value="'.$id.'" >'.$value.'</option>'.NL;
        $this->activeValue = $value;
      } else {
        $select .= '<option value="'.$id.'" >'.$value.'</option>'.NL;
      }

    }

    if ($this->firstFree && !$this->activeValue)
      $this->activeValue = $this->firstFree;

    $select .= '</select>'.NL;

    return $select;

  }//end public function element  */

}// end class AclMgmt_Selectbox_Access */

