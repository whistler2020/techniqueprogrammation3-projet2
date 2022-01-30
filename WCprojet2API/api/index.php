<?php
include_once '../include/config.php'; 
include_once '../include/fonctions.php'; 

header('Content-Type: application/json;');
header('Access-Control-Allow-Origin: *'); 

$mysqli = new mysqli($host, $username, $password, $database); // Établissement de la connexion à la base de données
if ($mysqli -> connect_errno) { // Affichage d'une erreur si la connexion échoue
  echo 'Échec de connexion à la base de données MySQL: ' . $mysqli -> connect_error;
  exit();
} 

switch($_SERVER['REQUEST_METHOD'])
{
case 'GET':  // GESTION DES DEMANDES DE TYPE GET
	if(isset($_GET['idReservation'])) { 
		if ($requete = $mysqli->prepare("SELECT * FROM reservations WHERE idReservation=?")) {  
		  $requete->bind_param("i", $_GET['idReservation']); 
		  $requete->execute(); 

		  $resultat_requete = $requete->get_result(); 
		  $objetSQL = $resultat_requete->fetch_assoc(); 

		  // Convesion de l'objet au format JSON désiré
		  $objetRV = ConvertDataReservSQLEnObjet($objetSQL);

		  echo json_encode($objetRV, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

		  $requete->close(); 
		}
	} else {
		$requete = $mysqli->query("SELECT * FROM reservations");
		$listeObjet = [];

		while ($objetSQL = $requete->fetch_assoc()) {
			// Convesion de l'objet au format JSON désiré
			$objetRV = ConvertDataReservSQLEnObjet($objetSQL);

			// Ajout du Cégep à la liste
			array_push($listeObjet, $objetRV);
		}
		     //$donnees_tableau = $requete->fetch_all(MYSQLI_ASSOC);
		echo json_encode($listeObjet, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		$requete->close();
	}
	break;
case 'POST':  // GESTION DES DEMANDES DE TYPE POST
	$reponse = new stdClass();
	$reponse->message = "Ajout de la reservation: ";
	
	$corpsJSON = file_get_contents('php://input');
	$data = json_decode($corpsJSON, TRUE); 

	$destination = $data['destination'];
	$villeDepart = $data['villeDepart'];
	$nomHotel = $data['hotel']['nomHotel'];
	$coordonneesHotel = $data['hotel']['coordonneesHotel'];
	$nombreEtoiles = $data['hotel']['nombreEtoiles'];
	$nombreChambres = $data['hotel']['nombreChambres'];
	$caracteristiques = $data['hotel']['caracteristiques'];
	$dateDepart = $data['dateDepart'];
	$dateRetour = $data['dateRetour'];
	$prix = $data['prix'];
	$rabais = $data['rabais'];
	$vedette = $data['vedette'];

	if(isset($destination) && isset($villeDepart) && isset($nomHotel) && isset($coordonneesHotel) && isset($nombreEtoiles) && isset($nombreChambres) && isset($caracteristiques) && isset($dateDepart) && isset($dateRetour) && isset($prix) && isset($rabais) && isset($vedette)) {
		$liste_data_str = implode(';', $caracteristiques);

      if ($requete = $mysqli->prepare("INSERT INTO reservations (destination, villeDepart, nomHotel, coordonneesHotel, nombreEtoiles, nombreChambres, caracteristiques, dateDepart, dateRetour, prix, rabais, vedette) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);")) {      
        $requete->bind_param("ssssiisssddi", $destination, $villeDepart, $nomHotel, $coordonneesHotel, $nombreEtoiles, $nombreChambres, $liste_data_str, $dateDepart, $dateRetour, $prix, $rabais, $vedette);

        if($requete->execute()) { 
          $reponse->message .= "Succès";  
        } else {
          $reponse->message .=  "Erreur dans l'exécution de la requête";  
        }

        $requete->close(); 
      } else  {
        $reponse->message .=  "Erreur dans la préparation de la requête";  
      } 
    } else {
		$reponse->message .=  "Erreur dans le corps de l'objet fourni";  
	}
	echo json_encode($reponse, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	
	break;
case 'PUT':  // GESTION DES DEMANDES DE TYPE PUT
	$reponse = new stdClass();
	$reponse->message = "Édition de la reservation: ";
	
	$corpsJSON = file_get_contents('php://input');
	$data = json_decode($corpsJSON, TRUE); 

	$destination = $data['destination'];
	$villeDepart = $data['villeDepart'];
	$nomHotel = $data['hotel']['nomHotel'];
	$coordonneesHotel = $data['hotel']['coordonneesHotel'];
	$nombreEtoiles = $data['hotel']['nombreEtoiles'];
	$nombreChambres = $data['hotel']['nombreChambres'];
	$caracteristiques = $data['hotel']['caracteristiques'];
	$dateDepart = $data['dateDepart'];
	$dateRetour = $data['dateRetour'];
	$prix = $data['prix'];
	$rabais = $data['rabais'];
	$vedette = $data['vedette'];

	if(isset($_GET['idReservation'])) { 
		if(isset($destination) && isset($villeDepart) && isset($nomHotel) && isset($coordonneesHotel) && isset($nombreEtoiles) && isset($nombreChambres) && isset($caracteristiques) && isset($dateDepart) && isset($dateRetour) && isset($prix) && isset($rabais) && isset($vedette)) {
			$liste_data_str = implode(';', $caracteristiques);
			
			if ($requete = $mysqli->prepare ("UPDATE reservations SET destination=?, villeDepart=?, nomHotel=?, coordonneesHotel=?, nombreEtoiles=?, nombreChambres=?, caracteristiques=?, dateDepart=?, dateRetour=?, prix=?, rabais=?, vedette=? WHERE idReservation=?")) {      
				$requete->bind_param("ssssiisssddii", $destination, $villeDepart, $nomHotel, $coordonneesHotel, $nombreEtoiles, $nombreChambres, $liste_data_str, $dateDepart, $dateRetour, $prix, $rabais, $vedette, $_GET['idReservation']);
			
			if($requete->execute()) { 
			  $reponse->message .= "Succès";  
			} else {
			  $reponse->message .=  "Erreur dans l'exécution de la requête";  
			}

			$requete->close(); 
		  } else  {
			$reponse->message .=  "Erreur dans la préparation de la requête";  
		  } 
		} else {
			$reponse->message .=  "Erreur dans le corps de l'objet fourni";  
		}
	} else {
		$reponse->message .=  "Erreur dans les paramètres (aucun identifiant fourni)";  
	}
	
	echo json_encode($reponse, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	break;
case 'DELETE':  // GESTION DES DEMANDES DE TYPE DELETE
	$reponse = new stdClass();
	$reponse->message = "Suppression de la reservation: ";
	if(isset($_GET['idReservation'])) { 
		if ($requete = $mysqli->prepare("DELETE FROM reservations WHERE idReservation=?")) {     
			$requete->bind_param("i", $_GET['idReservation']);

			if($requete->execute()) { 
			  $reponse->message .= "Succès";  
			} else {
			  $reponse->message .=  "Erreur dans l'exécution de la requête";  
			}

			$requete->close(); 
		  } else  {
			$reponse->message .=  "Erreur dans la préparation de la requête";  
		  } 
	} else {
		$reponse->message .=  "Erreur dans les paramètres (aucun identifiant fourni)";  
	}
	echo json_encode($reponse, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	break;
default:
	$reponse = new stdClass();
	$reponse->message = "Opération non supportée";	
	echo json_encode($reponse, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

$mysqli->close(); 
?>