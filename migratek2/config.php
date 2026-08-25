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

	/* The mapping between K2 extra fields and Articles custom fields */
	public $cfMapping = [
// 'k2_field_id' => 'content_field_id',
		'1' 	=> '5',
		'2' 	=> '6',
	];
}
