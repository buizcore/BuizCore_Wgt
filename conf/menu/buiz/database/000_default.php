<?php

$this->crumbs = array(
  array('Root', $this->interface.'?c=Buiz.Navigation.explorer','fa fa-desktop'),
  array('System', $this->interface.'?c=Buiz.Base.menu&amp;menu=maintenance','fa fa-folder-o'),
  array('Database', $this->interface.'?c=Buiz.Base.menu&amp;menu=database','fa fa-folder-o'),
);

$this->firstEntry = array(
  'menu_mod_root',
   Wgt::MAIN_TAB,
  '..',
  I18n::s('Root', 'wbf.label'  ),
  'maintab.php?c=Buiz.Base.menu&amp;menu=maintenance',
  'fa fa-level-up',
);

$this->files[] = array(
  'menu-system-maintenance-db-consistency',
  Wgt::AJAX,
  'Db Concistency',
  'Db Concistency',
  'maintab.php?c=Maintenance.DbConsistency.table',
  'fa fa-database',
);

$this->files[] = array(
  'menu-system-maintenance-db-queries',
  Wgt::AJAX,
  'Db Queries',
  'Db Queries',
  'maintab.php?c=MaintenanceDbAdmin.form',
  'fa fa-database',
);


