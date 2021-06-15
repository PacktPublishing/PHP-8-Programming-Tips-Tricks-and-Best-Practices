<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * List of available forms, each form is described as an array of fields to display.
 * Fields MUST have their counterparts in the $cfg array.
 *
 * There are two possible notations:
 * $forms['Form group']['Form name'] = array('Servers' => array(1 => array('host')));
 * can be written as
 * $forms['Form group']['Form name'] = array('Servers/1/host');
 *
 * You can assign default values set by special button ("set value: ..."), eg.:
 * 'Servers/1/pmadb' => 'phpmyadmin'
 *
 * To group options, use:
 * ':group:' . __('group name') // just define a group
 * or
 * 'option' => ':group' // group starting from this option
 * End group blocks with:
 * ':group:end'
 *
 * @package PhpMyAdmin-Setup
 */

$forms = array();
$forms['_config.php'] = array(
    'DefaultLang',
    'ServerDefault');
$forms['Servers']['Server'] = array('Servers' => array(1 => array(
    'verbose',
    'host',
    'port',
    'socket',
    'ssl',
    'connect_type',
    'compress',
    'nopassword')));
$forms['Servers']['Server_auth'] = array('Servers' => array(1 => array(
    'auth_type',
    ':group:' . __('Config authentication'),
        'user',
        'password',
        ':group:end',
    ':group:' . __('HTTP authentication'),
        'auth_http_realm',
        ':group:end',
    ':group:' . __('Signon authentication'),
        'SignonSession',
        'SignonURL',
        'LogoutURL')));
$forms['Servers']['Server_config'] = array('Servers' => array(1 => array(
    'only_db',
    'hide_db',
    'AllowRoot',
    'AllowNoPassword',
    'DisableIS',
    'AllowDeny/order',
    'AllowDeny/rules',
    'SessionTimeZone')));
$forms['Servers']['Server_pmadb'] = array('Servers' => array(1 => array(
    'pmadb' => 'phpmyadmin',
    'controlhost',
    'controlport',
    'controluser',
    'controlpass',
    'bookmarktable' => 'pma__bookmark',
    'relation' => 'pma__relation',
    'userconfig' => 'pma__userconfig',
    'users' => 'pma__users',
    'usergroups' => 'pma__usergroups',
    'navigationhiding' => 'pma__navigationhiding',
    'table_info' => 'pma__table_info',
    'column_info' => 'pma__column_info',
    'history' => 'pma__history',
    'recent' => 'pma__recent',
    'favorite' => 'pma__favorite',
    'table_uiprefs' => 'pma__table_uiprefs',
    'tracking' => 'pma__tracking',
    'table_coords' => 'pma__table_coords',
    'pdf_pages' => 'pma__pdf_pages',
    'savedsearches' => 'pma__savedsearches',
    'central_columns' => 'pma__central_columns',
    'designer_settings' => 'pma__designer_settings',
    'export_templates' => 'pma__export_templates',
    'MaxTableUiprefs' => 100)));
$forms['Servers']['Server_tracking'] = array('Servers' => array(1 => array(
    'tracking_version_auto_create',
    'tracking_default_statements',
    'tracking_add_drop_view',
    'tracking_add_drop_table',
    'tracking_add_drop_database',
)));
$forms['Features']['Import_export'] = array(
    'UploadDir',
    'SaveDir',
    'RecodingEngine' => ':group',
        'IconvExtraParams',
        ':group:end',
    'ZipDump',
    'GZipDump',
    'BZipDump',
    'CompressOnFly');
$forms['Features']['Security'] = array(
    'blowfish_secret',
    'CheckConfigurationPermissions',
    'TrustedProxies',
    'AllowUserDropDatabase',
    'AllowArbitraryServer',
    'ArbitraryServerRegexp',
    'LoginCookieRecall',
    'LoginCookieValidity',
    'LoginCookieStore',
    'LoginCookieDeleteAll',
    'CaptchaLoginPublicKey',
    'CaptchaLoginPrivateKey');
$forms['Features']['Page_titles'] = array(
    'TitleDefault',
    'TitleTable',
    'TitleDatabase',
    'TitleServer');
$forms['Features']['Warnings'] = array(
    'ServerLibraryDifference_DisableWarning',
    'PmaNoRelation_DisableWarning',
    'SuhosinDisableWarning',
    'LoginCookieValidityDisableWarning');
$forms['Features']['Developer'] = array(
    'UserprefsDeveloperTab',
    'DBG/sql');
$forms['Features']['Other_core_settings'] = array(
    'NaturalOrder',
    'InitialSlidersState',
    'MaxDbList',
    'MaxTableList',
    'NumFavoriteTables',
    'ShowHint',
    'OBGzip',
    'PersistentConnections',
    'ExecTimeLimit',
    'MemoryLimit',
    'SkipLockedTables',
    'DisableMultiTableMaintenance',
    'UseDbSearch',
    'VersionCheck',
    'SendErrorReports',
    'ConsoleEnterExecutes',
    'ProxyUrl',
    'ProxyUser',
    'ProxyPass',
    'AllowThirdPartyFraming',
    'ZeroConf'
);
$forms['Sql_queries']['Sql_queries'] = array(
    'ShowSQL',
    'Confirm',
    'QueryHistoryDB',
    'QueryHistoryMax',
    'IgnoreMultiSubmitErrors',
    'MaxCharactersInDisplayedSQL',
    'RetainQueryBox',
    'CodemirrorEnable',
    'LintEnable',
    'EnableAutocompleteForTablesAndColumns',
    'DefaultForeignKeyChecks');
$forms['Sql_queries']['Sql_box'] = array('SQLQuery' => array(
    'Edit',
    'Explain',
    'ShowAsPHP',
    'Refresh'));
$forms['Navi_panel']['Navi_panel'] = array(
    'ShowDatabasesNavigationAsTree',
    'NavigationLinkWithMainPanel',
    'NavigationDisplayLogo',
    'NavigationLogoLink',
    'NavigationLogoLinkWindow',
    'NavigationTreePointerEnable',
    'FirstLevelNavigationItems',
    'NavigationTreeDisplayItemFilterMinimum',
    'NumRecentTables',
    'NumFavoriteTables'
);
$forms['Navi_panel']['Navi_tree'] = array(
    'MaxNavigationItems',
    'NavigationTreeEnableGrouping',
    'NavigationTreeEnableExpansion',
    'NavigationTreeShowTables',
    'NavigationTreeShowViews',
    'NavigationTreeShowFunctions',
    'NavigationTreeShowProcedures',
    'NavigationTreeShowEvents'
);
$forms['Navi_panel']['Navi_servers'] = array(
    'NavigationDisplayServers',
    'DisplayServersList');
$forms['Navi_panel']['Navi_databases'] = array(
    'NavigationTreeDbSeparator');
$forms['Navi_panel']['Navi_tables'] = array(
    'NavigationTreeDefaultTabTable',
    'NavigationTreeDefaultTabTable2',
    'NavigationTreeTableSeparator',
    'NavigationTreeTableLevel',
);
$forms['Main_panel']['Startup'] = array(
    'ShowCreateDb',
    'ShowStats',
    'ShowServerInfo',
    'ShowPhpInfo',
    'ShowChgPassword');
$forms['Main_panel']['DbStructure'] = array(
    'ShowDbStructureComment',
    'ShowDbStructureCreation',
    'ShowDbStructureLastUpdate',
    'ShowDbStructureLastCheck');
$forms['Main_panel']['TableStructure'] = array(
    'HideStructureActions',
    'ShowColumnComments');
$forms['Main_panel']['Browse'] = array(
    'TableNavigationLinksMode',
    'ShowAll',
    'MaxRows',
    'Order',
    'BrowsePointerEnable',
    'BrowseMarkerEnable',
    'GridEditing',
    'SaveCellsAtOnce',
    'RepeatCells',
    'LimitChars',
    'RowActionLinks',
    'RowActionLinksWithoutUnique',
    'TablePrimaryKeyOrder',
    'RememberSorting',
    'RelationalDisplay');
$forms['Main_panel']['Edit'] = array(
    'ProtectBinary',
    'ShowFunctionFields',
    'ShowFieldTypesInDataEditView',
    'CharEditing',
    'MinSizeForInputField',
    'MaxSizeForInputField',
    'CharTextareaCols',
    'CharTextareaRows',
    'TextareaCols',
    'TextareaRows',
    'LongtextDoubleTextarea',
    'InsertRows',
    'ForeignKeyDropdownOrder',
    'ForeignKeyMaxLimit');
$forms['Main_panel']['Tabs'] = array(
    'TabsMode',
    'ActionLinksMode',
    'DefaultTabServer',
    'DefaultTabDatabase',
    'DefaultTabTable'
);
$forms['Import']['Import_defaults'] = array('Import' => array(
    'format',
    'charset',
    'allow_interrupt',
    'skip_queries'));
$forms['Import']['Sql'] = array('Import' => array(
    'sql_compatibility',
    'sql_no_auto_value_on_zero'));
$forms['Import']['Csv'] = array('Import' => array(
    ':group:' . __('CSV'),
        'csv_replace',
        'csv_ignore',
        'csv_terminated',
        'csv_enclosed',
        'csv_escaped',
        'csv_col_names',
        ':group:end',
    ':group:' . __('CSV using LOAD DATA'),
        'ldi_replace',
        'ldi_ignore',
        'ldi_terminated',
        'ldi_enclosed',
        'ldi_escaped',
        'ldi_local_option',
        ':group:end'));
$forms['Import']['Open_Document'] = array('Import' => array(
    ':group:' . __('OpenDocument Spreadsheet'),
        'ods_col_names',
        'ods_empty_rows',
        'ods_recognize_percentages',
        'ods_recognize_currency'));
$forms['Export']['Export_defaults'] = array('Export' => array(
    'method',
    ':group:' . __('Quick'),
        'quick_export_onserver',
        'quick_export_onserver_overwrite',
        ':group:end',
    ':group:' . __('Custom'),
        'format',
        'compression',
        'charset',
        'lock_tables',
        'as_separate_files',
        'asfile' => ':group',
            'onserver',
            'onserver_overwrite',
            ':group:end',
        'remember_file_template',
        'file_template_table',
        'file_template_database',
        'file_template_server'));
$forms['Export']['Sql'] = array('Export' => array(
    'sql_include_comments' => ':group',
        'sql_dates',
        'sql_relation',
        'sql_mime',
        ':group:end',
    'sql_use_transaction',
    'sql_disable_fk',
    'sql_views_as_tables',
    'sql_metadata',
    'sql_compatibility',
    'sql_structure_or_data',
    ':group:' . __('Structure'),
        'sql_drop_database',
        'sql_create_database',
        'sql_drop_table',
        'sql_procedure_function',
        'sql_create_table' => ':group',
            'sql_if_not_exists',
            'sql_auto_increment',
            ':group:end',
        'sql_create_view',
        'sql_create_trigger',
        'sql_backquotes',
        ':group:end',
    ':group:' . __('Data'),
        'sql_delayed',
        'sql_ignore',
        'sql_type',
        'sql_insert_syntax',
        'sql_max_query_size',
        'sql_hex_for_binary',
        'sql_utc_time'));
$forms['Export']['CodeGen'] = array('Export' => array(
    'codegen_format'));
$forms['Export']['Csv'] = array('Export' => array(
    ':group:' . __('CSV'),
        'csv_separator',
        'csv_enclosed',
        'csv_escaped',
        'csv_terminated',
        'csv_null',
        'csv_removeCRLF',
        'csv_columns',
        ':group:end',
    ':group:' . __('CSV for MS Excel'),
        'excel_null',
        'excel_removeCRLF',
        'excel_columns',
        'excel_edition'));
$forms['Export']['Latex'] = array('Export' => array(
    'latex_caption',
    'latex_structure_or_data',
    ':group:' . __('Structure'),
        'latex_structure_caption',
        'latex_structure_continued_caption',
        'latex_structure_label',
        'latex_relation',
        'latex_comments',
        'latex_mime',
        ':group:end',
    ':group:' . __('Data'),
        'latex_columns',
        'latex_data_caption',
        'latex_data_continued_caption',
        'latex_data_label',
        'latex_null'));
$forms['Export']['Microsoft_Office'] = array('Export' => array(
    ':group:' . __('Microsoft Word 2000'),
        'htmlword_structure_or_data',
        'htmlword_null',
        'htmlword_columns'));
$forms['Export']['Open_Document'] = array('Export' => array(
    ':group:' . __('OpenDocument Spreadsheet'),
        'ods_columns',
        'ods_null',
        ':group:end',
    ':group:' . __('OpenDocument Text'),
        'odt_structure_or_data',
        ':group:' . __('Structure'),
            'odt_relation',
            'odt_comments',
            'odt_mime',
            ':group:end',
        ':group:' . __('Data'),
            'odt_columns',
            'odt_null'));
$forms['Export']['Texy'] = array('Export' => array(
    'texytext_structure_or_data',
    ':group:' . __('Data'),
        'texytext_null',
        'texytext_columns'));
