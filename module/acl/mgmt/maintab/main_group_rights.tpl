<!-- elements are assigned via class asgd-<?php echo $VAR->formId?> -->
<form
    method="post"
    accept-charset="utf-8"
    id="<?php echo $VAR->formId?>"
    action="<?php echo $VAR->formAction?>" ></form>


  <!-- Accordion Content Container -->
  <div
    id="<?php echo $this->tabCId ?>-content"
    style="position:absolute;left:0px;right:0px;top:0px;bottom:0px;height:100%;overflow:hidden;overflow-y:auto;"  >
    
    <div
        class="content"
        id="<?php echo $this->tabCId ?>-content-details"
        title="<?php echo $I18N->l( 'Rolebased Access', 'wbf.label' ); ?>" >

    <section class="" >
    </section>

    <section class="wgt-content_box form" >
      <header
        id="<?php echo $this->id?>-<?php echo $VAR->domain->aclDomainKey ?>-areadata-head"
        class="wcm wcm_ui_tab_head wgt-panel tabs"
        data-tab-body="<?php echo $this->id?>-<?php echo $VAR->domain->aclDomainKey ?>-areadata-content"  >

        <ul class="wgt-tab-head"  >
          <li><a data-tab="levels" class="tab" >Area Levels</a></li>
          <li><a data-tab="assignments" class="tab" >Assignments</a></li>
        </ul>
      </header>
      <div id="<?php echo $this->id?>-<?php echo $VAR->domain->aclDomainKey ?>-areadata-content" class="wgt-content-box"  >

        <!-- Tab budget_constraints  -->
        <div
          id="<?php echo $this->id?>-<?php echo $VAR->domain->aclDomainKey ?>-areadata-content-levels"
          title="Area Levels"
          wgt_key="levels"
          class="content" >

        <div class="wgt-panel second" >

          <form
            method="get"
            accept-charset="utf-8"
            id="<?php echo $VAR->searchFormId?>"
            action="<?php echo $VAR->searchFormAction?>&area_id=<?php echo $VAR->entityBuizSecurityArea ?>" ></form>

          <form
            method="post"
            accept-charset="utf-8"
            id="wgt-form-<?php echo $VAR->domain->aclDomainKey ?>-acl-append"
            action="ajax.php?c=Acl.Mgmt.appendGroup&dkey=<?php echo $VAR->domain->domainName ?>" ></form>

            <div class="left" >
            <!-- Group Input -->
            <span><?php echo $I18N->l( 'Group', 'wbf.label' ); ?></span>
            <input
              type="text"
              id="wgt-input-<?php echo $VAR->domain->aclDomainKey ?>-acl-id_group-tostring"
              name="key"
              class="large wcm wcm_ui_autocomplete wgt-no-save"
            />
            <var id="var-<?php echo $VAR->domain->aclDomainKey ?>-automcomplete" >{
                "url":"ajax.php?c=Acl.Mgmt.loadGroups&amp;area_id=<?php
                  echo $VAR->entityBuizSecurityArea
                ?>&amp;dkey=<?php
                  echo $VAR->domain->domainName
                ?>&amp;key=",
                "type":"entity"
            }</var>
            <input
              id="wgt-input-<?php echo $VAR->domain->aclDomainKey ?>-acl-id_group"
              class="asgd-wgt-form-<?php echo $VAR->domain->aclDomainKey ?>-acl-append valid_required"
              name="security_access[id_group]"
              type="hidden" />
            <button
              id="wgt-input-<?php echo $VAR->domain->aclDomainKey ?>-acl-id_group-append"
              class="wcm wcm_ui_tip wgt-button append"
              title="To assign a new role, just type the name of the role in the autocomplete field left to this infobox."
              onclick="$R.get('modal.php?c=Buiz.RoleGroup_Selection.mask&amp;target=<?php echo $VAR->searchFormId ?>');return false;" >
              <i class="fa fa-search" ></i>
            </button>

            <!-- Area Input -->
            &nbsp;&nbsp;
            <span><?php echo $I18N->l( 'Area', 'wbf.label' ); ?></span>&nbsp;

            </div>
            <div class="inline" >
              <select
                id="wgt-input-<?php echo $VAR->domain->aclDomainKey ?>-acl-id_area"
                class="wcm wcm_widget_selectbox asgd-wgt-form-<?php echo $VAR->domain->aclDomainKey ?>-acl-append"
                name="area" >
                <?php foreach( $VAR->domain->domainAclAreas as $areaKey ){
                  echo '<option value="'.$areaKey.'" >'.$areaKey.'</option>'.NL;
                } ?>
              </select>
            </div>

            <div class="inline" >
            <!-- area & button -->

            <input
              type="hidden"
              id="wgt-input-<?php echo $VAR->domain->aclDomainKey ?>-acl-id_area"
              name="security_access[id_area]"
              def_value="<?php echo $VAR->entityBuizSecurityArea?>"
              value="<?php echo $VAR->entityBuizSecurityArea?>"
              class="asgd-wgt-form-<?php echo $VAR->domain->aclDomainKey ?>-acl-append "
            />
            &nbsp;&nbsp;
            <button
              class="wgt-button"
              id="wgt-button-<?php echo $VAR->domain->aclDomainKey ?>-acl-form-append"  >
              <i class="fa fa-link" ></i> Create Relation</button>

            </div>

          </div><!-- end end panel -->


          <?php echo $ELEMENT->listingAclTable; ?>

          <div class="do-clear small" >&nbsp;</div>

        </div>

      <!-- Tab schedule  -->
      <div
        id="<?php echo $this->id?>-<?php echo $VAR->domain->aclDomainKey ?>-areadata-content-assignments"
        title="Group Assignments"
        wgt_key="assignments"
        class="content" >

        <section class="wgt-edit-matrix wgt-space" >
        
        
            <header>
                <h2>Access Settings</h2>
                <div class="lcol" >&nbsp;</div>
                <div class="w_2" ><label><?php echo $I18N->l( 'Area Acecss', 'wbf.label' ); ?></label></div>
                <div class="w_2" ><label><?php echo $I18N->l( 'References Access', 'wbf.label' ); ?></label></div>
            </header>
            <fieldset>
            
                <div>
                    <div><label>Listing</label></div>
                    <div class="w_2" ><?php echo $ELEMENT->inputBuizSecurityAreaIdLevelListing->element() ?></div>
                    <div class="w_2" ><?php echo $ELEMENT->inputBuizSecurityAreaIdRefListing->element() ?></div>
                </div>
                
                <div>
                    <div><label>Access</label></div>
                    <div class="w_2" ><?php echo $ELEMENT->inputBuizSecurityAreaIdLevelAccess->element()  ?></div>
                    <div class="w_2" ><?php echo $ELEMENT->inputBuizSecurityAreaIdRefAccess->element()  ?></div>
                </div>
        
                <div>
                    <div><label>Insert</label></div>
                    <div class="w_2" ><?php echo $ELEMENT->inputBuizSecurityAreaIdLevelInsert->element()  ?></div>
                    <div class="w_2" ><?php echo $ELEMENT->inputBuizSecurityAreaIdRefInsert->element()  ?></div>
                </div>
                
                <div>
                    <div><label>Update</label></div>
                    <div class="w_2" ><?php echo $ELEMENT->inputBuizSecurityAreaIdLevelUpdate->element()  ?></div>
                    <div class="w_2" ><?php echo $ELEMENT->inputBuizSecurityAreaIdRefUpdate->element()  ?></div>
                </div>
                
                <div>
                    <div><label>Delete</label></div>
                    <div class="w_2" ><?php echo $ELEMENT->inputBuizSecurityAreaIdLevelDelete->element() ?></div>
                    <div class="w_2" ><?php echo $ELEMENT->inputBuizSecurityAreaIdRefDelete->element() ?></div>
                </div>
                
                <div>
                    <div><label>Admin</label></div>
                    <div class="w_2" ><?php echo $ELEMENT->inputBuizSecurityAreaIdLevelAdmin->element() ?></div>
                    <div class="w_2" ><?php echo $ELEMENT->inputBuizSecurityAreaIdRefAdmin->element() ?></div>
                </div>
                
            </fieldset>
        
        </section>


        <div class="do-clear small">&nbsp;</div>

        <div class="inline n-cols-1" >
          <h3><?php echo $I18N->l( 'Description', 'wbf.label' ); ?></h3>
          <?php echo $ELEMENT->inputBuizSecurityAreaDescription->element(); ?>
        </div>

        <div class="meta" >
        <?php echo $ELEMENT->inputBuizSecurityAreaRowid?>
        </div>

        <div class="do-clear small">&nbsp;</div>

       </div>



      </div>
      <div class="do-clear xxsmall" ></div>
    </section>

    <div class="do-clear xsmall">&nbsp;</div>

  </div><!-- end tab -->

  <div
    class="content"
    id="<?php echo $this->tabCId ?>-content-qfd_users" >

  </div><!-- end tab -->

  <div
    class="content"
    id="<?php echo $this->tabCId ?>-content-backpath" >

  </div><!-- end tab -->


</div><!-- end tab body -->


<script>
$S('#<?php echo $VAR->searchFormId?>').data('connect',function( objid ){
  $R.post(
    'ajax.php?c=Acl.Mgmt.appendGroup&dkey=<?php echo $VAR->domain->aclDomainKey ?>',{
      'security_access[id_area]':'<?php echo $VAR->entityBuizSecurityArea?>',
      'security_access[id_group]':objid
    }
  );
});

<?php foreach( $this->jsItems as $jsItem ){ ?>
<?php echo $ELEMENT->$jsItem->jsCode?>
<?php } ?>
</script>


