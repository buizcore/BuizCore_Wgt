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
class AclMgmt_SecurityArea_Form extends WgtForm
{
/*////////////////////////////////////////////////////////////////////////////*/
// attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * the name of the key for the post data
   * @setter WgtForm::setKeyName()
   * @getter WgtForm::getKeyName()
   * @var string
   */
  public $keyName = 'buiz_security_area';

  /**
   * the cname for the entities, is used to request metadata from the orm
   * @setter WgtForm::setEntityName()
   * @getter WgtForm::getEntityName()
   * @var string
   */
  public $entityName = 'BuizSecurityArea';

  /**
   * namespace for the actual form
   * @setter WgtForm::setNamespace()
   * @getter WgtForm::getNamespace()
   * @var string
   */
  public $namespace = 'BuizSecurityArea';

  /**
   * prename for the ui elements to avoid redundant names in the forms
   * normally the entity key (the tablename), is used
   *
   * @setter WgtForm::setPrefix()
   * @getter WgtForm::getPrefix()
   * @var string
   */
  public $prefix = 'BuizSecurityArea';

  /**
   * suffixes are used to create multiple instances of forms for diffrent
   * datasets, normaly the suffix is the id of a dataset or "-new" for
   * create forms
   *
   * @setter WgtForm::setSuffix()
   * @getter WgtForm::getSuffix()
   * @var string
   */
  public $suffix = null;

  /**
   * Die Datenentity für das Formular
   *
   * @var BuizSecurityArea_Entity
   */
  public $entity = null;

/*////////////////////////////////////////////////////////////////////////////*/
// form methodes
/*////////////////////////////////////////////////////////////////////////////*/

 /**
  * create an IO form for the BuizSecurityArea entity
  *
  * @param Entity $entity the entity object
  * @param array $fields list with all elements that shoul be shown in the ui
  * @namedParam TFlag $params named parameters
  * {
  *   string keyName    : the key name for the multidim array name of the inputfields;
  *   string prefix     : prefix for the inputs;
  *   string target     : target for;
  *   boolean readOnly  : set all elements to readonly;
  *   boolean refresh   : refresh the elements in an ajax request ;
  *   boolean sendElement : if true, then the system will send the elements in
  *   ajax requests als serialized html and not only just as value
  * }
  */
  public function createForm($entity, $fields = [], $params = null  )
  {

    $params = $this->checkNamedParams($params);

    if (!$entity) {
      Error::addError('Entity must not be null!!');
      Message::addError('Some internal error occured, it\'s likely, that some data are missing in the ui');

      return false;
    }

    $this->entity = $entity;
    $this->rowid = $entity->getId();

    // add the entity to the view
    $this->view->addVar('entity'.$this->prefix, $this->entity);

    $this->db = $this->getDb();

    if (!$this->suffix) {
      if ('create' != $params->context)
        $this->suffix = $this->rowid?:null;
    }

    if ($this->target)
      $sendTo = 'wgt-input-'.$this->target.'-tostring';
    else
      $sendTo = 'wgt-input-'.$this->keyName.($this->suffix?'-'.$this->suffix:'').'-tostring';

    $inputToString = $this->view->newInput('input'.$this->prefix.'ToString' , 'Text');
    $inputToString->addAttributes(
      array(
        'name' => $this->keyName.'[id_'.$this->keyName.'-tostring]',
        'id' => $sendTo,
        'value' => $this->entity->text(),
      )
    );

    $inputToString->setReadOnly($this->readOnly);
    $inputToString->refresh = $this->refresh;

    // append search meta data
    $this->input_rowid($params);

    foreach ($fields as $key) {
      $method = 'input_'.$key;

      if (method_exists($this,  $method)) {
        $this->$method($params);
      } else {
        if (DEBUG)
          Log::debug('Call to nonexisting method: '.$method.' in Form: BuizSecurityArea');
      }
    }

  }//end public function createForm */

 /**
  * create a search form for the BuizSecurityArea entity
  *
  * @param Entity $entity
  * @param array $fields
  * @param TFlag $params
  */
  public function createSearchForm( $entity, $fields = [], $params = null  )
  {

    $this->entity = $entity;
    $this->rowid = $entity->getId();

    $this->db = $this->getDb();
    $params = $this->checkNamedParams($params);

    $this->prefix  .= 'Search';
    $this->keyName = 'search_'.$this->keyName;

    if (!$this->suffix) {
      $this->suffix = 'search';
    }

    foreach ($fields as $key) {
      $method = 'search_'.$key;
      if (method_exists($this,  $method)) {
        $this->$method($params);
      } else {
        if (DEBUG)
          Debug::console('Call to nonexisting method: '.$method.' in Form: BuizSecurityArea');
      }
    }

    // append search meta data
    $this->search_m_role_created($params);
    $this->search_m_role_changed($params);
    $this->search_m_time_created_before($params);
    $this->search_m_time_created_after($params);
    $this->search_m_time_changed_before($params);
    $this->search_m_time_changed_after($params);
    $this->search_m_rowid($params);
    $this->search_m_uuid($params);

  }//end public function createSearchForm */

/*////////////////////////////////////////////////////////////////////////////*/
// field methodes
/*////////////////////////////////////////////////////////////////////////////*/

 /**
  * create the ui element for field m_parent
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_m_parent($params)
  {

    if (!BuizCore::classExists('BuizSecurityArea_Entity')) {
      if (DEBUG)
        Debug::console('Entity BuizSecurityArea not exists');

      Log::warn('Looks like the Entity: BuizSecurityArea is missing');

      return;
    }

      //p: Window
      $objidBuizSecurityArea = $this->entity->getData('m_parent') ;

      // entity ids can never be 0 so thats ok
      if(
        !$objidBuizSecurityArea
          || !$entityBuizSecurityArea = $this->db->orm->get
          (
            'BuizSecurityArea',
            $objidBuizSecurityArea
          )
      ) {
        $entityBuizSecurityArea = $this->db->orm->newEntity('BuizSecurityArea');
      }

      $inputMParent = $this->view->newInput('input'.$this->prefix.'MParent', 'Window');
      $inputMParent->addAttributes(array
      (
        'readonly' => 'readonly',
        'name' => $this->keyName.'[m_parent]',
        'id' => 'wgt-input-'.$this->keyName.'_m_parent'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
        'title' => $this->view->i18n->l('Insert value for Parent Node (Security Area)', 'wbf.label'),
      ));

      if ($this->assignedForm)
        $inputMParent->assignedForm = $this->assignedForm;

      $inputMParent->setWidth('medium');

      $inputMParent->setData($this->entity->getData('m_parent')  );
      $inputMParent->setReadOnly($this->isReadOnly('m_parent'));
      $inputMParent->setLabel($this->view->i18n->l('Parent Node', 'wbf.label'));

      $listUrl = 'modal.php?c=Buiz.SecurityArea.selection'
        .'&amp;suffix='.$this->suffix.'&amp;input='.$this->keyName.'_m_parent'.($this->suffix?'-'.$this->suffix:'');

      $inputMParent->setListUrl ($listUrl);
      $inputMParent->setListIcon('fa fa-link');
      $inputMParent->setEntityUrl('maintab.php?c=Buiz.SecurityArea.edit');
      $inputMParent->conEntity = $entityBuizSecurityArea;
      $inputMParent->refresh = $this->refresh;
      $inputMParent->serializeElement = $this->sendElement;

        $inputMParent->setAutocomplete(
        '{
          "url":"ajax.php?c=Buiz.SecurityArea.autocomplete&amp;key=",
          "type":"entity"
          }'
        );

      $inputMParent->view = $this->view;
      $inputMParent->buildJavascript('wgt-input-'.$this->keyName.'_m_parent'.($this->suffix?'-'.$this->suffix:''));
      $this->view->addJsCode($inputMParent);

      // activate the category
      $this->view->addVar(
        'showCat'.$this->namespace.'_Default' ,
        true
      );

  }//end public function input_m_parent */

 /**
  * create the ui element for field label
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_label($params)
  {

      //tpl: class ui:text
      $inputLabel = $this->view->newInput('input'.$this->prefix.'Label' , 'Text');
      $this->items['label'] = $inputLabel;
      $inputLabel->addAttributes(
        array(
          'name' => $this->keyName.'[label]',
          'id' => 'wgt-input-'.$this->keyName.'_label'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip valid_required medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title' => $this->view->i18n->l('Insert value for Label (Security Area)', 'wbf.label'),
          'maxlength' => $this->entity->maxSize('label'),
        )
      );
      $inputLabel->setWidth('medium');

      $inputLabel->setReadOnly($this->isReadOnly('label'));
      $inputLabel->setData($this->entity->getSecure('label'));
      $inputLabel->setLabel(
        $this->view->i18n->l('Label', 'wbf.label'),
        $this->entity->required('label')
      );

      $inputLabel->refresh = $this->refresh;
      $inputLabel->serializeElement = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );

  }//end public function input_label */

 /**
  * create the ui element for field id_ref_listing
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_id_ref_listing($params)
  {
    if (!BuizCore::classExists('BuizSecurityLevel_Selectbox')) {
      if (DEBUG)
        Debug::console('BuizSecurityLevel_Selectbox not exists');

      Log::warn('Looks like Selectbox: BuizSecurityLevel_Selectbox is missing');

      return;
    }

      //p: Selectbox
      $inputIdRefListing = $this->view->newItem('input'.$this->prefix.'IdRefListing' , 'BuizSecurityLevel_Selectbox');
      $this->items['id_ref_listing'] = $inputIdRefListing;
      $inputIdRefListing->addAttributes
      (
        array
        (
          'name' => $this->keyName.'[id_ref_listing]',
          'id' => 'wgt-input-'.$this->keyName.'_id_ref_listing'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title' => $this->view->i18n->l('Insert value for Ref Listing (Security Area)', 'wbf.label'),
        )
      );
      $inputIdRefListing->setWidth('medium');
      $inputIdRefListing->labelSize = 'small';

      if ($this->assignedForm)
        $inputIdRefListing->assignedForm = $this->assignedForm;

      $inputIdRefListing->setActive($this->entity->getData('id_ref_listing'));
      $inputIdRefListing->setReadOnly($this->isReadOnly('id_ref_listing'));
      $inputIdRefListing->setLabel
      (
        $this->view->i18n->l('Ref Listing', 'wbf.label'),
        $this->entity->required('id_ref_listing')
      );

      /* @var $acl LibAclAdapter_Db */
      $acl = $this->getAcl();

      if ($acl->access('mod-buiz>mod-buiz-cat-core_data:insert')) {
        $inputIdRefListing->refresh = $this->refresh;
        $inputIdRefListing->serializeElement = $this->sendElement;
        $inputIdRefListing->editUrl = 'index.php?c=Buiz.SecurityLevel.listing&amp;target='.$this->namespace.'&amp;field=id_ref_listing&amp;publish=selectbox&amp;suffix='.$this->suffix.'&amp;input_id=wgt-input-'.$this->keyName.'_id_ref_listing'.$this->suffix;
      }
      // set an empty first entry
      $inputIdRefListing->setFirstFree('No Ref Listing selected');

      $queryIdRefListing = $this->db->newQuery('BuizSecurityLevel_Selectbox');
      $queryIdRefListing->fetchSelectbox();
      $inputIdRefListing->setData($queryIdRefListing->getAll());

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );

  }//end public function input_id_ref_listing */

 /**
  * create the ui element for field id_ref_access
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_id_ref_access($params)
  {
    if (!BuizCore::classExists('BuizSecurityLevel_Selectbox')) {
      if (DEBUG)
        Debug::console('BuizSecurityLevel_Selectbox not exists');

      Log::warn('Looks like Selectbox: BuizSecurityLevel_Selectbox is missing');

      return;
    }

      //p: Selectbox
      $inputIdRefAccess = $this->view->newItem('input'.$this->prefix.'IdRefAccess' , 'BuizSecurityLevel_Selectbox');
      $this->items['id_ref_access'] = $inputIdRefAccess;
      $inputIdRefAccess->addAttributes
      (
        array
        (
          'name' => $this->keyName.'[id_ref_access]',
          'id' => 'wgt-input-'.$this->keyName.'_id_ref_access'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title' => $this->view->i18n->l('Insert value for Ref Access (Security Area)', 'wbf.label'),
        )
      );
      $inputIdRefAccess->setWidth('medium');
      $inputIdRefAccess->labelSize = 'small';

      if ($this->assignedForm)
        $inputIdRefAccess->assignedForm = $this->assignedForm;

      $inputIdRefAccess->setActive($this->entity->getData('id_ref_access'));
      $inputIdRefAccess->setReadOnly($this->isReadOnly('id_ref_access'));
      $inputIdRefAccess->setLabel
      (
        $this->view->i18n->l('Ref Access', 'wbf.label'),
        $this->entity->required('id_ref_access')
      );

      /* @var $acl LibAclAdapter_Db */
      $acl = $this->getAcl();

      if ($acl->access('mod-buiz>mod-buiz-cat-core_data:insert')) {
        $inputIdRefAccess->refresh = $this->refresh;
        $inputIdRefAccess->serializeElement = $this->sendElement;
        $inputIdRefAccess->editUrl = 'index.php?c=Buiz.SecurityLevel.listing&amp;target='.$this->namespace.'&amp;field=id_ref_access&amp;publish=selectbox&amp;suffix='.$this->suffix.'&amp;input_id=wgt-input-'.$this->keyName.'_id_ref_access'.$this->suffix;
      }
      // set an empty first entry
      $inputIdRefAccess->setFirstFree('No Ref Access selected');

      $queryIdRefAccess = $this->db->newQuery('BuizSecurityLevel_Selectbox');
      $queryIdRefAccess->fetchSelectbox();
      $inputIdRefAccess->setData($queryIdRefAccess->getAll());

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );

  }//end public function input_id_ref_access */

 /**
  * create the ui element for field id_ref_insert
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_id_ref_insert($params)
  {
    if (!BuizCore::classExists('BuizSecurityLevel_Selectbox')) {
      if (DEBUG)
        Debug::console('BuizSecurityLevel_Selectbox not exists');

      Log::warn('Looks like Selectbox: BuizSecurityLevel_Selectbox is missing');

      return;
    }

      //p: Selectbox
      $inputIdRefInsert = $this->view->newItem('input'.$this->prefix.'IdRefInsert' , 'BuizSecurityLevel_Selectbox');
      $this->items['id_ref_insert'] = $inputIdRefInsert;
      $inputIdRefInsert->addAttributes
      (
        array
        (
          'name' => $this->keyName.'[id_ref_insert]',
          'id' => 'wgt-input-'.$this->keyName.'_id_ref_insert'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title' => $this->view->i18n->l('Insert value for Ref Insert (Security Area)', 'wbf.label'),
        )
      );
      $inputIdRefInsert->setWidth('medium');
      $inputIdRefInsert->labelSize = 'small';

      if ($this->assignedForm)
        $inputIdRefInsert->assignedForm = $this->assignedForm;

      $inputIdRefInsert->setActive($this->entity->getData('id_ref_insert'));
      $inputIdRefInsert->setReadOnly($this->isReadOnly('id_ref_insert'));
      $inputIdRefInsert->setLabel
      (
        $this->view->i18n->l('Ref Insert', 'wbf.label'),
        $this->entity->required('id_ref_insert')
      );

      /* @var $acl LibAclAdapter_Db */
      $acl = $this->getAcl();

      if ($acl->access('mod-buiz>mod-buiz-cat-core_data:insert')) {
        $inputIdRefInsert->refresh = $this->refresh;
        $inputIdRefInsert->serializeElement = $this->sendElement;
        $inputIdRefInsert->editUrl = 'index.php?c=Buiz.SecurityLevel.listing&amp;target='.$this->namespace.'&amp;field=id_ref_insert&amp;publish=selectbox&amp;suffix='.$this->suffix.'&amp;input_id=wgt-input-'.$this->keyName.'_id_ref_insert'.$this->suffix;
      }
      // set an empty first entry
      $inputIdRefInsert->setFirstFree('No Ref Insert selected');

      $queryIdRefInsert = $this->db->newQuery('BuizSecurityLevel_Selectbox');
      $queryIdRefInsert->fetchSelectbox();
      $inputIdRefInsert->setData($queryIdRefInsert->getAll());

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );

  }//end public function input_id_ref_insert */

 /**
  * create the ui element for field id_ref_update
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_id_ref_update($params)
  {
    if (!BuizCore::classExists('BuizSecurityLevel_Selectbox')) {
      if (DEBUG)
        Debug::console('BuizSecurityLevel_Selectbox not exists');

      Log::warn('Looks like Selectbox: BuizSecurityLevel_Selectbox is missing');

      return;
    }

      //p: Selectbox
      $inputIdRefUpdate = $this->view->newItem('input'.$this->prefix.'IdRefUpdate' , 'BuizSecurityLevel_Selectbox');
      $this->items['id_ref_update'] = $inputIdRefUpdate;
      $inputIdRefUpdate->addAttributes
      (
        array
        (
          'name' => $this->keyName.'[id_ref_update]',
          'id' => 'wgt-input-'.$this->keyName.'_id_ref_update'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title' => $this->view->i18n->l('Insert value for Ref Update (Security Area)', 'wbf.label'),
        )
      );
      $inputIdRefUpdate->setWidth('medium');
      $inputIdRefUpdate->labelSize = 'small';

      if ($this->assignedForm)
        $inputIdRefUpdate->assignedForm = $this->assignedForm;

      $inputIdRefUpdate->setActive($this->entity->getData('id_ref_update'));
      $inputIdRefUpdate->setReadOnly($this->isReadOnly('id_ref_update'));
      $inputIdRefUpdate->setLabel
      (
        $this->view->i18n->l('Ref Update', 'wbf.label'),
        $this->entity->required('id_ref_update')
      );

      /* @var $acl LibAclAdapter_Db */
      $acl = $this->getAcl();

      if ($acl->access('mod-buiz>mod-buiz-cat-core_data:insert')) {
        $inputIdRefUpdate->refresh = $this->refresh;
        $inputIdRefUpdate->serializeElement = $this->sendElement;
        $inputIdRefUpdate->editUrl = 'index.php?c=Buiz.SecurityLevel.listing&amp;target='.$this->namespace.'&amp;field=id_ref_update&amp;publish=selectbox&amp;suffix='.$this->suffix.'&amp;input_id=wgt-input-'.$this->keyName.'_id_ref_update'.$this->suffix;
      }
      // set an empty first entry
      $inputIdRefUpdate->setFirstFree('No Ref Update selected');

      $queryIdRefUpdate = $this->db->newQuery('BuizSecurityLevel_Selectbox');
      $queryIdRefUpdate->fetchSelectbox();
      $inputIdRefUpdate->setData($queryIdRefUpdate->getAll());

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );

  }//end public function input_id_ref_update */

 /**
  * create the ui element for field id_ref_delete
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_id_ref_delete($params)
  {
    if (!BuizCore::classExists('BuizSecurityLevel_Selectbox')) {
      if (DEBUG)
        Debug::console('BuizSecurityLevel_Selectbox not exists');

      Log::warn('Looks like Selectbox: BuizSecurityLevel_Selectbox is missing');

      return;
    }

      //p: Selectbox
      $inputIdRefDelete = $this->view->newItem('input'.$this->prefix.'IdRefDelete' , 'BuizSecurityLevel_Selectbox');
      $this->items['id_ref_delete'] = $inputIdRefDelete;
      $inputIdRefDelete->addAttributes
      (
        array
        (
          'name' => $this->keyName.'[id_ref_delete]',
          'id' => 'wgt-input-'.$this->keyName.'_id_ref_delete'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title' => $this->view->i18n->l('Insert value for Ref Delete (Security Area)', 'wbf.label'),
        )
      );
      $inputIdRefDelete->setWidth('medium');
      $inputIdRefDelete->labelSize = 'small';

      if ($this->assignedForm)
        $inputIdRefDelete->assignedForm = $this->assignedForm;

      $inputIdRefDelete->setActive($this->entity->getData('id_ref_delete'));
      $inputIdRefDelete->setReadOnly($this->isReadOnly('id_ref_delete'));
      $inputIdRefDelete->setLabel
      (
        $this->view->i18n->l('Ref Delete', 'wbf.label'),
        $this->entity->required('id_ref_delete')
      );

      /* @var $acl LibAclAdapter_Db */
      $acl = $this->getAcl();

      if ($acl->access('mod-buiz>mod-buiz-cat-core_data:insert')) {
        $inputIdRefDelete->refresh = $this->refresh;
        $inputIdRefDelete->serializeElement = $this->sendElement;
        $inputIdRefDelete->editUrl = 'index.php?c=Buiz.SecurityLevel.listing&amp;target='.$this->namespace.'&amp;field=id_ref_delete&amp;publish=selectbox&amp;suffix='.$this->suffix.'&amp;input_id=wgt-input-'.$this->keyName.'_id_ref_delete'.$this->suffix;
      }
      // set an empty first entry
      $inputIdRefDelete->setFirstFree('No Ref Delete selected');

      $queryIdRefDelete = $this->db->newQuery('BuizSecurityLevel_Selectbox');
      $queryIdRefDelete->fetchSelectbox();
      $inputIdRefDelete->setData($queryIdRefDelete->getAll());

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );

  }//end public function input_id_ref_delete */

 /**
  * create the ui element for field id_ref_admin
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_id_ref_admin($params)
  {
    if (!BuizCore::classExists('BuizSecurityLevel_Selectbox')) {
      if (DEBUG)
        Debug::console('BuizSecurityLevel_Selectbox not exists');

      Log::warn('Looks like Selectbox: BuizSecurityLevel_Selectbox is missing');

      return;
    }

      //p: Selectbox
      $inputIdRefAdmin = $this->view->newItem('input'.$this->prefix.'IdRefAdmin' , 'BuizSecurityLevel_Selectbox');
      $this->items['id_ref_admin'] = $inputIdRefAdmin;
      $inputIdRefAdmin->addAttributes
      (
        array
        (
          'name' => $this->keyName.'[id_ref_admin]',
          'id' => 'wgt-input-'.$this->keyName.'_id_ref_admin'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title' => $this->view->i18n->l('Insert value for Ref Admin (Security Area)', 'wbf.label'),
        )
      );
      $inputIdRefAdmin->setWidth('medium');
      $inputIdRefAdmin->labelSize = 'small';

      if ($this->assignedForm)
        $inputIdRefAdmin->assignedForm = $this->assignedForm;

      $inputIdRefAdmin->setActive($this->entity->getData('id_ref_admin'));
      $inputIdRefAdmin->setReadOnly($this->isReadOnly('id_ref_admin'));
      $inputIdRefAdmin->setLabel
      (
        $this->view->i18n->l('Ref Admin', 'wbf.label'),
        $this->entity->required('id_ref_admin')
      );

      /* @var $acl LibAclAdapter_Db */
      $acl = $this->getAcl();

      if ($acl->access('mod-buiz>mod-buiz-cat-core_data:insert')) {
        $inputIdRefAdmin->refresh = $this->refresh;
        $inputIdRefAdmin->serializeElement = $this->sendElement;
        $inputIdRefAdmin->editUrl = 'index.php?c=Buiz.SecurityLevel.listing&amp;target='.$this->namespace.'&amp;field=id_ref_admin&amp;publish=selectbox&amp;suffix='.$this->suffix.'&amp;input_id=wgt-input-'.$this->keyName.'_id_ref_admin'.$this->suffix;
      }
      // set an empty first entry
      $inputIdRefAdmin->setFirstFree('No Ref Admin selected');

      $queryIdRefAdmin = $this->db->newQuery('BuizSecurityLevel_Selectbox');
      $queryIdRefAdmin->fetchSelectbox();
      $inputIdRefAdmin->setData($queryIdRefAdmin->getAll());

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );

  }//end public function input_id_ref_admin */

 /**
  * create the ui element for field id_level_listing
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_id_level_listing($params)
  {
    if (!BuizCore::classExists('BuizSecurityLevel_Selectbox')) {
      if (DEBUG)
        Debug::console('BuizSecurityLevel_Selectbox not exists');

      Log::warn('Looks like Selectbox: BuizSecurityLevel_Selectbox is missing');

      return;
    }

      //p: Selectbox
      $inputIdLevelListing = $this->view->newItem('input'.$this->prefix.'IdLevelListing' , 'BuizSecurityLevel_Selectbox');
      $this->items['id_level_listing'] = $inputIdLevelListing;
      $inputIdLevelListing->addAttributes
      (
        array
        (
          'name' => $this->keyName.'[id_level_listing]',
          'id' => 'wgt-input-'.$this->keyName.'_id_level_listing'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title' => $this->view->i18n->l('Insert value for Level Listing (Security Area)', 'wbf.label'),
        )
      );
      $inputIdLevelListing->setWidth('medium');
      $inputIdLevelListing->labelSize = 'small';

      if ($this->assignedForm)
        $inputIdLevelListing->assignedForm = $this->assignedForm;

      $inputIdLevelListing->setActive($this->entity->getData('id_level_listing'));
      $inputIdLevelListing->setReadOnly($this->isReadOnly('id_level_listing'));
      $inputIdLevelListing->setLabel
      (
        $this->view->i18n->l('Listing', 'wbf.label'),
        $this->entity->required('id_level_listing')
      );

      /* @var $acl LibAclAdapter_Db */
      $acl = $this->getAcl();

      if ($acl->access('mod-buiz>mod-buiz-cat-core_data:insert')) {
        $inputIdLevelListing->refresh = $this->refresh;
        $inputIdLevelListing->serializeElement = $this->sendElement;
        $inputIdLevelListing->editUrl = 'index.php?c=Buiz.SecurityLevel.listing&amp;target='.$this->namespace.'&amp;field=id_level_listing&amp;publish=selectbox&amp;suffix='.$this->suffix.'&amp;input_id=wgt-input-'.$this->keyName.'_id_level_listing'.$this->suffix;
      }
      // set an empty first entry
      $inputIdLevelListing->setFirstFree('No Listing selected');

      $queryIdLevelListing = $this->db->newQuery('BuizSecurityLevel_Selectbox');
      $queryIdLevelListing->fetchSelectbox();
      $inputIdLevelListing->setData($queryIdLevelListing->getAll());

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );

  }//end public function input_id_level_listing */

 /**
  * create the ui element for field id_level_access
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_id_level_access($params)
  {
    if (!BuizCore::classExists('BuizSecurityLevel_Selectbox')) {
      if (DEBUG)
        Debug::console('BuizSecurityLevel_Selectbox not exists');

      Log::warn('Looks like Selectbox: BuizSecurityLevel_Selectbox is missing');

      return;
    }

      //p: Selectbox
      $inputIdLevelAccess = $this->view->newItem('input'.$this->prefix.'IdLevelAccess' , 'BuizSecurityLevel_Selectbox');
      $this->items['id_level_access'] = $inputIdLevelAccess;
      $inputIdLevelAccess->addAttributes
      (
        array
        (
          'name' => $this->keyName.'[id_level_access]',
          'id' => 'wgt-input-'.$this->keyName.'_id_level_access'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title' => $this->view->i18n->l('Insert value for Level Access (Security Area)', 'wbf.label'),
        )
      );
      $inputIdLevelAccess->setWidth('medium');
      $inputIdLevelAccess->labelSize = 'small';

      if ($this->assignedForm)
        $inputIdLevelAccess->assignedForm = $this->assignedForm;

      $inputIdLevelAccess->setActive($this->entity->getData('id_level_access'));
      $inputIdLevelAccess->setReadOnly($this->isReadOnly('id_level_access'));
      $inputIdLevelAccess->setLabel
      (
        $this->view->i18n->l('Access', 'wbf.label'),
        $this->entity->required('id_level_access')
      );

      /* @var $acl LibAclAdapter_Db */
      $acl = $this->getAcl();

      if ($acl->access('mod-buiz>mod-buiz-cat-core_data:insert')) {
        $inputIdLevelAccess->refresh = $this->refresh;
        $inputIdLevelAccess->serializeElement = $this->sendElement;
        $inputIdLevelAccess->editUrl = 'index.php?c=Buiz.SecurityLevel.listing&amp;target='.$this->namespace.'&amp;field=id_level_access&amp;publish=selectbox&amp;suffix='.$this->suffix.'&amp;input_id=wgt-input-'.$this->keyName.'_id_level_access'.$this->suffix;
      }
      // set an empty first entry
      $inputIdLevelAccess->setFirstFree('No Level Access selected');

      $queryIdLevelAccess = $this->db->newQuery('BuizSecurityLevel_Selectbox');
      $queryIdLevelAccess->fetchSelectbox();
      $inputIdLevelAccess->setData($queryIdLevelAccess->getAll());

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );

  }//end public function input_id_level_access */

 /**
  * create the ui element for field id_level_insert
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_id_level_insert($params)
  {
    if (!BuizCore::classExists('BuizSecurityLevel_Selectbox')) {
      if (DEBUG)
        Debug::console('BuizSecurityLevel_Selectbox not exists');

      Log::warn('Looks like Selectbox: BuizSecurityLevel_Selectbox is missing');

      return;
    }

      //p: Selectbox
      $inputIdLevelInsert = $this->view->newItem('input'.$this->prefix.'IdLevelInsert' , 'BuizSecurityLevel_Selectbox');
      $this->items['id_level_insert'] = $inputIdLevelInsert;
      $inputIdLevelInsert->addAttributes
      (
        array
        (
          'name' => $this->keyName.'[id_level_insert]',
          'id' => 'wgt-input-'.$this->keyName.'_id_level_insert'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title' => $this->view->i18n->l('Insert value for Level Insert (Security Area)', 'wbf.label'),
        )
      );
      $inputIdLevelInsert->setWidth('medium');
      $inputIdLevelInsert->labelSize = 'small';

      if ($this->assignedForm)
        $inputIdLevelInsert->assignedForm = $this->assignedForm;

      $inputIdLevelInsert->setActive($this->entity->getData('id_level_insert'));
      $inputIdLevelInsert->setReadOnly($this->isReadOnly('id_level_insert'));
      $inputIdLevelInsert->setLabel
      (
        $this->view->i18n->l('Insert', 'wbf.label'),
        $this->entity->required('id_level_insert')
      );

      /* @var $acl LibAclAdapter_Db */
      $acl = $this->getAcl();

      if ($acl->access('mod-buiz>mod-buiz-cat-core_data:insert')) {
        $inputIdLevelInsert->refresh = $this->refresh;
        $inputIdLevelInsert->serializeElement = $this->sendElement;
        $inputIdLevelInsert->editUrl = 'index.php?c=Buiz.SecurityLevel.listing&amp;target='.$this->namespace.'&amp;field=id_level_insert&amp;publish=selectbox&amp;suffix='.$this->suffix.'&amp;input_id=wgt-input-'.$this->keyName.'_id_level_insert'.$this->suffix;
      }
      // set an empty first entry
      $inputIdLevelInsert->setFirstFree('No Level Insert selected');

      $queryIdLevelInsert = $this->db->newQuery('BuizSecurityLevel_Selectbox');
      $queryIdLevelInsert->fetchSelectbox();
      $inputIdLevelInsert->setData($queryIdLevelInsert->getAll());

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );

  }//end public function input_id_level_insert */

 /**
  * create the ui element for field id_level_update
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_id_level_update($params)
  {
    if (!BuizCore::classExists('BuizSecurityLevel_Selectbox')) {
      if (DEBUG)
        Debug::console('BuizSecurityLevel_Selectbox not exists');

      Log::warn('Looks like Selectbox: BuizSecurityLevel_Selectbox is missing');

      return;
    }

      //p: Selectbox
      $inputIdLevelUpdate = $this->view->newItem('input'.$this->prefix.'IdLevelUpdate' , 'BuizSecurityLevel_Selectbox');
      $this->items['id_level_update'] = $inputIdLevelUpdate;
      $inputIdLevelUpdate->addAttributes
      (
        array
        (
          'name' => $this->keyName.'[id_level_update]',
          'id' => 'wgt-input-'.$this->keyName.'_id_level_update'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title' => $this->view->i18n->l('Insert value for Level Update (Security Area)', 'wbf.label'),
        )
      );
      $inputIdLevelUpdate->setWidth('medium');
      $inputIdLevelUpdate->labelSize = 'small';

      if ($this->assignedForm)
        $inputIdLevelUpdate->assignedForm = $this->assignedForm;

      $inputIdLevelUpdate->setActive($this->entity->getData('id_level_update'));
      $inputIdLevelUpdate->setReadOnly($this->isReadOnly('id_level_update'));
      $inputIdLevelUpdate->setLabel
      (
        $this->view->i18n->l('Update', 'wbf.label'),
        $this->entity->required('id_level_update')
      );

      /* @var $acl LibAclAdapter_Db */
      $acl = $this->getAcl();

      if ($acl->access('mod-buiz>mod-buiz-cat-core_data:insert')) {
        $inputIdLevelUpdate->refresh = $this->refresh;
        $inputIdLevelUpdate->serializeElement = $this->sendElement;
        $inputIdLevelUpdate->editUrl = 'index.php?c=Buiz.SecurityLevel.listing&amp;target='.$this->namespace.'&amp;field=id_level_update&amp;publish=selectbox&amp;suffix='.$this->suffix.'&amp;input_id=wgt-input-'.$this->keyName.'_id_level_update'.$this->suffix;
      }
      // set an empty first entry
      $inputIdLevelUpdate->setFirstFree('No Level Update selected');

      $queryIdLevelUpdate = $this->db->newQuery('BuizSecurityLevel_Selectbox');
      $queryIdLevelUpdate->fetchSelectbox();
      $inputIdLevelUpdate->setData($queryIdLevelUpdate->getAll());

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );

  }//end public function input_id_level_update */

 /**
  * create the ui element for field id_level_delete
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_id_level_delete($params)
  {
    if (!BuizCore::classExists('BuizSecurityLevel_Selectbox')) {
      if (DEBUG)
        Debug::console('BuizSecurityLevel_Selectbox not exists');

      Log::warn('Looks like Selectbox: BuizSecurityLevel_Selectbox is missing');

      return;
    }

      //p: Selectbox
      $inputIdLevelDelete = $this->view->newItem('input'.$this->prefix.'IdLevelDelete' , 'BuizSecurityLevel_Selectbox');
      $this->items['id_level_delete'] = $inputIdLevelDelete;
      $inputIdLevelDelete->addAttributes
      (
        array
        (
          'name' => $this->keyName.'[id_level_delete]',
          'id' => 'wgt-input-'.$this->keyName.'_id_level_delete'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title' => $this->view->i18n->l('Insert value for Level Delete (Security Area)', 'wbf.label'),
        )
      );
      $inputIdLevelDelete->setWidth('medium');
      $inputIdLevelDelete->labelSize = 'small';

      if ($this->assignedForm)
        $inputIdLevelDelete->assignedForm = $this->assignedForm;

      $inputIdLevelDelete->setActive($this->entity->getData('id_level_delete'));
      $inputIdLevelDelete->setReadOnly($this->isReadOnly('id_level_delete'));
      $inputIdLevelDelete->setLabel
      (
        $this->view->i18n->l('Delete', 'wbf.label'),
        $this->entity->required('id_level_delete')
      );

      /* @var $acl LibAclAdapter_Db */
      $acl = $this->getAcl();

      if ($acl->access('mod-buiz>mod-buiz-cat-core_data:insert')) {
        $inputIdLevelDelete->refresh = $this->refresh;
        $inputIdLevelDelete->serializeElement = $this->sendElement;
        $inputIdLevelDelete->editUrl = 'index.php?c=Buiz.SecurityLevel.listing&amp;target='.$this->namespace.'&amp;field=id_level_delete&amp;publish=selectbox&amp;suffix='.$this->suffix.'&amp;input_id=wgt-input-'.$this->keyName.'_id_level_delete'.$this->suffix;
      }
      // set an empty first entry
      $inputIdLevelDelete->setFirstFree('No Level Delete selected');

      $queryIdLevelDelete = $this->db->newQuery('BuizSecurityLevel_Selectbox');
      $queryIdLevelDelete->fetchSelectbox();
      $inputIdLevelDelete->setData($queryIdLevelDelete->getAll());

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );

  }//end public function input_id_level_delete */

 /**
  * create the ui element for field id_level_admin
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_id_level_admin($params)
  {
    if (!BuizCore::classExists('BuizSecurityLevel_Selectbox')) {
      if (DEBUG)
        Debug::console('BuizSecurityLevel_Selectbox not exists');

      Log::warn('Looks like Selectbox: BuizSecurityLevel_Selectbox is missing');

      return;
    }

      //p: Selectbox
      $inputIdLevelAdmin = $this->view->newItem('input'.$this->prefix.'IdLevelAdmin' , 'BuizSecurityLevel_Selectbox');
      $this->items['id_level_admin'] = $inputIdLevelAdmin;
      $inputIdLevelAdmin->addAttributes
      (
        array
        (
          'name' => $this->keyName.'[id_level_admin]',
          'id' => 'wgt-input-'.$this->keyName.'_id_level_admin'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title' => $this->view->i18n->l('Insert value for Level Admin (Security Area)', 'wbf.label'),
        )
      );
      $inputIdLevelAdmin->setWidth('medium');
      $inputIdLevelAdmin->labelSize = 'small';

      if ($this->assignedForm)
        $inputIdLevelAdmin->assignedForm = $this->assignedForm;

      $inputIdLevelAdmin->setActive($this->entity->getData('id_level_admin'));
      $inputIdLevelAdmin->setReadOnly($this->isReadOnly('id_level_admin'));
      $inputIdLevelAdmin->setLabel
      (
        $this->view->i18n->l('Admin', 'wbf.label'),
        $this->entity->required('id_level_admin')
      );

      /* @var $acl LibAclAdapter_Db */
      $acl = $this->getAcl();

      if ($acl->access('mod-buiz>mod-buiz-cat-core_data:insert')) {
        $inputIdLevelAdmin->refresh = $this->refresh;
        $inputIdLevelAdmin->serializeElement = $this->sendElement;
        $inputIdLevelAdmin->editUrl = 'index.php?c=Buiz.SecurityLevel.listing&amp;target='.$this->namespace.'&amp;field=id_level_admin&amp;publish=selectbox&amp;suffix='.$this->suffix.'&amp;input_id=wgt-input-'.$this->keyName.'_id_level_admin'.$this->suffix;
      }
      // set an empty first entry
      $inputIdLevelAdmin->setFirstFree('No Level Admin selected');

      $queryIdLevelAdmin = $this->db->newQuery('BuizSecurityLevel_Selectbox');
      $queryIdLevelAdmin->fetchSelectbox();
      $inputIdLevelAdmin->setData($queryIdLevelAdmin->getAll());

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );

  }//end public function input_id_level_admin */

 /**
  * create the ui element for field vid
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_vid($params)
  {

      //tpl: class ui:hidden
      $inputVid = $this->view->newInput('input'.$this->prefix.'Vid', 'Hidden');
      $this->items['vid'] = $inputVid;
      $inputVid->addAttributes
      (
        array
        (
          'name' => $this->keyName.'[vid]',
          'id' => 'wgt-input-'.$this->keyName.'_vid'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title' => $this->view->i18n->l('Insert value for VID (Security Area)', 'wbf.label'),
          'maxlength' => $this->entity->maxSize('vid'),
        )
      );
      $inputVid->setWidth('medium');

      $inputVid->setReadOnly($this->isReadOnly('vid'));
      $inputVid->setData($this->entity->getSecure('vid'));
      $inputVid->refresh = $this->refresh;
      $inputVid->serializeElement = $this->sendElement;

  }//end public function input_vid */

 /**
  * create the ui element for field id_target
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_id_target($params)
  {

    if (!BuizCore::classExists('BuizSecurityArea_Entity')) {
      if (DEBUG)
        Debug::console('Entity BuizSecurityArea not exists');

      Log::warn('Looks like the Entity: BuizSecurityArea is missing');

      return;
    }

      //p: Window
      $objidBuizSecurityArea = $this->entity->getData('id_target') ;

      // entity ids can never be 0 so thats ok
      if
      (
        !$objidBuizSecurityArea
          || !$entityBuizSecurityArea = $this->db->orm->get
          (
            'BuizSecurityArea',
            $objidBuizSecurityArea
          )
      )
      {
        $entityBuizSecurityArea = $this->db->orm->newEntity('BuizSecurityArea');
      }

      $inputIdTarget = $this->view->newInput('input'.$this->prefix.'IdTarget', 'Window');
      $inputIdTarget->addAttributes(array
      (
        'readonly' => 'readonly',
        'name' => $this->keyName.'[id_target]',
        'id' => 'wgt-input-'.$this->keyName.'_id_target'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
        'title' => $this->view->i18n->l('Insert value for Target (Security Area)', 'wbf.label'),
      ));

      if ($this->assignedForm)
        $inputIdTarget->assignedForm = $this->assignedForm;

      $inputIdTarget->setWidth('medium');

      $inputIdTarget->setData($this->entity->getData('id_target')  );
      $inputIdTarget->setReadOnly($this->isReadOnly('id_target'));
      $inputIdTarget->setLabel($this->view->i18n->l('Target', 'wbf.label'));

      $listUrl = 'modal.php?c=Buiz.SecurityArea.selection'
        .'&amp;suffix='.$this->suffix.'&amp;input='.$this->keyName.'_id_target'.($this->suffix?'-'.$this->suffix:'');

      $inputIdTarget->setListUrl ($listUrl);
      $inputIdTarget->setListIcon('fa fa-link');
      $inputIdTarget->setEntityUrl('maintab.php?c=Buiz.SecurityArea.edit');
      $inputIdTarget->conEntity = $entityBuizSecurityArea;
      $inputIdTarget->refresh = $this->refresh;
      $inputIdTarget->serializeElement = $this->sendElement;

        $inputIdTarget->setAutocomplete
        (
        '{
          "url":"ajax.php?c=Buiz.SecurityArea.autocomplete&amp;key=",
          "type":"entity"
          }'
        );

      $inputIdTarget->view = $this->view;
      $inputIdTarget->buildJavascript('wgt-input-'.$this->keyName.'_id_target'.($this->suffix?'-'.$this->suffix:''));
      $this->view->addJsCode($inputIdTarget);

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );

  }//end public function input_id_target */

 /**
  * create the ui element for field id_type
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_id_type($params)
  {
    if (!BuizCore::classExists('BuizSecurityAreaType_Selectbox')) {
      if (DEBUG)
        Debug::console('BuizSecurityAreaType_Selectbox not exists');

      Log::warn('Looks like Selectbox: BuizSecurityAreaType_Selectbox is missing');

      return;
    }

      //p: Selectbox
      $inputIdType = $this->view->newItem('input'.$this->prefix.'IdType' , 'BuizSecurityAreaType_Selectbox');
      $this->items['id_type'] = $inputIdType;
      $inputIdType->addAttributes
      (
        array
        (
          'name' => $this->keyName.'[id_type]',
          'id' => 'wgt-input-'.$this->keyName.'_id_type'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title' => $this->view->i18n->l('Insert value for Type (Security Area)', 'wbf.label'),
        )
      );
      $inputIdType->setWidth('medium');

      if ($this->assignedForm)
        $inputIdType->assignedForm = $this->assignedForm;

      $inputIdType->setActive($this->entity->getData('id_type'));
      $inputIdType->setReadOnly($this->isReadOnly('id_type'));
      $inputIdType->setLabel
      (
        $this->view->i18n->l('Type', 'wbf.label'),
        $this->entity->required('id_type')
      );

      /* @var $acl LibAclAdapter_Db */
      $acl = $this->getAcl();

      if ($acl->access('mod-buiz>mgmt-buiz_security_area_type:insert')) {
        $inputIdType->refresh = $this->refresh;
        $inputIdType->serializeElement = $this->sendElement;
        $inputIdType->editUrl = 'index.php?c=Buiz.SecurityAreaType.listing&amp;target='.$this->namespace.'&amp;field=id_type&amp;publish=selectbox&amp;suffix='.$this->suffix.'&amp;input_id=wgt-input-'.$this->keyName.'_id_type'.$this->suffix;
      }
      // set an empty first entry
      $inputIdType->setFirstFree('No Type selected');

      $queryIdType = $this->db->newQuery('BuizSecurityAreaType_Selectbox');
      $queryIdType->fetchSelectbox();
      $inputIdType->setData($queryIdType->getAll());

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );

  }//end public function input_id_type */

 /**
  * create the ui element for field access_key
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_access_key($params)
  {

      //tpl: class ui:text
      $inputAccessKey = $this->view->newInput('input'.$this->prefix.'AccessKey' , 'Text');
      $this->items['access_key'] = $inputAccessKey;
      $inputAccessKey->addAttributes
      (
        array
        (
          'name' => $this->keyName.'[access_key]',
          'id' => 'wgt-input-'.$this->keyName.'_access_key'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip valid_required medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title' => $this->view->i18n->l('Insert value for Access Key (Security Area)', 'wbf.label'),
          'maxlength' => $this->entity->maxSize('access_key'),
        )
      );
      $inputAccessKey->setWidth('medium');

      $inputAccessKey->setReadOnly($this->isReadOnly('access_key'));
      $inputAccessKey->setData($this->entity->getSecure('access_key'));
      $inputAccessKey->setLabel
      (
        $this->view->i18n->l('Access Key', 'wbf.label'),
        $this->entity->required('access_key')
      );

      $inputAccessKey->refresh = $this->refresh;
      $inputAccessKey->serializeElement = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );

  }//end public function input_access_key */

 /**
  * create the ui element for field type_key
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_type_key($params)
  {

      //tpl: class ui:text
      $inputTypeKey = $this->view->newInput('input'.$this->prefix.'TypeKey' , 'Text');
      $this->items['type_key'] = $inputTypeKey;
      $inputTypeKey->addAttributes
      (
        array
        (
          'name' => $this->keyName.'[type_key]',
          'id' => 'wgt-input-'.$this->keyName.'_type_key'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title' => $this->view->i18n->l('Insert value for Type key (Security Area)', 'wbf.label'),
          'maxlength' => $this->entity->maxSize('type_key'),
        )
      );
      $inputTypeKey->setWidth('medium');

      $inputTypeKey->setReadOnly($this->isReadOnly('type_key'));
      $inputTypeKey->setData($this->entity->getSecure('type_key'));
      $inputTypeKey->setLabel
      (
        $this->view->i18n->l('Type key', 'wbf.label'),
        $this->entity->required('type_key')
      );

      $inputTypeKey->refresh = $this->refresh;
      $inputTypeKey->serializeElement = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );

  }//end public function input_type_key */

 /**
  * create the ui element for field parent_key
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_parent_key($params)
  {

      //tpl: class ui:text
      $inputParentKey = $this->view->newInput('input'.$this->prefix.'ParentKey' , 'Text');
      $this->items['parent_key'] = $inputParentKey;
      $inputParentKey->addAttributes
      (
        array
        (
          'name' => $this->keyName.'[parent_key]',
          'id' => 'wgt-input-'.$this->keyName.'_parent_key'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title' => $this->view->i18n->l('Insert value for Parent key (Security Area)', 'wbf.label'),
          'maxlength' => $this->entity->maxSize('parent_key'),
        )
      );
      $inputParentKey->setWidth('medium');

      $inputParentKey->setReadOnly($this->isReadOnly('parent_key'));
      $inputParentKey->setData($this->entity->getSecure('parent_key'));
      $inputParentKey->setLabel
      (
        $this->view->i18n->l('Parent key', 'wbf.label'),
        $this->entity->required('parent_key')
      );

      $inputParentKey->refresh = $this->refresh;
      $inputParentKey->serializeElement = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );

  }//end public function input_parent_key */

 /**
  * create the ui element for field source_key
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_source_key($params)
  {

      //tpl: class ui:text
      $inputSourceKey = $this->view->newInput('input'.$this->prefix.'SourceKey' , 'Text');
      $this->items['source_key'] = $inputSourceKey;
      $inputSourceKey->addAttributes
      (
        array
        (
          'name' => $this->keyName.'[source_key]',
          'id' => 'wgt-input-'.$this->keyName.'_source_key'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title' => $this->view->i18n->l('Insert value for Source key (Security Area)', 'wbf.label'),
          'maxlength' => $this->entity->maxSize('source_key'),
        )
      );
      $inputSourceKey->setWidth('medium');

      $inputSourceKey->setReadOnly($this->isReadOnly('source_key'));
      $inputSourceKey->setData($this->entity->getSecure('source_key'));
      $inputSourceKey->setLabel
      (
        $this->view->i18n->l('Source key', 'wbf.label'),
        $this->entity->required('source_key')
      );

      $inputSourceKey->refresh = $this->refresh;
      $inputSourceKey->serializeElement = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );

  }//end public function input_source_key */

 /**
  * create the ui element for field id_source
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_id_source($params)
  {

    if (!BuizCore::classExists('BuizSecurityArea_Entity')) {
      if (DEBUG)
        Debug::console('Entity BuizSecurityArea not exists');

      Log::warn('Looks like the Entity: BuizSecurityArea is missing');

      return;
    }

      //p: Window
      $objidBuizSecurityArea = $this->entity->getData('id_source') ;

      // entity ids can never be 0 so thats ok
      if
      (
        !$objidBuizSecurityArea
          || !$entityBuizSecurityArea = $this->db->orm->get
          (
            'BuizSecurityArea',
            $objidBuizSecurityArea
          )
      )
      {
        $entityBuizSecurityArea = $this->db->orm->newEntity('BuizSecurityArea');
      }

      $inputIdSource = $this->view->newInput('input'.$this->prefix.'IdSource', 'Window');
      $inputIdSource->addAttributes(array
      (
        'readonly' => 'readonly',
        'name' => $this->keyName.'[id_source]',
        'id' => 'wgt-input-'.$this->keyName.'_id_source'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
        'title' => $this->view->i18n->l('Insert value for Source (Security Area)', 'wbf.label'),
      ));

      if ($this->assignedForm)
        $inputIdSource->assignedForm = $this->assignedForm;

      $inputIdSource->setWidth('medium');

      $inputIdSource->setData($this->entity->getData('id_source')  );
      $inputIdSource->setReadOnly($this->isReadOnly('id_source'));
      $inputIdSource->setLabel($this->view->i18n->l('Source', 'wbf.label'));

      $listUrl = 'modal.php?c=Buiz.SecurityArea.selection'
        .'&amp;suffix='.$this->suffix.'&amp;input='.$this->keyName.'_id_source'.($this->suffix?'-'.$this->suffix:'');

      $inputIdSource->setListUrl ($listUrl);
      $inputIdSource->setListIcon('fa fa-link');
      $inputIdSource->setEntityUrl('maintab.php?c=Buiz.SecurityArea.edit');
      $inputIdSource->conEntity = $entityBuizSecurityArea;
      $inputIdSource->refresh = $this->refresh;
      $inputIdSource->serializeElement = $this->sendElement;

        $inputIdSource->setAutocomplete
        (
        '{
          "url":"ajax.php?c=Buiz.SecurityArea.autocomplete&amp;key=",
          "type":"entity"
          }'
        );

      $inputIdSource->view = $this->view;
      $inputIdSource->buildJavascript('wgt-input-'.$this->keyName.'_id_source'.($this->suffix?'-'.$this->suffix:''));
      $this->view->addJsCode($inputIdSource);

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );

  }//end public function input_id_source */

 /**
  * create the ui element for field parent_path
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_parent_path($params)
  {

      //tpl: class ui:text
      $inputParentPath = $this->view->newInput('input'.$this->prefix.'ParentPath' , 'Text');
      $this->items['parent_path'] = $inputParentPath;
      $inputParentPath->addAttributes
      (
        array
        (
          'name' => $this->keyName.'[parent_path]',
          'id' => 'wgt-input-'.$this->keyName.'_parent_path'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title' => $this->view->i18n->l('Insert value for Parent Path (Security Area)', 'wbf.label'),
          'maxlength' => $this->entity->maxSize('parent_path'),
        )
      );
      $inputParentPath->setWidth('medium');

      $inputParentPath->setReadOnly($this->isReadOnly('parent_path'));
      $inputParentPath->setData($this->entity->getSecure('parent_path'));
      $inputParentPath->setLabel
      (
        $this->view->i18n->l('Parent Path', 'wbf.label'),
        $this->entity->required('parent_path')
      );

      $inputParentPath->refresh = $this->refresh;
      $inputParentPath->serializeElement = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );

  }//end public function input_parent_path */

 /**
  * create the ui element for field revision
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_revision($params)
  {

      //tpl: class ui:int
      $inputRevision = $this->view->newInput('input'.$this->prefix.'Revision' , 'Int');
      $this->items['revision'] = $inputRevision;
      $inputRevision->addAttributes
      (
        array
        (
          'name' => $this->keyName.'[revision]',
          'id' => 'wgt-input-'.$this->keyName.'_revision'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title' => $this->view->i18n->l('Insert value for Revision (Security Area)', 'wbf.label'),
        )
      );
      $inputRevision->setWidth('medium');

      $inputRevision->setReadOnly($this->isReadOnly('revision'));
      $inputRevision->setData($this->entity->getData('revision'));
      $inputRevision->setLabel
      (
        $this->view->i18n->l('Revision', 'wbf.label'),
        $this->entity->required('revision')
      );

      $inputRevision->refresh = $this->refresh;
      $inputRevision->serializeElement = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );

  }//end public function input_revision */

 /**
  * create the ui element for field flag_system
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_flag_system($params)
  {

      //tpl: class ui:Checkbox
      $inputFlagSystem = $this->view->newInput('input'.$this->prefix.'FlagSystem' , 'Checkbox');
      $this->items['flag_system'] = $inputFlagSystem;
      $inputFlagSystem->addAttributes
      (
        array
        (
          'name' => $this->keyName.'[flag_system]',
          'id' => 'wgt-input-'.$this->keyName.'_flag_system'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title' => $this->view->i18n->l('Insert value for System (Security Area)', 'wbf.label'),
        )
      );
      $inputFlagSystem->setWidth('medium');

      $inputFlagSystem->setReadOnly($this->isReadOnly('flag_system'));
      $inputFlagSystem->setActive($this->entity->getBoolean('flag_system'));
      $inputFlagSystem->setLabel
      (
        $this->view->i18n->l('System', 'wbf.label'),
        $this->entity->required('flag_system')
      );

      $inputFlagSystem->refresh = $this->refresh;
      $inputFlagSystem->serializeElement = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );

  }//end public function input_flag_system */

 /**
  * create the ui element for field description
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_description($params)
  {

      //p: textarea
      $inputDescription = $this->view->newInput('input'.$this->prefix.'Description', 'Textarea');
      $this->items['description'] = $inputDescription;
      $inputDescription->addAttributes
      (
        array
        (
          'name' => $this->keyName.'[description]',
          'id' => 'wgt-input-'.$this->keyName.'_description'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip full medium-height'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title' => $this->view->i18n->l('Insert value for Description (Security Area)', 'wbf.label'),
        )
      );
      $inputDescription->setWidth('full');

      $inputDescription->full = true;
      $inputDescription->setData($this->entity->getSecure('description'));
      $inputDescription->setReadOnly($this->isReadOnly('description'));
      $inputDescription->setLabel
      (
        $this->view->i18n->l('Description', 'wbf.label'),
        $this->entity->required('description')
      );

      $inputDescription->refresh = $this->refresh;
      $inputDescription->serializeElement = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Description' ,
        true
      );

  }//end public function input_description */

 /**
  * create the ui element for field id_vid_entity
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_id_vid_entity($params)
  {

      //tpl: class ui:hidden
      $inputIdVidEntity = $this->view->newInput('input'.$this->prefix.'IdVidEntity', 'Hidden');
      $this->items['id_vid_entity'] = $inputIdVidEntity;
      $inputIdVidEntity->addAttributes
      (
        array
        (
          'name' => $this->keyName.'[id_vid_entity]',
          'id' => 'wgt-input-'.$this->keyName.'_id_vid_entity'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title' => $this->view->i18n->l('Insert value for Entity (Security Area)', 'wbf.label'),
          'maxlength' => $this->entity->maxSize('id_vid_entity'),
        )
      );
      $inputIdVidEntity->setWidth('medium');

      $inputIdVidEntity->setReadOnly($this->isReadOnly('id_vid_entity'));
      $inputIdVidEntity->setData($this->entity->getSecure('id_vid_entity'));
      $inputIdVidEntity->refresh = $this->refresh;
      $inputIdVidEntity->serializeElement = $this->sendElement;

  }//end public function input_id_vid_entity */

 /**
  * create the ui element for field rowid
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_rowid($params)
  {

      //tpl: class ui: guess
      $inputRowid = $this->view->newInput('input'.$this->prefix.'Rowid' , 'int');
      $this->items['rowid'] = $inputRowid;
      $inputRowid->addAttributes
      (
        array
        (
          'name' => $this->keyName.'[rowid]',
          'id' => 'wgt-input-'.$this->keyName.'_rowid'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip valid_required medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title' => $this->view->i18n->l('Insert value for Rowid (Security Area)', 'wbf.label'),
        )
      );
      $inputRowid->setWidth('medium');

      $inputRowid->setReadOnly($this->isReadOnly('rowid'));
      $inputRowid->setData($this->entity->getId());
      $inputRowid->setLabel
      (
        $this->view->i18n->l('Rowid', 'wbf.label'),
        $this->entity->required('rowid')
      );

      $inputRowid->refresh = $this->refresh;
      $inputRowid->serializeElement = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Meta' ,
        true
      );

  }//end public function input_rowid */

 /**
  * create the ui element for field m_time_created
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_m_time_created($params)
  {

      //tpl: class ui:date
      $inputMTimeCreated = $this->view->newInput('input'.$this->prefix.'MTimeCreated' , 'Date');
      $this->items['m_time_created'] = $inputMTimeCreated;
      $inputMTimeCreated->addAttributes
      (
        array
        (
          'name' => $this->keyName.'[m_time_created]',
          'id' => 'wgt-input-'.$this->keyName.'_m_time_created'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip small'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title' => $this->view->i18n->l('Insert value for Time Created (Security Area)', 'wbf.label'),
          'maxlength' => $this->entity->maxSize('m_time_created'),
        )
      );
      $inputMTimeCreated->setWidth('small');

      $inputMTimeCreated->setReadOnly(true);
      $inputMTimeCreated->setData($this->entity->getDate('m_time_created'));
      $inputMTimeCreated->setLabel
      (
        $this->view->i18n->l('Time Created', 'wbf.label'),
        $this->entity->required('m_time_created')
      );

      $inputMTimeCreated->refresh = $this->refresh;
      $inputMTimeCreated->serializeElement = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Meta' ,
        true
      );

  }//end public function input_m_time_created */

 /**
  * create the ui element for field m_role_created
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_m_role_created($params)
  {

    if (!BuizCore::classExists('BuizRoleUser_Entity')) {
      if (DEBUG)
        Debug::console('Entity BuizRoleUser not exists');

      Log::warn('Looks like the Entity: BuizRoleUser is missing');

      return;
    }

      //p: Window
      $objidBuizRoleUser = $this->entity->getData('m_role_created') ;

      // entity ids can never be 0 so thats ok
      if
      (
        !$objidBuizRoleUser
          || !$entityBuizRoleUser = $this->db->orm->get
          (
            'BuizRoleUser',
            $objidBuizRoleUser
          )
      )
      {
        $entityBuizRoleUser = $this->db->orm->newEntity('BuizRoleUser');
      }

      $inputMRoleCreate = $this->view->newInput('input'.$this->prefix.'MRoleCreate', 'Window');
      $inputMRoleCreate->addAttributes(array
      (
        'readonly' => 'readonly',
        'name' => $this->keyName.'[m_role_created]',
        'id' => 'wgt-input-'.$this->keyName.'_m_role_created'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
        'title' => $this->view->i18n->l('Insert value for Role Create (Security Area)', 'wbf.label'),
      ));

      if ($this->assignedForm)
        $inputMRoleCreate->assignedForm = $this->assignedForm;

      $inputMRoleCreate->setWidth('medium');

      $inputMRoleCreate->setData($this->entity->getData('m_role_created')  );
      $inputMRoleCreate->setReadOnly(true);
      $inputMRoleCreate->setLabel($this->view->i18n->l('Role Create', 'wbf.label'));

      $listUrl = 'modal.php?c=Buiz.RoleUser.selection'
        .'&amp;suffix='.$this->suffix.'&amp;input='.$this->keyName.'_m_role_created'.($this->suffix?'-'.$this->suffix:'');

      $inputMRoleCreate->setListUrl ($listUrl);
      $inputMRoleCreate->setListIcon('fa fa-link');
      $inputMRoleCreate->setEntityUrl('maintab.php?c=Buiz.RoleUser.edit');
      $inputMRoleCreate->conEntity = $entityBuizRoleUser;
      $inputMRoleCreate->refresh = $this->refresh;
      $inputMRoleCreate->serializeElement = $this->sendElement;

        $inputMRoleCreate->setAutocomplete
        (
        '{
          "url":"ajax.php?c=Buiz.RoleUser.autocomplete&amp;key=",
          "type":"entity"
          }'
        );

      $inputMRoleCreate->view = $this->view;
      $inputMRoleCreate->buildJavascript('wgt-input-'.$this->keyName.'_m_role_created'.($this->suffix?'-'.$this->suffix:''));
      $this->view->addJsCode($inputMRoleCreate);

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Meta' ,
        true
      );

  }//end public function input_m_role_created */

 /**
  * create the ui element for field m_time_changed
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_m_time_changed($params)
  {

      //tpl: class ui:date
      $inputMTimeChanged = $this->view->newInput('input'.$this->prefix.'MTimeChanged' , 'Date');
      $this->items['m_time_changed'] = $inputMTimeChanged;
      $inputMTimeChanged->addAttributes
      (
        array
        (
          'name' => $this->keyName.'[m_time_changed]',
          'id' => 'wgt-input-'.$this->keyName.'_m_time_changed'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip small'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title' => $this->view->i18n->l('Insert value for Time Changed (Security Area)', 'wbf.label'),
          'maxlength' => $this->entity->maxSize('m_time_changed'),
        )
      );
      $inputMTimeChanged->setWidth('small');

      $inputMTimeChanged->setReadOnly(true);
      $inputMTimeChanged->setData($this->entity->getDate('m_time_changed'));
      $inputMTimeChanged->setLabel
      (
        $this->view->i18n->l('Time Changed', 'wbf.label'),
        $this->entity->required('m_time_changed')
      );

      $inputMTimeChanged->refresh = $this->refresh;
      $inputMTimeChanged->serializeElement = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Meta' ,
        true
      );

  }//end public function input_m_time_changed */

 /**
  * create the ui element for field m_role_changed
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_m_role_changed($params)
  {

    if (!BuizCore::classExists('BuizRoleUser_Entity')) {
      if (DEBUG)
        Debug::console('Entity BuizRoleUser not exists');

      Log::warn('Looks like the Entity: BuizRoleUser is missing');

      return;
    }

      //p: Window
      $objidBuizRoleUser = $this->entity->getData('m_role_changed') ;

      // entity ids can never be 0 so thats ok
      if
      (
        !$objidBuizRoleUser
          || !$entityBuizRoleUser = $this->db->orm->get
          (
            'BuizRoleUser',
            $objidBuizRoleUser
          )
      )
      {
        $entityBuizRoleUser = $this->db->orm->newEntity('BuizRoleUser');
      }

      $inputMRoleChange = $this->view->newInput('input'.$this->prefix.'MRoleChange', 'Window');
      $inputMRoleChange->addAttributes(array
      (
        'readonly' => 'readonly',
        'name' => $this->keyName.'[m_role_changed]',
        'id' => 'wgt-input-'.$this->keyName.'_m_role_changed'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
        'title' => $this->view->i18n->l('Insert value for Role Change (Security Area)', 'wbf.label'),
      ));

      if ($this->assignedForm)
        $inputMRoleChange->assignedForm = $this->assignedForm;

      $inputMRoleChange->setWidth('medium');

      $inputMRoleChange->setData($this->entity->getData('m_role_changed')  );
      $inputMRoleChange->setReadOnly(true);
      $inputMRoleChange->setLabel($this->view->i18n->l('Role Change', 'wbf.label'));

      $listUrl = 'modal.php?c=Buiz.RoleUser.selection'
        .'&amp;suffix='.$this->suffix.'&amp;input='.$this->keyName.'_m_role_changed'.($this->suffix?'-'.$this->suffix:'');

      $inputMRoleChange->setListUrl ($listUrl);
      $inputMRoleChange->setListIcon('fa fa-link');
      $inputMRoleChange->setEntityUrl('maintab.php?c=Buiz.RoleUser.edit');
      $inputMRoleChange->conEntity = $entityBuizRoleUser;
      $inputMRoleChange->refresh = $this->refresh;
      $inputMRoleChange->serializeElement = $this->sendElement;

        $inputMRoleChange->setAutocomplete
        (
        '{
          "url":"ajax.php?c=Buiz.RoleUser.autocomplete&amp;key=",
          "type":"entity"
          }'
        );

      $inputMRoleChange->view = $this->view;
      $inputMRoleChange->buildJavascript('wgt-input-'.$this->keyName.'_m_role_changed'.($this->suffix?'-'.$this->suffix:''));
      $this->view->addJsCode($inputMRoleChange);

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Meta' ,
        true
      );

  }//end public function input_m_role_changed */

 /**
  * create the ui element for field m_version
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_m_version($params)
  {

      //tpl: class ui: guess
      $inputMVersion = $this->view->newInput('input'.$this->prefix.'MVersion' , 'int');
      $this->items['m_version'] = $inputMVersion;
      $inputMVersion->addAttributes
      (
        array
        (
          'name' => $this->keyName.'[m_version]',
          'id' => 'wgt-input-'.$this->keyName.'_m_version'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip valid_int medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title' => $this->view->i18n->l('Insert value for Version (Security Area)', 'wbf.label'),
        )
      );
      $inputMVersion->setWidth('medium');

      $inputMVersion->setReadOnly(true);
      $inputMVersion->setData($this->entity->getSecure('m_version'));
      $inputMVersion->setLabel
      (
        $this->view->i18n->l('Version', 'wbf.label'),
        $this->entity->required('m_version')
      );

      $inputMVersion->refresh = $this->refresh;
      $inputMVersion->serializeElement = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Meta' ,
        true
      );

  }//end public function input_m_version */

 /**
  * create the ui element for field m_uuid
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_m_uuid($params)
  {

      //tpl: class ui: guess
      $inputMUuid = $this->view->newInput('input'.$this->prefix.'MUuid' , 'Text');
      $this->items['m_uuid'] = $inputMUuid;
      $inputMUuid->addAttributes
      (
        array
        (
          'name' => $this->keyName.'[m_uuid]',
          'id' => 'wgt-input-'.$this->keyName.'_m_uuid'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title' => $this->view->i18n->l('Insert value for Uuid (Security Area)', 'wbf.label'),
        )
      );
      $inputMUuid->setWidth('medium');

      $inputMUuid->setReadOnly(true);
      $inputMUuid->setData($this->entity->getSecure('m_uuid'));
      $inputMUuid->setLabel
      (
        $this->view->i18n->l('Uuid', 'wbf.label'),
        $this->entity->required('m_uuid')
      );

      $inputMUuid->refresh = $this->refresh;
      $inputMUuid->serializeElement = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Meta' ,
        true
      );

  }//end public function input_m_uuid */

/*////////////////////////////////////////////////////////////////////////////*/
// search field methodes
/*////////////////////////////////////////////////////////////////////////////*/

 /**
  * create the search element for field label
  * @param TFlag $params named parameters
  * @return void
  */
  public function search_label($params)
  {

      //tpl: class ui:text
      $inputLabel = $this->view->newInput('input'.$this->prefix.'Label' , 'Text');
      $this->items['label'] = $inputLabel;
      $inputLabel->addAttributes
      (
        array
        (
          'name' => $this->keyName.'[label]',
          'id' => 'wgt-input-'.$this->keyName.'_label'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip medium wcm_req_search wgt-no-save'.($this->assignedForm?' fparam-'.$this->assignedForm:''),
          'title' => $this->view->i18n->l('Search for Label (Security Area)', 'wbf.label'),
          'maxlength' => $this->entity->maxSize('label'),
        )
      );
      $inputLabel->setWidth('medium');

      $inputLabel->setReadOnly($this->isReadOnly('label'));
      $inputLabel->setData($this->entity->getSecure('label'));
      $inputLabel->setLabel
      (
        $this->view->i18n->l('Label', 'wbf.label'),
        $this->entity->required('label')
      );

      $inputLabel->refresh = $this->refresh;
      $inputLabel->serializeElement = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Search_Default' ,
        true
      );

  }//end public function search_label */

 /**
  * create the search element for field id_type
  * @param TFlag $params named parameters
  * @return void
  */
  public function search_id_type($params)
  {

    if (!BuizCore::classExists('BuizSecurityAreaType_Selectbox')) {
      if (DEBUG)
        Debug::console('BuizSecurityAreaType_Selectbox not exists');

      Log::warn('Looks like Selectbox: BuizSecurityAreaType_Selectbox is missing');

      return;
    }

      //p: Selectbox
      $inputIdType = $this->view->newItem('input'.$this->prefix.'IdType' , 'BuizSecurityAreaType_Selectbox');
      $this->items['id_type'] = $inputIdType;
      $inputIdType->addAttributes
      (
        array
        (
          'name' => $this->keyName.'[id_type][]',
          'id' => 'wgt-input-'.$this->keyName.'_id_type'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip medium wcm_req_search wgt-no-save'.($this->assignedForm?' fparam-'.$this->assignedForm:''),
          'title' => $this->view->i18n->l('Search for Type (Security Area)', 'wbf.label'),
          'multiple' => 'multiple',
          'size' => '5',
        )
      );
      $inputIdType->setWidth('medium');

      if ($this->assignedForm)
        $inputIdType->assignedForm = $this->assignedForm;

      $inputIdType->setActive($this->entity->getData('id_type'));
      $inputIdType->setReadOnly($this->isReadOnly('id_type'));
      $inputIdType->setLabel
      (
        $this->view->i18n->l('Type', 'wbf.label'),
        $this->entity->required('id_type')
      );

      // set an empty first entry
      $inputIdType->setFirstFree('No Type selected');

      $queryIdType = $this->db->newQuery('BuizSecurityAreaType_Selectbox');
      $queryIdType->fetchSelectbox();
      $inputIdType->setData($queryIdType->getAll());

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Search_Default' ,
        true
      );

  }//end public function search_id_type */

 /**
  * create the search element for field access_key
  * @param TFlag $params named parameters
  * @return void
  */
  public function search_access_key($params)
  {

      //tpl: class ui:text
      $inputAccessKey = $this->view->newInput('input'.$this->prefix.'AccessKey' , 'Text');
      $this->items['access_key'] = $inputAccessKey;
      $inputAccessKey->addAttributes
      (
        array
        (
          'name' => $this->keyName.'[access_key]',
          'id' => 'wgt-input-'.$this->keyName.'_access_key'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip medium wcm_req_search wgt-no-save'.($this->assignedForm?' fparam-'.$this->assignedForm:''),
          'title' => $this->view->i18n->l('Search for Access Key (Security Area)', 'wbf.label'),
          'maxlength' => $this->entity->maxSize('access_key'),
        )
      );
      $inputAccessKey->setWidth('medium');

      $inputAccessKey->setReadOnly($this->isReadOnly('access_key'));
      $inputAccessKey->setData($this->entity->getSecure('access_key'));
      $inputAccessKey->setLabel
      (
        $this->view->i18n->l('Access Key', 'wbf.label'),
        $this->entity->required('access_key')
      );

      $inputAccessKey->refresh = $this->refresh;
      $inputAccessKey->serializeElement = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Search_Default' ,
        true
      );

  }//end public function search_access_key */

 /**
  * create the search element for field type_key
  * @param TFlag $params named parameters
  * @return void
  */
  public function search_type_key($params)
  {

      //tpl: class ui:text
      $inputTypeKey = $this->view->newInput('input'.$this->prefix.'TypeKey' , 'Text');
      $this->items['type_key'] = $inputTypeKey;
      $inputTypeKey->addAttributes
      (
        array
        (
          'name' => $this->keyName.'[type_key]',
          'id' => 'wgt-input-'.$this->keyName.'_type_key'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip medium wcm_req_search wgt-no-save'.($this->assignedForm?' fparam-'.$this->assignedForm:''),
          'title' => $this->view->i18n->l('Search for Type key (Security Area)', 'wbf.label'),
          'maxlength' => $this->entity->maxSize('type_key'),
        )
      );
      $inputTypeKey->setWidth('medium');

      $inputTypeKey->setReadOnly($this->isReadOnly('type_key'));
      $inputTypeKey->setData($this->entity->getSecure('type_key'));
      $inputTypeKey->setLabel
      (
        $this->view->i18n->l('Type key', 'wbf.label'),
        $this->entity->required('type_key')
      );

      $inputTypeKey->refresh = $this->refresh;
      $inputTypeKey->serializeElement = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Search_Default' ,
        true
      );

  }//end public function search_type_key */

 /**
  * create the search element for field parent_key
  * @param TFlag $params named parameters
  * @return void
  */
  public function search_parent_key($params)
  {

      //tpl: class ui:text
      $inputParentKey = $this->view->newInput('input'.$this->prefix.'ParentKey' , 'Text');
      $this->items['parent_key'] = $inputParentKey;
      $inputParentKey->addAttributes
      (
        array
        (
          'name' => $this->keyName.'[parent_key]',
          'id' => 'wgt-input-'.$this->keyName.'_parent_key'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip medium wcm_req_search wgt-no-save'.($this->assignedForm?' fparam-'.$this->assignedForm:''),
          'title' => $this->view->i18n->l('Search for Parent key (Security Area)', 'wbf.label'),
          'maxlength' => $this->entity->maxSize('parent_key'),
        )
      );
      $inputParentKey->setWidth('medium');

      $inputParentKey->setReadOnly($this->isReadOnly('parent_key'));
      $inputParentKey->setData($this->entity->getSecure('parent_key'));
      $inputParentKey->setLabel
      (
        $this->view->i18n->l('Parent key', 'wbf.label'),
        $this->entity->required('parent_key')
      );

      $inputParentKey->refresh = $this->refresh;
      $inputParentKey->serializeElement = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Search_Default' ,
        true
      );

  }//end public function search_parent_key */

 /**
  * create the search element for field source_key
  * @param TFlag $params named parameters
  * @return void
  */
  public function search_source_key($params)
  {

      //tpl: class ui:text
      $inputSourceKey = $this->view->newInput('input'.$this->prefix.'SourceKey' , 'Text');
      $this->items['source_key'] = $inputSourceKey;
      $inputSourceKey->addAttributes(
        array(
          'name' => $this->keyName.'[source_key]',
          'id' => 'wgt-input-'.$this->keyName.'_source_key'.($this->suffix?'-'.$this->suffix:''),
          'class' => 'wcm wcm_ui_tip medium wcm_req_search wgt-no-save'.($this->assignedForm?' fparam-'.$this->assignedForm:''),
          'title' => $this->view->i18n->l('Search for Source key (Security Area)', 'wbf.label'),
          'maxlength' => $this->entity->maxSize('source_key'),
        )
      );
      $inputSourceKey->setWidth('medium');

      $inputSourceKey->setReadOnly($this->isReadOnly('source_key'));
      $inputSourceKey->setData($this->entity->getSecure('source_key'));
      $inputSourceKey->setLabel(
        $this->view->i18n->l('Source key', 'wbf.label'),
        $this->entity->required('source_key')
      );

      $inputSourceKey->refresh = $this->refresh;
      $inputSourceKey->serializeElement = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Search_Default' ,
        true
      );

  }//end public function search_source_key */

 /**
  * create the ui element for field m_role_created
  * @param TFlag $params named parameters
  * @return void
  */
  public function search_m_role_created($params)
  {
    //tpl: special

    if (!BuizCore::classExists('BuizRoleUser_Entity')) {
      if (DEBUG)
        Debug::console('Class BuizRoleUser_Entity not exists');

      Log::warn('Looks like the Entity: BuizRoleUser_Entity is missing');

      return;
    }

    $entityBuizRoleUser = $this->db->orm->newEntity('BuizRoleUser');

    $inputRole = $this->view->newInput('input'.$this->prefix.'MRoleCreate', 'Window');
    $inputRole->addAttributes(
      array(
        'readonly' => 'readonly',
        'name' => $this->keyName.'[m_role_created]',
        'id' => 'wgt-input-'.$this->keyName.'_m_role_created'.($this->suffix?'-'.$this->suffix:''),
        'class' => 'wcm wcm_req_search medium wgt-no-save '.($this->assignedForm?' fparam-'.$this->assignedForm:''),
        'title' => $this->view->i18n->l('Creator','wbf.label'),
      )
    );
    $inputRole->setWidth('medium');
    $inputRole->setReadOnly($this->readOnly);
    $inputRole->setLabel(
      $this->view->i18n->l('Creator','wbf.label')
    );

    $listUrl = 'modal.php?c=Buiz.RoleUser.selection&amp;target=buiz_security_area_m_role_created';

    $inputRole->setListUrl($listUrl);
    $inputRole->setListIcon('fa fa-link');
    $inputRole->setEntityUrl('maintab.php?c=Buiz.RoleUser.show');
    $inputRole->conEntity = $entityBuizRoleUser;
    $inputRole->refresh = $this->refresh;
    $inputRole->serializeElement = $this->sendElement;

    $inputRole->view = $this->view;
    $inputRole->buildJavascript('wgt-input-'.$this->keyName.'_m_role_created');
    $this->view->addJsCode($inputRole);

    // activate the category
    $this->view->addVar(
      'showCat'.$this->namespace.'_Search_Meta' ,
      true
    );

  }//end public function search_m_role_created */

 /**
  * create the ui element for field m_role_created
  * @param TFlag $params named parameters
  * @return void
  */
  public function search_m_role_changed($params)
  {
    //tpl: special

    if (!BuizCore::classExists('BuizRoleUser_Entity')) {
      if (DEBUG)
        Debug::console('Class BuizRoleUser_Entity not exists');

      Log::warn('Looks like the Entity: BuizRoleUser_Entity is missing');

      return;
    }

    $entityBuizRoleUser = $this->db->orm->newEntity('BuizRoleUser');

    $inputRole = $this->view->newInput('input'.$this->prefix.'MRoleChange', 'Window');
    $inputRole->addAttributes(
      array(
        'readonly' => 'readonly',
        'name' => $this->keyName.'[m_role_changed]',
        'id' => 'wgt-input-'.$this->keyName.'_m_role_changed'.($this->suffix?'-'.$this->suffix:''),
        'class' => 'wcm wcm_req_search medium wgt-no-save '.($this->assignedForm?' fparam-'.$this->assignedForm:''),
        'title' => $this->view->i18n->l('Last Editor','wbf.label'),
      )
    );
    $inputRole->setWidth('medium');
    $inputRole->setReadOnly($this->readOnly);
    $inputRole->setLabel(
      $this->view->i18n->l('Last Editor','wbf.label')
    );

    $listUrl = 'modal.php?c=Buiz.RoleUser.selection&amp;target=buiz_security_area_m_role_changed';

    $inputRole->setListUrl($listUrl);
    $inputRole->setListIcon('fa fa-link');
    $inputRole->setEntityUrl('maintab.php?c=Buiz.RoleUser.show');
    $inputRole->conEntity = $entityBuizRoleUser;
    $inputRole->refresh = $this->refresh;
    $inputRole->serializeElement = $this->sendElement;

    $inputRole->view = $this->view;
    $inputRole->buildJavascript('wgt-input-'.$this->keyName.'_m_role_changed');
    $this->view->addJsCode($inputRole);

    // activate the category
    $this->view->addVar(
      'showCat'.$this->namespace.'_Search_Meta' ,
      true
    );

  }//end public function search_m_role_changed */

 /**
  *
  * @param TFlag $params named parameters
  * @return void
  */
  public function search_m_time_created_before($params)
  {

    //tpl: special
    $inputDate = $this->view->newInput('input'.$this->prefix.'MTimeCreatedBefore' , 'Date');
    $inputDate->addAttributes
    (
      array
      (
        'name' => $this->keyName.'[m_time_created_before]',
        'id' => 'wgt-input-'.$this->keyName.'_m_time_created_before'.($this->suffix?'-'.$this->suffix:''),
        'class' => 'wcm wcm_req_search small wgt-no-save'.($this->assignedForm?' fparam-'.$this->assignedForm:''),
        'title' => $this->view->i18n->l('Changed Before','wbf.label'),
      )
    );
    $inputDate->setWidth('small');

    $inputDate->setReadOnly($this->readOnly);
    $inputDate->setLabel
    (
      $this->view->i18n->l('Created Before','wbf.label')
    );
    $inputDate->refresh = $this->refresh;
    $inputDate->serializeElement = $this->sendElement;

    // activate the category
    $this->view->addVar
    (
      'showCat'.$this->namespace.'_Search_Meta' ,
      true
    );

  }//end public function search_m_time_created_before */

 /**
  *
  * @param TFlag $params named parameters
  * @return void
  */
  public function search_m_time_created_after($params)
  {

    //tpl: special
    $inputDate = $this->view->newInput('input'.$this->prefix.'MTimeCreatedAfter' , 'Date');
    $inputDate->addAttributes
    (
      array
      (
        'name' => $this->keyName.'[m_time_created_after]',
        'id' => 'wgt-input-'.$this->keyName.'_m_time_created_after'.($this->suffix?'-'.$this->suffix:''),
        'class' => 'wcm wcm_req_search small wgt-no-save'.($this->assignedForm?' fparam-'.$this->assignedForm:''),
        'title' => $this->view->i18n->l('Created After','wbf.label'),
      )
    );
    $inputDate->setWidth('small');

    $inputDate->setReadOnly($this->readOnly);
    $inputDate->setLabel
    (
      $this->view->i18n->l('Created After','wbf.label')
    );
    $inputDate->refresh = $this->refresh;
    $inputDate->serializeElement = $this->sendElement;

    // activate the category
    $this->view->addVar
    (
      'showCat'.$this->namespace.'_Search_Meta' ,
      true
    );

  }//end public function search_m_time_created_after */

 /**
  *
  * @param TFlag $params named parameters
  * @return void
  */
  public function search_m_time_changed_before($params)
  {

    //tpl: special
    $inputDate = $this->view->newInput('input'.$this->prefix.'MTimeChangedBefore' , 'Date');
    $inputDate->addAttributes
    (
      array
      (
        'name' => $this->keyName.'[m_time_changed_before]',
        'id' => 'wgt-input-'.$this->keyName.'_m_time_changed_before'.($this->suffix?'-'.$this->suffix:''),
        'class' => 'wcm wcm_req_search small wgt-no-save'.($this->assignedForm?' fparam-'.$this->assignedForm:''),
        'title' => $this->view->i18n->l('Changed Before','wbf.label'),
      )
    );
    $inputDate->setWidth('small');

    $inputDate->setReadOnly($this->readOnly);
    $inputDate->setLabel
    (
      $this->view->i18n->l('Changed Before','wbf.label')
    );
    $inputDate->refresh = $this->refresh;
    $inputDate->serializeElement = $this->sendElement;

    // activate the category
    $this->view->addVar
    (
      'showCat'.$this->namespace.'_Search_Meta' ,
      true
    );

  }//end public function search_m_time_changed_before */

 /**
  *
  * @param TFlag $params named parameters
  * @return void
  */
  public function search_m_time_changed_after($params)
  {

    //tpl: special
    $inputDate = $this->view->newInput('input'.$this->prefix.'MTimeChangedAfter' , 'Date');
    $inputDate->addAttributes
    (
      array
      (
        'name' => $this->keyName.'[m_time_changed_after]',
        'id' => 'wgt-input-'.$this->keyName.'_m_time_changed_after'.($this->suffix?'-'.$this->suffix:''),
        'class' => 'wcm wcm_req_search small wgt-no-save'.($this->assignedForm?' fparam-'.$this->assignedForm:''),
        'title' => $this->view->i18n->l('Changed After','wbf.label'),
      )
    );
    $inputDate->setWidth('small');

    $inputDate->setReadOnly($this->readOnly);
    $inputDate->setLabel
    (
      $this->view->i18n->l('Changed After','wbf.label')
    );
    $inputDate->refresh = $this->refresh;
    $inputDate->serializeElement = $this->sendElement;

    // activate the category
    $this->view->addVar
    (
      'showCat'.$this->namespace.'_Search_Meta' ,
      true
    );

  }//end public function search_m_time_changed_after */

 /**
  * create the ui element for field rowid
  * @param TFlag $params named parameters
  * @return void
  */
  public function search_m_rowid($params)
  {

    //tpl: special
    $inputRowid = $this->view->newInput('input'.$this->prefix.'MRowid' , 'Int');
    $inputRowid->addAttributes
    (
      array
      (
        'name' => $this->keyName.'[rowid]',
        'id' => 'wgt-input-'.$this->keyName.'_rowid'.($this->suffix?'-'.$this->suffix:''),
        'class' => 'valid_required medium wgt-no-save'.($this->assignedForm?' fparam-'.$this->assignedForm:''),
        'title' => $this->view->i18n->l('IDI','wbf.label'),
      )
    );
    $inputRowid->setWidth('medium');

    $inputRowid->setReadOnly($this->readOnly);
    $inputRowid->setLabel
    (
      $this->view->i18n->l('IDI','wbf.label')
    );
    $inputRowid->refresh = $this->refresh;
    $inputRowid->serializeElement = $this->sendElement;

    // activate the category
    $this->view->addVar
    (
      'showCat'.$this->namespace.'_Search_Meta' ,
      true
    );

  }//end public function search_m_rowid */

 /**
  * create the search element for field name
  * @param TFlag $params named parameters
  * @return void
  */
  public function search_m_uuid($params)
  {

    //tpl: special
    $input = $this->view->newInput('input'.$this->prefix.'MUuid' , 'Text');
    $input->addAttributes
    (
      array
      (
        'name' => $this->keyName.'[m_uuid]',
        'id' => 'wgt-input-'.$this->keyName.'_m_uuid'.($this->suffix?'-'.$this->suffix:''),
        'class' => 'wcm wcm_req_search medium wgt-no-save'.($this->assignedForm?' fparam-'.$this->assignedForm:''),
        'title' => $this->view->i18n->l('UUID','wbf.label'),
      )
    );
    $input->setWidth('medium');

    $input->setReadOnly($this->readOnly);
    $input->setLabel
    (
      $this->view->i18n->l('UUID','wbf.label')
    );
    $input->refresh = $this->refresh;
    $input->serializeElement = $this->sendElement;

    // activate the category
    $this->view->addVar
    (
      'showCat'.$this->namespace.'_Search_Meta' ,
      true
    );

  }//end public function search_m_uuid */

}//end class BuizSecurityArea_Form */

