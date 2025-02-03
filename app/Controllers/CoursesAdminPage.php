<?php

    class CoursesAdminPage extends BaseController
    {
        public function index()
        {
            $filters['keyword'] = $_GET['keyword'] ?? '';
            $filters['category_id'] = $_GET['category_id'] ?? '';

            $courses = Course::all($filters);
            $categories = Category::all();
            
            $this->render("/courses/index", compact('courses', 'categories'));
        }

        public function show($id)
        {
            $course = Course::find($id);
            $categories = Category::all();
            $tags = Tag::all();

            $this->render("/courses/show", compact('course', 'categories', 'tags'));
        }

        public function delete($id)
        {
            // Get existing course
            $course = Course::find($id);
            if (!$course) {
                flash("error", "Course not found.");
                redirect('courses');
            }

            if ($course->delete()) {
                flash("success", "The course has been deleted successfully.");
                redirect('courses');
            }

            flash("error", "Something went wrong.");
            back();

            $this->render("/courses/edit", compact('course', 'categories', 'tags'));
        }
    }