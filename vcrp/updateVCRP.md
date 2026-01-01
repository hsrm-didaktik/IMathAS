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
* Translate Vue files from `assess2/vue-src/locales/en.json` into `assess2/vue-src/locales/de.json` using https://netmath.vcrp.de/services/translator/ 
* Rebuild Vue files with `npm run build` as described in `assess2/vue-src/translations.md`.
* Run `php upgrade.php` in IMathAS