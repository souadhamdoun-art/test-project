#!/bin/bash

# Script pour corriger les permissions du projet Laravel
# Usage: ./fix-permissions.sh

echo "🔧 Correction des permissions du projet Laravel..."

# Corriger le propriétaire de tous les fichiers
sudo chown -R $USER:$USER .

# Définir les permissions correctes
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;

# Permissions spéciales pour certains fichiers
chmod +x artisan
chmod +x fix-permissions.sh

# Permissions pour les dossiers de cache/logs
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/

# Vérifier les fichiers problématiques
echo "🔍 Vérification des permissions..."
problematic_files=$(find . -user root -type f 2>/dev/null | wc -l)
if [ $problematic_files -gt 0 ]; then
    echo "⚠️  Fichiers avec des permissions root trouvés:"
    find . -user root -type f 2>/dev/null | head -10
else
    echo "✅ Aucun fichier avec des permissions root trouvé"
fi

echo "✅ Permissions corrigées !"
echo "👤 Propriétaire: $(whoami)"
echo "📁 Projet: $(pwd)"
