<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employee Management</title>
  <!-- Include jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    #updateEmployeeForm { display: none; } /* Initially hide the update form */
  </style>
</head>
<body>
  <h1>Employee Management</h1>

  <!-- Create Employee Form -->
  <form id="createEmployeeForm">
    <input type="text" id="empId" placeholder="Employee ID" required>
    <input type="text" id="empName" placeholder="Employee Name" required>
    <input type="text" id="empNum" placeholder="Employee Number" required>
    <button type="submit">Add Employee</button>
  </form>

  <!-- Update Employee Form -->
  <form id="updateEmployeeForm">
    <input type="text" id="updateEmpId" placeholder="Employee ID" readonly>
    <input type="text" id="updateEmpName" placeholder="Employee Name" required>
    <input type="text" id="updateEmpNum" placeholder="Employee Number" required>
    <button type="submit">Update Employee</button>
  </form>

  <!-- Employee Table -->
  <table border="1">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Number</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody id="employeeTable"></tbody>
  </table>
</body>
</html>

<script>
  $(document).ready(function () {
    const employeeTable = $("#employeeTable");
    const createEmployeeForm = $("#createEmployeeForm");
    const updateEmployeeForm = $("#updateEmployeeForm");

    // Fetch all employees on page load
    fetchEmployees();

    // Event listener for adding an employee
    createEmployeeForm.on("submit", function (event) {
      event.preventDefault();

      const empId = $("#empId").val();
      const empName = $("#empName").val();
      const empNum = $("#empNum").val();

      const employeeData = { empId, empName, empNum };

      $.ajax({
        url: '/EmployeeController/createEmployee',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(employeeData),
        success: function (response) {
          if (response.success) {
            alert("Employee created successfully!");
            fetchEmployees();
            createEmployeeForm.trigger("reset"); // Clear the form
          } else {
            alert(response.error || "Failed to create employee.");
          }
        },
        error: function (xhr, status, error) {
          console.error("Error creating employee:", error);
        }
      });
    });

    // Fetch all employees
    function fetchEmployees() {
      $.ajax({
        url: '/EmployeeController/getAllEmployees',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            employeeTable.empty(); // Clear the table
            response.data.forEach(employee => {
              const row = `
                <tr>
                  <td>${employee.empId}</td>
                  <td>${employee.empName}</td>
                  <td>${employee.empNum}</td>
                  <td>
                    <button onclick="editEmployee('${employee.empId}', '${employee.empName}', ${employee.empNum})">Edit</button>
                    <button onclick="deleteEmployee('${employee.empId}')">Delete</button>
                  </td>
                </tr>
              `;
              employeeTable.append(row);
            });
          } else {
            alert(response.error || "Failed to fetch employees.");
          }
        },
        error: function (xhr, status, error) {
          console.error("Error fetching employees:", error);
        }
      });
    }

    // Function to delete an employee
    window.deleteEmployee = function (empId) {
      if (confirm("Are you sure you want to delete this employee?")) {
        $.ajax({
          url: '/EmployeeController/deleteEmployee',
          type: 'POST',
          contentType: 'application/json',
          data: JSON.stringify({ empId }),
          success: function (response) {
            if (response.success) {
              alert("Employee deleted successfully!");
              fetchEmployees();
            } else {
              alert(response.error || "Failed to delete employee.");
            }
          },
          error: function (xhr, status, error) {
            console.error("Error deleting employee:", error);
          }
        });
      }
    };

    // Function to edit an employee
    window.editEmployee = function (empId, empName, empNum) {
      $("#updateEmpId").val(empId);
      $("#updateEmpName").val(empName);
      $("#updateEmpNum").val(empNum);
      updateEmployeeForm.show(); // Show the update form
    };

    // Event listener for updating an employee
    updateEmployeeForm.on("submit", function (event) {
      event.preventDefault();

      const empId = $("#updateEmpId").val();
      const empName = $("#updateEmpName").val();
      const empNum = $("#updateEmpNum").val();

      const employeeData = { empId, empName, empNum };

      $.ajax({
        url: '/EmployeeController/updateEmployee',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(employeeData),
        success: function (response) {
          if (response.success) {
            alert("Employee updated successfully!");
            fetchEmployees();
            updateEmployeeForm.hide(); // Hide the update form
          } else {
            alert(response.error || "Failed to update employee.");
          }
        },
        error: function (xhr, status, error) {
          console.error("Error updating employee:", error);
        }
      });
    });
  });
</script>
