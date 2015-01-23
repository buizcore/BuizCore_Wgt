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
 * Render Element für Form Elemente
 *
 * @package net.buizcore.wgt
 */
class WgtRndLayout
{

  /**
   * @param array $options
   * @param string $active
   * @return string
   */
  public static function selectTabHead($options, $active = null)
  {

    $html = '';

    foreach( $options as $value => $data ){

      $checked = '';
      if( $active === $value ){
        $checked = ' checked="checked" ';
      }

      $html .= '<option  wgt_tab="'.$value.'" value="'.$data[0].'" '.$checked.' >'.$data[1].'</option>'.NL;

    }

    return $html;

  }//end public static function selectbox */

}//end class WgtRndLayout

