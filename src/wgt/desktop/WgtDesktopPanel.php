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
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 */
abstract class WgtDesktopPanel extends WgtDesktopElement
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * sub Modul Extention
   * @var array
   */
  protected $models = array();

/*////////////////////////////////////////////////////////////////////////////*/
// Constructor and other Magics
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * (non-PHPdoc)
   * @see WgtDesktopElement::__toString()
   */
  public function __toString()
  {
    return $this->build();
  }//end public function __toString */

  /**
   * (non-PHPdoc)
   * @see WgtDesktopElement::build()
   */
  public function build()
  {
    return '';
  }//end public function build */

  /**
   * request the default action of the ControllerClass
   * @return Model
   */
  protected function loadModel($modelName , $key = null)
  {

    if (!$key)
      $key = $modelName;

    $modelName = 'Model'.$modelName;
    if (!isset($this->models[$key]  )) {
      if (BuizCore::classExists($modelName)) {
        $this->models[$key] = new $modelName();
      } else {
        throw new Controller_Exception('Internal Error','Failed to load Submodul: '.$modelName);
      }
    }

    return $this->models[$key];

  }//end protected function loadModel */

  /**
   * @param $key
   * @return Model
   */
  protected function getModel($key)
  {

    if (isset($this->models[$key]))
      return $this->models[$key];
    else
      return null;

  }//end protected function getModel */

  /**
   * @return string
   */
  protected function getProfileSelectbox()
  {

    $selectboxProfile = new WgtSelectboxSessionuserProfiles('userprofile');
    $selectboxProfile->load();

    $selectboxProfile->addAttributes
    (array(
      'name' =>  'switch_profile',
      'id' =>  'wgt-panel-switch-profile',
      'class' =>  'medium',
      'onchange' => '$R.redirect(\'index.php\',{c:\'Buiz.Profile.change\',profile:$S(\'#wgt-panel-switch-profile\').val()});'
    ));

    return $selectboxProfile->element();

  }//end protected function getProfileSelectbox

} // end abstract class WgtDesktopElement

