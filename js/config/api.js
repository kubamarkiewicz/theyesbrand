
/* This file has to loaded before app.js */

window.config = window.config || {};

window.config.defaultLanguage = 'en';

window.config.api = {

	"urls" : {
        "getPages"              : "admin/api/pages",
        "getTranslations"		: "admin/api/translations",
        "missingTranslations"	: "admin/api/translations"
	}

}