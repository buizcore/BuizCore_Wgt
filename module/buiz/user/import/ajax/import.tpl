
<div id="wgt-box-buiz_user_import" >

    <div class="wgt-panel" >
        <h1>Import Report</h1>
    </div>
    
    <?php if($VAR->manager->errors){ ?>
        <div class="wgt-box error" >
            <ul>
                <?php foreach($VAR->manager->errors as $error){ ?>
                    <li><?php echo $error ?></li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>
    
    <?php if($VAR->manager->warnings){ ?>
        <div class="wgt-box warning" >
            <ul>
                <?php foreach($VAR->manager->warnings as $warning){ ?>
                    <li><?php echo $warning ?></li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>
    
    <dl class="wgt-field-map" >
        <dt>Corp Customers</dt><dd><?php echo $VAR->manager->stats['corp-customer'] ?><dd>
        <dt>Private Customers</dt><dd><?php echo $VAR->manager->stats['private-customer'] ?><dd>
        <dt>Contact Persons</dt><dd><?php echo $VAR->manager->stats['contacts'] ?><dd>
        <dt>Neue Kunden</dt><dd><?php echo $VAR->manager->stats['new-customers'] ?><dd>
        <dt>Neue Kontakte</dt><dd><?php echo $VAR->manager->stats['new-contacts'] ?><dd>
    </dl>

    <div class="do-clear" > </div>


</div>