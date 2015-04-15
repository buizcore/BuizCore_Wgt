<?php

$this->crumbs = array(
  array(
    'Dashboard',
    '',
    'fa fa-desktop',
    null,
    'wgt-ui-desktop'
  ),
  array('Root', $this->interface.'?c=Buiz.Navigation.explorer','fa fa-desktop'),
  array('System', $this->interface.'?c=Buiz.Base.menu&amp;menu=maintenance','fa fa-folder-o'),
);

$this->firstEntry = array(
  'menu-system-maintenance-root',
   Wgt::MAIN_TAB,
  '..',
  I18n::s('Root', 'wbf.label'  ),
  'maintab.php?c=Buiz.Navigation.explorer',
  'fa fa-level-up',
);

/*
$this->files[] = array(
  'menu-system-maintenance-theme',
  Wgt::MAIN_TAB,
  'Themes',
  'Themes',
  'maintab.php?c=Daidalos.Theme.form',
  'fa fa-picture',
);
*/


$this->folders[] = array(
  'menu-system-maintenance-conf',
  Wgt::MAIN_TAB,
  'Conf',
  'Conf',
  'maintab.php?c=Buiz.System_Conf.overview',
  'fa fa-cog',
);


/*
$this->folders[] = array(
  'menu-system-maintenance-imports',
  Wgt::MAIN_TAB,
  'Imports',
  'Imports',
  'maintab.php?c=Buiz.Base.Menu&menu=imports',
  'fa fa-upload-alt',
);

$this->folders[] = array(
  'menu-system-maintenance-exports',
  Wgt::MAIN_TAB,
  'Exports',
  'Exports',
  'maintab.php?c=Buiz.Base.Menu&menu=exports',
  'fa fa-download-alt',
);
*/

$this->folders[] = array(
  'menu-system-maintenance-coredata',
  Wgt::MAIN_TAB,
  'Core Data',
  'Core Data',
  'maintab.php?c=Buiz.Base.Menu&menu=masterdata',
  'fa fa-list',
);

$this->folders[] = array(
  'menu-system-maintenance-access',
  Wgt::MAIN_TAB,
  'Access',
  'Access',
  'maintab.php?c=Buiz.Base.Menu&menu=access',
  'fa fa-shield',
);

/*
$this->folders[] = array(
  'menu-system-maintenance-planned-tasks',
  Wgt::MAIN_TAB,
  'Planned Tasks',
  'Planned Tasks',
  'maintab.php?c=Buiz.TaskPlanner.list',
  'fa fa-tasks',
);
*/

/*
$this->files[] = array(
  'menu-system-maintenance-protocol',
  Wgt::MAIN_TAB,
  'Protocols &amp; Logs',
  'Protocols &amp; Logs',
  'maintab.php?c=Buiz.Base.menu&amp;menu=protocols',
  'fa fa-list',
);
*/

$this->files[] = array(
  'menu-system-maintenance-database',
  Wgt::MAIN_TAB,
  'Database',
  'Database',
  'maintab.php?c=Buiz.Base.menu&amp;menu=database',
  'fa fa-database',
);

/*
$this->files[] = array(
  'menu-system-maintenance-services',
  Wgt::MAIN_TAB,
  'External Datasources',
  'External Datasources',
  'ajax.php?c=Buiz.Mockup.notYetImplemented',
  //'maintab.php?c=Buiz.Datasources.explorer',
  'fa fa-rss',
);
*/

$this->files[] = array(
  'menu-system-maintenance-status',
  Wgt::MAIN_TAB,
  'System Status',
  'System Status',
  'maintab.php?c=Buiz.System_Status.stats',
  'fa fa-cog',
);

$this->files[] = array(
  'menu-system-maintenance-actions',
  Wgt::MAIN_TAB,
  'Maintenance Actions',
  'Maintenance Actions',
  'maintab.php?c=Buiz.MaintenanceAction.listing',
  ' fa fa-cogs',
);

$this->files[] = array(
    'menu-system-maintenance-flush-memchached',
    Wgt::MAIN_TAB,
    'Flush Memcache',
    'Flush Memcache',
    'ajax.php?c=Buiz.Cache.flushMemcache',
    ' fa fa-refresh',
);

