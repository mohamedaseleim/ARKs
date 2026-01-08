{**
 * @file plugins/pubIds/ark/templates/arkAssignCheckBox.tpl
 *
 * Copyright (c) 2026 Mohamed Seleim
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Displayed only if the ARK can be assigned.
 * Assign ARK form check box included in arkSuffixEdit.tpl and arkAssign.tpl.
 *}

{capture assign=translatedObjectType}{translate key="plugins.pubIds.ark.editor.arkObjectType"|cat:$pubObjectType}{/capture}
{capture assign=assignCheckboxLabel}{translate key="plugins.pubIds.ark.editor.assignARK" pubId=$pubId pubObjectType=$translatedObjectType}{/capture}

<div class="pkp_form_section">
	<div class="pkp_form_field pkp_checkbox_input">
		<input type="checkbox" 
			   name="assignARK" 
			   id="assignARK" 
			   value="1" 
			   checked 
			   {if $disabled}disabled="disabled"{/if}>
		<label for="assignARK">
			{$assignCheckboxLabel}
		</label>
	</div>
</div>
