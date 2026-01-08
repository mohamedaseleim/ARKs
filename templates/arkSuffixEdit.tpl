{**
 * plugins/pubIds/ark/templates/arkSuffixEdit.tpl
 *
 * Copyright (c) 2026 Mohamed Seleim
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Edit custom ARK suffix for an object (issue, submission, file)
 *}
{load_script context="publicIdentifiersForm" scripts=$scripts}

{assign var=pubObjectType value=$pubIdPlugin->getPubObjectType($pubObject)}
{assign var=contextId value=$pubObject->getData('contextId')}
{assign var=enableObjectARK value=$pubIdPlugin->isObjectTypeEnabled($pubObjectType, $contextId)}

{if $enableObjectARK}
	{assign var=storedPubId value=$pubObject->getStoredPubId($pubIdPlugin->getPubIdType())}
	
	<div class="pkp_form_section" id="pubIdARKFormArea">
		<div class="header">
			<h3>{translate key="plugins.pubIds.ark.editor.ark"}</h3>
		</div>
		
		{assign var=formArea value=true}
		
		{if $pubIdPlugin->getSetting($contextId, 'arkSuffix') == 'customId' || $storedPubId}
			
			{if empty($storedPubId)} 
				
				<div class="section">
					<p class="pkp_help">{translate key="plugins.pubIds.ark.manager.settings.arkSuffix.description"}</p>
					
					<div class="pkp_form_field pkp_text_input">
						<label class="label">
							{translate key="plugins.pubIds.ark.manager.settings.arkPrefix"}
						</label>
						<input type="text" 
							   disabled="disabled" 
							   value="{$pubIdPlugin->getSetting($contextId, 'arkPrefix')|escape}" 
							   class="pkp_form_control" 
							   style="display: inline-block; width: 48%; margin-right: 2%;">
					
						<label class="label" style="display:inline;">
							{translate key="plugins.pubIds.ark.manager.settings.arkSuffix"}
						</label>
						<input type="text" 
							   name="arkSuffix" 
							   id="arkSuffix" 
							   value="{$arkSuffix|escape}" 
							   class="pkp_form_control" 
							   style="display: inline-block; width: 48%;">
					</div>
				</div>

				{if $canBeAssigned}
					<div class="section">
						<p class="pkp_help">{translate key="plugins.pubIds.ark.editor.canBeAssigned"}</p>
						{assign var=templatePath value=$pubIdPlugin->getTemplateResource('arkAssignCheckBox.tpl')}
						{include file=$templatePath pubId=$pubIdPlugin->getPubId($pubObject) pubObjectType=$pubObjectType}
					</div>
				{else}
					<div class="section">
						<p class="pkp_help">{translate key="plugins.pubIds.ark.editor.customSuffixMissing"}</p>
					</div>
				{/if}

			{else}
				<div class="section">
					<p>
						<strong>{$storedPubId|escape}</strong><br />
						{capture assign=translatedObjectType}{translate key="plugins.pubIds.ark.editor.arkObjectType"|cat:$pubObjectType}{/capture}
						{capture assign=assignedMessage}{translate key="plugins.pubIds.ark.editor.assigned" pubObjectType=$translatedObjectType}{/capture}
						<span class="pkp_help">{$assignedMessage}</span>
						
						{* زر الحذف (Clear) *}
						{include file="linkAction/linkAction.tpl" action=$clearPubIdLinkActionARK contextId="publicIdentifiersForm"}
					</p>
				</div>
			{/if}

		{else} {* حالة: عرض المعرف المتوقع (Pattern Preview) *}
			<div class="section">
				<p>{$pubIdPlugin->getPubId($pubObject)|escape}</p>
				{if $canBeAssigned}
					<p class="pkp_help">{translate key="plugins.pubIds.ark.editor.canBeAssigned"}</p>
					{assign var=templatePath value=$pubIdPlugin->getTemplateResource('arkAssignCheckBox.tpl')}
					{include file=$templatePath pubId=$pubIdPlugin->getPubId($pubObject) pubObjectType=$pubObjectType}
				{else}
					<p class="pkp_help">{translate key="plugins.pubIds.ark.editor.patternNotResolved"}</p>
				{/if}
			</div>
		{/if}
	</div>
{/if}

{if $pubObjectType == 'Issue'}
	{assign var=enableSubmissionARK value=$pubIdPlugin->getSetting($contextId, "enableSubmissionARK")}
	{assign var=enableRepresentationARK value=$pubIdPlugin->getSetting($contextId, "enableRepresentationARK")}
	
	{if $enableSubmissionARK || $enableRepresentationARK}
		{if !$formArea}
			{assign var="formAreaTitle" value="plugins.pubIds.ark.editor.ark"}
		{else}
			{assign var="formAreaTitle" value=""}
		{/if}
		
		<div class="pkp_form_section" id="pubIdARKIssueobjectsFormArea">
			{if $formAreaTitle}
				<div class="header">
					<h3>{translate key=$formAreaTitle}</h3>
				</div>
			{/if}
			
			<div class="section">
				<p class="pkp_help">{translate key="plugins.pubIds.ark.editor.clearIssueObjectsARK.description"}</p>
				{include file="linkAction/linkAction.tpl" action=$clearIssueObjectsPubIdsLinkActionARK contextId="publicIdentifiersForm"}
			</div>
		</div>
	{/if}
{/if}
