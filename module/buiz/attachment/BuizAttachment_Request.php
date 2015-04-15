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
class BuizAttachment_Request extends ContextListing
{

  public $fetchUntyped = null;
  
  /**
   * @param LibRequestHttp $request
   */
  public function interpretRequest($request)
  {

    // startpunkt des pfades für die acls
    if ($aclRoot = $request->param('a_root', Validator::CKEY))
      $this->aclRoot = $aclRoot;

    // die id des Datensatzes von dem aus der Pfad gestartet wurde
    if ($aclRootId = $request->param('a_root_id', Validator::INT))
      $this->aclRootId = $aclRootId;

    // der key des knotens auf dem wir uns im pfad gerade befinden
    if ($aclKey = $request->param('a_key', Validator::CKEY))
      $this->aclKey = $aclKey;

    // der name des knotens
    if ($aclNode = $request->param('a_node', Validator::CKEY))
      $this->aclNode = $aclNode;

    // an welchem punkt des pfades befinden wir uns?
    if ($aclLevel = $request->param('a_level', Validator::INT))
      $this->aclLevel = $aclLevel;

    // Attachment stuff
    /////////////////

    // an welchem punkt des pfades befinden wir uns?
    if ($element = $request->param('element', Validator::CKEY))
      $this->element = $element;

    if ($refId = $request->param('refid', Validator::EID))
      $this->refId = $refId;

    if ($refMask = $request->param('ref_mask', Validator::CKEY))
      $this->refMask = $refMask;

    if ($refField = $request->param('ref_field', Validator::CKEY))
      $this->refField = $refField;

    if ($maskFilter = $request->param('mask_filter', Validator::CKEY))
      $this->maskFilter = $maskFilter;

    if ($typeFilter = $request->param('type_filter', Validator::CKEY))
      $this->typeFilter = $typeFilter;

    if ($fetchUntyped = $request->param('futpd', Validator::BOOLEAN))
      $this->fetchUntyped = $fetchUntyped;
    else
      $this->fetchUntyped = false;

    
    // listing stuff
    // start position of the query and size of the table
    $this->offset = $request->param('offset', Validator::INT);

    
    // stepsite for query (limit) and the table
    if (!$this->qsize = $request->param('qsize', Validator::INT))
    	$this->qsize = Wgt::$defListSize;
    
    // order for the multi display element
    $this->order = $request->param('order', Validator::CNAME);
    
    // order for the multi display element
    $this->search = $request->param('search', Validator::SEARCH);
    
    $this->searchType = $request->param('search-file_type', Validator::INT);
    

    $ltype = $request->param('ltype', Validator::CKEY);
    if ($ltype) {
        $this->ltype = ucfirst($ltype);
    }
    
  }//end public function interpretRequest */

  /**
   * @return string
   */
  public function toUrlExt()
  {

    if ($this->urlExt)
      return $this->urlExt;

    if ($this->aclRoot)
      $this->urlExt .= '&amp;a_root='.$this->aclRoot;

    if ($this->aclRootId)
      $this->urlExt .= '&amp;a_root_id='.$this->aclRootId;

    if ($this->aclKey)
      $this->urlExt .= '&amp;a_key='.$this->aclKey;

    if ($this->aclNode)
      $this->urlExt .= '&amp;a_node='.$this->aclNode;

    if ($this->aclLevel)
      $this->urlExt .= '&amp;a_level='.$this->aclLevel;

    // domain

    if ($this->element)
      $this->urlExt .= '&amp;element='.$this->element;

    if ($this->refId)
      $this->urlExt .= '&amp;refid='.$this->refId;

    if ($this->refMask)
      $this->urlExt .= '&amp;ref_mask='.$this->refMask;

    if ($this->refField)
      $this->urlExt .= '&amp;ref_field='.$this->refField;
    
    if ($this->fetchUntyped)
      $this->urlExt .= '&amp;futpd=1';

    if ($this->maskFilter)
      $this->urlExt .= '&amp;mask_filter='.$this->maskFilter;

    if ($this->typeFilter)
      $this->urlExt .= '&amp;type_filter[]='.implode('&amp;type_filter[]=', $this->typeFilter);

    if ($this->ltype)
        $this->urlExt .= '&amp;ltype='.$this->ltype;
    
    return $this->urlExt;

  }//end public function toUrlExt */

  /**
   * @return string
   */
  public function toActionExt()
  {

    if ($this->actionExt)
      return $this->actionExt;

    if ($this->aclRoot)
      $this->actionExt .= '&a_root='.$this->aclRoot;

    if ($this->aclRootId)
      $this->actionExt .= '&a_root_id='.$this->aclRootId;

    if ($this->aclKey)
      $this->actionExt .= '&a_key='.$this->aclKey;

    if ($this->aclNode)
      $this->actionExt .= '&a_node='.$this->aclNode;

    if ($this->aclLevel)
      $this->actionExt .= '&a_level='.$this->aclLevel;

    // domain

    if ($this->element)
      $this->actionExt .= '&element='.$this->element;

    if ($this->refId)
      $this->actionExt .= '&refid='.$this->refId;

    if ($this->refMask)
      $this->actionExt .= '&ref_mask='.$this->refMask;

    if ($this->refField)
      $this->actionExt .= '&ref_field='.$this->refField;
    
    if ($this->fetchUntyped)
      $this->actionExt .= '&futpd=1';

    if ($this->maskFilter)
      $this->actionExt .= '&mask_filter='.$this->maskFilter;

    if ($this->typeFilter)
      $this->actionExt .= '&type_filter[]='.implode('&type_filter[]=', $this->typeFilter  );

    if ($this->ltype)
        $this->actionExt .= '&ltype='.$this->ltype;

    return $this->actionExt;

  }//end public function toActionExt */

} // end class BuizAttachment_Request */

