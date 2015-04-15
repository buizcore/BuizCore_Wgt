<?php 

$form = new WgtFormBuilder(
    $this,
    'ajax.php?c=Buiz.FormDesigner.save',
    'buiz-form-designer',
    'get'
);


$form->form();

include 'form.style.tpl';
include 'form.js.tpl';
include 'form.tpl.tpl';

?>



<ul style="width:99%;" class="wgt-menu crumb inline" >
  <li><a tab="wgt-ui-desktop" ><i class="fa fa-desktop"></i> Step 1</a></li>
</ul>

<div class="link-list" >
    <h4>Form designer</h4>
    <ul>
        <li><a data-key="text" class="wgt-buiz-form-designer-cntrl" ><i class="fa fa-terminal" ></i> Textfeld</a></li>
        <li><a data-key="textarea" class="wgt-buiz-form-designer-cntrl" ><i class="fa fa-align-left" ></i> Text</a></li>
        <li><a data-key="checkboxes" class="wgt-buiz-form-designer-cntrl" ><i class="fa fa-square-o" ></i> Checkboxes</a></li>
        <li><a data-key="radios" class="wgt-buiz-form-designer-cntrl" ><i class="fa fa-circle-blank" ></i> Radios</a></li>
        <li><a data-key="range" class="wgt-buiz-form-designer-cntrl" ><i class="fa fa-resize-horizontal" ></i> Range</a></li>
        <li><a data-key="money" class="wgt-buiz-form-designer-cntrl" ><i class="fa fa-eur" ></i> Money</a></li>
        <li><a data-key="matrix" class="wgt-buiz-form-designer-cntrl" ><i class="fa fa-th" ></i> Matrix</a></li>
        <li><a data-key="list" class="wgt-buiz-form-designer-cntrl" ><i class="fa fa-list" ></i> List</a></li>
        <li><a data-key="file" class="wgt-buiz-form-designer-cntrl" ><i class="fa fa-file-alt" ></i> File / Document</a></li>
        <li><a data-key="image" class="wgt-buiz-form-designer-cntrl" ><i class="fa fa-picture" ></i> Image</a></li>
        <li><a data-key="photo" class="wgt-buiz-form-designer-cntrl" ><i class="fa fa-camera" ></i> Photo</a></li>
        <li><a data-key="date" class="wgt-buiz-form-designer-cntrl" ><i class="fa fa-calendar" ></i> Date</a></li>
        <li><a data-key="rating" class="wgt-buiz-form-designer-cntrl" ><i class="fa fa-star-half-empty" ></i> Rating</a></li>
        <li><a data-key="location" class="wgt-buiz-form-designer-cntrl" ><i class="fa fa-map-marker" ></i> Location</a></li>
        <li><a data-key="address" class="wgt-buiz-form-designer-cntrl" ><i class="fa fa-credit-card" ></i> Address</a></li>
    </ul>
</div>

<div class="do-clear" >&nbsp;</div>

<section>
    
    <section class="wgt-content_box form pad" >
        <div class="content" >
            <div class="left n-cols-2" >
                <?php $form->input('Title', 'name') ?>
                <?php $form->textarea('Description', 'description') ?>
            </div>
        </div>
        
        <div class="do-clear" >&nbsp;</div>
    </section>

    <div id="buiz-fdes-slices-container"  >
    
    </div>
    
    <div class="do-clear large" >&nbsp;</div>
    
</section>

