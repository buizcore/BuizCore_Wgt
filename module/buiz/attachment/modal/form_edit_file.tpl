<?php

$uplForm = new WgtFormBuilder(
  $this,
  'ajax.php?c=Buiz.Attachment.saveFile&amp;attachid='.$VAR->attachmentId.$VAR->preUrl.$VAR->paramTypeFilter,
  'wgt-form-wbf-attachment-edit-file',
  'post'
);
$uplForm->form();

$typeData = $uplForm->loadQuery( 'BuizFileType_Selectbox' );
$typeData->fetchSelectbox( $VAR->typeFilter );

$confidentialData = $uplForm->loadQuery( 'BuizConfidentialityLevel_Selectbox' );
$confidentialData->fetchSelectbox();

$simpleTabDesc = new WgtSimpleTabContainer($this,'wbf-attachment-edit-file-type');
$simpleTabDesc->data = $typeData->getAll();


?>

<section class="wgt-content_box form single" style="min-width:600px;width:600px;" >
  <header style="min-width:600px;width:600px;margin:0px;" >
    <h2>Upload File</h2>
  </header>
  <div class="content single" style="min-width:600px;width:600px;" >
    <fieldset>
    
      <div class="left n-cols-2 single">


  <?php $uplForm->hidden
    (
      'objid',
     $VAR->file->getId()
    ); ?>


        <?php $uplForm->upload( 'File', 'file', $VAR->file->name,  [], array('size'=>'large') ); ?>

        <?php $uplForm->selectboxByKey
        (
        	'Type',
        	'type',
        	'BuizFileType_Selectbox',
         $typeData->getAll(),
         $VAR->file->id_type,
         array('class'=>'wcm wcm_ui_selection_tab','data-tab-body'=>'wbf-attachment-edit-file-type')
        ); ?>
       	<?php echo $simpleTabDesc->render() ?>

        <?php $uplForm->selectboxByKey
        (
        		'Confidentiality Level',
        		'id_confidentiality',
        		'BuizConfidentialityLevel_Selectbox',
          $confidentialData->getAll()  ,
           $VAR->file->id_confidentiality
        ); ?>


        <?php $uplForm->textarea
        (
        	 'Description',
        	 'description',
          $VAR->file->getSecure('description'),
          [],array( 'size' => 'xlarge' )
        ); ?>

        <?php $uplForm->submit( 'Upload', '$S.modal.close();' ); ?>

    
        </fieldset>
    
    </div>

</section>
