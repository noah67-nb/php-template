<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Générateur de Contrat de Travail</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Générateur de Contrat de Travail</h1>
        <div class="form-group">
            <label for="employe">Nom de l'employé:</label>
            <input type="text" id="employe" required>
        </div>
        <div class="form-group">
            <label for="employeur">Nom de l'employeur:</label>
            <input type="text" id="employeur" required>
        </div>
        <div class="form-group">
            <label for="poste">Poste:</label>
            <input type="text" id="poste" required>
        </div>
        <div class="form-group">
            <label for="dateDebut">Date de début du contrat:</label>
            <input type="date" id="dateDebut" required>
        </div>
        <div class="form-group">
            <label for="typeContrat">Type de contrat:</label>
            <select id="typeContrat" onchange="toggleSalaire()">
                <option value="benevole">Bénévole</option>
                <option value="remunere">Rémunéré</option>
            </select>
        </div>
        <div class="form-group hidden" id="salaireGroup">
            <label for="salaire">Salaire:</label>
            <input type="text" id="salaire">
            <label for="frequenceSalaire">Fréquence du salaire:</label>
            <select id="frequenceSalaire">
                <option value="mois">Par mois</option>
                <option value="heure">Par heure</option>
            </select>
        </div>
        <button onclick="genererContrat()">Générer le Contrat</button>
        <button onclick="genererPDF()">Télécharger en PDF</button>
        <pre id="contratResult"></pre>
    </div>

    <script>
        function toggleSalaire() {
            var typeContrat = document.getElementById("typeContrat").value;
            var salaireGroup = document.getElementById("salaireGroup");
            if (typeContrat === "remunere") {
                salaireGroup.classList.remove("hidden");
            } else {
                salaireGroup.classList.add("hidden");
            }
        }

        function genererContrat() {
            var employe = document.getElementById("employe").value;
            var employeur = document.getElementById("employeur").value;
            var poste = document.getElementById("poste").value;
            var dateDebut = document.getElementById("dateDebut").value;
            var typeContrat = document.getElementById("typeContrat").value;
            var salaire = document.getElementById("salaire").value;
            var frequenceSalaire = document.getElementById("frequenceSalaire").value;

            var contrat = `Contrat de Travail

Nom de l'employé: ${employe}
Nom de l'employeur: ${employeur}
Poste: ${poste}
Date de début du contrat: ${dateDebut}
Type de contrat: ${typeContrat.charAt(0).toUpperCase() + typeContrat.slice(1)}`;

            if (typeContrat === "remunere") {
                contrat += `
Salaire: ${salaire}
Fréquence du salaire: ${frequenceSalaire}`;
            }

            var accordConfidentialite = `
ACCORD DE CONFIDENTIALITÉ

Cet Accord de Confidentialité (l'"Accord") est conclu à Canada/France, entre Mercure Hosting, et ${employeur}

Objet de l'Accord

Les parties conviennent de partager certaines informations confidentielles comme le Nom Prénom, adresse-mail dans le but d'avoir un accord sur les données confidentielle des clients et de Mercure Hosting et donnée la pleine confiance. Les Informations Confidentielles peuvent inclure, sans s'y limiter, des données, des idées, des plans, des prototypes, des produits, des méthodes, des stratégies, des clients, et d'autres informations liées aux activités des parties.

Engagements de Confidentialité

1. Protection des Informations Confidentielles: La Partie Réceptrice s'engage à prendre toutes les mesures raisonnables pour protéger les Informations Confidentielles contre toute divulgation non autorisée, utilisation ou reproduction.

2. Utilisation Restreinte: Les Informations Confidentielles ne seront utilisées que dans le cadre de Mercure Hosting et ne seront en aucun cas utilisées à des fins personnelles ou pour le bénéfice d'une partie tierce sans le consentement écrit préalable du Divulgateur.

3. Communication Sélective: La Partie Réceptrice s'engage à ne divulguer les Informations Confidentielles qu'aux employés ou sous-traitants ayant besoin de connaître ces informations dans le cadre du présent Accord et qui ont été informés de leurs obligations en matière de confidentialité.

Durée de Confidentialité

Les obligations de confidentialité stipulées dans le présent Accord resteront en vigueur pendant une période de jusqu'à la fin de votre appartenance a entreprise à compter de la date de réception des Informations Confidentielles.

Retour ou Destruction des Informations

À la demande écrite du Divulgateur ou à la résiliation du présent Accord, la Partie Réceptrice s'engage à retourner toutes les copies des Informations Confidentielles ou à les détruire de manière sécurisée, à la discrétion du Divulgateur.

Non-divulgation

La Partie Réceptrice s'engage à ne pas divulguer l'existence ou le contenu de cet Accord sans le consentement écrit préalable du Divulgateur.

Loi Applicable

Cet Accord est régi par les lois du Canada

En signe de leur accord, les parties ont apposé leur signature ci-dessous :
`;

            contrat += accordConfidentialite;
            document.getElementById("contratResult").textContent = contrat;
        }

        function genererPDF() {
            var { jsPDF } = window.jspdf;
            var doc = new jsPDF();
            var contratText = document.getElementById("contratResult").textContent;

            doc.setFontSize(12);
            var textLines = doc.splitTextToSize(contratText, 180);
            doc.text(textLines, 10, 10);
            doc.save('contrat_travail.pdf');
        }
    </script>
</body>
</html>
