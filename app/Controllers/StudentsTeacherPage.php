<?php
    class StudentsTeacherPage extends BaseController
    {
        public function index()
        {
            $keyword = $_GET['keyword'] ?? '';

            $students = Student::teacherStudents(user()->getId(), $keyword);

            $this->render("/students/index", compact('students'));
        }
    }