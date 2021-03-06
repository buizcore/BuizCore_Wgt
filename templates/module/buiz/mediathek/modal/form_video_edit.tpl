<?php 

$uplForm = new WgtFormBuilder
(
  $this,
  'ajax.php?c=Buiz.Attachment.saveFile&amp;attachid='.$VAR->attachmentId.'&amp;element='.$VAR->elementKey,
  'wgt-form-wbf-attachment-edit-file',
  'post'
);
$uplForm->form();

$typeData = $uplForm->loadQuery( 'BuizFileType_Selectbox' );
$typeData->fetchSelectbox();

$confidentialData = $uplForm->loadQuery( 'BuizConfidentialityLevel_Selectbox' );
$confidentialData->fetchSelectbox();

?>


<fieldset>
  <legend>Upload File</legend>
  
  <?php $uplForm->hidden
    ( 
      'objid', 
     $VAR->file->getId()
    ); ?>
  
  <table style="width:100%;" >
    <tr>
      <td colspan="2" >
        <?php $uplForm->upload( 'File', 'file', $VAR->file->name, [], array('size' => 'large' )  ); ?>
        
      </td>
    </tr>
    <tr>
      <td valign="top" >
        <?php $uplForm->selectboxByKey
        ( 
        	'Type', 
        	'type', 
        	'BuizFileType_Selectbox', 
         $typeData->getAll(),
         $VAR->file->id_type  
        ); ?>
        
        <?php $uplForm->selectboxByKey
        ( 
        		'Confidentiality Level', 
        		'id_confidentiality', 
        		'BuizConfidentialityLevel_Selectbox', 
          $confidentialData->getAll()  ,
           $VAR->file->id_confidentiality  
        ); ?>
      </td>
      <td valign="top" >
        <?php $uplForm->checkbox
        ( 
        	 'Versioning', 
        	 'version', 
        	 ($VAR->file->flag_versioning?'true':'false') 
        ); ?>
      </td>
    </tr>
    <tr>
      <td>
        <?php $uplForm->textarea
        ( 
        	 'Description', 
        	 'description',
          $VAR->file->getSecure('description')
        ); ?>
      </td>
      <td valign="bottom" >
        <?php $uplForm->submit( 'Save File', '$S.modal.close();' ); ?>
      </td>
    </tr>
  </table>

  
</fieldset>