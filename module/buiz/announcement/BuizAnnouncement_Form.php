<?php
/*******************************************************************************
* BuizCore.com billion monkeys division
*
* @author      : Dominik Bonsch <BuizCore.com>
* @date        : @date@
* @copyright   : BuizCore.com <BuizCore.com>
* @project     : 
* @projectUrl  : 
* @licence     : BuizCore.com
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/
/**
 * @package com.buizcore.
 * @author Dominik Bonsch <BuizCore.com>
 * @copyright BuizCore.com <BuizCore.com>
 * @licence BuizCore.com
 */
class BuizAnnouncement_Form extends WgtCrudForm
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/
    
  /**
   * @var string
   */
  public $namespace = 'Announcement';

  /**
   * @var string
   */
  public $prefix = 'Announcement';

  /**
   * @var int
   */
  public $refId = null;

  /**
   * Standard Liste der Felder die angezeigt werden sollen
   *
   * @var array
   */
  protected $fields = array(
      'announcement' => array(
        'title' => array(
          'required' => true,
          'key' => 'announcement[title]',
          'valid' => 'text',
          'tmp_required' => false,
          'required_by' => [],
          'readonly' => false,
          'lenght' => '400',
        ),
        'importance' => array(
          'required' => false,
          'key' => 'announcement[importance]',
          'valid' => 'text',
          'tmp_required' => false,
          'required_by' => [],
          'readonly' => false,
          'lenght' => '',
        ),
        'message' => array(
          'required' => true,
          'key' => 'announcement[message]',
          'valid' => 'html',
          'tmp_required' => false,
          'required_by' => [],
          'readonly' => false,
          'lenght' => '',
        ),
      ),

  );

  /**
   * Die Haupt Entity für das Formular
   *
   * @var BuizAnnouncement_Entity
   */
  public $entity = null;

  /**
  * Erfragen der Haupt Entity
  * @param int $objid
  * @return BuizAnnouncement_Entity
  */
  public function getEntity()
  {

    return $this->entity;

  }//end public function getEntity */

  /**
  * Setzen der Haupt Entity
  * @param BuizAnnouncement_Entity $entity
  */
  public function setEntity($entity)
  {

    $this->entity = $entity;
    $this->rowid = $entity->getId();

  }//end public function setEntity */


  /**
   * Erfragen aller zu speichernden Attribute
   * @return array
   */
  public function getSaveFields()
  {

    return array(
      'announcement' => array(
        'importance',
        'message',
      ),

    );

  }//end public function getSaveFields */

/*////////////////////////////////////////////////////////////////////////////*/
// Form Methodes
/*////////////////////////////////////////////////////////////////////////////*/
    
 /**
  * create an IO form for the BuizAnnouncement entity
  *
  * @param Entity $entity the entity object
  * @param array $fields list with all elements that shoul be shown in the ui
  * @namedParam TFlag $params named parameters
  * {
  *   string prefix : prefix for the inputs;
  *   string target : target for;
  *   boolean readOnly : set all elements to readonly;
  *   boolean refresh : refresh the elements in an ajax request ;
  *   boolean sendElement : if true, then the system will send the elements in
  *   ajax requests als serialized html and not only just as value
  * }
  */
  public function renderForm($params = null)
  {

    $params = $this->checkNamedParams($params);
    $i18n = $this->view->i18n;

    if ($params->access)
      $this->access = $params->access;

    // add the entity to the view
    $this->view->addVar('entityItemAnnouncement', $this->entity);
    $this->view->addElement('formItemAnnouncement', $this);
    
    $this->db = $this->getDb();

    if (!$this->suffix) {
      if ('create' != $params->context)
        $this->suffix = $this->rowid?:null;
    }

    if ($this->target)
      $sendTo = 'wgt-input-'.$this->target.'-tostring';
    else
      $sendTo = 'wgt-input-announcement'.($this->suffix?'-'.$this->suffix:'').'-tostring';

    $this->customize();

    $inputToString = $this->view->newInput('input'.$this->prefix.'ToString' , 'Text');
    $inputToString->addAttributes(
      array(
        'name' => 'announcement[id_announcement-tostring]',
        'id' => $sendTo,
        'value' => $this->entity->text(),
      )
    );

    $inputToString->setReadOnly($this->readOnly);
    $inputToString->refresh = $this->refresh;

    $this->input_RefId($params);
    $this->input_Announcement_Title($params);
    $this->input_Announcement_Importance($params);
    $this->input_Announcement_Message($params);


  }//end public function renderForm */
  
    /**
    * create an IO form for the BuizAnnouncement entity
    *
    * @param Entity $entity the entity object
    * @param array $fields list with all elements that shoul be shown in the ui
    * @namedParam TFlag $params named parameters
    * {
    *   string prefix : prefix for the inputs;
    *   string target : target for;
    *   boolean readOnly : set all elements to readonly;
    *   boolean refresh : refresh the elements in an ajax request ;
    *   boolean sendElement : if true, then the system will send the elements in
    *   ajax requests als serialized html and not only just as value
    * }
    */
    public function readValues($params = null)
    {
  
        $i18n = $this->view->i18n;
        
        if ($params->access)
          $this->access = $params->access;
        
        $this->db = $this->getDb();
        
        $this->customizeData();
        
        //$this->value_Announcement_Title($params);
        $this->value_Announcement_Importance($params);
        $this->value_Announcement_Message($params);
        $this->value_RefId($params);
  
    
    }//end public function readValues */
  
 /**
  * create the ui element for field title
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_Announcement_Title($params)
  {
    $i18n = $this->view->i18n;

      //tpl: class ui:text
      $inputTitle = new WgtInputText();
      $this->items['title'] = $inputTitle;
      $inputTitle->addAttributes(
        array(
          'name' => 'announcement[title]',
          'id' => 'wgt-input-announcement_title'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm   wcm_valid_required xxlarge'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'maxlength' => $this->entity->maxSize('title'),
        )
      );
      $inputTitle->setWidth('xxlarge');

      $inputTitle->setReadonly($this->fieldReadOnly('announcement', 'title'));
      $inputTitle->setRequired(true);

      $inputTitle->setData($this->entity->getSecure('title'));
      $inputTitle->setLabel($i18n->l('Title', 'core.base'));


  }//end public function input_Announcement_Title */
      
  
 /**
  * inject the value for field title
  * @param TFlag $params named parameters
  * @return void
  */
  public function value_Announcement_Title($params)
  {

  
        if($this->entity)
            $this->jData['announcement']['title'] = $this->entity->getSecure('title');
        else
            $this->jData['announcement']['title'] = null;
  
  }//end public function value_Announcement_Title */

    /**
    * create the ui element for field rowid
    * @param TFlag $params named parameters
    * @return void
    */
    public function input_RefId($params)
    {
        $i18n = $this->view->i18n;

        //tpl: class ui: guess
        $inputVid = new WgtInputHidden();
        $this->items['vid'] = $inputVid;
        $inputVid->addAttributes(array(
            'name' => 'announcement[vid]',
            'id' => 'wgt-input-announcement_vid'.($this->suffix?'-'.$this->suffix:''),
            'class' => ''.($this->assignedForm?' asgd-'.$this->assignedForm:''),
        ));

        $inputVid->setData($this->refId);

    }//end public function input_RefId */
        
    /**
    * inject the value for field rowid
    * @param TFlag $params named parameters
    * @return void
    */
    public function value_RefId($params)
    {
    
        if($this->entity)
            $this->jData['announcement']['vid'] = $this->entity->getId();
        else
            $this->jData['announcement']['vid'] = null;
    
    }//end public function value_RefId */


    /**
    * create the ui element for field importance
    * @param TFlag $params named parameters
    * @return void
    */
    public function input_Announcement_Importance($params)
    {
        $i18n = $this->view->i18n;

        //tpl: class ui:importance
        $inputImportance = new WgtInputImportance('importance');
        $this->items['importance'] = $inputImportance;
        $inputImportance->addAttributes(array(
            'name' => 'announcement[importance]',
            'id' => 'wgt-input-announcement_importance'.($this->suffix?'-'.$this->suffix:''),
            'class' => 'wcm medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
        ));
        $inputImportance->setWidth('medium');
        
        $inputImportance->setReadonly($this->fieldReadOnly('announcement', 'importance'));
        $inputImportance->setRequired($this->fieldRequired('announcement', 'importance'));
        
        $inputImportance->setActive($this->entity->getSecure('importance'));
        $inputImportance->setLabel($i18n->l('Importance', 'core.base'));

    }//end public function input_Announcement_Importance */
        
    /**
    * inject the value for field importance
    * @param TFlag $params named parameters
    * @return void
    */
    public function value_Announcement_Importance($params)
    {
        if($this->entity)
            $this->jData['announcement']['importance'] = $this->entity->getData('importance');
        else
            $this->jData['announcement']['importance'] = null;
    
    }//end public function value_Announcement_Importance */

    /**
    * create the ui element for field message
    * @param TFlag $params named parameters
    * @return void
    */
    public function input_Announcement_Message($params)
    {
        $i18n = $this->view->i18n;
    
        //p: textarea
        $inputMessage = new WgtInputTextarea('message');
        $this->items['message'] = $inputMessage;
        $inputMessage->addAttributes(array(
          'name' => 'announcement[message]',
          'id' => 'wgt-input-announcement_message'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_valid_required large-height'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
        ));
        
        $inputMessage->setData($this->entity->getData('message'));
        $inputMessage->setReadonly($this->fieldReadOnly('announcement', 'message'));
        $inputMessage->setRequired(true);
        $inputMessage->setLabel($i18n->l('Message', 'core.base'));
    
    
    }//end public function input_Announcement_Message */
      
  
    /**
    * inject the value for field message
    * @param TFlag $params named parameters
    * @return void
    */
    public function value_Announcement_Message($params)
    {
        if ($this->entity)
            $this->jData['announcement']['message'] = $this->entity->getData('message');
        else
            $this->jData['announcement']['message'] = null;
    }//end public function value_Announcement_Message */

/*////////////////////////////////////////////////////////////////////////////*/
// Validate Methodes
/*////////////////////////////////////////////////////////////////////////////*/
      
    /**
    * Wenn die Formularmaske per POST Request aufgerufen wird können default
    * Parameter mitübergeben werden
    *
    * @param LibRequestHttp $request
    * @throws Wgt_Exception
    */
    public function fetchDefaultData($request)
    {
    
        // prüfen ob alle nötigen objekte vorhanden sind
        if (!$this->entity) {
          throw new Wgt_Exception(
            "To call fetchDefaultData in a CrudFrom an entity object is required!"
          );
        }
        
        // laden aller nötigen system resourcen
        $orm = $this->getOrm();
        $response = $this->getResponse();
        
        // extrahieren der Daten für die Hauptentity
            
        $filter = $request->checkFormInput(
            $orm->getValidationData('BuizAnnouncement', array_keys($this->fields['announcement']), true),
            $orm->getErrorMessages('BuizAnnouncement'),
            'announcement'
        );
            
        
        $tmp = $filter->getData();
        $data = [];
        
        // es werden nur daten gesetzt die tatsächlich übergeben wurden, sonst
        // würden default werte in den entities überschrieben werden
        foreach ($tmp as $key => $value) {
            if (!is_null($value)) {
                $data[$key] = $value;
                $this->externDefData['announcement['.$key.']'] = $value;
            }
        }
        
        $this->entity->addData($data);
    
    }//end public function fetchDefaultData */
    
    /**
    * Wenn die Formularmaske per POST Request aufgerufen wird können default
    * Parameter mitübergeben werden
    *
    * @param LibRequestHttp $request
    * @throws Wgt_Exception
    */
    public function setDefaultData()
    {
    
        // prüfen ob alle nötigen objekte vorhanden sind
        if (!$this->entity) {
            throw new Wgt_Exception(
                "To call fetchDefaultData in a CrudFrom an entity object is required!"
            );
        }
        
        // laden aller nötigen system resourcen
        $orm = $this->getOrm();
        $response = $this->getResponse();
    
    }//end public function setDefaultData */
  

}//end class BuizAnnouncement_Crud_Edit_Form */


