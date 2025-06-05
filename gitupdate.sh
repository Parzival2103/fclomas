#!/bin/bash

# Mostrar cambios pendientes
echo "📄 Archivos modificados:"
git status -s

# Pedir mensaje de commit
read -p "📝 Ingresa el mensaje del commit: " mensaje

# Agregar todos los archivos
git add .

# Hacer commit
git commit -m "$mensaje"

# Subir al repositorio remoto
git push

echo "✅ Cambios subidos correctamente."
