<?php 


$commentTree = new WgtElementCommentTree( 'fuu', $this  );
$commentTree->label = 'Comments';
$commentTree->refId = BuizCore::$env->getUser()->getId();
$commentTree->id = 'example';
$commentTree->setData( $this->model->getCommentTree( BuizCore::$env->getUser()->getId()  ) );

echo $ELEMENT->fuu;

?>