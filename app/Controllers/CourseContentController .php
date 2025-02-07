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

        public function certify($id)
        {
            $enrollment = Enrollment::find(user()->getId(), $id);

            if (! $enrollment) {
                flash("warning", "You are not enrolled in this course.");
                back();
            }

            if (! $enrollment->getIsCompleted()) {
                flash("warning", "You didn't complete the course yet.");
                back();
            }

            $name = user()->getFullName();
        
            // Load the certificate template
            $image = imagecreatefrompng(CERTROOT . 'template.png');
        
            $black = imagecolorallocate($image, 43, 45, 66);
        
            $font = FONTSROOT . '/AlexBrush-Regular.ttf';
            $fontSize = 145;
        
            $imageWidth = imagesx($image);
            
            $textBox = imagettfbbox($fontSize, 0, $font, $name);
            $textWidth = $textBox[2] - $textBox[0];
            $x = ($imageWidth - $textWidth) / 2;
            $y = 650;
        
            // Add text to the image
            imagettftext($image, $fontSize, 0, $x, $y, $black, $font, $name);
        
            header('Content-Type: image/png');
            header('Content-Disposition: attachment; filename="certificate.png"');
            imagepng($image);
            
            // Free memory
            imagedestroy($image);
        }
    }