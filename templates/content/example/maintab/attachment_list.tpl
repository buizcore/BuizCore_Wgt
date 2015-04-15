<?php 


$commentTree = new WgtElementAttachmentList( 'fuu', $this  );
$commentTree->label = 'Attachments';
$commentTree->refId = BuizCore::$env->getUser()->getId();
$commentTree->id = 'example';
$commentTree->setData( $this->model->getAttachmentList( BuizCore::$env->getUser()->getId()  ) );

echo $ELEMENT->fuu;

?>