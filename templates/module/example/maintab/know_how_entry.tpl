<?php 


$knHwNode = new WgtElementKnowhowNode( 'fuu', $this  );
$knHwNode->label = 'Node';
$knHwNode->refId = BuizCore::$env->getUser()->getId();
$knHwNode->id = 'example';

//$knHwNode->setData( $this->model->getActiveEntry() );

echo $ELEMENT->fuu;

?>