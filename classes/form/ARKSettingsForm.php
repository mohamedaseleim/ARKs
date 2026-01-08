<?php

/**
 * @file plugins/pubIds/ark/classes/form/ARKSettingsForm.php
 *
 * Copyright (c) 2026 Mohamed Seleim
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class ARKSettingsForm
 * @ingroup plugins_pubIds_ark
 *
 * @brief Form for journal managers to setup ARK plugin
 */

namespace APP\plugins\pubIds\ark\classes\form;

use APP\core\Application;
use PKP\form\Form;
use PKP\form\validation\FormValidatorCSRF;
use PKP\form\validation\FormValidatorCustom;
use PKP\form\validation\FormValidatorPost;
use PKP\form\validation\FormValidatorRegExp;
use PKP\form\validation\FormValidatorUrl;
use PKP\linkAction\LinkAction;
use PKP\linkAction\request\RemoteActionConfirmationModal;

class ARKSettingsForm extends Form {

    //
    // Private properties
    //
    /** @var integer */
    public $_contextId;

    /**
     * Get the context ID.
     * @return integer
     */
    function _getContextId() {
        return $this->_contextId;
    }

    /** @var \APP\plugins\pubIds\ark\ARKPubIdPlugin */
    public $_plugin;

    /**
     * Get the plugin.
     * @return \APP\plugins\pubIds\ark\ARKPubIdPlugin
     */
    function _getPlugin() {
        return $this->_plugin;
    }

    //
    // Constructor
    //
    /**
     * Constructor
     * @param $plugin \APP\plugins\pubIds\ark\ARKPubIdPlugin
     * @param $contextId integer
     */
    function __construct($plugin, $contextId) {
        $this->_contextId = $contextId;
        $this->_plugin = $plugin;

        parent::__construct($plugin->getTemplateResource('settingsForm.tpl'));

        $form = $this;
        $this->addCheck(new FormValidatorCustom($this, 'arkObjects', 'required', 'plugins.pubIds.ark.manager.settings.arkObjectsRequired', function($enableIssueARK) use ($form) {
            return $form->getData('enableIssueARK') || $form->getData('enableSubmissionARK') || $form->getData('enableRepresentationARK');
        }));
        $this->addCheck(new FormValidatorRegExp($this, 'arkPrefix', 'required', 'plugins.pubIds.ark.manager.settings.form.arkPrefixPattern', '/^ark:\/[0123456789bcdfghjkmnpqrstvwxz]{1,16}$/'));
        $this->addCheck(new FormValidatorCustom($this, 'arkIssueSuffixPattern', 'required', 'plugins.pubIds.ark.manager.settings.arkIssueSuffixPatternRequired', function($arkIssueSuffixPattern) use ($form) {
            if ($form->getData('arkSuffix') == 'pattern' && $form->getData('enableIssueARK')) return $arkIssueSuffixPattern != '';
            return true;
        }));
        $this->addCheck(new FormValidatorCustom($this, 'arkSubmissionSuffixPattern', 'required', 'plugins.pubIds.ark.manager.settings.arkSubmissionSuffixPatternRequired', function($arkSubmissionSuffixPattern) use ($form) {
            if ($form->getData('arkSuffix') == 'pattern' && $form->getData('enableSubmissionARK')) return $arkSubmissionSuffixPattern != '';
            return true;
        }));
        $this->addCheck(new FormValidatorCustom($this, 'arkRepresentationSuffixPattern', 'required', 'plugins.pubIds.ark.manager.settings.arkRepresentationSuffixPatternRequired', function($arkRepresentationSuffixPattern) use ($form) {
            if ($form->getData('arkSuffix') == 'pattern' && $form->getData('enableRepresentationARK')) return $arkRepresentationSuffixPattern != '';
            return true;
        }));
        $this->addCheck(new FormValidatorUrl($this, 'arkResolver', 'required', 'plugins.pubIds.ark.manager.settings.form.arkResolverRequired'));
        $this->addCheck(new FormValidatorPost($this));
        $this->addCheck(new FormValidatorCSRF($this));

        // for ARK reset requests
        // LinkAction imports are handled at the top of the file via 'use'
        $request = Application::get()->getRequest();
        
        $this->setData('clearPubIdsLinkAction', new LinkAction(
            'reassignARKs',
            new RemoteActionConfirmationModal(
                $request->getSession(),
                __('plugins.pubIds.ark.manager.settings.arkReassign.confirm'),
                __('common.delete'),
                $request->url(null, null, 'manage', null, array('verb' => 'clearPubIds', 'plugin' => $plugin->getName(), 'category' => 'pubIds')),
                'modal_delete'
            ),
            __('plugins.pubIds.ark.manager.settings.arkReassign'),
            'delete'
        ));
        $this->setData('pluginName', $plugin->getName());
    }


    //
    // Implement template methods from Form
    //

    /**
     * @copydoc Form::initData()
     */
    function initData() {
        $contextId = $this->_getContextId();
        $plugin = $this->_getPlugin();
        foreach($this->_getFormFields() as $fieldName => $fieldType) {
            $this->setData($fieldName, $plugin->getSetting($contextId, $fieldName));
        }
    }

    /**
     * @copydoc Form::readInputData()
     */
    function readInputData() {
        $this->readUserVars(array_keys($this->_getFormFields()));
    }

    /**
     * @copydoc Form::execute()
     */
    function execute(...$functionArgs) {
        $contextId = $this->_getContextId();
        $plugin = $this->_getPlugin();
        foreach($this->_getFormFields() as $fieldName => $fieldType) {
            $plugin->updateSetting($contextId, $fieldName, $this->getData($fieldName), $fieldType);
        }
    }

    //
    // Private helper methods
    //
    function _getFormFields() {
        return array(
            'enableIssueARK' => 'bool',
            'enableSubmissionARK' => 'bool',
            'enableRepresentationARK' => 'bool',
            'arkPrefix' => 'string',
            'arkSuffix' => 'string',
            'arkIssueSuffixPattern' => 'string',
            'arkSubmissionSuffixPattern' => 'string',
            'arkRepresentationSuffixPattern' => 'string',
            'arkResolver' => 'string',
        );
    }
}
