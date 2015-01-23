<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <dominik.bonsch@webfrap.net>
* @date        :
* @copyright   : Webfrap Developer Network <contact@webfrap.net>
* @project     : Webfrap Web Frame Application
* @projectUrl  : http://webfrap.net
*
* @licence     : BSD License see: LICENCE/BSD Licence.txt
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

/**
 * @package net.webfrap.wgt
 */
class WgtTableBuilder extends WgtTable
{
/*////////////////////////////////////////////////////////////////////////////*/
// Table Navigation
/*////////////////////////////////////////////////////////////////////////////*/

  public $keyName = 'id';

  /**
   * @var function Callback zum Rendern des Heads
   */
  public $cbHead = null;

  /**
   * @var function Callback zum Rendern des Heads
   */
  public $cbBody = null;

  /**
   * @var function Callback zum Rendern des Footer
   */
  public $cbFoot = null;

  /**
   * @var array
   */
  public $cols = [];

  /**
   *
   * Enter description here ...
   * @var function
   */
  public $cbAction = null;

  /**
   * build the table
   * @return string
   */
  public function build()
  {

    if ($this->html)
      return $this->html;

    $keys = array_keys($this->cols);
    
    if ($this->cbHead) {
        
      $cbHead = $this->cbHead;
      $head = $cbHead($this);
    } else {
        
      $this->numCols = count($this->cols) + 1 ;
      $head = $this->buildHead($keys);
      
    }

    if ($this->cbBody) {
      $cbBody = $this->cbBody;

      $body = '<tbody>'.NL;
      foreach ($this->data as $line => $row) {
        $body .= $cbBody($this, $line, $row);
      }
      $body .= '</tbody>'.NL;

    } else {
      $body = $this->buildBody($keys);
    }

    // check for replace is used to check if this table should be pushed via ajax
    // to the client, or if the table is placed direct into a template
    if ($this->insertMode)
      $this->html .= '<div id="'.$this->id.'" >'.NL;

    $this->html .= '<table id="'.$this->id.'_table" class="wgt-table" >'.NL;

    $this->html .= $head;
    $this->html .= $body;



    $this->html .= '</table>';

    // check for replace is used to check if this table should be pushed via ajax
    // to the client, or if the table is placed direct into a template
    if ($this->insertMode) {
        
        $this->html .= '</div>'.NL;
      
        if ($this->cbFoot) {
            $cbFoot = $this->cbFoot;
            $this->html .= $cbFoot($this);
        } else {
            $this->html .= $this->buildTableFooter();
        }
    
        $this->html .= '<script type="application/javascript" >'.NL;
        $this->html .= $this->buildJavascript();
        $this->html .= '</script>'.NL;
    
    }
    
    return $this->html;

  }//end public function build */

  /**
   * @param array $keys
   */
  public function buildHead($keys)
  {

    // Creating the Head
    $head = '<thead class="wgt-table-head" >'.NL;
    $head .= '<tr>'.NL;
    
    foreach ($keys as $colName)
      $head .= '<th>'.$colName.'</th>'.NL;

    $head .= '<th style="width:70px;">'.$this->i18n->l('nav', 'wbf.text.tableNav'  ).'</th>'.NL;

    $head .= '</tr>'.NL;
    $head .= '</thead>'.NL;
    //\ Creating the Head
    return $head;

  }//end public function buildHead */

  /**
   * @param array $keys 
   */
  public function buildBody($keys)
  {

    // Generieren des Bodys
    $body = '<tbody>'.NL;

    $self = $this;
    
    if ($this->cbAction)
      $cbAction = $this->cbAction;
    else
      $cbAction = function($objid, $row) use ($self) {
        return $self->rowMenu($objid, $row);
      };

    // Welcher Rowtyp soll ausgegeben werden
    foreach ($this->data as $line => $row) {

      if (isset($row[$this->keyName]))
        $objid = $row[$this->keyName];
      else
        $objid = $line;

      $rowid = $this->id.'_row_'.$objid;
      $body .= '<tr  id="'.$rowid.'" >'.NL;

      foreach ($keys as $key){
        if(isset($row[$key])){

            $body .= '<td>'.Validator::sanitizeHtml($row[$key]).'</td>'.NL;
        } else {
            $body .= '<td>missing: '.$key.'</td>'.NL;
        }
      } 

      $body .= '<td valign="top" style="text-align:center;" >'.$cbAction($objid,$row).'</td>'.NL;
      $body .= '</tr>'.NL;

    } // ENDE FOREACH

    $body .= '</tbody>'.NL;
    //\ Create the table body
    return $body;

  }//end public function buildBody */

}//end class WgtTable

