#!/bin/bash


clear

cat << "HEIM"

    Ce script appartient à Versa Group / Mercure Hosting.
    Toute copie ou utilisation non-autorisée entraînera des poursuites judiciaires.

HEIM

echo -e "\e[1;33mMerci de ne pas annuler le script d'installation Rondcube ni de vous déconnecter du SSH\e[0m"

sudo apt-get install -y ca-certificates curl gnupg

sudo mkdir -p /etc/apt/keyrings

curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | sudo gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg

echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_20.x nodistro main" | tee /etc/apt/sources.list.d/nodesource.list

apt-get update

apt-get install -y nodejs