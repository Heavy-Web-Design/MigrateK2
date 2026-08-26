<?php

class MigK2Config
{
	/* 
	 * Super admin account is needed to create Joomla content . 
	 * $migk2Username: Super admin username
	 * $migk2Password: Super admin password
	*/
	public $migk2Username = '';
	public $migk2Password = '';

	/* Attachment field id */
	public $attachmentCFId = '';
	
	/* Attachments Folder*/
	public $attachmentsFolder = '';

	/* K2 items migrated per loop, just to avoid timeout */
	public $itemsPerLoop = 50;

	/*
	 * Test mode: migrate only a single K2 item instead of the whole
	 * K2 database. Useful to try out the configuration (custom fields
	 * mapping, attachments, etc.) before running the full migration.
	 * $testMode:   set to true to enable test mode
	 * $testItemId: the K2 item id (#__k2_items.id) to migrate when
	 *              test mode is enabled
	 */
	public $testMode = false;
	public $testItemId = 0;

	/*
	 * When a K2 category's title doesn't match an existing Joomla category
	 * but its auto-generated alias collides with one that's already there
	 * (same parent/extension/language), Joomla normally throws
	 * "JLIB_DATABASE_ERROR_CATEGORY_UNIQUE_ALIAS" and the category fails
	 * to be created. Set this to true to instead reuse that existing
	 * category (matched by alias) for the migration.
	 */
	public $reuseCategoryOnAliasMatch = false;

	/* The mapping between K2 extra fields and Articles custom fields */
	public $cfMapping = [
// 'k2_field_id' => 'content_field_id',
		'1' 	=> '5',
		'2' 	=> '6',
	];

	/*
	 * K2 items can carry a "Media" value (#__k2_items.video) set via the
	 * item edit form's Media tab, options "Select third-party media
	 * provider" (e.g. YouTube, Vimeo, ...) and "...and enter media URL
	 * (or ID)". K2 stores that as a single string shaped like
	 * "{provider}url-or-id{/provider}", e.g. "{youtube}dQw4w9WgXcQ{/youtube}".
	 * Set the ids below to migrate the provider and the URL/ID into their
	 * own Joomla custom (com_fields) fields on the article. Leave either
	 * at 0 to skip it. Media set via the other Media tab options
	 * (uploaded file, remote file URL) uses the same bracket format and
	 * will also be split into these two fields; a raw HTML embed (the
	 * "Embed" tab) does not use this format and is not migrated here.
	 */
	public $mediaProviderCFId = 0;
	public $mediaValueCFId = 0;
}
