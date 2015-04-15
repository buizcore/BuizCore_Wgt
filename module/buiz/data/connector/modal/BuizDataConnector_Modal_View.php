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
class BuizDataConnector_Modal_View extends LibViewModal
{
/*////////////////////////////////////////////////////////////////////////////*/
// Methoden
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @see LibViewModal::$width
   */
  public $width = 800;

  /**
   * @see LibViewModal::$height
   */
  public $height = 600;

  /**
   * @param Context $params
   * @return void
   */
  public function displayForm()
  {

    $this->setStatus('Data Connector');
    $this->setTitle('Data Connector');

    $this->setTemplate('buiz/data/connector/modal/form', true);

  }//end public function displayForm */

  
  /**
   * @param BuizDataConnector_Search_Request $searchReq
   * @return void
   */
  public function displaySelection($searchReq)
  {

    $this->setStatus('Data Connector');
    $this->setTitle('Data Connector');
    $this->addVar('rqt',$searchReq);
    
    $this->setTemplate('buiz/data/connector/modal/selection', true);

  }//end public function displayForm */
  
}//end class BuizDataConnector_Modal_View

