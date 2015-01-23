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
 * Item zum generieren einer Linkliste
 * @package net.webfrap.wgt
 */
class WgtElementTimeline extends WgtAbstract
{

    
    /**
     * @param array $data
     */
    public function setData($data, $tmp=null)
    {
        
        $this->data = array();
        
        foreach ($data as $row) {
            
            $dateNode = DateTime::createFromFormat ( 'Y-m-d H:i:s' , $row['created'] ); 
            
            $dateStr = $dateNode->format('Y-m-d');
            
            if (!isset($this->data[$dateStr])) {
                $this->data[$dateStr] = array();
            }
            
            $this->data[$dateStr][] = array(
                $row,
                $dateNode
            );
            
        }
        
    }//end public function setData */
    
  /**
   * @param TFlag $params
   * @return string
   */
  public function render( $params = null)
  {
      
    $id = $this->getId();

    if (!$this->data)
      return <<<HTML
<section id="{$id}" class="wgt-msg-flow-box">

</section>
HTML;
    
    

    $html = <<<HTML
<section class="wgt-msg-flow-box">

HTML;
    
    foreach ($this->data as $date => $rows) {
        $html .=  $this->dayRow($date);
        
        foreach ($rows as $row) {
            $html .= $this->entryRow($row[0], $row[1]);
        }
    }

    $html .= <<<HTML
</section>

HTML;
    
    return $html;

  } // end public function render */


  /**
   * @param string $date
   * @return string
   */
  protected function dayRow($date)
  {

      $dateNode = DateTime::createFromFormat ( 'Y-m-d' , $date );

      return <<<HTML
    <div class="day-row" >
        <div class="outer" >
            <div class="inner" ><a>{$dateNode->format('d')}<br />{$dateNode->format('M')}</a></div>
        </div>
    </div>

HTML;
  
  
  }//end public function dayRow */
  
  /**
   * @param array $row
   * @param DateTime $date
   * @return string
   */
  protected function entryRow($row, $date)
  {
  
      return <<<HTML
    <div class="entry-row" >
        <div class="outer" >
            <i class="fa fa-calendar" ></i>
        </div>
        <div class="entry" >
            <h3>
                <span>{$row['title']}</span>
                <span class="sub">{$row['creator']} <span>{$date->format('H:i')}</span></span>
            </h3>
            <div>
                {$row['content']}
            </div>
        </div>
    </div>

HTML;
  
  
  }//end public function entryRow */
  
  /**
   * Methode zum bauen des Javascript codes für das UI Element.
   *
   * Dieser kann / soll in die aktuelle view injected werden
   *
   * @return string
   */
  public function buildJsCode()
  {

    return '';

    $id = $this->getId();

    $this->jsCode = <<<JCODE

JCODE;


  }//end public function buildJsCode */

} // end class WgtElementSystemMessage

