<?php

    class CoursesPage extends BaseController
    {
        public function index()
        {
            $filters['keyword'] = $_GET['keyword'] ?? '';
            $filters['category_id'] = $_GET['category_id'] ?? '';
            $filters['min_price'] = $_GET['min_price'] ?? '';
            $filters['max_price'] = $_GET['max_price'] ?? '';

            $page = $_GET['page'] ?? 1;

            if (! is_numeric($page) || $page < 1) {
                redirect('courses');
            }

            $coursesTotalCount = Course::countByFilter($filters);
            $courses = Course::paginate($page, 6, $filters);
            $categories = Category::all();
            
            $this->render("/courses/index", compact('courses', 'categories', 'coursesTotalCount'));
        }

        public function show($id)
        {
            $course = Course::find($id);

            if (isLoggedIn() && $course->isStudentEnrolled(user()->getId())) {
                redirect("courses/content/" . $course->getId());
            }

            $relatedCourses = Course::limit(4);

            $this->render("/courses/show", compact('course', 'relatedCourses'));
        }

        public function enroll($courseId)
        {
            $enrollment = Enrollment::find(user()->getId(), $courseId);

            if ($enrollment) {
                flash("warning", "You already enrolled in this course.");
                back();
            }
            if (user()->getIsBanned()) {
                flash("error", "You are banned, you can't enroll in new courses.");
                back();
            }
            
            $enrollment = new Enrollment();
            $enrollment->setStudentId(user()->getId());
            $enrollment->setCourseId($courseId);

            if ($enrollment->save()) {
                flash("success", "You enrolled in the course successfully.");
                redirect("my-courses");
            }

            flash("error", "Something went wrong.");
            back();
        }

        public function completed($courseId)
        {
            $enrollment = Enrollment::find(user()->getId(), $courseId);

            if (! $enrollment) {
                flash("error", "Something went wrong.");
                back();
            }
            
            $enrollment->setIsCompleted(1);

            if ($enrollment->update()) {
                flash("success", "Congrutlations, you finished the course.");
                redirect("my-courses");
            }


            flash("error", "Something went wrong.");
            back();
        }
    }