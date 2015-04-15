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
class BuizStats_Model  extends MvcModel
{

/*////////////////////////////////////////////////////////////////////////////*/
//  Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var  BuizKnowhowNode_Entity
   */
  public $activeNode = null;

/*////////////////////////////////////////////////////////////////////////////*/
//  Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return  BuizKnowhowNode_Entity
   */
  public function getActiveNode()
  {
    return $this->activeNode;
  } //end  public  function  getActiveNode  */

  /**
   * Anlegen  eines  neuen  Nodes
   * @param  string  $title
   * @param  string  $accessKey
   * @param  string  $content
   * @param  int  $container
   * @return  BuizKnowHowNode_Entity
   */
  public function addNode($title, $accessKey, $content, $container)
  {

    $orm = $this->getOrm();

    $khNode = $orm->newEntity("BuizKnowHowNode");
    $khNode->title = $title;
    $khNode->access_key = $accessKey;
    $khNode->id_repository = $container;
    $khNode->raw_content = $content;
    $khNode->content = $content;
    $khNode = $orm->insert($khNode);

    $this->activeNode = $khNode;

    return $khNode;

  } //end  public  function  addNode  */

  /**
   * @param  int  $rowid
   * @param  string  $title
   * @param  string  $accessKey
   * @param  string  $content
   * @param  int  $container
   * @return  BuizKnowHowNode_Entity
   */
  public function updateNode($rowid, $title, $accessKey, $content, $container)
  {

    $orm = $this->getOrm();

    $khNode = $orm->get("BuizKnowHowNode", $rowid);
    $khNode->title = $title;
    $khNode->access_key = $accessKey;
    $khNode->id_repository = $container;
    $khNode->raw_content = $content;
    $khNode->content = $content;
    $khNode = $orm->update($khNode);

    $this->activeNode = $khNode;

    return $khNode;

  } //end  public  function  updateNode  */

  /**
   * @param  string  $nodeKey
   * @param  int  $containerId
   * @return  BuizKnowHowNode_Entity
   */
  public function preCreateNode($nodeKey, $containerId)
  {

    $orm = $this->getOrm();
    $activeNode = $orm->newEntity('BuizKnowHowNode');

    $activeNode->id_container = $containerId;
    $activeNode->access_key = $nodeKey;

    return $activeNode;

  } //end  public  function  preCreateNode  */

  /**
   * @param  int  $objid
   * @return  BuizKnowHowNode_Entity
   */
  public function loadNodeById($objid)
  {

    $orm = $this->getOrm();
    $this->activeNode = $orm->get('BuizKnowHowNode', $objid);

    return $this->activeNode;

  } //end  public  function  loadNodeById  */

  /**
   * @param  string  $key
   * @return  BuizKnowHowNode_Entity
   */
  public function loadNodeByKey($key, $containerId)
  {

    $orm = $this->getOrm();
    $this->activeNode = $orm->getWhere('BuizKnowHowNode', "access_key =  upper('{$orm->escape($key)}')  ");

    Debug::console("load  by  key  " . $key, $this->activeNode);

    return $this->activeNode;

  } //end  public  function  loadNodeByKey  */

  /**
   * @param  int  $objid
   * @return  int
   */
  public function delete($objid)
  {

    $orm = $this->getOrm();
    $orm->delete('BuizKnowHowNode', $objid);

  }//end  public  function  delete  */

  /**
   * @param  int  $key
   * @param  int  $container
   * @return  int
   */
  public function deleteByKey($key, $container)
  {

    $orm = $this->getOrm();
    $orm->deleteWhere('BuizKnowHowNode', "access_key =  UPPER('{$orm->escape($key)}')");

  } //end  public  function  deleteByKey  */

}//end  class  BuizKnowhowNode_Model

