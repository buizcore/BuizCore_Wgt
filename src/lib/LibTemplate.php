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
 *
 * @package net.buizcore.wgt
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 *        
 */
abstract class LibTemplate extends BaseChild
{
/*
 * //////////////////////////////////////////////////////////////////////////////
 * // Output File Attributes
 * //////////////////////////////////////////////////////////////////////////////
 */
    
    /**
     * Die Id des View Elements, wird zb.
     * bei Maintabs und Windows bennötigt
     * 
     * @var string
     */
    public $id = 'wgt_html';

    /**
     * de:
     * Der Title für das Title tag im html head
     * je nach Viewtype ann der Title jedoch auch an anderen Stellen verwendet
     * werden wie z.B im Maintab as Title Panel
     * 
     * @var string
     */
    public $title = null;

    /**
     * what type of view ist this object, html, ajax, pdf...
     * 
     * @var string lowercase
     */
    public $type = null;

    /**
     * the activ index template
     * 
     * @var string
     */
    public $indexTemplate = null;

    /**
     * The main Template
     * 
     * @var string
     */
    public $template = null;

    /**
     * Befindet sich das Template beim Code oder
     * im templates folder?
     *
     * @since 0.9.2
     * @var string
     */
    public $tplInCode = false;

    /**
     * der aktuelle content type der seite
     * dürfte text/html bleiben
     * 
     * @var string
     */
    public $contentType = View::CONTENT_TYPE_TEXT;

    /**
     * de:
     * File wird verwendet um eine Datei zurück zu geben anstelle dynamisch
     * content zu genrieren.
     *
     * File wird z.B verwendet zum PDFs oder Excel Sheets über die View direkt
     * ausgeben zu können
     *
     * @see LibTemplateDocument
     *
     * @var LibTemplateDataFile | string der filename
     */
    public $file = null;

    /**
     * Conf informationen fürs template
     * 
     * @var array
     */
    public $tplConf = [];

    /**
     * Status der Seite
     * Solange keiner das Gegenteil behauptet ist alles in Ordnung
     * 
     * @var string
     */
    public $status = 'ok';

    /**
     * Context URL mit den acls, masken whatever
     * 
     * @var string
     */
    public $contextUrl = null;

    /**
     * Der aktuelle Kontext (sowas wie ein Environment mit Settings)
     * der View
     * 
     * @var Context
     */
    public $context = null;

    /**
     * Name des aktiven Scopes
     * 
     * @var string
     */
    public $scope = null;

    /**
     * Definition eines Scopes
     * 
     * @var string
     */
    public $scopeData = null;
    
/*
 * //////////////////////////////////////////////////////////////////////////////
 * //
 * //////////////////////////////////////////////////////////////////////////////
 */
    
    /**
     * Template Conditions zum implementieren von Conditionbasierter Templateanpassung
     *
     * @var array
     */
    protected $condition = [];

    /**
     *
     * @var LibTemplate
     */
    protected $parent = null;

    /**
     *
     * @var View
     */
    protected $subView = null;
    
/*
 * //////////////////////////////////////////////////////////////////////////////
 * // Data Attributes
 * //////////////////////////////////////////////////////////////////////////////
 */
    
    /**
     *
     * @var TDataObject
     */
    protected $var = [];

    /**
     * @deprecated kann eigentlich alles über VAR gemacht werden
     * @var TDataObject
     */
    protected $object = [];

    /**
     * Variable zum anhängen von Javascript Code
     * Aller Inline JS Code sollte am Ende der Html Datei stehen
     * Also sollte der Code nicht direkt in den Templates stehen sondern
     * in die View geschrieben werden können, so dass das Templatesystem den Code
     * am Ende der Seite einfach anhängen kann
     * 
     * @var string
     */
    protected $jsCode = [];

    /**
     *
     * @var TDataObject
     */
    protected $area = [];

    /**
     *
     * @var array
     */
    protected $tabs = [];

    /**
     *
     * @var array
     */
    protected $tabclose = [];

    /**
     *
     * @var array
     */
    protected $forms = [];

    /**
     * Named array of closures
     * 
     * @var array<string,closure>
     */
    protected $funcs = [];

    /**
     *
     * @var Model
     */
    public $model = null;

    /**
     *
     * @var array
     */
    protected $models = null;

    /**
     *
     * @var array
     */
    protected $renderer = null;

    /**
     * Loader für texte
     * @var BuizText_Manager
     */
    protected $text = null;
    
/*
 * //////////////////////////////////////////////////////////////////////////////
 * // data with assembled elements
 * //////////////////////////////////////////////////////////////////////////////
 */
    
    /**
     *
     * @var string
     */
    protected $assembledBody = '';

    /**
     *
     * @var string
     */
    protected $compiled = '';

    /**
     *
     * @var string
     */
    protected $assembledMainContent = null;

    /**
     * String mit den zusammengebauten Mainmessages
     * *
     * 
     * @var string
     */
    protected $assembledMessages = null;

    /**
     * Der komplett fertig gerenderte Content
     * Wird zb von der Response zurück gegeben
     * 
     * @var string
     */
    public $output = null;
    
/*
 * //////////////////////////////////////////////////////////////////////////////
 * // cache attributes
 * //////////////////////////////////////////////////////////////////////////////
 */

    /**
     * a default footer
     *
     * @var LibCacheAdapter
     */
    protected $cacheObj = null;

    /**
     * der key für den cache
     * Wenn Aktiv dann wird gecached
     *
     * @var string
     */
    protected $cacheKey = null;

    /**
     *
     * @var string
     */
    protected $keyCachePage = null;
    
/*
 * //////////////////////////////////////////////////////////////////////////////
 * // magic methodes
 * //////////////////////////////////////////////////////////////////////////////
 */
    
    /**
     * de:
     * Der Konstruktor initialisier die View mit dem minimal notwendigen
     * Resourcen zum arbeiten
     *
     * @param array $conf
     *            der Konfigurationsabschnitt der View aus der Conf File
     * @param Base $env
     *            Die Aktive Environment für die View
     */
    public function __construct($conf = [], $env = null)
    {

        $this->var = new TDataObject();
        $this->object = new TDataObject();
        $this->area = new TDataObject();
        $this->funcs = new TTrait();
        
        $this->tplConf = $conf;
        
        if (is_array($conf)) {
            $this->scopeData = isset($conf['scopes']) ? $conf['scopes'] : [];
        } else 
            if (is_object($conf) && $conf instanceof LibTemplate) {
                $this->parent = $conf;
            }
        
        if (! $env) {
            $env = BuizCore::getActive();
        }
        
        $this->env = $env;
        $this->getAcl();
        $this->getI18n();
        $this->getCache();
        
        $this->text = Manager::get('BuizText');
    
    } // end public function __construct */

    /**
     */
    public function __destruct()
    {

        $this->var = null;
        $this->object = null;
        $this->area = null;
        $this->funcs = null;
        
        $this->forms = [];
        $this->tabs = [];
    
    } // end public function __destruct*/

    /**
     * de:
     * methode zum abfagen von nicht implementierted display aufrufen
     *
     * @param
     *            $name
     * @param $values /
     *            public function __call($name, $values)
     *            {
     *            
     *            throw new LibTemplate_Exception("You Tried to Call non existing Method: ".__CLASS__."::{$name}");
     *            
     *            }//end public function __call
     */
    
////////////////////////////////////////////////////////////////////////////////
// Getter und Setter
////////////////////////////////////////////////////////////////////////////////

    
    /**
     * the design to use
     * 
     * @param string $condition
     *            Name des Maintemplates
     * @return void
     */
    public function setCondition($condition)
    {

        $this->condition = $condition;
    
    } // end public function setCondition*/

    /**
     *
     * @param Model $model            
     */
    public function setModel($model)
    {

        $this->model = $model;
        
        if ($this->model->access)
            $this->access = $this->model->access;
    
    } // end public function setModel */
    
    /**
     *
     * @param LibTemplate $parent            
     */
    public function setParent($parent)
    {

        $this->parent = $parent;
    
    } // end public function setParent */

    /**
     * setzen des HTML Titels
     *
     * @param string $title
     *            Titel Der in der HTML Seite zu zeigende Titel
     * @return void
     */
    public function setTitle($title)
    {

        $this->title = $title;
    
    } // end public function setTitle */

    /**
     * request the title
     * 
     * @return string
     */
    public function getTitle()
    {

        return $this->title;
    
    } // end public function getTitle */

    /**
     *
     * @return string
     */
    public function getIdKey()
    {

        Debug::console('seems we got a request for an idKey on the wrong type of template object');
        
        return null;
    
    } // end public function getIdKey */

    /**
     *
     * @param string $fileName            
     * @return void
     */
    public function savePage($fileName)
    {

        SFiles::write($fileName, $this->compiled);
    
    } // end public function savePage */

    /**
     * the design to use
     * 
     * @param string $condition
     *            Name des Maintemplates
     * @return void
     */
    public function setScope($scope)
    {
        
        // fallback auf die default configuration
        // / todo checken ob das so passt
        if (! $this->tplConf) {
            $this->tplConf = $this->getConf()->getResource('view');
        }
        
        $this->scope = $scope;
        
        if (isset($this->tplConf['scopes'][$scope])) {
            
            $this->scopeData = $this->tplConf['scopes'][$scope];
        } else {
            
            Log::error('tried to set a non existing view scope '.$scope.'.Maybe you try to set a wrong scope or you forgot to define this scope in the view part of the config.');
            
            // fallback to the ria scope
            $this->scope = 'ria';
            $this->scopeData = $this->tplConf['scopes']['ria'];
        }
    
    } // end public function setScope*/

    /**
     *
     * @return string
     */
    public function getId()
    {

        return $this->id;
    
    } // end public function getId */

    /**
     *
     * @param boolean $forceHttps            
     * @return string
     */
    public function getServerAddress($forceHttps = false)
    {

        return BuizCore::$env->getRequest()->getServerAddress($forceHttps);
    
    } // end public function getServerAddress */

    /**
     *
     * @param string $name            
     * @param string $size            
     * @return string
     */
    public function iconPath($name, $size = 'xsmall')
    {

        return View::$iconsWeb.$size.'/'.$name;
    
    } // end public function iconPath */

    /**
     * the design to use
     *
     * @param string/array $type
     *            Template Name des Maintemplates
     * @return void
     */
    public function isType($type)
    {

        if (is_array($type)) {
            
            foreach ($type as $key) {
                if ($this->type === $key)
                    return true;
            }
            
            return false;
        } else {
            return ($this->type === $type);
        }
    
    } // end public function isType */
    
    /**
     * @param LibTemplateWidget $child
     */
    public function assignSubview($child) 
    {
        
        $child->injectResources($this->var, $this->object, $this->area);
        
    }//end public function assignSubview */

    /**
     *
     * @return string
     */
    public function getType()
    {

        return $this->type;
    
    } // end public function getType */

    /**
     * @lang de:
     * Getter für WGT Render Objekte.
     * Renderobjekte werden zur Trennung von Darstellung und Daten in den
     * WGT Elementen verwendet
     *
     * @param string $type            
     * @return WgtRenderHtml
     */
    public function getRenderer($type)
    {

        if (isset($this->renderer[$type]))
            return $this->renderer[$type];
        
        $className = 'WgtRender'.SParserString::subToCamelCase($type);
        
        $this->renderer[$type] = new $className($this);
        
        return $this->renderer[$type];
    
    } // end public function getRenderer */

    /**
     * set the html content
     *
     * @param string $html            
     * @return void
     */
    public function setContent($content)
    {

        $this->compiled = $content;
    
    } // end public function setHtml */

    /**
     * @setter LibTemplate::$indexTemplate
     *
     * @param
     *            string Index Name des Indextemplates
     * @return bool
     */
    public function setIndex($index = 'default')
    {

        $this->indexTemplate = $index;
    
    } // end public function setIndex */

    /**
     *
     * @return string
     */
    public function getIndex()
    {

        return $this->indexTemplate;
    
    } // end public function getIndex */

    /**
     * @setter LibTemplate::$template
     * 
     * @param string $template            
     * @param boolean $tplInCode
     *            since: 0.9.2,
     * @return void
     */
    public function setTemplate($template, $tplInCode = false)
    {

        $this->template = $template;
        $this->tplInCode = $tplInCode;
    
    } // end public function setTemplate */

    /**
     *
     * @return string
     */
    public function getTemplate()
    {

        return $this->template;
    
    } // end public function getTemplate */

    /**
     * request the template path
     * 
     * @return string
     */
    public function getTemplatePath()
    {

        if ($this->tplInCode)
            return PATH_GW.'/';
        else
            return PATH_GW.'templates/';
    
    } // end public function getTemplatePath */

    /**
     *
     * @param string $key            
     * @return LibTemplate
     */
    public function loadView($key)
    {

        $className = $key.'_View';
        
        if (! BuizCore::classExists($className)) {
            throw new LibTemplate_Exception('Requested nonexisting View '.$key);
        }
        
        $this->subView = new $className($this);
        
        $this->subView->setI18n($this->i18n);
        $this->subView->setUser($this->user);
        $this->subView->setTplEngine($this);
        $this->subView->setView($this);
        $this->subView->setParent($this);
        
        return $this->subView;
    
    } // end public function loadView */

    /**
     *
     * @return LibTemplate
     */
    public function getSubView()
    {

        return $this->subView;
    
    } // end public function getSubView */
    
/*
 * //////////////////////////////////////////////////////////////////////////////
 * // UI
 * //////////////////////////////////////////////////////////////////////////////
 */
    
    /**
     * de:
     * Erstellen eines UI Containers.
     * UI Container sind Hilfsobjekte welche Teilbereiche der Seite beschreiben.
     * z.B ein CRUD Formular, ein Suchformular, ein Listing Element, einen Graphen
     * etc.
     * In einem moderaten Maß ist die Logik durch Parameter konfigurierbar
     * Mehr Informationen dazu sind den jeweiligen Methoden auf den Containern zu
     * entnehmen.
     * 
     * @see Ui Dies Methode versucht ein Objekt eines Containers anhand eines übergeben
     *      Keys zu erstellen.
     *      Wenn die Klasse existiert wird ein Objekt erstell und die View übergibt
     *      sich direkt selbst.
     *     
     * @param string $uiName            
     * @return Ui ein UI Container
     * @throws LibTemplate_Exception
     */
    public function loadUi($uiName)
    {

        $uiName = ucfirst($uiName);
        $className = $uiName.'_Ui';
        
        if (BuizCore::classExists($className)) {
            
            $ui = new $className($this);
            $ui->setView($this);
            
            return $ui;
        } else {
            
            throw new LibTemplate_Exception('Internal Error', 'Failed to load ui: '.$uiName);
        }
    
    } // end public function loadUi */

    /**
     * setter for the ui
     * 
     * @param Ui $ui            
     */
    public function setUi($ui)
    {

        $this->ui = $ui;
    
    } // end public function setUi */
    
/*
 * //////////////////////////////////////////////////////////////////////////////
 * // Models können direkt an eine View übergeben
 * // Das ermöglich einen direkten zugriff aus den Templates auf die Models
 * // wenn der Use-Case eifach genug ist
 * //////////////////////////////////////////////////////////////////////////////
 */

    /**
     *
     * @param string $key            
     * @param Model $model            
     */
    public function addModel($key, $model)
    {

        $this->models[$key] = $model;
    
    } // end public function addModel

    /**
     * request the default action of the ControllerClass
     * 
     * @return Model
     * @throws LibTemplate_Exception
     */
    public function getModel($modelKey, $key = null, $create = false)
    {

        if (! $key)
            $key = $modelKey;
        
        $modelName = $modelKey.'_Model';
        
        if (! isset($this->models[$key])) {
            if (BuizCore::classExists($modelName)) {
                $this->models[$key] = new $modelName($this);
            } else {
                throw new LibTemplate_Exception('Internal Error', 'Failed to load Submodul: '.$modelName);
            }
        }
        
        return $this->models[$key];
    
    } // end public function getModel */

    /**
     *
     * @param string $modelKey            
     * @param string $key            
     * @return Ambigous <Model, multitype:>
     */
    public function loadModel($modelKey, $key = null)
    {

        return $this->getModel($modelKey, $key, true);
    
    } // end public function loadModel */
    
    /*
     * //////////////////////////////////////////////////////////////////////////////
     * // Variablen / Elemente und Templates
     * //////////////////////////////////////////////////////////////////////////////
     */
    
    /**
     *
     * @param
     *            $content
     * @return void
     */
    public function setMainContent($content)
    {

        $this->assembledMainContent = $content;
    
    } // end public function setMainContent */

    /**
     * de:
     *
     * hinzufügen von Template-Variablen
     *
     * diese Variablen sind im Template später über <?php $VAR ?>
     *
     *
     * @param array $vars            
     * @return void
     */
    public function addVars($vars)
    {

        $this->var->content = array_merge($this->var->content, $vars);
    
    } // end public function addVars */

    /**
     * add variables in the view namespace
     *
     * @param array/string $key
     *            Content $key Einen Array mit Content für die Seite
     * @param string $data
     *            Die Daten für ein bestimmtes Feld
     * @return void
     */
    public function addVar($key, $data = null)
    {

        if (is_scalar($key)) {
            $this->var->content[$key] = $data;
        } elseif (is_array($key)) {
            $this->var->content = array_merge($this->var->content, $key);
        }
    
    } // end public function addVar */
    
    /**
     * @param string $key
     * @return string
     */
    public function getVar($key)
    {
        if (isset($this->var->content[$key])) {
            return $this->var->content[$key];
        } else {
            return null;
        }
    }//end public function getVar */

    /**
     * Enter description here...
     *
     * @param string $classKey            
     * @return LibTemplateAreaView
     */
    public function getMainArea($key, $classKey)
    {

        $className = $classKey.'_View';
        
        if (! BuizCore::classExists($className))
            throw new LibTemplate_Exception("The requested View {$className} not exists");
        
        $area = new $className();
        $area->setI18n($this->i18n);
        $area->setUser($this->user);
        $area->setParent($this);
        $this->area->content[$key] = $area;
        
        return $this->area->content[$key];
    
    } // end public function getMainArea */

    /**
     *
     * @param string $key            
     * @param string $area            
     *
     * @return LibTemplateAreaView
     */
    public function newArea($key, $area = null)
    {

        if ($area) {
            $this->area->content[$key] = $area;
        } elseif (! isset($this->area->content[$key])) {
            $area = new LibTemplateAreaView();
            $area->setI18n($this->i18n);
            $area->setUser($this->user);
            $area->setParent($this);
            $this->area->content[$key] = $area;
        }
        
        return $this->area->content[$key];
    
    } // end public function newArea */

    /**
     * @param string $key            
     * @param string $content            
     * @return LibTemplatePhp
     */
    public function setArea($key, $content)
    {

        $this->area->content[$key] = $content;
    
    } // end public function setArea */

    /**
     * @param string $key            
     * @param string $area            
     * @return LibTemplatePhp
     */
    public function setAreaContent($key, $area)
    {

        $this->area->content[$key] = $area;
    
    } // end public function setAreaContent */

    /**
     *
     * @param string $key            
     * @param string $content            
     */
    public function setPageFragment($key, $content)
    {

        $this->area->content[$key] = $content;
    
    } // end public function setPageFragment */

    /**
     *
     * @param string $key            
     * @return LibTemplate
     */
    public function getArea($key)
    {

        if (! isset($this->area->content[$key])) {
            $this->area->content[$key] = new LibTemplateAreaView();
            
            return $this->area->content[$key];
        } else {
            return $this->area->content[$key];
        }
    
    } // end public function getArea */

    /**
     *
     * @param string $key            
     * @param function $func            
     */
    public function addFunction($key, $func = null)
    {

        if (is_array($key)) {
            foreach ($key as $objKey => $funct) {
                $this->funcs->$objKey = $funct;
            }
        } else {
            $this->funcs->$key = $func;
        }
    
    } // end public function addFunction */

    /**
     * Enter description here...
     *
     * @param string $key            
     * @param WgtForm $form            
     * @return WgtForm
     */
    public function addForm($key, $form)
    {

        $this->forms[$key] = $form;
        
        return $form;
    
    } // end public function addForm */

    /**
     * Enter description here...
     *
     * @param string $key            
     * @return WgtForm
     */
    public function newForm($key, $type = null)
    {

        $type = $type ? ucfirst($type) : ($key);
        
        $className = $type.'_Form';
    
        if (!BuizCore::classExists($className))
            throw new LibTemplate_Exception('Requested noexisting form '.$type);
        
        $form = new $className($this);
        
        $this->forms[$key] = $form;
        
        return $form;
    
    } // end public function newForm */

    /**
     * Neues Formobjekt für eine Entity erstellen / anfragen
     * *
     * 
     * @param string $key            
     * @return WgtForm
     */
    public function getForm($key)
    {

        if (isset($this->forms[$key]))
            return $this->forms[$key];
        
        $type = ucfirst($key);
        
        $className = $type.'_Form';
        
        if (! BuizCore::classExists($className)) {
            throw new LibTemplate_Exception('Requested noexisting form '.$type);
        }
        
        $form = new $className($this);
        $this->forms[$key] = $form;
        
        return $form;
    
    } // end public function getForm */

    /**
     * Content für die Seite hinzufügen
     *
     * @param array/string Content Einen Array mit Content für die Seite
     * @param string Data Die Daten für ein bestimmtes Feld
     * @return WgtItemAbstract
     */
    public function newItem($key, $type)
    {

        if (isset($this->object->content[$key])) {
            return $this->object->content[$key];
        } elseif (is_object($type)) {
            $this->object->content[$key] = $type;
            
            return $type;
        } else {
            
            $className = $type;
            $classNameOld = 'Wgt'.$type;
            
            if (! BuizCore::classExists($className)) {
                $className = $classNameOld;
                
                if (! BuizCore::classExists($className))
                    throw new WgtItemNotFound_Exception('Item '.$className.' is not loadable');
            }
            
            $object = new $className($key);
            $object->view = $this; // add back reference to the owning view
            $object->i18n = $this->i18n;
            
            $this->object->content[$key] = $object;
            
            if (DEBUG)
                Debug::console('Created Item: '.$className.' key: '.$key);
            
            return $object;
        }
    
    } // end public function newItem */

    /**
     * ein oder mehrere Items hinzufügen
     *
     * @param
     *            array/string Content Einen Array mit Content für die Seite
     * @param
     *            string Data Die Daten für ein bestimmtes Feld
     * @return WgtItemAbstract
     */
    public function addItem($key, $item = null)
    {

        if (is_array($key))
            $this->object->content = array_merge($key, $this->object->content);
        else
            $this->object->content[$key] = $item;
    
    } // end public function addItem */

    /**
     * Enter description here...
     *
     * @param string $key            
     * @return object
     */
    public function getItem($key)
    {

        if (isset($this->object->content[$key]))
            return $this->object->content[$key];
        
        else
            return null;
    
    } // end public function getItem */

    /**
     * Content für die Seite hinzufügen
     *
     * @param
     *            array/string Content Einen Array mit Content für die Seite
     * @param
     *            string Data Die Daten für ein bestimmtes Feld
     * @return WgtItemAbstract
     */
    public function createElement($key, $type)
    {

        if (isset($this->object->content[$key])) {
            return $this->object->content[$key];
        } elseif (is_object($type)) {
            $this->object->content[$key] = $type;
            
            return $type;
        } else {
            
            $className = $type.'_Element';
            
            if (! BuizCore::classExists($className))
                throw new WgtItemNotFound_Exception('Element '.$className.' is not loadable');
            
            $object = new $className($key);
            $object->view = $this; // add back reference to the owning view
            $object->i18n = $this->i18n;
            
            $this->object->content[$key] = $object;
            
            if (DEBUG)
                Debug::console('Created Element: '.$className.' key: '.$key);
            
            return $object;
        }
    
    } // end public function createElement */

    /**
     * ein oder mehrere Items hinzufügen
     *
     * @param
     *            array/string Content Einen Array mit Content für die Seite
     * @param
     *            string Data Die Daten für ein bestimmtes Feld
     * @return WgtItemAbstract
     */
    public function addElement($key, $element = null)
    {

        if (is_array($key))
            $this->object->content = array_merge($key, $this->object->content);
        else
            $this->object->content[$key] = $element;
    
    } // end public function addElement */

    /**
     * Content für die Seite hinzufügen
     *
     * @param
     *            array/string Content Einen Array mit Content für die Seite
     * @param
     *            string Data Die Daten für ein bestimmtes Feld
     * @return WgtWidget
     */
    public function addWidget($key, $type)
    {

        if (isset($this->var->content[$key])) {
            return $this->var->content[$key];
        } elseif (is_object($type)) {
            $this->var->content[$key] = $type;
            
            return $type;
        } else {
            
            $className = $type.'_Widget';
            $classNameOld = 'WgtWidget'.$type;
            
            if (! BuizCore::classExists($className)) {
                $className = $classNameOld;
                
                if (! BuizCore::classExists($className))
                    throw new WgtItemNotFound_Exception('Widget '.$className.' is not loadable');
            }
            
            $object = new $className($key);
            $object->view = $this; // add back reference to the owning view
            $object->i18n = $this->i18n;
            
            $this->var->content[$key] = $object;
            
            $this->jsCode[$key] = $object;
            
            if (DEBUG)
                Debug::console('Created Widget: '.$className.' key: '.$key);
            
            return $object;
        }
    
    } // end public function addWidget */

    /**
     *
     * @param string $key            
     * @param string $type            
     * @return WgtInput
     */
    public function newInput($key, $type)
    {

        if (isset($this->object->content[$key])) {
            return $this->object->content[$key];
        } elseif (is_object($type)) {
            $this->object->content[$key] = $type;
            
            return $type;
        } else {
            $className = 'WgtInput'.ucfirst($type);
            
            if (! BuizCore::classExists($className)) {
                throw new WgtItemNotFound_Exception('Class '.$className.' was not found');
            } else {
                $object = new $className($key);
                $this->object->content[$key] = $object;
                
                if (Log::$levelTrace)
                    Debug::console('Created Input: '.$className.' key '.$key);
                
                return $object;
            }
        }
    
    } // end public function newInput */

    /**
     * Hinzufügen eines neuen Maintabs
     *
     * @param string $name            
     * @param string $type            
     * @return LibViewMaintab
     */
    public function newMaintab($name, $type = null)
    {

        if (isset($this->tabs[$name])) {
            return $this->tabs[$name];
        } elseif (is_object($type)) {
            $this->tabs[$name] = $type;
            
            return $type;
        } else {
            if ($type) {
                
                $className = ucfirst($type).'_Maintab_View';
                if (! BuizCore::classExists($className)) {
                    $className = ucfirst($type).'_Maintab';
                    if (! BuizCore::classExists($className)) {
                        throw new LibTemplate_Exception('requested nonexisting tab '.$type);
                    }
                }
                
                $tab = new $className($name, $this);
            } else {
                $tab = new LibViewMaintab($name, $this);
            }
            
            $tab->id = 'wgt_tab-'.$name;
            $tab->setI18n($this->i18n);
            $tab->setUser($this->user);
            $tab->setAcl($this->acl);
            $tab->setParent($this);
            
            $this->tabs[$name] = $tab;
            
            return $tab;
        }
    
    } // end public function newMaintab */

    /**
     * Schliesen eines Maintabs
     *
     * @param string $name            
     */
    public function closeTab($name)
    {

        $this->tabclose[$name] = new LibViewMaintabCloser($name);
    
    } // end public function closeTab */

    /**
     *
     * @param string $jsCode            
     * @return void
     */
    public function addJsCode($jsCode)
    {

        $this->jsCode[] = $jsCode;
    
    } // end public function addJsCode */

    /**
     * Start Js Code
     */
    public function openJs()
    {

        ob_start();
    
    } // end public function openJs */

    /**
     * Get the code from the
     */
    public function closeJs()
    {

        $jsCode = trim(ob_get_contents());
        // @ is required to prevent error for empty tags
        // should normaly not happen, but it would not be an error if
        // so ignore warnings
        @ob_end_clean();
        
        // remove <script></script>
        // / TODO implement this less error-prone
        $jsCode = substr($jsCode, 8, - 9);
        
        if ('' !== $jsCode)
            $this->addJsCode($jsCode);
    
    } // end public function closeJs */
    
/*
 * //////////////////////////////////////////////////////////////////////////////
 * // Parser Methodes
 * //////////////////////////////////////////////////////////////////////////////
 */
    
    /**
     * Enter description here...
     *
     * @param string $template            
     * @param string $content            
     * @return string
     */
    public function includeBody($template, $content = null)
    {

        if ($content)
            return $content;
        
        if (! $filename = $this->templatePath($template, 'index')) {
            Error::report('failed to load the body '.$template);
            
            if (Log::$levelDebug)
                return '<p class="wgt-box error">failed to load the body: '.$template.'</p>';
            else
                return '<p class="wgt-box error">failed to load the body '.$filename.' </p>';
        }
        
        $TITLE = $this->title;
        $VAR = $this->var;
        $ITEM = $this->object;
        $ELEMENT = $this->object;
        
        $AREA = $this->area;
        $FUNC = $this->funcs;
        $I18N = $this->i18n;
        ;
        $USER = $this->user;
        
        if (Log::$levelVerbose)
            Log::verbose("Loaded Body Template: $filename");
        
        ob_start();
        include $filename;
        $content = ob_get_contents();
        ob_end_clean();
        
        return $content;
    
    } // end public function includeBody */

    /**
     *
     * @param string $template            
     * @param boolean $inCode            
     * @param array $PARAMS            
     * @return string
     *
     * @since 0.9.2
     */
    public function includeContentTemplate($template, $inCode = false, $PARAMS = [])
    {

        return $this->includeTemplate($template, 'module', $PARAMS, $inCode);
    
    } // end public function includeContentTemplate */

    /**
     * Enter description here...
     *
     * @param string $template            
     * @param string $type            
     * @param array $PARAMS            
     * @return string
     */
    public function includeTemplate($template, $type = 'module', $PARAMS = [], $inCode = false)
    {

        if (! $filename = $this->templatePath($template, $type, $inCode)) {
            
            Error::addError('Failed to load the template :'.$template);
            
            if (DEBUG) {
                
                $error = '<p class="wgt-box error">template '.$template.' not exists</p>';
                $error .= '<pre>'.get_class($this).'<br />'.Debug::backtrace().'</pre>';
                return $error;
                
            } else {
                
                return '<p class="wgt-box error">template '.$template.' not exists</p>';
            }
        }
        
        $VAR = $this->var;
        $ITEM = $this->object;
        $ELEMENT = $this->object;
        $AREA = $this->area;
        $FUNC = $this->funcs;
        $I18N = $this->i18n;
        $USER = $this->user;
        $CONF = $this->getConf();
        
        if (Log::$levelVerbose)
            Log::verbose("Include Template: $filename ");
        
        ob_start();
        include $filename;
        $content = ob_get_contents();
        ob_end_clean();
        
        return $content;
    
    } // end public function includeTemplate */

    /**
     *
     * @param string $template            
     * @param string $type            
     * @param array $PARAMS            
     */
    public function includeAll($template, $type = 'module', $PARAMS = [])
    {

        if (! $listTemplates = $this->allTemplatePaths($template, $type)) {
            Error::report('Failed to load any template with the all key: '.$template);
            
            return '<p class="wgt-box error">template all key <strong>'.$template.'</strong> not exists</p>';
        }
        
        $VAR = $this->var;
        $ITEM = $this->object;
        $ELEMENT = $this->object;
        $AREA = $this->area;
        $FUNC = $this->funcs;
        $I18N = $this->i18n;
        $USER = $this->user;
        
        ob_start();
        foreach ($listTemplates as $filename) {
            if (Log::$levelVerbose)
                Log::verbose("Include Template: $filename");
            
            include $filename;
            $content = ob_get_contents();
        }
        ob_end_clean();
        
        return $content;
    
    } // end public function includeTemplate */

    /**
     * Enter description here...
     *
     * @param string $template            
     * @param string $type            
     * @param array $condition            
     * @param array $PARAMS            
     * @return string
     */
    public function conditionTemplate($template, $type = 'module', $condition = [], $PARAMS = [])
    {

        if ($condition)
            $filename = $this->conditionPath($template, $type, $condition);
        else
            $filename = $this->templatePath($template, $type);
        
        if (! $filename) {
            Error::report('Failed to load the template :'.$template);
            if (DEBUG) {
                $error = '<p class="wgt-box error">template '.$template.' not exists</p>';
                $error .= '<pre>'.Debug::backtrace().'</pre>';
                
                return $error;
            } else {
                return '<p class="wgt-box error">template '.$template.' not exists</p>';
            }
        }
        
        $VAR = $this->var;
        $ITEM = $this->object;
        $ELEMENT = $this->object;
        $AREA = $this->area;
        $FUNC = $this->funcs;
        $I18N = $this->i18n;
        ;
        $USER = $this->user;
        
        if (Log::$levelVerbose)
            Log::verbose("Include Template: $filename ");
        
        ob_start();
        include $filename;
        $content = ob_get_contents();
        ob_end_clean();
        
        return $content;
    
    } // end public function includeTemplate */

    /**
     * Enter description here...
     *
     * @param string $template            
     * @param array $PARAMS            
     * @return unknown
     */
    public function includeFile($template, $PARAMS = [])
    {

        if (! file_exists($template)) {
            Error::report('Failed to load the template :'.$template);
            
            if (DEBUG) {
                $error = '<p class="wgt-box error">template '.$template.' not exists</p>';
                $error .= '<pre>'.Debug::backtrace().'</pre>';
                
                return $error;
            } else {
                return '<p class="wgt-box error">template '.$template.' not exists</p>';
            }
        }
        
        $VAR = $this->var;
        $ITEM = $this->object;
        $ELEMENT = $this->object;
        $AREA = $this->area;
        $FUNC = $this->funcs;
        $I18N = $this->i18n;
        $USER = $this->user;
        
        ob_start();
        include $template;
        $content = ob_get_contents();
        ob_end_clean();
        
        return $content;
    
    } // end public function includeFile */

    /**
     * Enter description here...
     *
     * @param string $template            
     * @param string $folder            
     * @param array $PARAMS            
     * @return string
     */
    public function includeI18nFile($template, $folder = null, $PARAMS = [])
    {

        if (file_exists($folder.Session::status('lang').'/'.$template)) {
            $fileName = $folder.Session::status('lang').'/'.$template;
        } elseif (file_exists($folder.Session::status('def_lang').'/'.$template)) {
            $fileName = $folder.Session::status('def_lang').'/'.$template;
        } else {
            Error::report('Failed to load the path:'.$folder.' template :'.$template);
            
            $fileName = $folder.Session::status('lang').'/'.$template;
            
            if (DEBUG) {
                $error = '<p class="wgt-box error">template '.$fileName.' not exists</p>';
                $error .= '<pre>'.Debug::backtrace().'</pre>';
                
                return $error;
            } else {
                return '<p class="wgt-box error">template '.$fileName.' not exists</p>';
            }
        }
        
        $VAR = $this->var;
        $ITEM = $this->object;
        $ELEMENT = $this->object;
        $AREA = $this->area;
        $FUNC = $this->funcs;
        $I18N = $this->i18n;
        $USER = $this->user;
        
        ob_start();
        include $fileName;
        $content = ob_get_contents();
        ob_end_clean();
        
        return $content;
    
    } // end public function includeI18nFile */

    /**
     * Getter für ein Subtemplate Pfad
     *
     * @param string $file            
     * @param string $folder            
     * @return string
     */
    public function getPath($file, $type = 'module')
    {
        // use the webfrap template
        return BuizCore::templatePath($file, $type, true);
    
    } // end public function getPath */

    /**
     *
     * @param string $template            
     * @param string $type            
     * @param array $PARAMS            
     */
    public function subTemplate($template, $type = 'content', $PARAMS = [])
    {

        if (! $filename = $this->templatePath($template, $type)) {
            Error::report('Failed to load the template :'.$template);
            return '<p class="wgt-box error">template '.$template.' not exists</p>';
        }
        
        if (Log::$levelVerbose)
            Log::verbose("Include Sub Template: $filename ");
        
        $VAR = $this->var;
        $ITEM = $this->object;
        $ELEMENT = $this->object;
        $AREA = $this->area;
        $FUNC = $this->funcs;
        $I18N = $this->i18n;
        $USER = $this->user;
        
        return $filename;
    
    } // end public function subTemplate */

    /**
     *
     * @param string $template            
     * @param array $condition            
     * @param array $PARAMS            
     */
    public function buildMainContent($template, $condition = null, $PARAMS = [], $tplType = 'module')
    {

        if ($this->assembledMainContent)
            return $this->assembledMainContent;
        
        if (! $condition)
            $condition = $this->condition;
        
        if ($condition)
            $this->assembledMainContent = $this->conditionTemplate($template, $tplType, $condition, $PARAMS);
        else
            $this->assembledMainContent = $this->includeTemplate($template, $tplType, $PARAMS, $this->tplInCode);
        
        return $this->assembledMainContent;
    
    } // end public function buildMainContent */
    

    /**
     * @param [] $row
     * @param string $template
     */
    public function loopTemplate($row, $template)
    {
    
        if ($filename = $this->templatePath($template , 'module')) {
    
            $VAR = $this->var;
            $ITEM = $this->object;
            $ELEMENT = $this->object;
            $AREA = $this->area;
            $I18N = $this->i18n;
            $user = $this->user;
            $CONF = $this->getConf();
    
            if (Log::$levelVerbose)
                Log::verbose("Load Index Template: $filename ");
    
            ob_start();
            include $filename;
            $content = ob_get_contents();
            ob_end_clean();
    
        } else {
    
            Error::report('Loop Template does not exist: '.$template);
            $content = '<p class="wgt-box error">Wrong loop Template '.$template.' </p>';
    
        }
    
        return $content;
    
    }//end public function loopTemplate */

    /**
     *
     * @return void
     */
    public function buildBody()
    {
        
        // wenn ein file vorhanden ist aber kein template wird nicht gebaut
        if ($this->file)
            return;
            
            // wenn der main content bereits vorhanden ist und kein index template
            // gesetzt wurd dann wird der content verwendet
        if (! empty($this->assembledMainContent) && ! $this->indexTemplate) {
            
            $this->assembledBody = $this->assembledMainContent;
            return;
        }
        
        // wenn der komplette body schon da ist, ist auch schon alles erledigt
        if ($this->assembledBody)
            return;
        
        if ($filename = $this->templatePath($this->indexTemplate, 'index')) {
            
            $VAR = $this->var;
            $ITEM = $this->object;
            $ELEMENT = $this->object;
            $AREA = $this->area;
            $FUNC = $this->funcs;
            $CONDITION = $this->condition;
            
            $MESSAGES = $this->buildMessages();
            $TEMPLATE = $this->template;
            $CONTENT = $this->assembledMainContent;
            
            $I18N = $this->i18n;
            $USER = $this->user;
            $CONF = $this->getConf();
            
            if (Log::$levelVerbose)
                Log::verbose("Load Index Template: $filename ");
            
            ob_start();
            include $filename;
            $content = ob_get_contents();
            ob_end_clean();
            
        } else {
            
            Error::report('Index Template does not exist: '.$this->indexTemplate);
            
            // /TODO add some good error handler here
            if (Log::$levelDebug)
                $content = '<p class="wgt-box error">Wrong Index Template: '.$this->indexTemplate.' ('.$filename.')  </p>';
            else
                $content = '<p class="wgt-box error">Wrong Index Template '.$this->indexTemplate.' </p>';
        }
        
        $this->assembledBody .= $content;
    
    } // end public function buildBody */

    /**
     * Das Indextemmplate bauen
     * 
     * @param boolean $force
     *            erzwingen, dass auf jeden fall gebaut wird
     */
    public function buildIndexTemplate($force = false)
    {

        if ($filename = $this->templatePath($this->indexTemplate, 'index')) {
            
            $VAR = $this->var;
            $ITEM = $this->object;
            $ELEMENT = $this->object;
            $AREA = $this->area;
            $FUNC = $this->funcs;
            $CONDITION = $this->condition;
            
            $MESSAGES = $this->buildMessages();
            $TEMPLATE = $this->template;
            $CONTENT = $this->assembledMainContent;
            
            $I18N = $this->i18n;
            $USER = $this->user;
            $CONF = $this->getConf();
            
            if (Log::$levelVerbose)
                Log::verbose("Load Index Template: $filename ");
            
            ob_start();
            include $filename;
            $content = ob_get_contents();
            ob_end_clean();
            
        } else {
            
            Error::report('Index Template does not exist: '.$this->indexTemplate);
            
            // /TODO add some good error handler here
            if (Log::$levelDebug)
                $content = '<p class="wgt-box error">Wrong Index Template: '.$this->indexTemplate.' ('.$filename.')  </p>';
            else
                $content = '<p class="wgt-box error">Wrong Index Template '.$this->indexTemplate.' </p>';
        }
        
        $this->compiled = $content;
    
    } // end public function buildIndexTemplate */

    /**
     * show an Error Message
     * 
     * @param string $errorMessage
     * @param string $errorTitle
     * @param string $template
     * @param string $folder
     */
    public function showError($errorMessage, $errorTitle = 'Error', $template = 'error', $folder = 'webfrap')
    {

        Error::report('Got Error:'.$errorMessage);
        
        $this->addVar(array(
            'errorTitle' => $errorTitle,
            'errorMessage' => $errorMessage
        ));
        
        $this->setTemplate($folder.'/'.$template);
    
    } // end public function showError */

    /**
     * de:
     * Komplettes leeren aller in die View übergebenen Daten
     *
     * Nach dem Aufruf von clean View befindet sich die View in einem Status
     * als wäre sie eben erst erstellt worden.
     */
    public function cleanView()
    {

        $this->template = null;
        
        $this->var->reset();
        $this->area->reset();
        $this->object->reset();
        $this->funcs->reset();
        
        $this->forms = [];
        
        $this->assembledBody = '';
    
    } // end public function cleanView */
    
/*
 * //////////////////////////////////////////////////////////////////////////////
 * // Request Path
 * //////////////////////////////////////////////////////////////////////////////
 */
    
    /**
     * Methode zum finden des passende Templates
     * Templates können sich an 3 Orten befinden
     * Theme Templates überschreiben dabei Modultemplates und diese wiederrum
     * generierte Theme Templates in Sandbox
     *
     * @param string $file            
     * @param string $folder            
     * @param @deprecated boolean $tplInCode            
     * @return string
     */
    public function templatePath($file, $type = 'module', $tplInCode = false)
    {
        // use the webfrap template
        if ('module' === $type)  {
            
            // globale templates gewinnen gegen lokale
            // so ist ein theming möglich
            $tplPath = BuizCore::templatePath($file, $type);
            
            if ($tplPath) {
                return $tplPath;
            }
            
            return BuizCore::templatePath($file, $type, true);
        }
        
        return BuizCore::templatePath($file, $type);
            
    } // end public function templatePath */

    /**
     * de:
     * Methode zum finden des passende Templates
     * Templates können sich an 3 Orten befinden
     * Theme Templates überschreiben dabei Modultemplates und diese wiederrum
     * generierte Theme Templates in Sandbox
     *
     * @param string $file            
     * @param string $folder            
     * @return string
     */
    public function allTemplatePaths($file, $type = 'module')
    {

        $templates = [];
        
        $tPath = View::$templatePath.'/'.$type.'/'.$file;
        
        // Zuerst den Standard Pfad checken
        if (file_exists($tPath)) {
            $folder = new LibFilesystemFolder($tPath);
            
            if ($files = $folder->getFilesByEnding('.tpl'))
                $templates = array_merge($templates, $files);
        }
        
        foreach (View::$searchPathTemplate as $path) {
            
            $tmpPath = $path.'/'.$type.'/'.$file;
            
            if (file_exists($tmpPath)) {
                $folder = new LibFilesystemFolder($tmpPath);
                
                if ($files = $folder->getFilesByEnding('.tpl'))
                    $templates = array_merge($templates, $files);
            }
        }
        
        // return list of found templates
        return $templates;
    
    } // end public function allTemplatePaths */

    /**
     * Suchen eines Templates anhand von Conditions
     * 
     * @param string $template            
     * @param string $type            
     * @param array $condition            
     * @return string
     */
    public function conditionPath($template, $type = 'module', $condition = [])
    {

        foreach (View::$searchPathTemplate as $folder) {
            $tmp = $condition;
            while ($tmp) {
                $rek = implode('/', $tmp);
                
                $tmpPath = $folder.'/'.$type.'/'.$rek.'/'.$template.'.tpl';
                
                if (file_exists($tmpPath))
                    return $tmpPath;
                
                array_pop($tmp);
            }
        }
        
        return null;
    
    } // end public function conditionPath */

    /**
     * Methode zum finden des passende Templates
     * Templates können sich an 3 Orten befinden
     * Theme Templates überschreiben dabei Modultemplates und diese wiederrum
     * generierte Theme Templates in Sandbox
     *
     * @param string $file            
     * @return string
     */
    public function sysTemplatePath($file)
    {

        if (! $file)
            return null;
            
        /*
         * if (file_exists(View::$templatePath.$file.'.tpl')) {
         * if (Log::$levelDebug)
         * Log::debug("found Systemplate: ".View::$templatePath.$file.'.tpl');
         *
         * return View::$templatePath.$file.'.tpl';
         * }
         */
        
        foreach (View::$searchPathIndex as $path) {
            if (file_exists($path.'/'.$file.'.tpl')) {
                if (Log::$levelDebug)
                    Log::debug("found Systemplate: ".$path.'/'.$file.'.tpl');
                
                return $path.'/'.$file.'.tpl';
            }
        }
        
        return null;
    
    } // end public function sysTemplatePath */
    
    /**
     */
    public function startTplMode()
    {
        ob_start();
    }//end public function startTplMode */
    
    /**
    * @return string
    */
    public function getTplContent()
    {
        $templateData = ob_get_contents();
        ob_end_clean();
        
        return $templateData;
    }//end public function getTplContent */
    
/*
 * //////////////////////////////////////////////////////////////////////////////
 * // Caching Methodes
 * //////////////////////////////////////////////////////////////////////////////
 */
    
    /**
     *
     * @param string $key            
     */
    public function loadCachedPage($key)
    {

        if ($content = $this->getCache()->get('module/'.$key, Cache::WEEK)) {
            $this->compiled = $content;
            
            return true;
        }
        
        $this->keyCachePage = $key;
        
        return false;
    
    } // end public function loadCachedPage */

    /**
     *
     * @param string $key            
     */
    public function resetCachedPage($key)
    {

        return $this->cacheRemove('content/'.$key);
    
    } // end public function resetCachedPage

    /**
     *
     * @param string $key            
     */
    public function writeCachedPage($key, $content)
    {

        $this->getCache()->add('module/'.$key, $content);
    
    } // end public function writeCachedPage

    /**
     *
     * @param string $key            
     * @param int $time            
     * @return boolean
     */
    public function cacheGet($key, $time = Cache::MEDIUM)
    {

        $cache = $this->getCache();
        
        $cached = $cache->get($key, $time);
        
        if (is_null($cached)) {
            $this->cacheKey = $key;
            ob_start();
            
            return false;
        } else {
            echo $cached;
            
            return true;
        }
    
    } // end public function cacheGet */

    /**
     * speichern in den cache uns ausgabe
     */
    public function cacheWrite()
    {

        if ($this->cacheKey) {
            $cache = $this->getCache();
            
            $toCache = ob_get_contents();
            ob_end_clean();
            
            $cache->add($this->cacheKey, $toCache);
            echo $toCache;
        }
    
    } // end public function cacheWrite */

    /**
     *
     * @param
     *            $key
     * @return string
     */
    public function cacheRemove($key)
    {

        $cache = $this->getCache();
        $cache->remove($key);
    
    } // end public function cacheRemove */

    /**
     *
     * @param string $key            
     * @param int $time            
     */
    public function bodyCacheGet($key, $time = Cache::MEDIUM)
    {

        $cache = $this->getCache();
        
        $key = 'body/'.$key;
        
        if ($cached = $cache->get($key, $time)) {
            $this->assembledBody = $cached;
            
            return true;
        } else {
            return false;
        }
    
    } // public function bodyCacheGet */

    /**
     *
     * @param string $key            
     * @param int $time            
     */
    public function bodyCacheWrite($key, $time = null)
    {

        $cache = $this->getCache();
        
        if (! $this->assembledBody)
            $this->buildBody();
        
        $key = 'body/'.$key;
        
        return $cache->add($key, $this->assembledBody, $time);
    
    } // end public function bodyCacheWrite */

    /**
     *
     * @param string $key            
     * @param int $time            
     */
    public function bodyCacheRemove($key, $time = null)
    {

        $cache = $this->getCache();
        $key = 'body/'.$key;
        $cache->remove($key);
    
    } // end public function bodyCacheRemove */

    /**
     *
     * @param string $key            
     * @param int $time            
     */
    public function contentCacheGet($key, $time = Cache::MEDIUM)
    {

        $cache = $this->getCache();
        
        $key = 'module/'.$key;
        
        if ($cached = $cache->get($key, $time)) {
            $this->assembledMainContent = $cached;
            
            return true;
        } else {
            return false;
        }
    
    } // public function contentCacheGet */

    /**
     *
     * @param string $key            
     * @param string $template            
     * @param array $condition            
     * @param array $PARAMS            
     */
    public function contentCacheWrite($key, $template, $condition = null, $PARAMS = [])
    {

        $cache = $this->getCache();
        
        if (! $this->assembledMainContent)
            $this->buildMainContent($template, $condition, $PARAMS);
        
        $key = 'module/'.$key;
        
        return $cache->add($key, $this->assembledMainContent);
    
    } // end public function contentCacheWrite */

    /**
     *
     * @param string $key            
     * @param string $time            
     */
    public function contentCacheRemove($key, $time = null)
    {

        $cache = $this->getCache();
        
        $key = 'module/'.$key;
        
        $cache->remove($key);
    
    } // end public function contentCacheRemove */
    
/*
 * //////////////////////////////////////////////////////////////////////////////
 * // Context Setter
 * //////////////////////////////////////////////////////////////////////////////
 */
    
    /**
     * method to set the form data
     * 
     * @param TFlag $param            
     */
    public function setSaveFormData($param, $subkey = null)
    {

        $this->setFormData($param->formAction, $param->formId, $param, $subkey);
    
    } // end public function setSaveFormData */

    public function renderFormContext($param, $subkey = null)
    {

        $contextUrl = '';
        
        // flag if the new entry should be added with connection action or CRUD actions
        if ($param->publish)
            $contextUrl .= '&amp;publish='.$param->publish;
            
            // the id of the html table where the new entry has to be added
        if ($param->targetId)
            $contextUrl .= '&amp;target_id='.$param->targetId;
            
            // target is a pointer to a js function that has to be called
        if ($param->target)
            $contextUrl .= '&amp;target='.$param->target;
        
        if ($param->input)
            $contextUrl .= '&amp;input='.$param->input;
        
        if ($param->suffix)
            $contextUrl .= '&amp;suffix='.$param->suffix;
            
            // target is a pointer to a js function that has to be called
        if ($param->refId)
            $contextUrl .= '&amp;refid='.$param->refId;
            
            // target is a pointer to a js function that has to be called
        if ($param->targetMask)
            $contextUrl .= '&amp;target_mask='.$param->targetMask;
            
            // which view type was used, important to close the ui element eg.
        if ($param->viewType)
            $contextUrl .= '&amp;view='.$param->viewType;
            
            // which view type was used, important to close the ui element eg.
        if ($param->viewId)
            $contextUrl .= '&amp;view_id='.$param->viewId;
            
            // list type
        if ($param->ltype)
            $contextUrl .= '&amp;ltype='.$param->ltype;
        
        if ($param->refIds) {
            foreach ($param->refIds as $key => $value) {
                $contextUrl .= '&amp;refids['.$key.']='.$value;
            }
        }
        
        // ACLS
        
        // startpunkt des pfades für die acls
        if ($param->aclRoot)
            $contextUrl .= '&amp;a_root='.$param->aclRoot;
        
        if ($param->maskRoot)
            $contextUrl .= '&amp;m_root='.$param->maskRoot;
            
            // die id des Datensatzes von dem aus der Pfad gestartet wurde
        if ($param->aclRootId)
            $contextUrl .= '&amp;a_root_id='.$param->aclRootId;
            
            // der key des knotens auf dem wir uns im pfad gerade befinden
        if ($param->aclKey)
            $contextUrl .= '&amp;a_key='.$param->aclKey;
            
            // der key des knotens auf dem wir uns im pfad gerade befinden
        if ($param->aclLevel)
            $contextUrl .= '&amp;a_level='.$param->aclLevel;
            
            // der neue knoten
        if ($param->aclNode)
            $contextUrl .= '&amp;a_node='.$param->aclNode;
        
        if (! $subkey)
            $this->contextUrl = $contextUrl;
        
        return $contextUrl;
    
    } // end public function renderFormContext */

    /**
     * method to set the form data
     * 
     * @param TFlag $param            
     */
    public function buildContextUrl($param)
    {

        $this->renderFormContext($param);
    
    } // end public function buildContextUrl */

    /**
     *
     * @param string $formAction            
     * @param string $formId            
     * @param TFlag $param            
     * @param string $subkey            
     */
    public function setFormData($formAction, $formId, $param, $subkey = null)
    {
        
        // flag if the new entry should be added with connection action or CRUD actions
        $formAction .= $this->renderFormContext($param, $subkey);
        
        // add the action to the form
        $this->addVar('formAction'.$subkey, $formAction);
        
        // formId
        $this->addVar('formId'.$subkey, $formId);
    
    } // end public function setFormAction */
    

}//end abstract class LibTemplate

