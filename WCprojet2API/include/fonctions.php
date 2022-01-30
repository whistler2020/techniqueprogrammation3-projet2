<?php

// Cette fonction prend l'object au format tablulaire SQL 
// et retourne un objet dont la structure correspond au format
// devant être retourné par l'API. 
function ConvertDataReservSQLEnObjet($objetSQL) {
    $objetRV = new stdClass();
    $objetRV->destination = $objetSQL["destination"];
    $objetRV->villeDepart = $objetSQL["villeDepart"];

    $objetRV->hotel = new stdClass();
    $objetRV->hotel->nomHotel = $objetSQL["nomHotel"];
    $objetRV->hotel->coordonneesHotel = $objetSQL["coordonneesHotel"];
    $objetRV->hotel->nombreEtoiles = $objetSQL["nombreEtoiles"];
    $objetRV->hotel->nombreChambres = $objetSQL["nombreChambres"];
    $objetRV->hotel->caracteristiques = explode(";", $objetSQL["caracteristiques"]);
    
    $objetRV->dateDepart = $objetSQL["dateDepart"];
    $objetRV->dateRetour = $objetSQL["dateRetour"];
    $objetRV->prix = $objetSQL["prix"];
    $objetRV->rabais = $objetSQL["rabais"];
    $objetRV->vedette = $objetSQL["vedette"];
    

    return $objetRV;
}   

?>