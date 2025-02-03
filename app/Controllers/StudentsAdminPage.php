<?php
    class StudentsAdminPage extends BaseController
    {
        public function index()
        {
            $filters["keyword"] = $_GET['keyword'] ?? '';
            $filters["status"] = $_GET['status'] ?? '';
            $filters["banned"] = false;

            $students = Student::all($filters);

            $this->render("/students/index", compact("students"));
        }
    }