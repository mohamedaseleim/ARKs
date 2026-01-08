{**
 * @file plugins/pubIds/ark/templates/arkAssign.tpl
 *
 * Copyright (c) 2026 Mohamed Seleim
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Assign ARK to an object option.
 *}

{assign var=pubObjectType value=$pubIdPlugin->getPubObjectType($pubObject)}

{assign var=contextId value=$pubObject->getData('contextId')}
{assign var=enableObjectARK value=$pubIdPlugin->isObjectTypeEnabled($pubObjectType, $contextId)}

{if $enableObjectARK}
    <div class="pkp_form_section" id="pubIdARKFormArea">
        <div class="header">
            <h3>{translate key="plugins.pubIds.ark.editor.ark"}</h3>
        </div>

        {if $pubObject->getStoredPubId($pubIdPlugin->getPubIdType())}
            <div class="section">
                <p class="pkp_help">
                    {translate key="plugins.pubIds.ark.editor.assignARK.assigned" pubId=$pubObject->getStoredPubId($pubIdPlugin->getPubIdType())}
                </p>
            </div>
        {else}
            {assign var=pubId value=$pubIdPlugin->getPubId($pubObject)}
            
            {if !$canBeAssigned}
                <div class="section">
                    {if !$pubId}
                        <p class="pkp_help">{translate key="plugins.pubIds.ark.editor.assignARK.emptySuffix"}</p>
                    {else}
                        <p class="pkp_help">{translate key="plugins.pubIds.ark.editor.assignARK.pattern" pubId=$pubId}</p>
                    {/if}
                </div>
            {else}
                {assign var=templatePath value=$pubIdPlugin->getTemplateResource('arkAssignCheckBox.tpl')}
                {include file=$templatePath pubId=$pubId pubObjectType=$pubObjectType}
            {/if}
        {/if}
    </div>
{/if}
