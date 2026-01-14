Artist EventPlanner 🎤
Artist EventPlanner is een overzichtelijke webapplicatie die speciaal is ontwikkeld voor artiesten om hun drukke professionele leven te beheren. Of het nu gaat om optredens, studiosessies of fotoshoots: met deze tool houdt de artiest de volledige controle over zijn eigen agenda.

📝 Projectomschrijving
Voor veel artiesten is het lastig om een duidelijk overzicht te houden van hun planning. De Artist EventPlanner lost dit op door een persoonlijke, beveiligde omgeving te bieden waar alleen de artiest zelf toegang tot heeft. Na het inloggen krijgt de gebruiker een dashboard te zien met zijn of haar eigen events, waardoor dubbele boekingen of vergeten afspraken verleden tijd zijn.

✨ Functionaliteiten
Accountbeheer: Artiesten kunnen een eigen account registreren met een beveiligd wachtwoord.

Veilig Inlogsysteem: Toegang tot de planning is strikt persoonlijk via PHP-sessiebeveiliging.

Persoonlijk Dashboard: Een overzichtelijke lijst van alle geplande activiteiten.

CRUD-systeem:

Aanmaken: Voeg eenvoudig nieuwe shows of afspraken toe.

Bekijken: Zie direct de datum, tijd en details van een event.

Verwijderen: Verwijder oude of geannuleerde afspraken met een bevestigingscheck.

Databeveiliging: Gebruikers kunnen alleen hun eigen events inzien en beheren.

🛠️ Gebruikte Technieken
De applicatie is gebouwd met een moderne focus op core webtechnieken:

Frontend: HTML5, CSS3 (Bootstrap 5 voor responsive design).

Interactie: JavaScript (voor bevestigingsdialogen en UI-interactie).

Backend: PHP (voor server-side logica en sessiebeheer).

Database: MySQL (voor relationele dataopslag).

🚀 Installatie-instructies
Volg deze stappen om het project lokaal op je eigen machine (bijv. via XAMPP of MAMP) te draaien:

1. Database importeren
Open phpMyAdmin.

Maak een nieuwe database aan met de naam artist_planner.

Klik op de tab Importeren.

Kies het bestand db.sql uit de hoofdmap van dit project en klik op Starten.

2. Bestanden plaatsen
Kopieer de volledige projectmap naar je lokale servermap (bijv. C:/xampp/htdocs/artist-eventplanner).

3. Configuratie aanpassen
Open het bestand includes/db_connect.php en controleer of de inloggegevens voor je lokale database kloppen:

PHP

$host = 'localhost';
$db   = 'artist_planner';
$user = 'root'; // Jouw database gebruiker
$pass = '';     // Jouw database wachtwoord
4. De applicatie openen
Ga in je browser naar: http://localhost/artist-eventplanner/login.php

📁 Mappenstructuur
Plaintext

/artist-eventplanner
│   index.php          (Dashboard)
│   login.php          (Login)
│   register.php       (Registratie)
│   logout.php         (Sessie verbreken)
│   add_event.php      (Event toevoegen)
│   delete_event.php   (Event verwijderen)
│   db.sql             (Database export)
├── /includes
│   └── db_connect.php (PDO verbinding)
├── /css
│   └── style.css      (Eigen styling)
└── /js
    └── script.js      (JS logica)