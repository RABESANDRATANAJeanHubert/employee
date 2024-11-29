<?php
require_once 'Config/Databases.php';
require_once 'Config/Script.php';

class EmployeeModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Create a new employee.
     *
     * @param string $empId Employee ID.
     * @param string $empName Employee name.
     * @param int $empNum Employee number.
     * @return bool Whether the operation was successful.
     */
    public function createEmployee(string $empId, string $empName, int $empNum): bool
    {
        $stmt = $this->db->prepare(SQLScripts::CREATE_EMPLOYEE);
        return $stmt->execute([
            ':empId' => $empId,
            ':empName' => $empName,
            ':empNum' => $empNum,
        ]);
    }

    /**
     * Get all employees.
     *
     * @return array List of employees.
     */
    public function getEmployees(): array
    {
        $stmt = $this->db->query(SQLScripts::GET_ALL_EMPLOYEES);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get an employee by ID.
     *
     * @param string $empId Employee ID.
     * @return array|null Employee data or null if not found.
     */
    public function getEmployeeById(string $empId): ?array
    {
        $stmt = $this->db->prepare(SQLScripts::GET_EMPLOYEE_BY_ID);
        $stmt->execute([':empId' => $empId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Update an employee's details.
     *
     * @param string $empId Employee ID.
     * @param string $empName Employee name.
     * @param int $empNum Employee number.
     * @return bool Whether the operation was successful.
     */
    public function updateEmployee(string $empId, string $empName, int $empNum): bool
    {
        $stmt = $this->db->prepare(SQLScripts::UPDATE_EMPLOYEE);
        return $stmt->execute([
            ':empId' => $empId,
            ':empName' => $empName,
            ':empNum' => $empNum,
        ]);
    }

    /**
     * Delete an employee by ID.
     *
     * @param string $empId Employee ID.
     * @return bool Whether the operation was successful.
     */
    public function deleteEmployee(string $empId): bool
    {
        $stmt = $this->db->prepare(SQLScripts::DELETE_EMPLOYEE);
        return $stmt->execute([':empId' => $empId]);
    }
}

?>
