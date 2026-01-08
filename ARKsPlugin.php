<?php

/**
 * @file plugins/pubIds/ark/ARKPubIdPlugin.php
 *
 * Copyright (c) 2026 Mohamed Seleim
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
use PKP\form\Form;

class ARKPubIdPlugin extends PubIdPlugin {

    //
    // Implement template methods from Plugin.
    //
    /**
     * @copydoc Plugin::getDisplayName()
     */
    public function getDisplayName(): string {
        return __('plugins.pubIds.ark.displayName');
    }

    /**
     * @copydoc Plugin::getDescription()
     */
    public function getDescription(): string {
        return __('plugins.pubIds.ark.description');
    }


    //
    // Implement template methods from PubIdPlugin.
    //
    /**
     * @copydoc PKPPubIdPlugin::constructPubId()
     */
    public function constructPubId($pubIdPrefix, $pubIdSuffix, $contextId): string {
        return $pubIdPrefix . '/' . $pubIdSuffix;
    }

    /**
     * @copydoc PKPPubIdPlugin::getPubIdType()
     */
    public function getPubIdType(): string {
        return 'ark';
    }

    /**
     * @copydoc PKPPubIdPlugin::getPubIdDisplayType()
     */
    public function getPubIdDisplayType(): string {
        return 'ARK';
    }

    /**
     * @copydoc PKPPubIdPlugin::getPubIdFullName()
     */
    public function getPubIdFullName(): string {
        return 'Archival Resource Key';
    }

    /**
     * @copydoc PKPPubIdPlugin::getResolvingURL()
     */
    public function getResolvingURL($contextId, $pubId): string {
        $resolverURL = $this->getSetting($contextId, 'arkResolver');
        return $resolverURL . $pubId;
    }

    /**
     * @copydoc PKPPubIdPlugin::getPubIdMetadataFile()
     */
    public function getPubIdMetadataFile(): string {
        return $this->getTemplateResource('arkSuffixEdit.tpl');
    }

    /**
     * @copydoc PKPPubIdPlugin::addJavaScript()
     */
    public function addJavaScript($request, $templateMgr): void {
        // Implementation left empty as per original code
    }

    /**
     * @copydoc PKPPubIdPlugin::getPubIdAssignFile()
     */
    public function getPubIdAssignFile(): string {
        return $this->getTemplateResource('arkAssign.tpl');
    }

    /**
     * @copydoc PKPPubIdPlugin::instantiateSettingsForm()
     */
    public function instantiateSettingsForm($contextId): Form {
        return new ARKSettingsForm($this, $contextId);
    }

    /**
     * @copydoc PKPPubIdPlugin::getFormFieldNames()
     */
    public function getFormFieldNames(): array {
        return array('arkSuffix');
    }

    /**
     * @copydoc PKPPubIdPlugin::getAssignFormFieldName()
     */
    public function getAssignFormFieldName(): string {
        return 'assignARK';
    }

    /**
     * @copydoc PKPPubIdPlugin::getPrefixFieldName()
     */
    public function getPrefixFieldName(): string {
        return 'arkPrefix';
    }

    /**
     * @copydoc PKPPubIdPlugin::getSuffixFieldName()
     */
    public function getSuffixFieldName(): string {
        return 'arkSuffix';
    }

    /**
     * @copydoc PKPPubIdPlugin::getLinkActions()
     */
    public function getLinkActions($pubObject): array {
        $linkActions = array();
        
        $request = Application::get()->getRequest();
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

        if (is_a($pubObject, 'APP\issue\Issue')) {
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
    public function getSuffixPatternsFieldNames(): array {
        return array(
            'Issue' => 'arkIssueSuffixPattern',
            'Submission' => 'arkSubmissionSuffixPattern',
            'Representation' => 'arkRepresentationSuffixPattern',
        );
    }

    /**
     * @copydoc PKPPubIdPlugin::getDAOFieldNames()
     */
    public function getDAOFieldNames(): array {
        return array('pub-id::ark');
    }

    /**
     * @copydoc PKPPubIdPlugin::isObjectTypeEnabled()
     */
    public function isObjectTypeEnabled($pubObjectType, $contextId): bool {
        return (boolean) $this->getSetting($contextId, "enable{$pubObjectType}ARK");
    }

    /**
     * @copydoc PKPPubIdPlugin::getNotUniqueErrorMsg()
     */
    public function getNotUniqueErrorMsg(): string {
        return __('plugins.pubIds.ark.editor.arkSuffixCustomIdentifierNotUnique');
    }
}
