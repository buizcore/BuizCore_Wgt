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
 * de:
 *
 * Basisklasse für die Dropmenüs in den Tabs
 * wird hauptsächlich als html container verwendet.
 *
 * Der Einfachheit halben werden die Menüs in Markup Blöcken zusammengebaut
 * für jeden Knoten eine Objekt anzulegen bringt kaum vorteile, würde
 * die nötigen Resourcen zum erstellen des Menüs jedoch unnötig in die
 * Höhe treiben
 *
 * @package net.buizcore.wgt
 */
class WgtSubControlBox
{
/*////////////////////////////////////////////////////////////////////////////*/
// attributes
/*////////////////////////////////////////////////////////////////////////////*/


  /**
   * @var LibTemplate
   */
  public $view;

  /**
   * @var Model
   */
  public $model;

  /**
   * @var PBase
   */
  public $env;

  /**
   * de:
   * Die Html Id des Menü Elements
   * @var string
   */
  public $id;

/*////////////////////////////////////////////////////////////////////////////*/
// construct
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * de:
   * Konstruktor halt, keine Besonderheiten, beide Parameter optional
   * @param string $id
   * @param LibTemplate $view
   */
  public function __construct($id = null, $view = null)
  {
    $this->id = $id;
    $this->view = $view;
  }//end public function __construct */

/*////////////////////////////////////////////////////////////////////////////*/
// Die Render Methode
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return string
   */
  public function render($view = null)
  {
      
    return '<div class="sub-box inline" style="margin-left:25px;" >
                <div class="wgt-panel-control" style="margin-right:15px;" >
                    <div class="left" ><input type="checkbox" /></div>
                    <label class="inline" style="height:32px;line-height:32px;padding-left:4px;" > Customer</label>
                </div>
                <div class="wgt-panel-control" style="margin-right:15px;" >
                    <div class="left" ><input type="checkbox" /></div> 
                    <label class="inline" style="height:32px;line-height:32px;padding-left:4px;" > Contractor</label>
                </div>
                <div class="wgt-panel-control" style="margin-right:15px;" >
                    <div class="left" ><input type="checkbox" /></div> 
                    <label class="inline" style="height:32px;line-height:32px;padding-left:4px;" > Employee</label>
                </div>
                <div class="wgt-panel-control" style="margin-right:15px;" >
                    <div class="left" ><input type="checkbox" /></div> 
                    <label class="inline" style="height:32px;line-height:32px;padding-left:4px;" > User</label>
                </div>
            </div>';
    
  }//end public function build */


}// end class WgtSubControlBox

