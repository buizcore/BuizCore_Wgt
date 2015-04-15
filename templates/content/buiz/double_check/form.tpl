<?php 

$orm = $this->getOrm();
$uplForm = new WgtFormBuilder
(
  $this,
  'ajax.php?c=Buiz.Attachment.addLink',
  'wgt-form-wbf-attachment-add-link',
  'post'
);
$uplForm->form();


?>


<fieldset>
  <legend>Add Link</legend>
  
    <table style="width:100%" >
      <tr>
        <td colspan="2" >
          <?php $uplForm->input( 'Link', 'link', null, [], array( 'size' => 'xlarge' )  ); ?>
        </td>
      </tr>
      <tr>
        <td valign="top" >
          <?php $uplForm->textarea( 'Description', 'description',null,[],array( 'size' => 'xlarge_nl' ) ); ?>
        </td>
        <td valign="top" >
        </td>
      </td>
      <tr>
        <td>
        </td>
        <td valign="bottom" align="right" >
          <?php $uplForm->submit( 'Add Link', '$S.modal.close();' ); ?>
        </td>
      </tr>
    </table>

</fieldset>