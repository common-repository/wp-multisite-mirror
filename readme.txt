=== WP Multisite Mirror ===
Contributors: kienguyen
Donate link: http://designtomarkup.com/
Tags: multisite, mirror
Requires at least: 3.0
Tested up to: 3.2.1
Stable tag: 0.2

Populate multiple, different WP Multisite sites with identical content from the same database.

== Description ==

This is a simple plugin to mirror sites in WP Multisite installation(s). It can be used to populate multiple different WP Multisite sites with identical content. Posting on 1 site will update all other mirrors of it.

I originally put this together for a website that has 2 near identical versions, one paid and one free, both are WP Multisite installation with multiple subsites. I'm posting it here so it can be useful for other developers.

Some requirements:
* The destination site and the site being mirrored must be in the same database.
* Requires some working knowledge of WP database and WP in general (to use this and be able to mod it to your needs).

Git repository:
https://github.com/kien/wordpress-multisites-mirror

Issues tracker:
https://github.com/kien/wordpress-multisites-mirror/issues

== Installation ==

1. Extract the zip archive and upload the `multisites_mirror` directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Configure the plugin in the `MMS Settings` page under `Plugins`

== Changelog ==

= 0.2 =
* Initial Upload