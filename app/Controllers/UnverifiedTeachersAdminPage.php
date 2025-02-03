<?php
    class UnverifiedTeachersAdminPage extends BaseController
    {
        public function index()
        {
            $filters["verified"] = false;

            $unverifiedTeachers = Teacher::all($filters);

            $this->render("/unverified-teachers/index", compact("unverifiedTeachers"));
        }

        public function verify($id)
        {
            $teacher = User::find($id);

            if (!$teacher || !$teacher->isTeacher() || !$teacher->verify()) {
                flash("error", "Something whent wrong");
            }else{
                flash("success", $teacher->getFullName() . " verified successfully.");
            }

            back();
        }
    }