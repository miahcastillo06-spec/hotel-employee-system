# Hotel System ↔ Employee System Integration

This project recreates the activity diagram: two separate systems that talk to
each other over an API, so the Hotel System's reservation form can pull live
employee data from the Employee System instead of duplicating it.

```
 hotel_sys (PC1 / web server1)          employee_sys (PC2 / webserver2)
 ┌───────────────────────┐              ┌───────────────────────┐
 │ 1. reservation         │   fetch      │ employees table        │
 │   - name customer      │◄─────────────┤ get_employees.php       │
 │   - check in           │   (Create)   │  → returns JSON         │
 │   - check out          │              └───────────────────────┘
 │   - employee name      │
 │   - employee id        │
 │        (Create/Store)  │
 └───────────────────────┘
```

- **Employee System** (PC2 / Webserver 2): owns the `employees` table and
  exposes `get_employees.php`, which returns all employees as JSON. Employee
  IDs are set to start at 1001.
- **Hotel System** (PC1 / Web Server 1): shows a reservation form. Its
  frontend fetches the employee list from the Employee System's API to
  populate the "Attending Employee" dropdown (Employee ID auto-fills once an
  employee is selected), then submits the finished reservation to its own
  backend, which stores it in the `hotel_db` database.

## Folder structure

```
hotel-employee-system/
├── database/
│   ├── employee_system.sql     -> creates & seeds the employee database
│   └── hotel_system.sql        -> creates the reservations table
│
├── employee_system/            → PC2 / Webserver 2
│   ├── db_config.php            (connects to employee_db)
│   ├── get_employees.php        (API: returns employees as JSON)
│   ├── add_employee.php         (creates a new employee)
│   └── index.php                (frontend: add/list employees)
│
├── hotel_system/                → PC1 / Web Server 1
│   ├── db_config.php            (connects to hotel_db)
│   ├── create_reservation.php   (stores a reservation)
│   ├── index.html               (reservation form frontend)
│   ├── hotel-background.jpg
│   └── js/
│       ├── config.js            (points to Employee System API URL)
│       └── app.js               (fetches employees, submits reservation)
│
└── screenshots/                 (proof of functionality, see below)
    ├── 01-dropdown-populated.png
    ├── 02-form-filled.png
    ├── 03-reservation-success.png
    ├── 04-reservations-table.png
    └── 05-employees-table.png
```

## How it maps to the guide steps

| Guide step | Where it lives |
|---|---|
| Create the Hotel System frontend | `hotel_system/index.html` |
| Connect Hotel System to a database | `hotel_system/db_config.php` |
| Create database for hotel system | `database/hotel_system.sql` → `reservations` table |
| Hotel system's Create function working | `hotel_system/create_reservation.php` |
| Create database for employee system | `database/employee_system.sql` → `employees` table |
| PHP script returning employees as JSON | `employee_system/get_employees.php` |
| Frontend script populating the dropdown | `hotel_system/js/app.js` → `loadEmployees()` |
| Full flow: create reservation with dropdown fed by API | Open `hotel_system/index.html`, fill and submit the form |

## How to run it locally (XAMPP / WAMP / MAMP)

1. **Install XAMPP** (or WAMP/MAMP) — start **Apache** and **MySQL**.
2. **Create the databases**: open phpMyAdmin (`http://localhost/phpmyadmin`),
   click the **SQL** tab, and run `database/employee_system.sql`, then
   `database/hotel_system.sql`.
3. **Copy the project** into your web root, e.g.:
   ```
   C:\xampp\htdocs\hotel-employee-system\
   ```
4. Check `hotel_system/db_config.php` and `employee_system/db_config.php` —
   update the username/password if your MySQL setup isn't the default XAMPP
   `root` with no password.
5. In `hotel_system/js/config.js`, make sure `EMPLOYEE_API_URL` points to the
   Employee System's `get_employees.php`, e.g.:
   ```
   http://localhost/hotel-employee-system/employee_system/get_employees.php
   ```
6. Visit `http://localhost/hotel-employee-system/employee_system/index.php`
   to confirm employees exist (seeded with IDs 1001–1009).
7. Visit `http://localhost/hotel-employee-system/hotel_system/index.html` —
   the **Attending Employee** dropdown should populate automatically from the
   Employee System, and the **Employee ID** field auto-fills once you pick a
   name.
8. Fill out and submit a reservation — it's stored in `hotel_db` →
   `reservations` (the stored reservations aren't displayed on the page
   itself, only saved to the database — verify via phpMyAdmin).

### Running on two actual PCs
To truly split this across two machines like the diagram shows:
- Deploy `employee_system/` on PC2's web server, reachable from PC1 over the
  network.
- In `hotel_system/js/config.js`, change `EMPLOYEE_API_URL` to PC2's IP,
  e.g. `http://192.168.1.20/employee_system/get_employees.php`.
- CORS headers are already set in `get_employees.php` so PC1 can call PC2's
  API across origins.

## Proof of functionality

Screenshots in `screenshots/` show the full flow end-to-end:

1. `01-dropdown-populated.png` — employee dropdown populated via API fetch
   from the Employee System
2. `02-form-filled.png` — reservation form filled out, Employee ID auto-fills
   once an employee is selected
3. `03-reservation-success.png` — reservation created successfully
4. `04-reservations-table.png` — `hotel_db` → `reservations` table showing
   the saved record (proves the Create/Store function works)
5. `05-employees-table.png` — `employee_db` → `employees` table with IDs
   starting at 1001

## Submission checklist
- [x] Push this whole `hotel-employee-system/` folder to a **public** GitHub repo.
- [ ] Submit the GitHub repo link.
- [ ] Zip the folder and submit the `.zip` alongside the link.
