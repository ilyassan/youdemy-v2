<?php
    class TeachersAdminPage extends BaseController
    {
        public function index()
        {
            $filters["keyword"] = $_GET['keyword'] ?? '';
            $filters["status"] = $_GET['status'] ?? '';
            $filters["verified"] = true;

            $teachers = Teacher::all($filters);

            $this->render("/teachers/index", compact('teachers'));
        }
    }