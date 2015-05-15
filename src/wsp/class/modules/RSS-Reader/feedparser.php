<?php
/**
 * PHP file wsp\class\modules\RSS-Reader\feedparser.php
 */
/**
 * Class 
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2015 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 12/05/2015
 * @version     1.2.13
 * @access      public
 * @since       1.2.0
 */

// on inclut la classe magpierss
require_once("rss_fetch.inc");

// la fonction FeedParser() va extraire le contenu pour l'afficher
// elle prend en paramètre $url_feed, l'url du flux RSS et $nb_items_affiches, le nombre d'éléments (items) à afficher
function FeedParser($url_feed, $nb_items_affiches, $only_subject=false) {

    // lecture du fichier distant (flux XML)
    $rss = fetch_rss($url_feed);

    // si le parcours du fichier se passe bien, on lit les élements (items)
    if (is_array($rss->items))  {

        // on ne garde que les $nb_items_affiches premiers éléments (items), nombre défini dans l'en-tête de la fonction
        $items = array_slice($rss->items, 0, $nb_items_affiches);

        // on peut récupérer les informations sur le site proposant le flux (optionnel)
        $site_titre = $rss->channel["title"]; // titre du site
        $site_lien = $rss->channel["link"]; // lien du site
        $site_description = $rss->channel["description"]; // description du site   

        // à présent on stocke les données dans $html, variable à afficher
				$html = "";
				
        // titre sous forme de lien
        //$html .= "<a href=\"$site_lien\" title=\"$site_description\" target=\"_blank\">$site_titre</a><br />\n";

        // on affiche la description du site proposant le flux
        //$html .= "<span>$site_description</span><br clear=\"left\" target=\"_blank\"><br />\n"; // le clear="left" renvoie à la ligne même s'il y a une image

        // on fait une boucle sur les informations : pour chaque item, récupérer $titre... et afficher
        foreach($items as $item) {
            // on mémorise les informations de chaque item dans des variables
            $titre = $item["title"];
            $lien = $item["link"];
            $description = $item["description"];
           
            // la date utilisée pour les flux RSS est au format timestamp, il faut donc formater la date
            // conversion au format jj/mm/aa. pour plus d'informations, vous conférer au tutorial sur les timestamp
            $date = date("d/m/y",strtotime($item["pubdate"]));         

            // on affiche le titre de chaque item
            $html .= "<a href=\"".$lien."\" title=\"".$titre."\" target=\"_blank\"><img src=\"img/page_world.png\" border=\"0\" height=\"16\" width=\"16\" align=\"absmiddle\"/> ".$titre."</a><br>\n";

            // puis la date et la description
            if ($only_subject == false) {
            	$html .= "<span>$date - $description</span><br clear=\"left\"><br />\n";
            }
        } // fin de la boucle

        // on retourne la variable $html au programme (elle contient le code HTML pour l'affichage du flux)
        return array($site_titre, $site_lien, $site_description, $html);
    } // fin du traitement du fichier
} // fin de la fonction FeedParser()
?>
