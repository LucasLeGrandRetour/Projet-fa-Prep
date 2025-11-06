#!/bin/bash
# script pour démarrer les serveurs PHP et MariaDB

# Définir le chemin vers les dossiers web et web/API
WEB_DIR="site"

# Executer le script d'initialisation de la base de données database/scripts/initDBB.sh
# echo "Exécution du script initDBB.sh..."
# sudo chmod +x ./database/scripts/initDBB.sh
# sudo ./database/scripts/initDBB.sh

# Fonction pour vérifier si un port est utilisé
is_port_in_use() {
    # Utilise lsof pour vérifier si le port spécifié est en cours d'utilisation
    lsof -i:$1 > /dev/null # teste si le port $1 est utilisé et redirige la sortie standard et la sortie d'erreur vers /dev/null 
    return $? # Retourne le code de sortie de la commande lsof -> 0 si le port est utilisé
}

# Démarrage du serveur PHP pour le dossier web
WEB_PORT=8000
if is_port_in_use $WEB_PORT; then
    echo "Le serveur PHP pour le dossier web est déjà démarré sur le port $WEB_PORT"
else
    echo "Démarrage du serveur PHP sur http://0.0.0.0:$WEB_PORT depuis $WEB_DIR"
    php -S 0.0.0.0:$WEB_PORT -t $WEB_DIR &
fi