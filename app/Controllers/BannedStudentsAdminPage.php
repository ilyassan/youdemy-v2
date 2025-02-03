<?php

    class BannedStudentsAdminPage extends BaseController
    {
        public function index()
        {
            $filters["banned"] = true;
            
            $bannedStudents = Student::all($filters);

            $this->render("/banned-students/index", compact("bannedStudents"));
        }

        public function ban($id)
        {
            $student = User::find($id);

            if (!$student || !$student->isStudent() || !$student->ban()) {
                flash("error", "Something went wrong");
            }else{
                flash("success", $student->getFullName() . " has been banned successfully");
            }
            
            back();
        }

        public function unBan($id)
        {
            $student = User::find($id);

            if (!$student || !$student->isStudent() || !$student->unBan()) {
                flash("error", "Something went wrong");
            }else{
                flash("success", $student->getFullName() . " has been unbanned successfully");
            }

            back();
        }
    }