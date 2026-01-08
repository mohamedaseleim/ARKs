<?php

/**
 * @defgroup plugins_pubIds_ark ARK Pub ID Plugin
 */

/**
 * @file plugins/pubIds/ark/index.php
 *
 * Copyright (c) 2026 Mohamed Seleim
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup plugins_pubIds_ark
 * @brief Wrapper for ark plugin.
 *
 */

require_once('ARKPubIdPlugin.php');

return new \APP\plugins\pubIds\ark\ARKPubIdPlugin();
