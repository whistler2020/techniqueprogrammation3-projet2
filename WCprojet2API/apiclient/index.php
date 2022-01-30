<?php
include_once '../include/config.php'; 

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
	if(isset($_GET['idClient'])) { 
		if ($requete = $mysqli->prepare("SELECT * FROM clients WHERE idClient=?")) {  
		  $requete->bind_param("i", $_GET['idClient']); 
		  $requete->execute(); 

		  $resultat_requete = $requete->get_result(); 
		  $objet = $resultat_requete->fetch_assoc(); 

		  echo json_encode($objet, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

		  $requete->close(); 
		}
	} else {
		$requete = $mysqli->query("SELECT * FROM clients");
		$donnees_tableau = $requete->fetch_all(MYSQLI_ASSOC);
		echo json_encode($donnees_tableau, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		$requete->close();
	}
	break;
case 'POST':  // GESTION DES DEMANDES DE TYPE POST
	$reponse = new stdClass();
	$reponse->message = "Ajout d'un client: ";
	
	$corpsJSON = file_get_contents('php://input');
	$data = json_decode($corpsJSON, TRUE); 

	if(isset($data['nom']) && isset($data['prenom']) && isset($data['sexe'])) {
      if ($requete = $mysqli->prepare("INSERT INTO clients (nom, prenom, sexe) VALUES (?, ?, ?)")) {      
        $requete->bind_param("sss", $data['nom'], $data['prenom'], $data['sexe']);

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
	$reponse->message = "Édition d'un client: ";
	
	$corpsJSON = file_get_contents('php://input');
	$data = json_decode($corpsJSON, TRUE); 
	if(isset($_GET['idClient'])) { 
		if(isset($data['nom']) && isset($data['prenom']) && isset($data['sexe'])) {
		  if ($requete = $mysqli->prepare("UPDATE clients SET nom=?, prenom=?, sexe=? WHERE idClient=?")) {     
			$requete->bind_param("sssi", $data['nom'], $data['prenom'], $data['sexe'], $_GET['idClient']);

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
	$reponse->message = "Suppression d'un client: ";
	if(isset($_GET['idClient'])) { 
		if ($requete = $mysqli->prepare("DELETE FROM clients WHERE idClient=?")) {     
			$requete->bind_param("i", $_GET['idClient']);

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