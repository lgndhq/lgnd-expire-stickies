# LGND Expire Sticky Posts
This plugin automatically expires sticky posts after a set number of days (by default, 14). To use:

- Edit the `lgnd-expire-stickies.php` file to set the appropriate value of `LGND_EXPIRE_STICKIES_DAYS`
- Install the plugin by uploading it to the Plugins page in your WordPress backend
- Activate the plugin

Once installed and activated, the plugin will run using wp-cron **hourly**, selecting all sticky posts older than `LGND_EXPIRE_STICKIES_DAYS` and unstickying them.
