# Joomla 3.x K2 to Core Content Migration Script

This Joomla 3.x CLI script helps Joomla users who are using the K2 extension to migrate K2 database entities (including items, categories, tags, extra fields, and images) into their corresponding entities of core Joomla content.

## ✨ Features on this fork

On top of the original script, this fork adds:

- **Test mode:** migrate a single K2 item to try out your configuration before running the full migration.
- **Reuse category on alias conflict:** optionally reuse an existing Joomla category instead of failing the migration when an auto-generated alias collides with one already there.
- **Better logging for extra fields:** unmapped or missing K2 extra fields are logged upfront, and dropdown/select/radio/multiple-select values are resolved to their option labels instead of raw internal values.
- **Media field mapping:** K2's "Media" tab (third-party provider + URL/ID, e.g. a YouTube video) is split and migrated into Joomla Articles custom fields.
- **Migrate item hits:** optionally carry K2 item hit counts over to the migrated article's hit count.
- **Migrate rating:** optionally carry K2 item ratings over to the migrated article's vote.
- **Configurable images folder:** optionally save migrated K2 item and category images into a subfolder of `images/` instead of directly in it.

See the Installation section below for how to configure each of these.

## ✅ Prerequisites

- Joomla 3.10
- PHP 7.4
- Terminal or Shell access
- Article custom fields (corresponding to K2 extra fields with a matching field type)

## 🛠️ Installation

1. Clone or download this repository to the `cli` folder inside your Joomla site's root directory.
2. Fill in the required configuration values in the `migratek2/config.php` file:
   - **Super Admin Username and Password:** Required to create Joomla articles, categories, etc.
   - **Items Per Loop:** Set the number of items to migrate per loop to avoid timeouts.
   - **Extra Fields Mapping:** Map K2 extra fields to corresponding Joomla Articles custom fields (MUST be created before running the script). Below is an example of how to do this:
     ```php
     public $cfMapping = [
         // 'k2_field_id' => 'content_field_id',
         '3' => '1',
         '1' => '2',
         '2' => '3',
     ];
     ```
     In this example, K2 field with ID `3` is mapped to Joomla content field with ID `1`, K2 field `1` to Joomla content field `2`, and so on.
   - **Attachment Field:** Specify the ID of the attachment custom field (Note: only `File Upload` type of `Advanced Custom Fields` is supported for now).
   - **Attachment Folder:** Specify the attachments folder exactly the same as configured in the `File Upload` field.
   - **Item Images Folder:** By default, K2 item images are copied straight into the site's `images/` folder. Set the following to save them into a subfolder of `images/` instead (created automatically if it doesn't exist):
     ```php
     public $itemImagesFolder = 'k2'; // saves item images under images/k2/ instead of images/
     ```
     Leave blank (the default) to keep the previous behavior.
   - **Category Images Folder:** Same idea, but for K2 category images:
     ```php
     public $categoryImagesFolder = 'k2/categories'; // saves category images under images/k2/categories/ instead of images/
     ```
     Leave blank (the default) to keep the previous behavior.
   - **Test Mode:** Before running the full migration, you can test your configuration against a single K2 item:
     ```php
     public $testMode = true;
     public $testItemId = 123; // the K2 item id (#__k2_items.id) to migrate
     ```
     When `$testMode` is `true`, the script only migrates the K2 item whose ID is `$testItemId` (its category is created/mapped as usual) and then stops, instead of migrating the whole K2 database. Set `$testMode` back to `false` to run the full migration.
   - **Reuse Category on Alias Match:** The script matches a K2 category to an existing Joomla category by title first. If no title matches, it creates a new category — but if that new category's auto-generated alias collides with an existing one (same parent/extension/language), Joomla fails with `JLIB_DATABASE_ERROR_CATEGORY_UNIQUE_ALIAS`, and by default that category (and its items) is skipped, same as before. Set the following to `true` to instead reuse the existing category with the matching alias:
     ```php
     public $reuseCategoryOnAliasMatch = false; // set to true to reuse existing categories on alias conflicts
     ```
   - **Migrate Hits:** By default, each K2 item's hit count is carried over to the migrated article's hit count. Set the following to `false` to leave migrated articles at their default hit count (0) instead:
     ```php
     public $migrateHits = true; // set to false to not migrate K2 item hit counts
     ```
   - **Migrate Rating:** By default, each K2 item's rating (its average rating and vote count, stored in K2's `#__k2_rating` table) is carried over to the migrated article's vote (Joomla's `#__content_rating` table, used by the core "Voting" feature). Set the following to `false` to leave migrated articles without a rating instead:
     ```php
     public $migrateRating = true; // set to false to not migrate K2 item ratings
     ```
     Items nobody rated in K2 have no rating to migrate and are left without a vote either way.
   - **Media Field Mapping:** A K2 item's Media tab ("Select third-party media provider" and "...and enter media URL (or ID)", e.g. a YouTube/Vimeo video) is stored by K2 as a single value shaped like `{provider}url-or-id{/provider}` (e.g. `{youtube}dQw4w9WgXcQ{/youtube}`). Map the provider and the URL/ID to their own Joomla Articles custom fields (MUST be created before running the script):
     ```php
     public $mediaProviderCFId = 4; // custom field to receive the provider, e.g. "youtube"
     public $mediaValueCFId = 5;    // custom field to receive the URL/ID
     ```
     Leave either at `0` to skip it. Uploaded/remote media use this same bracket format (a file extension in place of the provider name) and will also be split into these two fields if configured; a raw HTML embed (the form's "Embed" tab) doesn't use this format and isn't migrated.

## 🚀 Usage

1. Navigate to the document root of your Joomla website.
2. Run the script using the command: 
   ```bash
   php cli/migratek2.php
   ```
3. If your Super Admin user has 2FA enabled, you will be prompted to enter the secret key. If not, simply press Enter.
4. The script will display messages indicating the progress of the migration, including the categories and K2 items being migrated.
5. Once the process is complete, you will see the message "Finished migrating K2 database.". See the screenshot below.
   ![image](https://github.com/user-attachments/assets/6cd4462f-343c-4290-81b3-528d1f171a35)


## ☕ Support This Project

If this script has helped you with your migration process, consider supporting its development.

* <a href="https://paypal.me/juanpablohwd" target="_blank" rel="noopener noreferrer">Support the work on this fork</a>
* <a href="https://paypal.me/mabdelaziz77" target="_blank" rel="noopener noreferrer">Support the original creator</a>

Thank you for your donation!

## ⚠️ Disclaimer & Warranty

This script is provided "as is," without warranty of any kind, express or implied. While I’ve made efforts to ensure it works as intended, it has not been extensively tested. Use it at your own risk.

I am not responsible for any damage or loss of data that may occur as a result of using this script. It is highly recommended to back up your site and database before running the script.
