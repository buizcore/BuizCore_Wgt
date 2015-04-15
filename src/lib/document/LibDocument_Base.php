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
class LibDocument_Base extends LibVendorTcpdf
{

    /**
     * Name des Ordners in dem die ganzen Latex Dateien inlcusive log etc angelegt
     * werden
     * @var string
     */
    protected $tmpFolder = null;

    /**
     * Temp Filename
     * @var string
     */
    protected $tmpFile = null;

    /**
     * Wenn filename gesetzt wird, wird nach dem erfolgreichen Build des
     * Dokuments das Dokument in den Angegebenen Pfad kopiert
     *
     * @var string
     */
    protected $filename = '';

    /**
     * Die Template Engine
     * @var LibTemplateDocument
     */
    protected $tpl = null;

    /**
     * @var LibDocumentData_Base
     */
    protected $docData = null;

    /**
     * @var Pbase
     */
    protected $env = null;

    /**
     * @param LibDocumentData_Base
     */
    public function __construct($env = null, $docData = null)
    {

        if ($env) {
            $this->env = $env;
        } else {
            $this->env = BuizCore::$env;
        }

        $this->docData = $docData;
        parent::__construct();

    } //end public function __construct */


/*////////////////////////////////////////////////////////////////////////////*/
// Build Logik
/*////////////////////////////////////////////////////////////////////////////*/

    /**
     * Setzen des Dateinamens der verwendet werden soll, wenn dieses Dokument
     * nicht nur on the fly erzeugt sondern auch gespeichert werden soll.
     *
     * @param string $filename
     */
    public function setFilename($filename)
    {


        $this->filename = $filename;


        Log::debug("{$this->filename} = {$filename}");

    } //end public function setFilename */


    /**
     * Setzen des Dateinamens der verwendet werden soll, wenn dieses Dokument
     * nicht nur on the fly erzeugt sondern auch gespeichert werden soll.
     *
     * @return string
     */
    public function getFileName()
    {

        return $this->filename;
    } //end public function getFileName */


    /**
    * @param string $tmpFolder
    */
    public function setTmpFolder($tmpFolder)
    {

        $this->tmpFolder = $tmpFolder;
    } //end public function setTmpFolder */


    /**
    * @param string $tmpFile
    */
    public function setTmpFile($tmpFile)
    {

        $this->tmpFile = $tmpFile;
    } //end public function setTmpFile */


    /**
    * @param LibTemplate $tpl
    */
    public function setTpl($tpl)
    {

        $this->tpl = $tpl;
    } //end public function setTpl */


    /**
    * @return string
    */
    public function getChecksum()
    {

        return md5_file($this->tmpFolder.'/'.$this->tmpFile);
    } //end public function getChecksum */


    /**
    * @return int
    */
    public function getSize()
    {

        return filesize($this->tmpFolder.'/'.$this->tmpFile);
    } //end public function getSize */


    /**
    * @return string
    */
    public function getMimeType()
    {

        return 'application/pdf';
    } //end public function getMimeType */


/*////////////////////////////////////////////////////////////////////////////*/
// Build Logik
/*////////////////////////////////////////////////////////////////////////////*/

    /**
    * Initialer Setup des Dokuments
    */
    public function initDocument()
    {

    } //end public function initDocument */


    /**
    * Render des Dokuments
    */
    public function renderDocument()
    {

    } //end public function renderDocument */


    /**
    * Rendern des PDFs
    */
    public function build()
    {

        if(!$this->tmpFolder){
            $this->tmpFolder = PATH_TMP.'documents/';
            $this->tmpFile = BuizCore::tmpFile();
        }

        // sicher stellen dass der cache folder vorhanden ist
        if(!file_exists(PATH_CACHE.'tcpdf/')){
            SFilesystem::createFolder(PATH_CACHE.'tcpdf/');
        }
        

        $this->initDocument();
        $this->renderDocument();

        if (!file_exists($this->tmpFolder))
            SFilesystem::mkdir($this->tmpFolder);

        $this->Output($this->tmpFolder.'/'.$this->tmpFile,'F');
        $this->close();
    } //end public function build */


    /**
    * Das generierte File über die View versenden
    * @param LibTemplateDocument $tpl
    */
    public function sendFile($tpl = null)
    {

        if (!$tpl)
            $tpl = $this->tpl;

        $file = $this->tpl->sendFile();

        $file->type = 'application/pdf';
        //$file->type = 'text/plain';


        $file->path = $this->tmpFolder.$this->tmpFile;
        $file->name = $this->filename;

        /*
        $file->tmp = true;
        $file->tmpFolder = $this->tmpFolder;
         */
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

        SFilesystem::delete($this->tmpFolder.$this->tmpFile);
    } //end public function cleanTmp */

} // end class LibDocument_Base

