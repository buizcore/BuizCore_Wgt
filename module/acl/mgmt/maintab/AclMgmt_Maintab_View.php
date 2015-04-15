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
 * Read before change:
 * It's not recommended to change this file inside a Mod or App Project.
 * If you want to change it copy it to a custom project.

 *
 * @package com.buizcore
 * @author Dominik Bonsch <d.bonsch@buizcore.com>

 */
class AclMgmt_Maintab_View extends LibViewMaintabTabbed
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
  * @var AclMgmt_Model
  */
  public $model = null;

  /**
  * @var AclMgmt_Ui
  */
  public $ui = null;

  /**
  * @var DomainNode
  */
  public $domainNode = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Methodes
/*////////////////////////////////////////////////////////////////////////////*/

 /**
  * add the table item
  * add the search field elements
  *
  * @param Context $params
  * @return null / Error im Fehlerfall
  */
  public function displayListing($params)
  {

    $access = $params->access;

    // for paging use the default search form, to enshure to keep the order
    // and to page in search results if there was any search
    $params->searchFormAction = 'index.php?c=Acl.Mgmt.search&dkey='.$this->domainNode->domainName;
    $params->searchFormId = 'wgt-form-table-'.$this->domainNode->aclDomainKey.'-acl-search';

    // fill the relevant data for the search form
    $params->injectSearchFormData($this);

    // create the form action
    $params->formAction = 'index.php?c=Acl.Mgmt.updateArea&dkey='.$this->domainNode->domainName;

    // add the id to the form
    $params->formId = 'wgt-form-'.$this->domainNode->aclDomainKey.'-acl-update';

    // set a namespace for the elements in the browser
    $params->namespace = ''.$this->domainNode->aclDomainKey.'-acl-update';

    // append form actions
    $this->setSaveFormData($params);

    $this->addVar('domain', $this->domainNode);
    
    $this->tabCId = $this->getId().'-'.$this->domainNode->aclDomainKey.'-acl';

    // set the path to the template
    // the system search in all modules for the template
    // the tpl ending is assigned automatically
    $this->setTemplate('acl/mgmt/maintab/main_group_rights', true);

    // fetch the i18n text only one time
    $i18nText = $this->i18n->l(
      'ACL Entity {@label@}',
      'wbf.label',
      array(
        'label' => $this->i18n->l($this->domainNode->label, $this->domainNode->domainI18n.'.label')
      )
    );

    // set browser title
    $this->setTitle($i18nText);

    // the label is displayed in the maintab as text
    $this->setLabel($i18nText);

    $params->viewType = 'maintab';

    // the tabid that is used in the template
    // this tabid has to be placed in the class attribute of all subtasks
    //$this->setTabId('wgt-tab-'.$this->domainNode.'_acl_listing');

    $areaId = $this->model->getAreaId();
    $params->areaId = $areaId;
    $params->dKey = $this->domainNode->domainName;

    // inject the menu in the view object
    $this->createMenu($areaId, $params);

    // create the ui helper object
    $ui = $this->loadUi('AclMgmt');
    $ui->setModel($this->model);
    $ui->domainNode = $this->domainNode;
    
    // inject the table item in the template system
    $ui->createListItem(
      $this->model->search($this->domainNode->domainAclAreas, $access, $params),
      $access,
      $params
    );

    // create the form elements and inject them in the templatesystem
    $ui->editForm(
      $areaId,
      $params
    );
    

    // alles ok
    return null;

  }//end public function displayListing */

  /** inject the menu in the activ view object
   *
   *
   * @param int $objid
   * @param TFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function createMenu($objid, $params)
  {
      
      
      $tabH1 = new WgtTabHead();
      $tabH1->key = 'details';
      $tabH1->label = $this->i18n->l( 'Rolebased Access', 'wbf.label' );
      $tabH1->content = <<<HTML
<label>Access Levels:</label>
<p>
	The "access levels" are the easiest way to grant access to the data.<br />
	Every user has a specific "access level" like employee, admin e.g.<br />
	To maintain the access to the datasource simply set the minimum required "access level"
	to the required activity(ies).
</p>

<label>Grouprole Access:</label>
<p>
	A more advanced method of access control can be implemented with the role access levels.
	To gain access rights for a specific role, append it to the list and select the appropriate access level
	from the "Access Level" dropdown in the list.
</p>
<p>
	To provide these rights to a specific user, maintain her/his relationship(s) in the "Qualified Users" tab below.
</p>

<label>Inherit Rights:</label>
<p>
	To inherit the dataset rights to form references, use the "Inherit Rights" mask which you can find
	in the dataset menu of the assigned roles.
</p>

<label class="hint" >Hint:</label>
<p class="hint" >If you have to use this mask frequently create a bookmark with the "Bookmark" action in "Menu" above.</p>

HTML;
      $this->tabs[] = $tabH1;
      
      
      $tabH2 = new WgtTabHead();
      $tabH2->key = 'qfd_users';
      $tabH2->label = $this->i18n->l('Qualified Users', 'wbf.label');
      $tabH2->src = "ajax.php?c=Acl.Mgmt_Qfdu.tabUsers"
            ."&area_id=".$this->var->entityBuizSecurityArea
            ."&tabid=".$this->tabCId."-content-qfd_users"
            ."&dkey=".$this->domainNode->domainName;
      
      $tabH2->content = <<<HTML
 <p>
	"Qualified Users" defines the relation(s) of users to the complete datasource ( the Project table ) and/or to a list of datasets.<br />
</p>
<label class="sub" >Example:</label>
<p>
	Assumption: there's a role "Owner" with access level "Edit".<br />
	If you assign a person in relation to the datasource (Projects) as "Owner" the person will be able to see and edit
	all Projects in the list.<br />
	As the "Owner" has only edit rights, the person is not allowed e.g. to delete Projects.
</p>
<p>
	To better specify grant access rights, you can also assign the "Owner" relationship in relation
	to either one or more Projects. The person will then only have edit rights for the assigned Projects.
</p>
HTML;
      $this->tabs[] = $tabH2;
      

      $tabH3 = new WgtTabHead();
      $tabH3->key = 'backpath';
      $tabH3->label = $this->i18n->l('Backpath', 'wbf.label');
      $tabH3->src = "ajax.php?c=Acl.Mgmt_Backpath.openTab"
            ."&area_id=".$this->var->entityBuizSecurityArea
            ."&tabid=".$this->tabCId."-content-backpath"
            ."&dkey=".$this->domainNode->domainName;
      $tabH3->content = <<<HTML
    <p>
		Backpath information for implicit role assignments.
	</p>
HTML;
      $this->tabs[] = $tabH3;
      
    $menu = $this->newMenu(
      $this->id.'_dropmenu',
      $this->domainNode->domainAclMask
    );
    $menu->domainNode = $this->domainNode;
    $menu->id = $this->id.'_dropmenu';
    $menu->buildMenu($objid, $params);

    $menu->injectMenuLogic($this, $objid, $params);

    return true;

  }//end public function createMenu */

} // end class AclMgmt_Maintab_View */

