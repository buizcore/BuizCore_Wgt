<?php 

$orm = $this->getOrm();
$uplForm = new WgtFormBuilder(
  $this,
  'ajax.php?c=Buiz.Message_Attachment.update',
  'wbf-msg-attach-edit',
  'post'
);
$uplForm->form();


$typeData = $uplForm->loadQuery( 'BuizFileType_Selectbox' );
$typeData->fetchSelectbox( );

$confidentialData = $uplForm->loadQuery( 'BuizConfidentialityLevel_Selectbox' );
$confidentialData->fetchSelectbox();

?>

<fieldset>
  <legend>Attach File</legend>
  
  <table style="width:100%;" >
    <tr>
      <td colspan="2" ><?php $uplForm->upload( 'File', 'file' ); ?></td>
    </tr>
    <tr>
      <td valign="top" >
        <?php $uplForm->selectboxByKey( 
        		'Type', 
        		'type', 
        		'BuizFileType_Selectbox', 
          $typeData->getAll()  
        ); ?>
        <?php $uplForm->selectboxByKey
        ( 
        		'Confidentiality Level', 
        		'id_confidentiality', 
        		'BuizConfidentialityLevel_Selectbox', 
          $confidentialData->getAll(),
          $orm->getIdByKey( 'BuizConfidentialityLevel', 'public' )   
        ); ?>
      </td>
    </tr>
    <tr>
      <td colspan="2" >
        <?php $uplForm->textarea( 'Description', 'description', null, [], array( 'size' => 'xlarge_nl' ) ); ?>
      </td>
    </tr>
    <tr>
    	<td></td>
      <td valign="bottom" align="right" >
      	<br />
        <?php $uplForm->submit( 'Upload', '$S.modal.close();' ); ?>
      </td>
    </tr>
  </table>

  
</fieldset>