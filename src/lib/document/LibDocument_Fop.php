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
class LibDocument_Fop extends PBase
{

    /**
     * Name des Ordners in dem die ganzen Latex Dateien inlcusive log etc angelegt
     * werden
     * @var string
     */
    public $tmpFolder = null;

    /**
     * Temp Filename
     * @var string
     */
    public $tmpFile = null;

    /**
     * Wenn filename gesetzt wird, wird nach dem erfolgreichen Build des
     * Dokuments das Dokument in den Angegebenen Pfad kopiert
     *
     * @var string
     */
    public $filename = '';

    /**
     * Die Template Engine
     * @var LibTemplateDocument
     */
    public $tpl = null;

    /**
     * Der Pfad zum dokument template
     * @var string
     */
    public $docTplPath = null;

    /**
     * Das Data XML als string
     * @var string
     */
    public $docData = null;

    /**
     * Das gerenderte Dokument als string
     * @var string
     */
    public $docContent = null;
    
    /**
     * Flag ob das dokument synchron oder asynchron versendet wird
     * @var boolean
     */
    public $sync = true;

    /**
     * Flag ob das dokument synchron oder asynchron versendet wird
     * @var boolean
     */
    public $mimeType = 'application/pdf';
    
    /**
     * Message Queue Client
     * @var BuizcoreAmqpClient
     */
    protected $mq = null;


    /**
     * @param LibDocumentData_Base
     */
    public function __construct($env = null, $mq = null)
    {

        if ($env) {
            $this->env = $env;
        } else {
            $this->env = BuizCore::$env;
        }
        
        if ($mq) {
            $this->mq = $mq;
        } else {
            
            $conf = $this->env->getConf();
            
            $mqConf = $conf->getResource('mq', 'default');
            
            if ($mqConf) {
                $this->mq = new BuizcoreAmqpClient($mqConf,"foprpc",BuizcoreAmqpClientType::RPC);
            }
            
        }

        //parent::__construct();

    } //end public function __construct */


/*////////////////////////////////////////////////////////////////////////////*/
// Build Logik
/*////////////////////////////////////////////////////////////////////////////*/

    /**
    * @return string
    */
    public function getChecksum()
    {
        return md5($this->docContent);
    } //end public function getChecksum */


    /**
    * @return int
    */
    public function getSize()
    {
        return strlen($this->docContent);
    } //end public function getSize */


    /**
    * @return string
    */
    public function getMimeType()
    {
        return $this->mimeType;
    } //end public function getMimeType */


/*////////////////////////////////////////////////////////////////////////////*/
// Build Logik
/*////////////////////////////////////////////////////////////////////////////*/



    /**
    * Rendern des PDFs
    */
    public function build()
    {

        if (!$this->mq) {
            throw new InternalError_Exception('Missing the Message queue');
        }
        
        // checken ob wir schon nen tmp file namen haben
        if (!$this->tmpFolder) {
            $this->tmpFolder = PATH_TMP.'fop_documents/';
            $this->tmpFile = BuizCore::tmpFile();
        }
        
        $queueData = [];
        $queueData['xsltSource'] = $this->docTplPath;
        $queueData['xmlData'] = $this->docData;
        
        
        $result = $this->mq->call(json_encode($queueData));

        $this->docContent = file_get_contents("http://localhost:8042/".$result->url);
        
        if(!$this->docContent){
            sleep(1);
            $this->docContent = file_get_contents("http://localhost:8042/".$result->url);
        }
        if(!$this->docContent){
            sleep(2);
            $this->docContent = file_get_contents("http://localhost:8042/".$result->url);
        }
        
        if (!$this->docContent) {
            throw new InternalError_Exception('Did not get a pdf');
        } else {
            SFiles::write( PATH_GW.'tmp/the.pdf', $this->docContent);
        }


    } //end public function build */


    /**
    * Das generierte File über die View versenden
    * @param LibTemplateDocument $tpl
    */
    public function sendFile($tpl = null)
    {
    
        if (!$tpl)
            $tpl = $this->tpl;
        
        $file = $tpl->sendFile();

        $file->type = 'application/pdf';
        $file->content = $this->docContent;
        $file->name = $this->filename;

    } //end public function sendFile */


    /**
     * Das generierte File über die View versenden
     * @param string $targetName
     * @param string $targetFolder
     */
    public function copy($targetName, $targetFolder)
    {
        
        if(!file_exists($targetFolder))
            SFilesystem::mkdir($targetFolder);

        SFilesystem::copy($this->tmpFolder.$this->tmpFile, $targetFolder.$targetName);
        
    } //end public function copy */


    /**
     * Die Temporären Daten die beim erstellen des PDFs erstellt wurden löschen
     */
    public function cleanTmp()
    {
        $this->docData = [];
        
    } //end public function cleanTmp */

} // end class LibDocument_Fop

