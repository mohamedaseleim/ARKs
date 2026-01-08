{**
 * plugins/pubIds/ark/templates/settingsForm.tpl
 *
 * Copyright (c) 2026 Mohamed Seleim
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * ARK plugin settings
 *}

<div id="description" class="pkp_form_section">
	<p>{translate key="plugins.pubIds.ark.manager.settings.description"}</p>
</div>

<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', function() {
		function togglePatternFields() {
			var patternRadio = document.querySelector('input[name="arkSuffix"][value="pattern"]');
			var patternFields = document.getElementById('arkSuffixPatternSettings');
			
			if (patternRadio && patternRadio.checked) {
				patternFields.style.display = 'block';
			} else {
				patternFields.style.display = 'none';
			}
		}

		var suffixRadios = document.querySelectorAll('input[name="arkSuffix"]');
		suffixRadios.forEach(function(radio) {
			radio.addEventListener('change', togglePatternFields);
		});

		togglePatternFields();
	});
</script>

<form class="pkp_form" id="arkSettingsForm" method="post" action="{url router=$smarty.const.ROUTE_COMPONENT op="manage" category="pubIds" plugin=$pluginName verb="save"}">
	{csrf}
	{include file="common/formErrors.tpl"}

	<div class="pkp_form_section">
		<div class="header">
			<h3>{translate key="plugins.pubIds.ark.manager.settings.arkObjects"}</h3>
		</div>
		<p class="pkp_help">{translate key="plugins.pubIds.ark.manager.settings.explainARKs"}</p>
		
		<div class="pkp_form_field pkp_checkbox_input">
			<input type="checkbox" name="enableIssueARK" id="enableIssueARK" value="1" {if $enableIssueARK}checked{/if}>
			<label for="enableIssueARK">{translate key="plugins.pubIds.ark.manager.settings.enableIssueARK"}</label>
		</div>
		<div class="pkp_form_field pkp_checkbox_input">
			<input type="checkbox" name="enableSubmissionARK" id="enableSubmissionARK" value="1" {if $enableSubmissionARK}checked{/if}>
			<label for="enableSubmissionARK">{translate key="plugins.pubIds.ark.manager.settings.enableSubmissionARK"}</label>
		</div>
		<div class="pkp_form_field pkp_checkbox_input">
			<input type="checkbox" name="enableRepresentationARK" id="enableRepresentationARK" value="1" {if $enableRepresentationARK}checked{/if}>
			<label for="enableRepresentationARK">{translate key="plugins.pubIds.ark.manager.settings.enableRepresentationARK"}</label>
		</div>
	</div>

	<div class="pkp_form_section">
		<div class="header">
			<h3>{translate key="plugins.pubIds.ark.manager.settings.arkPrefix"}</h3>
		</div>
		<div class="pkp_form_field pkp_text_input">
			<p class="pkp_help">{translate key="plugins.pubIds.ark.manager.settings.arkPrefix.description"}</p>
			<label class="label" for="arkPrefix">{translate key="plugins.pubIds.ark.manager.settings.arkPrefix"}</label>
			<input type="text" name="arkPrefix" id="arkPrefix" value="{$arkPrefix|escape}" required class="pkp_form_control" size="40">
		</div>
	</div>

	<div class="pkp_form_section">
		<div class="header">
			<h3>{translate key="plugins.pubIds.ark.manager.settings.arkSuffix"}</h3>
		</div>
		<p class="pkp_help">{translate key="plugins.pubIds.ark.manager.settings.arkSuffix.description"}</p>

		<div class="pkp_form_field pkp_radio_input">
			<input type="radio" name="arkSuffix" id="arkSuffixDefault" value="default" {if !in_array($arkSuffix, array("pattern", "customId"))}checked{/if}>
			<label for="arkSuffixDefault">
				{translate key="plugins.pubIds.ark.manager.settings.arkSuffixDefault"}
			</label>
			<div class="description">
				{translate key="plugins.pubIds.ark.manager.settings.arkSuffixDefault.description"}
			</div>
		</div>

		<div class="pkp_form_field pkp_radio_input">
			<input type="radio" name="arkSuffix" id="arkSuffixCustomId" value="customId" {if $arkSuffix == "customId"}checked{/if}>
			<label for="arkSuffixCustomId">
				{translate key="plugins.pubIds.ark.manager.settings.arkSuffixCustomIdentifier"}
			</label>
		</div>

		<div class="pkp_form_field pkp_radio_input">
			<input type="radio" name="arkSuffix" id="arkSuffixPattern" value="pattern" {if $arkSuffix == "pattern"}checked{/if}>
			<label for="arkSuffixPattern">
				{translate key="plugins.pubIds.ark.manager.settings.arkSuffixPattern"}
			</label>
			<div class="description">
				{translate key="plugins.pubIds.ark.manager.settings.arkSuffixPattern.example"}
			</div>
		</div>

		<div id="arkSuffixPatternSettings" style="display:none; margin-top: 10px; padding-left: 20px; border-left: 2px solid #ddd;">
			<div class="pkp_form_field pkp_text_input">
				<label class="label" for="arkIssueSuffixPattern">{translate key="plugins.pubIds.ark.manager.settings.arkSuffixPattern.issues"}</label>
				<input type="text" name="arkIssueSuffixPattern" id="arkIssueSuffixPattern" value="{$arkIssueSuffixPattern|escape}" class="pkp_form_control">
			</div>
			<div class="pkp_form_field pkp_text_input">
				<label class="label" for="arkSubmissionSuffixPattern">{translate key="plugins.pubIds.ark.manager.settings.arkSuffixPattern.submissions"}</label>
				<input type="text" name="arkSubmissionSuffixPattern" id="arkSubmissionSuffixPattern" value="{$arkSubmissionSuffixPattern|escape}" class="pkp_form_control">
			</div>
			<div class="pkp_form_field pkp_text_input">
				<label class="label" for="arkRepresentationSuffixPattern">{translate key="plugins.pubIds.ark.manager.settings.arkSuffixPattern.representations"}</label>
				<input type="text" name="arkRepresentationSuffixPattern" id="arkRepresentationSuffixPattern" value="{$arkRepresentationSuffixPattern|escape}" class="pkp_form_control">
			</div>
		</div>
	</div>

	<div class="pkp_form_section">
		<div class="header">
			<h3>{translate key="plugins.pubIds.ark.manager.settings.arkResolver"}</h3>
		</div>
		<div class="pkp_form_field pkp_text_input">
			<p class="pkp_help">{translate key="plugins.pubIds.ark.manager.settings.arkResolver.description"}</p>
			<label class="label" for="arkResolver">{translate key="plugins.pubIds.ark.manager.settings.arkResolver"}</label>
			<input type="text" name="arkResolver" id="arkResolver" value="{$arkResolver|escape}" required class="pkp_form_control">
		</div>
	</div>

	<div class="pkp_form_section">
		<div class="header">
			<h3>{translate key="plugins.pubIds.ark.manager.settings.arkReassign"}</h3>
		</div>
		<div class="pkp_form_field">
			<p class="pkp_help">{translate key="plugins.pubIds.ark.manager.settings.arkReassign.description"}</p>
			{include file="linkAction/linkAction.tpl" action=$clearPubIdsLinkAction contextId="arkSettingsForm"}
		</div>
	</div>

	<div class="pkp_form_buttons">
		<button class="pkp_button pkp_button_primary" type="submit">{translate key="common.save"}</button>
		<button class="pkp_button" type="button" id="cancelFormButton" onclick="document.location.reload()">{translate key="common.cancel"}</button>
	</div>
</form>

<p><span class="formRequired">{translate key="common.requiredField"}</span></p>
