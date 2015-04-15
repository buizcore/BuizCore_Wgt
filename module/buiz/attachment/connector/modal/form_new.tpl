<?php 

$uplForm = new WgtFormBuilder(
  $this,
  'ajax.php?c=Buiz.Attachment_Connector.insert'.$VAR->preUrl.'&amp;'.$VAR->paramTypeFilter,
  'wgt-form-wbf-attachment-con-create',
  'post'
);
$uplForm->form();


$typeData = $uplForm->loadQuery( 'BuizFileType_Selectbox' );
$typeData->fetchSelectbox( $VAR->typeFilter );

?>


<fieldset>
  <legend>Add Attachment</legend>
  
    <table style="width:100%" >
      <tr>
        <td colspan="2" ><?php $uplForm->upload( 'File', 'file' ); ?></td>
      </tr>
      <tr>
        <td valign="top" >
          
           <?php $uplForm->selectboxByKey( 
          	'Type', 
          	'id_type', 
          	'BuizFileType_Selectbox', 
            $typeData->getAll() 
          ); ?>
          
          <?php $uplForm->textarea( 
          	 'Description',
          	 'description',
            ''  ,
            [],array( 'size' => 'xlarge' )
          ); ?>
          
        </td>
        <td valign="top" >
        </td>
      </tr>
      <tr>
        <td>
        </td>
        <td valign="bottom" align="right" >
          <?php $uplForm->submit( 'Add Attachement', '$S.modal.close();' ); ?>
        </td>
      </tr>
    </table>

</fieldset>