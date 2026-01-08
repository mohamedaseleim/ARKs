{**
 * plugins/pubIds/ark/templates/arkAssignCheckBox.tpl
 *
 * Copyright (c) 2026 Mohamed Seleim
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Displayed only if the ARK can be assigned.
 * Assign ARK form check box included in arkSuffixEdit.tpl and arkAssign.tpl.
 *}

{capture assign=translatedObjectType}{translate key="plugins.pubIds.ark.editor.arkObjectType"|cat:$pubObjectType}{/capture}
{capture assign=assignCheckboxLabel}{translate key="plugins.pubIds.ark.editor.assignARK" pubId=$pubId pubObjectType=$translatedObjectType}{/capture}

{fbvFormSection list=true}
	{fbvElement type="checkbox" id="assignARK" checked="true" value="1" label=$assignCheckboxLabel translate=false disabled=$disabled}
{/fbvFormSection}
