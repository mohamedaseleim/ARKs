{**
 * plugins/pubIds/ark/templates/arkAssignCheckBox.tpl
 *
 * Copyright (c) 2026 Mohamed Seleim
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * ARK assignment checkbox (Optimized using FBV).
 *}

{capture assign=translatedObjectType}{translate key="plugins.pubIds.ark.editor.arkObjectType"|cat:$pubObjectType}{/capture}
{capture assign=assignCheckboxLabel}{translate key="plugins.pubIds.ark.editor.assignARK" pubId=$pubId pubObjectType=$translatedObjectType}{/capture}

{fbvFormSection list=true}
	{fbvElement 
		type="checkbox" 
		id="assignARK" 
		value="1" 
		checked=true 
		disabled=$disabled 
		label=$assignCheckboxLabel 
		translate=false
	}
{/fbvFormSection}
