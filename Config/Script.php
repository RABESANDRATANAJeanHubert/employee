<?php

/**
 * Class SQLScripts
 * Contains all reusable SQL queries as constants.
 */
class SQLScripts
{
    // SQL script to create a new employee
    public const CREATE_EMPLOYEE = "
        INSERT INTO employees (empId, empName, empNum) 
        VALUES (:empId, :empName, :empNum)
    ";

    // SQL script to fetch all employees
    public const GET_ALL_EMPLOYEES = "
        SELECT * FROM employees
    ";

    // SQL script to fetch a specific employee by ID
    public const GET_EMPLOYEE_BY_ID = "
        SELECT * FROM employees WHERE empId = :empId
    ";

    // SQL script to update an employee's information
    public const UPDATE_EMPLOYEE = "
        UPDATE employees SET empName = :empName, empNum = :empNum 
        WHERE empId = :empId
    ";

    // SQL script to delete an employee by ID
    public const DELETE_EMPLOYEE = "
        DELETE FROM employees WHERE empId = :empId
    ";
}

?>
