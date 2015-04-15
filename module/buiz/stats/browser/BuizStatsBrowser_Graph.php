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
class BuizStatsBrowser_Graph extends LibGraphEz
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var string
   */
  public $type = 'line';

  public $title = 'Browser Usage';

  /**
   *
   */
  public function prepare()
  {

    //$request = $this->getRequest();

    $this->data = new BuizStatsBrowser_Graph_Query();
    $this->data->fetch('2012-01-01');

    $this->width = 600;
    $this->height = 300;

  }//end public function prepare */

  /**
   * @return void
   */
  public function render()
  {

    $this->graph = new ezcGraphLineChart();
    $this->graph->title = $this->title;
    $this->graph->options->stackBars = true;
    $this->graph->yAxis->label = 'Hits';

    $this->setDefaultSettings();

    // Add data
    foreach ($this->data as $label => $data) {
      $this->graph->data[$label] = new ezcGraphArrayDataSet($data);
    }

  }//end public function render */

}//end class BuizStatsBrowser_Graph