<?php

/**
 * @defgroup plugins_reports_subscription Subscription Report Plugin
 */
 
/**
 * @file plugins/reports/subscriptions/index.php
 *
 * Copyright (c) 2014 Simon Fraser University Library
 * Copyright (c) 2003-2014 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup plugins_reports_subscription
 * @brief Wrapper for subscription report plugin.
 *
 */

require_once('SubscriptionReportPlugin.inc.php');

return new SubscriptionReportPlugin();

?>
