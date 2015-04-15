
<ul>
<?php foreach($VAR->modules as $module){ ?>
  <li><a
    href="maintab.php?c=Buiz.Core_Docu_Module.overview&objid=<?php echo $module['rowid']  ?>"
    class="wcm wcm_rqt_ajax" ><?php echo $module['access_key']; ?></a></li>
<?php } ?>
</ul>