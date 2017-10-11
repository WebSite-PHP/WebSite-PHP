<?php
	define("ERROR", "Erreur");
	define("WARNING", "Attention");
	define("LOADING", "Chargement");
	define("CLOSE", "Fermer");
	
	define("ERROR_LANG", "Erreur langue");
	define("ERROR_LANG_MSG", "Erreur langue inconnue.");
	
	define("ERROR_PAGE", "Erreur page");
	define("ERROR_PAGE_MSG", "Erreur page %s inconnue.");
	
	define("ERROR_USER_RIGHTS", "Erreur droits utilisateurs");
	define("ERROR_USER_RIGHTS_MSG", "Erreur, cet utilisateur n'a pas les droits d'afficher cette page.");
	
	define("ERROR_DATABASE", "Erreur base de données");
	define("ERROR_DATABASE_MSG", "Erreur: %s");
	
	define("ERROR_USER_BANNED", "Alerte de sécurité");
	define("ERROR_USER_BANNED_MSG_1", "Vous avez été bloqué sur ce site.");
	define("ERROR_USER_BANNED_MSG_2", "Veuillez entrer le captcha suivant pour accéder au site.");
	define("ERROR_USER_BUTTON", "Débloquer");
	
	define("ERROR_DEBUG_MAIL_SENT", "Un problème technique s'est produit. Un administrateur a été notifié et le problème devrait être résolu rapidement.");
	
	define("ERROR_401", "Erreur 401");
	define("ERROR_401_MSG", "Erreur 401 : Accès interdit");
	define("ERROR_403", "Erreur 403");
	define("ERROR_403_MSG", "Erreur 403 : Répertoire interdit");
	define("ERROR_404", "Erreur 404");
	define("ERROR_404_MSG", "Erreur 404 : Page introuvable");
	define("ERROR_500", "Erreur 500");
	define("ERROR_500_MSG", "Erreur 500 : Erreur de configuration");
	define("REDIRECT_URL_TO", "Vous allez être redirigé vers <a href='%s'>%s</a> (Si la redirection ne fonctionne pas veuillez clicker sur le lien).");
	
	define("MAIN_PAGE_GO_BACK", "Retourner à la page principale du site");
	
	define("BOX_LANGUAGE_TITLE", "Langues");
	define("CAPTCHA_CODE", "Saisissez ce code");
	define("ERROR_CAPTCHA", "Erreur du code captcha.");
	
	define("DECRYPT_ERROR", "Erreur lors du décodage du message, veuillez réessayer");
	define("SUBMIT_ERROR", "<table><tr><td><img src='{#CDN_BASE_URL#}wsp/img/warning.png' height='48' width='48' border='0' align='absmidlle'/></td><td><b>{#SIMPLE_QUOTE#} + ucfirst(transport.statusText) + {#SIMPLE_QUOTE#}</b></td></tr></table>{#SIMPLE_QUOTE#} + (transport.responseText!={#SIMPLE_QUOTE#}{#SIMPLE_QUOTE#}?{#SIMPLE_QUOTE#}<br/> {#SIMPLE_QUOTE#} + transport.responseText:{#SIMPLE_QUOTE#}{#SIMPLE_QUOTE#}) + {#SIMPLE_QUOTE#}");
	define("SUBMIT_UNKNOW_ERROR", "<table><tr><td><img src='{#CDN_BASE_URL#}wsp/img/warning.png' height='48' width='48' border='0' align='absmidlle'/></td><td><b>Erreur inconnue</b></td></tr></table>");
	define("SUBMIT_LOADING", "Veuillez patienter pendant la validation du formulaire ...");
	define("SUBMIT_LOADING_2", "Veuillez patienter ...");
	define("DOWNLOAD_FLASH_PLAYER", "<a href=\"http://www.macromedia.com/go/getflashplayer\" rel=\"nofollow\">Télécharger Flash Player</a> pour visualiser.");
	
	define("LIVE_VALIDATION_FORMULAR_ERROR", "Votre formulaire n'est pas correct, veuillez vérifier les champs.");
	define("LIVE_VALIDATION_FORMULAR_FIELD_ERROR", "Votre formulaire n'est pas correct, veuillez vérifier le champ {#SIMPLE_QUOTE#} + lv_error_alert_field_name + {#SIMPLE_QUOTE#}.");
	define("LIVE_VALIDATION_FORMULAR_ERROR_DEBUG", "Votre formulaire n'est pas correct, veuillez vérifier le champ {#SIMPLE_QUOTE#} + lv_error_alert_id + {#SIMPLE_QUOTE#}.");
	define("LIVE_VALIDATION_FORMULAR_ERROR_MSG", "lv_error_alert_msg");
	define("INCLUDE_OBJECT_TO_MAIN_PAGE", "Vous devez inclure l'objet %s dans la page parent (\$this->includeJsAndCssFromObjectToPage('%s')).");
	
	define('NOT_SUPPORTED_BROWSER_TITLE', 'Navigateur non supporté');
	define('NOT_SUPPORTED_BROWSER', '<b>Internet Explorer 6 et les versions plus anciennes ne sont pas complètements supportés.</b><br/>Nous vous recommandons d\'utiliser un autre navigateur.<br/><br/>Il existe plus de 50 façon de changer de navigateur - en voici 5 :<br/><br/>');
	
	define("JAVASCRIPT_NOT_ACTIVATE", "JavaScript n'est pas activé sur votre navigateur. Activez le pour profiter de tous les avantages du site, ensuite rafraichissez la page.");
	
	define("TABLE_CONFIME_DEL_ROW", "Etes-vous sûr de vouloir supprimer cette ligne?");

	define('WSP_BTN_UPLOAD_FILE', 'Choisissez un fichier');
	define('WSP_BTN_UPLOAD_FILES', 'Choisissez des fichiers');

	define('COOKIES_MSG', 'Notre site utilise des cookies. Les cookies nous permettent d\'offrir la meilleure expérience possible. En utilisant nos services, vous acceptez notre utilisation des cookies.');
	define('COOKIES_MSG_SHORT', 'En utilisant nos services, vous acceptez notre utilisation des cookies.');
	define('LEARN_MORE', 'En savoir plus');
	
	define('UPLOAD_FILESIZE_LIMIT_ERROR_MSG', 'Le fichier "{#SIMPLE_QUOTE#}+filename+{#SIMPLE_QUOTE#}" dépasse la taille maximum autorisé (%s).');
	define('UPLOAD_MIME_TYPES_ERROR_MSG', 'Le mime type du fichier "{#SIMPLE_QUOTE#}+filename+{#SIMPLE_QUOTE#}" ({#SIMPLE_QUOTE#}+mime_type+{#SIMPLE_QUOTE#}) n\'est pas autorisé (%s).');
?>