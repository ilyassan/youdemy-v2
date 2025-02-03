<?php

    class MyCoursesPage extends BaseController
    {
        public function index()
        {
            $keyword = $_GET['keyword'] ?? '';

            $courses = Course::findByStudentId(user()->getId(), $keyword);
            
            $this->render("/my-courses/index", compact("courses"));
        }

        public function rateCourse()
        {
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);

            $courseId = $data['courseId'];
            $studentId = user()->getId();
            $rating = $data['rating'];

            $rate = Rate::getRateOfStudent($studentId, $courseId);
            
            if ($rate) {
                $rate->setRate($rating);
                $rate->update();
            }else{
                $rate = new Rate(null, $rating, $studentId, $courseId);
                $rate->save();
            }
            
            echo json_encode(["success" => true]);
        }   

        public function deleteCourseRate()
        {
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);

            $courseId = $data['courseId'];
            $studentId = user()->getId();

            $rate = Rate::getRateOfStudent($studentId, $courseId);

            if ($rate) {
                $rate->delete();
            }

            echo json_encode(["success" => true]);
        }
    }