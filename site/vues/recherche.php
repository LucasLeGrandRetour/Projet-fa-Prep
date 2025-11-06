<div id="illustration">
	<img id='picnic_equipe' src='images/Picnic_equipe.jpg' alt='SJP_Picnic_equipe' />
</div>
<div id="description">
	<h2> Fonction de recherche de compétence : </h2>

    <?php if(isset($txt)){
        echo "<h3>Résultat de la recherche pour : <em>".$txt."</em></h3>";
        echo "<ul>";
		    foreach ($lesCompetences as $comp) {
		    		echo '<li>' . htmlspecialchars_decode($comp->getNom()) . '</li>';
		    }
        echo "</ul>";
    } else {
        echo '<form action="index.php?controleur=competences&action=recherche" method="post">';
        echo '<label for="texteRecherche">Compétence(s) : </label>';
        echo '<input type="text" name="texteRecherche" id="texteRecherche"><br><input type="submit" value="Valider"></form>';
}
	?>

</div>