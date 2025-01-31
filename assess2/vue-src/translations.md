# Translating the Vue part

Strings in the Vue part are represented in the code by identifiers. For the default language en the meaning of these identifiers is defined in `/assess2/vue-src/src/locales/en.json`. Translations must be defined in similar files for the target language. For example, German translations are defined in `/assess2/vue-src/src/locales/de.json`.

Updating these translations is supported by the online tool at https://netmath.vcrp.de/services/translator/

In order to take effect, after updating the translations, the command `npm run build` must be called in `assess2/vue-src`. If this produces error messages, try running `npm install` before this command in order to make sure, all required node modules are installed.