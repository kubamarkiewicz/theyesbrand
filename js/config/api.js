
/* This file has to loaded before app.js */

window.config = window.config || {};

window.config.defaultLanguage = 'es';

window.config.api = {

	"urls" : {
        "getPages"              : "admin/api/pages",
        "getTranslations"		: "admin/api/translations",
        "missingTranslations"	: "admin/api/translations",
        "getProyectos"			: "admin/api/proyectos",
        "getHomeBanners"		: "admin/api/home-banners"
	}

}