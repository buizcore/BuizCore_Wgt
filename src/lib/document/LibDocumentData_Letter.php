<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : BuizCore.com <contact@buizcore.com>
* @project     : BuizCore platform
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
class LibDocumentData_Letter extends LibDocumentData_Base
{

  /**
   * @var LibDocumentData_CompanyData
   */
  public $ourAddress = null;

  /**
   * @var LibDocumentData_Account
   */
  public $ourAccount = null;

  /**
   * @var LibDocumentData_Address
   */
  public $targetAddress = null;

  /**
   *
   */
  public function __construct()
  {

    $this->ourAddress = new LibDocumentData_CompanyData();
    $this->ourAccount = new LibDocumentData_Account();
    $this->targetAddress = new LibDocumentData_Address();

  }//end public function __construct */


} // end class LibDocumentData_Letter

