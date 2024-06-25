<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym Ni Dan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }
        .form-container, .table-container {
            margin-bottom: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-container h2, .table-container h2 {
            margin-bottom: 20px;
        }
        .form-container form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .form-container form input, .form-container form select {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-container form button {
            grid-column: span 2;
            padding: 10px 15px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
        }
        .form-container form button:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        th:nth-child(1) {
            width: 5%;
        }
        th:nth-child(2) {
            width: 20%;
        }
        th:nth-child(3), th:nth-child(4) {
            width: 20%;
        }
        th:nth-child(5) {
            width: 15%;
        }
        th:nth-child(6) {
            width: 20%;
        }
        td button {
            padding: 5px 10px;
            margin: 2px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            color: white;
        }
        .update-btn {
            background-color: #28a745;
        }
        .remove-btn {
            background-color: #dc3545;
        }
        .edit-btn {
            background-color: #17a2b8;
        }
        td button:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Gym Ni Dan</h2>
        <form id="taskForm">
            @csrf
            <input type="text" id="taskTitle" placeholder="Name" required>
            <input type="date" id="membershipDate" placeholder="Membership Date" required>
            <input type="date" id="expirationDate" placeholder="Expiration Date" required>
            <input type="hidden" id="editingMemberId">
            <select id="membershipType" required>
                <option value="" disabled selected>Select Membership Type</option>
                <option value="Basic">Basic</option>
                <option value="Premium">Premium</option>
            </select>
            <button type="submit" id="addButton" class="add-btn">Add</button>
            <button type="button" id="saveButton" class="add-btn" style="display:none;">Save</button>
        </form>
    </div>

    <div class="table-container">
        <h2>Current Members</h2>
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Membership Date</th>
                    <th>Expiration Date</th>
                    <th>Type</th>
                    <th>Operations</th>
                </tr>
            </thead>
            <tbody id="currentMembersTableBody">
                <!-- Dynamic rows will be added here -->
            </tbody>
        </table>
    </div>

    <script>
        let taskId = 1;
        let editingRow = null;
        const taskForm = document.getElementById('taskForm');
        const currentMembersTableBody = document.getElementById('currentMembersTableBody');

        async function fetchMembers() {
            const response = await fetch('/api/gymsub', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            if (response.ok) {
                const data = await response.json();
                data.members.forEach(member => {
                    addRowToTable(member.id, member.name, member.start_date, member.end_date, member.membership_type);
                });
            } else {
                console.error('Failed to fetch members');
            }
        }

        function addRowToTable(id, name, startDate, endDate, membershipType) {
            const row = document.createElement('tr');
            row.dataset.id = id;
            row.innerHTML = `
                <td>${id}</td>
                <td>${name}</td>
                <td>${startDate}</td>
                <td>${endDate}</td>
                <td>${membershipType}</td>
                <td>
                    <button class="edit-btn" onclick="editTask(this)">Edit</button>
                    <button class="remove-btn" onclick="removeTask(this)">Remove</button>
                </td>
            `;
            currentMembersTableBody.appendChild(row);
        }

        taskForm.addEventListener('submit', async function(event) {
            event.preventDefault();

            const title = document.getElementById('taskTitle').value;
            const membershipDate = document.getElementById('membershipDate').value;
            const expirationDate = document.getElementById('expirationDate').value;
            const membershipType = document.getElementById('membershipType').value;

            const csrfToken = document.querySelector('input[name="_token"]').value;

            const response = await fetch('/api/gymsub', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    name: title,
                    start_date: membershipDate,
                    end_date: expirationDate,
                    membership_type: membershipType
                })
            });

            if (response.ok) {
                const data = await response.json();
                addRowToTable(taskId, title, membershipDate, expirationDate, membershipType);
                taskId++;
                taskForm.reset();
            } else {
                const errorData = await response.json();
                alert('Error: ' + errorData.message);
            }
        });

        async function editTask(button) {
            const row = button.parentElement.parentElement;
            editingRow = row;
            document.getElementById('taskTitle').value = row.children[1].textContent;
            document.getElementById('membershipDate').value = row.children[2].textContent;
            document.getElementById('expirationDate').value = row.children[3].textContent;
            document.getElementById('membershipType').value = row.children[4].textContent;
            
            document.getElementById('editingMemberId').value = row.dataset.id;
            document.getElementById('addButton').style.display = 'none';
            document.getElementById('saveButton').style.display = 'block';
        }

        async function saveChanges() {
            const id = document.getElementById('editingMemberId').value;
            const title = document.getElementById('taskTitle').value;
            const membershipDate = document.getElementById('membershipDate').value;
            const expirationDate = document.getElementById('expirationDate').value;
            const membershipType = document.getElementById('membershipType').value;

            const csrfToken = document.querySelector('input[name="_token"]').value;

            const response = await fetch(`/api/gymsub/${id}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    name: title,
                    start_date: membershipDate,
                    end_date: expirationDate,
                    membership_type: membershipType
                })
            });

            if (response.ok) {
                const data = await response.json();
                console.log(data.message);

                // Update the row in the table with new values
                editingRow.children[1].textContent = title;
                editingRow.children[2].textContent = membershipDate;
                editingRow.children[3].textContent = expirationDate;
                editingRow.children[4].textContent = membershipType;

                // Reset the form and buttons
                taskForm.reset();
                document.getElementById('addButton').style.display = 'block';
                document.getElementById('saveButton').style.display = 'none';
                editingRow = null
            } else {
                const errorData = await response.json();
                alert('Error: ' + errorData.message);
            }
        }

        document.getElementById('saveButton').addEventListener('click', saveChanges);

        async function removeTask(button) {
            const row = button.parentElement.parentElement;
            const id = row.dataset.id;

            const csrfToken = document.querySelector('input[name="_token"]').value;

            const response = await fetch(`/api/gymsub/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            if (response.ok) {
                row.remove();
            } else {
                const errorData = await response.json();
                alert('Error: ' + errorData.message);
            }
        }

        // Fetch existing members when the page loads
        fetchMembers();
    </script>
</body>
</html>
