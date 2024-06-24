#!/bin/bash

clear

cat << "HEIM"

    Ce script appartient à Mercure Hosting.
    Toute copie ou utilisation non-autorisée entraînera des poursuites judiciaires.

HEIM

echo -e "\e[1;33mMerci de ne pas annuler le script d'installation Plesk ni de vous déconnecter du SSH\e[0m"

echo -e "\e[1;36mInstallation de Plesk en cours\e[0m"
sh <(curl https://autoinstall.plesk.com/one-click-installer || wget -O - https://autoinstall.plesk.com/one-click-installer)

echo -e "\e[1;32mUne fois l'installation terminée, le script se fermera automatiquement.\e[0m"

echo -e "\e[1;37mMercure Hosting vous remercie.\e[0m"