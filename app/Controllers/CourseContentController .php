<?php

    class CourseContentController extends BaseController
    {
        public function index($id)
        {
            $course = Course::find($id);

            if (! $course->isStudentEnrolled(user()->getId())) {
                flash("warning", "You are not enrolled in this course.");
                back();
            }

            $relatedCourses = Course::limit(4);

            $this->render("/course-content/" . $course->getContentType(), compact('course', 'relatedCourses'));
        }
    }