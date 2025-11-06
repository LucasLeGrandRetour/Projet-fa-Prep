<div id="illustration">
	<img id='picnic_equipe' src='images/Picnic_equipe.jpg' alt='SJP_Picnic_equipe' />
</div>
<div id="description">
	<h2> L'équipe ayant créé cette application est composée de : </h2>
    <h3>
        <?php
            if (isset($modifDeveloppeur)){
                echo $modifDeveloppeur;
            } else {
				if (isset($devSupp)){
                	echo $devSupp;
				}
            }
        ?>
    </h3>
	<table border='1'>
		<thead>
			<tr>
				<th>Nom</th>
				<th>Prénom</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($lesDeveloppeurs as $developpeur) {
				echo '<tr>';
				echo '<td>' . htmlspecialchars_decode($developpeur->getNom()) . '</td>';
				echo '<td>' . htmlspecialchars_decode($developpeur->getPrenom()) . '</td>';
				echo '<td><a href="index.php?controleur=developpeurs&action=aPropos&id='.$developpeur->getId().'">Supprimer</a>';
				echo '<a href="index.php?controleur=developpeurs&action=modifier&id='.$developpeur->getId().'">Modifier</a></td>';
				echo '</tr>';
			}
			?>
		</tbody>
	</table>

</div>