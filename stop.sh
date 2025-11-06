#!/bin/bash
# script pour arreter les serveurs PHP et MariaDB

# Arrêter le serveur PHP pour le dossier web (site)
WEB_PORT=8000
if lsof -i:$WEB_PORT > /dev/null; then
    echo "Arrêt du serveur PHP pour le dossier web sur le port $WEB_PORT"
    sudo kill $(lsof -t -i:$WEB_PORT)
else
    echo "Le serveur PHP pour le dossier web n'est pas démarré sur le port $WEB_PORT"
fi

