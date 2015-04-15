<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <dominik.bonsch@buiz.net>
* @date        :
* @copyright   : Buiz Developer Network <contact@buiz.net>
* @project     : Buiz Web Frame Application
* @projectUrl  : http://buiz.net
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
 * @package net.buiz
 */
class BuizAnnouncement_Widget extends WgtAbstract
{
    
    /**
     * @var string
     */
    public $label = 'Message';
    
    /**
     * @var array
     */
    public $refId = null;
    
    /**
     * @var BuizAnnouncement_Form
     */
    public $form = null;
  

  /**
   * @return string
   */
  public function render($params = null)
  {

     
    $id = $this->getId();
    $i18n = $this->getI18n();

    
    if (!$this->form->targetUrl)
        $this->form->targetUrl = "ajax.php?c=Buiz.Announcement.sendCustomer&refid=".$this->refId."&objid=";

    
    $html = <<<HTML

<section class="wgt-content_box form" >
        <header><h2>{$i18n->l('Message','wbf.label')}</h2></header>
        <div class="content" >
            <fieldset>
                <div class="left n-cols-2" >
                    {$this->form->formTag('post', true)}
                    
                    {$this->form->items['vid']}
                    {$this->form->items['importance']}
                    {$this->form->items['message']}

                    <div class="do-clear medium" >&nbsp;</div>

                    <div class="left half"  >
                        <button
                            class="wgt-button"
                            tabindex="-1"
                            onclick="\$R.form('{$this->form->formId()}',null,{'success':function(){ \$D.resetForm('{$this->form->formId()}');}});return false;" 
                            >{$i18n->l('Send Message','wbf.label')}</button>
                    </div>
                    <div class="do-clear small" >  </div>
              

                    <div class="do-clear small" >&nbsp;</div>
                </div>
            </fieldset>
        </div>
    </section>
HTML;

    return $html;

  } // end public function render */

} // end class BuizAnnouncement_Widget

