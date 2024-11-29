<?php
namespace App\Controllers;
require_once 'Models/EmployeeModel.php';
use App\Helpers\MessageConstants; 
/**
 * Class EmployeeController
 * Handles HTTP requests and responses for employee management.
 */
class EmployeeController
{
    private $model;

    public function __construct()
    {
        $this->model = new EmployeeModel();
    }

    /**
     * Create a new employee.
     *
     * @param array $data Employee data: ['empId', 'empName', 'empNum'].
     */
    public function createEmployee(array $data): void
    {
        var_dump($data);
        if ($this->validateEmployeeData($data)) {
            $success = $this->model->createEmployee($data['empId'], $data['empName'], (int)$data['empNum']);
            
            $this->sendResponse($success, MessageConstants::EMPOYEE_CREATED_SUCCESS, MessageConstants::EMPOYEE_FAILED_CREATED);
        } else {
            $this->sendResponse(false, '', MessageConstants::INVALID_EMPLOYEE_DATA);
        }
    }

    /**
     * Retrieve and display all employees.
     */
    public function getAllEmployees(): void
    {
        $employee_model = new EmployeeModel();
        $employees = $employee_model->getEmployees();
        $this->sendResponse(true, $employees);
    }

    /**
     * Retrieve a specific employee by ID.
     *
     * @param string $empId Employee ID.
     */
    public function getEmployeeById(string $empId): void
    {   
        $employee_model = new EmployeeModel();
        $employee = $temployee_model->getEmployeeById($empId);
        if ($employee) {
            $this->sendResponse(true, $employee);
        } else {
            $this->sendResponse(false, '', MessageConstants::EMPOYEE_NOT_FOUND);
        }
    }

    /**
     * Update an employee's details.
     *
     * @param array $data Employee data: ['empId', 'empName', 'empNum'].
     */
    public function updateEmployee(array $data): void
    {
        $employee_model = new EmployeeModel();
        if ($this->validateEmployeeData($data)) {
            $success = $employee_model->updateEmployee($data['empId'], $data['empName'], (int)$data['empNum']);

            $this->sendResponse($success, MessageConstants::EMPLOYEE_UPDATED_SUCCESS, MessageConstants::EMPLOYEE_UPDATE_FAILED);
        } else {
            $this->sendResponse(false, '', MessageConstants::INVALID_EMPLOYEE_DATA);
        }
    }

    /**
     * Delete an employee by ID.
     *
     * @param string $empId Employee ID.
     */
    public function deleteEmployee(string $empId): void
    {
        $employee_model = new EmployeeModel();
        $success = $employee_model->deleteEmployee($empId);
        $this->sendResponse($success, MessageConstants::EMPOYEE_DELETED_SUCCESS, MessageConstants::EMPLOYEE_DELETED_FAILED);
    }

    /**
     * Validate employee data.
     *
     * @param array $data Employee data.
     * @return bool Whether the data is valid.
     */
    private function validateEmployeeData(array $data): bool
    {
        return isset($data['empId'], $data['empName'], $data['empNum']) &&
            is_string($data['empId']) &&
            is_string($data['empName']) &&
            is_numeric($data['empNum']);
    }

    /**
     * Send a response back to the client.
     *
     * @param bool $success Whether the operation was successful.
     * @param mixed $data Data to send (can be a message or content).
     * @param string $errorMessage Error message (if any).
     */
    private function sendResponse(bool $success, $data = '', string $errorMessage = ''): void
    {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => $success,
            'data' => $success ? $data : null,
            'error' => $success ? null : $errorMessage,
        ]);
    }
}

?>
