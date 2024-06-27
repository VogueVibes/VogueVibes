# VogueVibes
VogueVibes is an innovative online shop offering unique customised clothing and fashion resale. We aim to satisfy the tastes of the most demanding customers, giving you the opportunity to personalise every detail of your wardrobe and purchase exclusive, time and fashion-tested items.

### Installationsanleitung

1. **XAMPP herunterladen und installieren**:
   - Gehen Sie auf die [offizielle XAMPP-Website](https://www.apachefriends.org/index.html) und laden Sie die XAMPP-Version für Ihr Betriebssystem herunter.
   - Installieren Sie XAMPP und folgen Sie den Anweisungen auf dem Bildschirm.

2. **Erstellen Sie eine Datenbank in phpMyAdmin**:
   - Starten Sie XAMPP und öffnen Sie das Steuerungsfenster.
   - Starten Sie die Module Apache und MySQL.
   - Gehen Sie im Browser zu `http://localhost/phpmyadmin`.
   - Erstellen Sie eine neue Datenbank:
     - Klicken Sie im linken Menü auf "Neu".
     - Geben Sie den Namen der Datenbank ein, z.B. `voguevibes_db`, und klicken Sie auf "Erstellen".

3. **Datenbankdatei importieren**:
   - Wählen Sie in phpMyAdmin die erstellte Datenbank `voguevibes_db` aus.
   - Gehen Sie auf die Registerkarte "Importieren".
   - Klicken Sie auf "Datei wählen" und wählen Sie die Datei `software_db.sql` aus Ihrem Projekt aus.
   - Klicken Sie auf "OK", um die Daten zu importieren.

4. **Composer installieren**:
   - Gehen Sie auf die [offizielle Composer-Website](https://getcomposer.org/) und laden Sie das Installationsprogramm für Ihr Betriebssystem herunter.
   - Installieren Sie Composer und folgen Sie den Anweisungen auf dem Bildschirm.
   - Überprüfen Sie die erfolgreiche Installation, indem Sie die Eingabeaufforderung (Terminal) öffnen und den folgenden Befehl eingeben:
     ```sh
     composer --version
     ```

5. **Abhängigkeiten des Projekts installieren**:
   - Öffnen Sie die Eingabeaufforderung (Terminal) und wechseln Sie in das Stammverzeichnis Ihres Projekts `vogueVibes_New`.
   - Führen Sie den folgenden Befehl aus, um alle im `composer.json` angegebenen Abhängigkeiten zu installieren:
     ```sh
     composer install
     ```

Diese Schritte helfen Ihnen, das Projekt auf Ihrem lokalen Server zu installieren und zu konfigurieren. Wenn Sie Fragen oder Probleme haben, konsultieren Sie die Dokumentation von XAMPP und Composer oder wenden Sie sich an Ihren Systemadministrator.
