# Note for updating the VCRP version feature_vcrp

## This is not necessary for updating the productive instance from the branch feature_vcrp

* Checkout master
* pull https://github.com/drlippman/IMathAS.git In case of conflicts remove conflicting files before pull, e.g. assess2/vue/gbviewassess.html
* Checkout feature_vcrp
* Merge master
* In case of conflict gettheirs from master
* Commit
* Do translations as described in i18n/translating.md - use ~/getmo to extract strings to translate, use poedit to translate. Dont forget saving as `i18n/locale/LC_MESSAGES/imathas.mo`.
* After backing up, generate `/i18n/locale/de/messages.js` with `php i18n/extractjsfrompo.php de` WARNING: Check resulting file for empty translations.

## Translate Vue files:

German translations are in assess2/vue-src/src/locales/de.ftl. English terms are in the same folder in en.ftl. Use findmissingstrings.php to detect stringst still to translate

* Rebuild Vue files with `npm run build` as described in `assess2/vue-src/translations.md`.

## After any update:
* Run `php upgrade.php` in IMathAS or call `IMathAS/upgrade.php`in the browser.

# About the branch tc/vcrp
This branch is generated on the base of feature_vcrp to integrate and check technology changes without affecting feature_vcrp.

After completing the integration, tc/vcrp should be merged into feature_vcrp.

Note: When technological changes have been made in the master branch, the master branch should no longer be integrated into feature_vcrp as long as tc/vcrp has not been merged