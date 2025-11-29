todo_app/
api/ - backend PHP (klasy + API)

Database.php - klasa odpowiedzialna za połączenie z MySQL

Task.php - klasa implementująca CRUD dla zadań

tasks.php - router API (GET / POST / PUT / DELETE)

public/ - frontend

css/ - style (CSS)

js/ - skrypty JS

index.html - główny widok aplikacji

sql/ - pliki bazy danych

baza.sql - skrypt do stworzenia bazy i tabeli tasks

bazav2.sql - baza ktoóra zawiera już kilka rekordów (użyta była do sprawdzenia działania)

Instalacja:

1. Sklonuj lub pobierz repozytorium do katalogu `htdocs` (jeśli używasz XAMPP).  
   ```bash
   git clone https://github.com/S1gla/zaliczeniephp.git
2. Uruchom serwer Apache i MySQL w XAMPP (lub innym).

3. Załaduj plik SQL w phpMyAdmin albo ręcznie:

4. Otwórz phpMyAdmin → Import → wybierz todo_app/sql/baza.sql

5. To utworzy bazę baza i tabelę tasks.

6. W przeglądarce przejdź pod adres:
    http://localhost/todo_app/public/
