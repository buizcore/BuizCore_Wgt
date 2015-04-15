<?php

$this->crumbs = array(
  array('Root', $this->interface.'?c=Buiz.Navigation.explorer','fa fa-desktop'),
  array('System', $this->interface.'?c=Buiz.Base.menu&amp;menu=maintenance','fa fa-folder-o'),
  array('Backup', $this->interface.'?c=Buiz.Base.menu&amp;menu=access','fa fa-folder-o'),
);

$this->firstEntry = array(
  'menu_mod_root',
   Wgt::MAIN_TAB,
  '..',
  I18n::s('System', 'wbf.label'  ),
  'maintab.php?c=Buiz.Base.menu&amp;menu=maintenance',
  'fa fa-level-up',
);

if ($acl->hasRole('developer')) {

  $this->firstEntry = array(
    'menu_mod_maintenance',
     Wgt::MAIN_TAB,
    '..',
    I18n::s('Maintenance', 'maintenance.title'  ),
    'maintab.php?c=maintenance.base.menu',
    Wgt::icon('places/folder.png'),
  );

  $this->folders[] = array(
    'menu_mod_maintenance_backup_db',
    Wgt::MAIN_TAB,
    'backup db',
    I18n::s('backup', 'admin.title'  ),
    'index.php?c=Daidalos.BackupDb.table',
    Wgt::icon('utilities/db_backup.png'),
  );

}
