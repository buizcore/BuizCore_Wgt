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
class LibDocumentData_Offer extends LibDocumentData_Letter
{

  /**
   * Angebotsnummer
   * @var string
   */
  public $offerNumber = null;
  
  /**
   * Angebotsdatum
   * @var string
   */
  public $offerDate = null;
  
  /**
   * Referenz auf die Anfrage des Kunden
   * @var string
   */
  public $requestRef = null;

  /**
   * Gültigkeitsdatum des Angebots
   * @var string
   */
  public $validTill = null;

  /**
   * Gültigkeitsdatum des Angebots
   * @var string
   */
  public $deliveryDate = null;

  /**
   * Das Währungssymbol
   * @var string
   */
  public $currencySym = null;

  /**
   * die angebotspositionen
   * @var array[
   *   'pos' => 5, 
   *   'quant' => 5, 
   *   'descr' => ".com domain registration .com domain registratio .com", 
   *   'tax' => 9.95, 
   *   'price' => 9.95
   * ]
   */
  public $positions = [];

  /**
   * texts start
   * @var string
   */
  public $textsStart = [];
  
  /**
   * texts end
   * @var string
   */
  public $textsEnd = [];


} // end class LibDocumentData_Offer

