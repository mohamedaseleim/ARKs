<?php

/**
 * @file plugins/pubIds/ark/ARKPubIdPlugin.php
 *
 * Copyright (c) 2025 Mohamed Seleim
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class ARKPubIdPlugin
 * @ingroup plugins_pubIds_ark
 *
 * @brief ARK plugin class
 */

namespace APP\plugins\pubIds\ark;

use APP\core\Application;
use APP\plugins\pubIds\ark\classes\form\ARKSettingsForm;
use PKP\linkAction\LinkAction;
use PKP\linkAction\request\RemoteActionConfirmationModal;
use PKP\plugins\PubIdPlugin;

class ARKPubIdPlugin extends PubIdPlugin {

    //
    // Implement template methods from Plugin.
    //
    /**
     * @copydoc Plugin::getDisplayName()
     */
    function getDisplayName() {
        return __('plugins.pubIds.ark.displayName');
    }

    /**
     * @copydoc Plugin::getDescription()
     */
    function getDescription() {
        return __('plugins.pubIds.ark.description');
    }


    //
    // Implement template methods from PubIdPlugin.
    //
    /**
     * @copydoc PKPPubIdPlugin::constructPubId()
     */
    function constructPubId($pubIdPrefix, $pubIdSuffix, $contextId) {
        $ark = $pubIdPrefix .'/'. $pubIdSuffix;
        return $ark;
    }

    /**
     * @copydoc PKPPubIdPlugin::getPubIdType()
     */
    function getPubIdType() {
        return 'ark';
    }

    /**
     * @copydoc PKPPubIdPlugin::getPubIdDisplayType()
     */
    function getPubIdDisplayType() {
        return 'ARK';
    }

    /**
     * @copydoc PKPPubIdPlugin::getPubIdFullName()
     */
    function getPubIdFullName() {
        return 'Archival Resource Key';
    }

    /**
     * @copydoc PKPPubIdPlugin::getResolvingURL()
     */
    function getResolvingURL($contextId, $pubId) {
        $resolverURL = $this->getSetting($contextId, 'arkResolver');
        return $resolverURL . $pubId;
    }

    /**
     * @copydoc PKPPubIdPlugin::getPubIdMetadataFile()
     */
    function getPubIdMetadataFile() {
        return $this->getTemplateResource('arkSuffixEdit.tpl');
    }

    /**
     * @copydoc PKPPubIdPlugin::addJavaScript()
     */
    function addJavaScript($request, $templateMgr) {
        // Implementation left empty as per original code
    }

    /**
     * @copydoc PKPPubIdPlugin::getPubIdAssignFile()
     */
    function getPubIdAssignFile() {
        return $this->getTemplateResource('arkAssign.tpl');
    }

    /**
     * @copydoc PKPPubIdPlugin::instantiateSettingsForm()
     */
    function instantiateSettingsForm($contextId) {
        // في الإصدارات الحديثة، نستخدم الـ namespace مباشرة بدلاً من import
        // سنحتاج للتأكد من تحديث ملف ARKSettingsForm لاحقاً ليحمل الـ namespace الصحيح
        return new ARKSettingsForm($this, $contextId);
    }

    /**
     * @copydoc PKPPubIdPlugin::getFormFieldNames()
     */
    function getFormFieldNames() {
        return array('arkSuffix');
    }

    /**
     * @copydoc PKPPubIdPlugin::getAssignFormFieldName()
     */
    function getAssignFormFieldName() {
        return 'assignARK';
    }

    /**
     * @copydoc PKPPubIdPlugin::getPrefixFieldName()
     */
    function getPrefixFieldName() {
        return 'arkPrefix';
    }

    /**
     * @copydoc PKPPubIdPlugin::getSuffixFieldName()
     */
    function getSuffixFieldName() {
        return 'arkSuffix';
    }

    /**
     * @copydoc PKPPubIdPlugin::getLinkActions()
     */
    function getLinkActions($pubObject) {
        $linkActions = array();
        
        // تم استبدال import بـ use statements في الأعلى
        $request = Application::get()->getRequest(); // تحديث طريقة استدعاء الـ Request
        $userVars = $request->getUserVars();
        $userVars['pubIdPlugIn'] = get_class($this);
        
        // Clear object pub id
        $linkActions['clearPubIdLinkActionARK'] = new LinkAction(
            'clearPubId',
            new RemoteActionConfirmationModal(
                $request->getSession(),
                __('plugins.pubIds.ark.editor.clearObjectsARK.confirm'),
                __('common.delete'),
                $request->url(null, null, 'clearPubId', null, $userVars),
                'modal_delete'
            ),
            __('plugins.pubIds.ark.editor.clearObjectsARK'),
            'delete',
            __('plugins.pubIds.ark.editor.clearObjectsARK')
        );

        if (is_a($pubObject, 'APP\issue\Issue')) { // تحديث المسار للتحقق من الكائن Issue
            // Clear issue objects pub ids
            $linkActions['clearIssueObjectsPubIdsLinkActionARK'] = new LinkAction(
                'clearObjectsPubIds',
                new RemoteActionConfirmationModal(
                    $request->getSession(),
                    __('plugins.pubIds.ark.editor.clearIssueObjectsARK.confirm'),
                    __('common.delete'),
                    $request->url(null, null, 'clearIssueObjectsPubIds', null, $userVars),
                    'modal_delete'
                ),
                __('plugins.pubIds.ark.editor.clearIssueObjectsARK'),
                'delete',
                __('plugins.pubIds.ark.editor.clearIssueObjectsARK')
            );
        }

        return $linkActions;
    }

    /**
     * @copydoc PKPPubIdPlugin::getSuffixPatternsFieldName()
     */
    function getSuffixPatternsFieldNames() {
        return array(
            'Issue' => 'arkIssueSuffixPattern',
            'Submission' => 'arkSubmissionSuffixPattern',
            'Representation' => 'arkRepresentationSuffixPattern',
        );
    }

    /**
     * @copydoc PKPPubIdPlugin::getDAOFieldNames()
     */
    function getDAOFieldNames() {
        return array('pub-id::ark');
    }

    /**
     * @copydoc PKPPubIdPlugin::isObjectTypeEnabled()
     */
    function isObjectTypeEnabled($pubObjectType, $contextId) {
        // تحديث صيغة المتغيرات لتوافق PHP 8.2 (Deprecated syntax fixed)
        return (boolean) $this->getSetting($contextId, "enable{$pubObjectType}ARK");
    }

    /**
     * @copydoc PKPPubIdPlugin::getNotUniqueErrorMsg()
     */
    function getNotUniqueErrorMsg() {
        return __('plugins.pubIds.ark.editor.arkSuffixCustomIdentifierNotUnique');
    }
}
