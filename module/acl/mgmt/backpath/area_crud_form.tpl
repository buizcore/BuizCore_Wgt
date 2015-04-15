<?php

$crudForm = new WgtFormBuilder(
  $this,
  $VAR->formActionCrud,
  $VAR->formIdCrud,
  'put'
);
?>

<input
  type="hidden"
  id="wgt-input-<?php echo $VAR->domain->aclDomainKey ?>-backpath-rowid"
  name="objid"
  value="<?php echo $VAR->entity->getId() ?>"
  class="meta asgd-<?php echo $VAR->formIdCrud?>"
/>

<div class="content" >
  <fieldset>

    <div class="left n-cols-2" >
      <?php $crudForm->autocomplete(
        'Target Area',
        'path,id_target_area',
    		array( $VAR->entity->id_target_area, $VAR->entity->target_area_key ),
        'ajax.php?c=Acl.Mgmt_Backpath.autoArea&amp;area_id='.$VAR->areaId.'&amp;dkey='.$VAR->domain->domainName.'&amp;key=',
        [],
        array('size'=>'large','entityMode'=>true)
      ); ?>

     <?php  $crudForm->input(
        'Ref Field',
        'path,ref_field',
    		$VAR->entity->ref_field,
        [],
        array('size'=>'large')
      ); ?>

      <?php  /* $crudForm->autocomplete(
        'Ref Field',
        'path[ref_field]',
        null,
        'ajax.php?c=Acl.Mgmt_Backpath.autoRefField&amp;area_id='.$VAR->areaId.'&amp;dkey='.$VAR->domain->domainName.'&amp;key=',
        [],
        array('size'=>'large')
      ); */ ?>
    </div>

    <div class="inline n-cols-2" >
      <?php $crudForm->textarea(
          'Groups',
          'path,groups',
      		$VAR->entity->groups,
          [],
          array('size'=>'large')
        );
      ?>
      <?php $crudForm->textarea(
          'Set Groups',
          'path,set_groups',
      		$VAR->entity->set_groups,
          [],
          array('size'=>'large')
        );
      ?>
    </div>

  </fieldset>
</div>
