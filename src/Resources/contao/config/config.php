<?php

/**
 * Contao Open Source CMS, Copyright (C) 2005-2020 Leo Feyer
 * 
 * Modul Banner Config - Backend
 *
 * This is the banner configuration file.
 *
 * @copyright	Glen Langer 2007..2020 <http://contao.ninja>
 * @author      Glen Langer (BugBuster)
 * @license     LGPL 
 * @filesource
 */

\define('BANNER_VERSION', '1.3');
\define('BANNER_BUILD', '6');

/**
 * -------------------------------------------------------------------------
 * BACK END MODULES
 * -------------------------------------------------------------------------
 */
$GLOBALS['BE_MOD']['content']['banner'] = array
(
	'tables'     => array('tl_banner_category', 'tl_banner'),
	'icon'       => 'bundles/bugbusterbanner/iconBanner.gif',
	'stylesheet' => 'bundles/bugbusterbanner/mod_banner_be.css'
);

$GLOBALS['BE_MOD']['system']['bannerstat'] = array
(
	'callback'   => 'BugBuster\BannerStatistics\ModuleBannerStatistics',
	'icon'       => 'bundles/bugbusterbanner/iconBannerStat.gif',
	'stylesheet' => 'bundles/bugbusterbanner/mod_banner_be.css'
);

/**
 * -------------------------------------------------------------------------
 * FRONT END MODULES
 * -------------------------------------------------------------------------
 */
$GLOBALS['FE_MOD']['miscellaneous']['banner'] = 'BugBuster\Banner\ModuleBanner';

/**
 * -------------------------------------------------------------------------
 * HOOKS
 * -------------------------------------------------------------------------
 */
$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('BugBuster\Banner\BannerInsertTag', 'replaceInsertTagsBanner');

/**
 * CSS
 */
if (\defined('TL_MODE') && TL_MODE == 'BE')
{
    $GLOBALS['TL_CSS'][] = 'bundles/bugbusterbanner/backend.css';
}
