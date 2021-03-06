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
 *
 */
class WgtItemRadiobox extends WgtItemAbstract
{
/*////////////////////////////////////////////////////////////////////////////*/
// attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  protected $radios = array();

  /**
   * @var string
   */
  protected $activ = null;

/*////////////////////////////////////////////////////////////////////////////*/
// getter and Setter
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return WgtItemRadio
   */
  public function addRadio()
  {

    $radio = new WgtInputRadio($this->name.'radio'.count($this->radios));
    $this->radios[] = $radio;

    return $radio;

  }//ned public function addRadio */

  /**
   * @param string $activ
   */
  public function setActive($activ)
  {

    $this->activ = $activ;
  }//end public function setActiv */

/*////////////////////////////////////////////////////////////////////////////*/
// Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return string
   */
  public function build()
  {

    $table = '<ul class="wgtRate">';

    foreach ($this->radios as $radio) {
      if ($radio->getAttributes('value') == $this->activ) {
        $radio->addAttributes(array('checked' => 'checked'));
      }
      $tdAttributes = $radio->buildTdAttributes();

      $table .= '<li '.$tdAttributes.' >'.$radio->build().'</li>';
    }

    $table .= '</ul>';

    return $table;

  }// end public function build

}//end WgtItemRadiobox

