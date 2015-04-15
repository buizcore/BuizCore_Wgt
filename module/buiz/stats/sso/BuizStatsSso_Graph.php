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
 *
 * @author Dominik Bonsch <d.bonsch@buizcore.com>
 *
 */
class BuizStatsSso_Graph extends LibGraphEz
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   */
  public function prepare()
  {

    $this->data = new BuizStatsSso_Graph_Query();
    $this->data->fetch('2012-01-01');

    $this->width = 400;
    $this->height = 300;

  }//end public function prepare */

  /**
   * @return void
   */
  public function render()
  {

    $this->graph = new ezcGraphPieChart();
    $this->graph->title = $this->title;

    $this->setDefaultSettings();

    // Add data
    $this->graph->data['SSO Usage'] = new ezcGraphArrayDataSet(array('sso' => '33', 'no sso'=> '44'));

  }//end public function render */

}//end class BuizStatsBrowser_Graph