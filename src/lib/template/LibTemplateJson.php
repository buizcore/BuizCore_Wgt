<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : BuizCore GmbH
* @project     : BuizCore - The Business Core
* @projectUrl  : http://buizcore.net
*
* @licence     : BSD License see: LICENCE/BSD Licence.txt
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

/**
 * @package net.buizcore.wgt
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 */
class LibTemplateJson extends LibTemplateHtml
{
/*////////////////////////////////////////////////////////////////////////////*/
// Public Methodes
/*////////////////////////////////////////////////////////////////////////////*/

   /**
    *
    * @var string
    */
    public $type = 'json';
    
   /**
    *
    * @var string
    */
    public $contentType =  'application/json';

   /**
    *
    * @var array
    */
    protected $data = [
        'head' => [],
        'body' => null
    ];
    
   /**
    * @var array
    */
    public $json = [];

/*////////////////////////////////////////////////////////////////////////////*/
// Parser Funktionen
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param array $data
   */
  public function setDataBody($data)
  {
    $this->data['body'] = $data;
  }//end public function setDataBody */
  
  /**
   *
   * @param array $data
   */
  public function setJson($data)
  {
      $this->data['body'] = $data;
  }//end public function setJson */

  /**
   *
   * @param array $status
   */
  public function setStatus($status)
  {
      $this->data['head']['status'] = $status;
  }//end public function setStatus */
  
  
  /**
   * Einfaches bauen der Seite ohne Caching oder sonstige Rücksicht auf
   * Verluste
   *
   * @return void
   */
  public function buildPage()
  {

    if ($this->compiled)
      return;

    $this->compiled = '';
    $this->output = '';

    $this->buildMessages();
    
    if ($this->json && !$this->data['body']) {
        $this->data['body'] = $this->json;
    }

    $this->compiled = json_encode($this->data);

  } // end public function buildPage */

  /**
   * bauen bzw generieren der System und der Fehlermeldungen
   *
   * @return void
   */
  protected function buildMessages()
  {

    $pool = $this->getMessage();

    // Gibet Fehlermeldungen? Wenn ja dann Raus mit
    if ($errors = $pool->getErrors()) {
      foreach ($errors as $error) {
        $this->data['head']['messages']['error'][] = $error;
      }
    }

    if ($warnings = $pool->getWarnings()) {
      foreach ($warnings as $warn) {
        $this->data['head']['messages']['warning'][] = $warn;
      }
    }

    if ($messages = $pool->getMessages()) {
      foreach ($messages as $message) {
        $this->data['head']['messages']['message'][] = $message;
      }
    }

  } // end protected function buildMessages */

} // end class LibTemplateJson */

