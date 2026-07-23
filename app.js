// ==========================================================
// HOTEL SYSTEM FRONTEND LOGIC
// 1. Fetch employee list from Employee System API (PC2)
// 2. Populate the dropdown
// 3. On submit, POST reservation data to create_reservation.php
//    which stores it in hotel_db (PC1)
// ==========================================================

const employeeSelect = document.getElementById("employee_select");
const form = document.getElementById("reservationForm");
const statusDiv = document.getElementById("status");
const reservationsTable = document.getElementById("reservationsTable");

// ---- Step 1: Fetch employees from Employee System API ----
async function loadEmployees() {
    employeeSelect.innerHTML = `<option value="">Loading employees...</option>`;
    try {
        const res = await fetch(EMPLOYEE_API_URL);
        const employees = await res.json();

        if (!Array.isArray(employees) || employees.length === 0) {
            employeeSelect.innerHTML = `<option value="">No employees found</option>`;
            return;
        }

        employeeSelect.innerHTML = `<option value="">-- Select Employee --</option>`;
        employees.forEach(emp => {
            const option = document.createElement("option");
            option.value = emp.employee_id;
            option.textContent = emp.employee_name;
            option.dataset.name = emp.employee_name;
            employeeSelect.appendChild(option);
            employeeSelect.addEventListener("change", function () {
    document.getElementById("employee_id_display").value = employeeSelect.value || "";
});
        });
    } catch (err) {
        employeeSelect.innerHTML = `<option value="">Failed to load employees</option>`;
        console.error("Error fetching employees:", err);
    }
}

// ---- Step 2: Handle reservation form submit (Create + Store)  ----
form.addEventListener("submit", async function (e) {
    e.preventDefault();

    const selectedOption = employeeSelect.options[employeeSelect.selectedIndex];
    const payload = {
        customer_name: document.getElementById("customer_name").value.trim(),
        check_in: document.getElementById("check_in").value,
        check_out: document.getElementById("check_out").value,
        employee_name: selectedOption ? selectedOption.dataset.name : "",
        employee_id: employeeSelect.value
    };

    if (!payload.employee_id) {
        showStatus("Please select an employee.", false);
        return;
    }

    try {
        const res = await fetch("create_reservation.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(payload)
        });
        const result = await res.json();

        showStatus(result.message, result.success);

        if (result.success) {
            form.reset();
            loadEmployees();
        }
    } catch (err) {
        showStatus("Request failed. Is the hotel server running?", false);
        console.error(err);
    }
});

// ---- Step 3: Show list of stored reservations ----
async function loadReservations() {
    try {
        const res = await fetch("list_reservations.php");
        const reservations = await res.json();

        reservationsTable.innerHTML = `<tr><th>ID</th><th>Customer</th><th>Check In</th><th>Check Out</th><th>Employee</th></tr>`;
        reservations.forEach(r => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${r.reservation_id}</td>
                <td>${r.customer_name}</td>
                <td>${r.check_in}</td>
                <td>${r.check_out}</td>
                <td>${r.employee_name}</td>
            `;
            reservationsTable.appendChild(row);
        });
    } catch (err) {
        console.error("Error fetching reservations:", err);
    }
}

function showStatus(message, isSuccess) {
    statusDiv.textContent = message;
    statusDiv.className = isSuccess ? "status-ok" : "status-err";
}

// Initial load
loadEmployees();

