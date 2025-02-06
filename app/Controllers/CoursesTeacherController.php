<?php

    class CoursesTeacherController extends BaseController
    {
        public function index()
        {
            $filters['keyword'] = $_GET['keyword'] ?? '';
            $filters['category_id'] = $_GET['category_id'] ?? '';
            $filters['teacher_id'] = user()->getId();

            $courses = Course::all($filters);
            $categories = Category::all();
            
            $this->render("/courses/index", compact('courses', 'categories'));
        }

        public function create()
        {
            if (! user()->getIsVerified()) {
                flash("warning", "You can't perfome any action until you are verified.");
                redirect("");
            }
            $categories = Category::all();
            $tags = Tag::all();

            $this->render("/courses/create", compact('categories', 'tags'));
        }

        public function edit($id)
        {
            if (! user()->getIsVerified()) {
                flash("warning", "You can't perfome any action until you are verified.");
                redirect("");
            }
            $course = Course::find($id);

            if ($course->getTeacherId() != user()->getId()) {
                redirect("courses");
            }

            $categories = Category::all();
            $tags = Tag::all();

            $this->render("/courses/edit", compact('course', 'categories', 'tags'));
        }


        public function store()
        {
            if (! user()->getIsVerified()) {
                flash("warning", "You can't perfome any action until you are verified.");
                redirect("");
            }
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
            $data = [
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'price' => trim($_POST['price']),
                'category_id' => trim($_POST['category_id']),
                'tag_ids' => $_POST['tag_ids'] ?? [],
                'thumbnail' => $_FILES['thumbnail'],
                'video_content' => $_FILES['video-content'] ?? null,
                'document_content' => $_FILES['document-content'] ?? null,
            ];
        
            $errors = [
                'title_err' => '',
                'description_err' => '',
                'price_err' => '',
                'category_id_err' => '',
                'tag_ids_err' => '',
                'thumbnail_err' => '',
                'content_err' => '',
                'general_err' => '',
            ];
        
            // Validate basic info
            if (empty($data['title'])) {
                $errors['title_err'] = 'Please enter the course title.';
            }
        
            if (empty($data['description'])) {
                $errors['description_err'] = 'Please enter the course description.';
            }
        
            if (empty($data['price'])) {
                $errors['price_err'] = 'Please enter the course price.';
            }
        
            if (empty($data['category_id'])) {
                $errors['category_id_err'] = 'Please select a course category.';
            }
        
            if (empty($data['tag_ids'])) {
                $errors['tag_ids_err'] = 'Please select at least one tag.';
            }
        
            // Handle thumbnail upload
            $thumbnailName = '';
            if (empty($data['thumbnail']['name']) || $data['thumbnail']['size'] == 0) {
                $errors['thumbnail_err'] = 'Course thumbnail is required.';
            } elseif ($data['thumbnail']['error'] === UPLOAD_ERR_OK) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (in_array($data['thumbnail']['type'], $allowedTypes)) {
                    $uploadDir = IMAGESROOT . 'thumbnails/';
                    
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
        
                    $thumbnailName = time() . '_' . basename($data['thumbnail']['name']);
                    $thumbnailPath = $uploadDir . $thumbnailName;
        
                    if (!move_uploaded_file($data['thumbnail']['tmp_name'], $thumbnailPath)) {
                        $errors['thumbnail_err'] = 'Failed to upload the thumbnail.';
                    }
                } else {
                    $errors['thumbnail_err'] = 'Invalid image format. Allowed formats are JPG, PNG, and GIF.';
                }
            }
        
            // Handle course content upload (video or document)
            $contentName = '';
            $contentType = '';

            if (!empty($data['video_content']['name'])) {
                $contentFile = $data['video_content'];
                $allowedTypes = ['video/mp4'];
                $contentType = 'video';
                $uploadDir = VIDEOSROOT;
            } elseif (!empty($data['document_content']['name'])) {
                $contentFile = $data['document_content'];
                $allowedTypes = ['application/pdf'];
                $contentType = 'document';
                $uploadDir = PDFSROOT;
            } else {
                $errors['content_err'] = 'Please upload either a video or document.';
            }
        
            // Process content upload if file was provided
            if (isset($contentFile) && $contentFile['error'] === UPLOAD_ERR_OK) {
                if (in_array($contentFile['type'], $allowedTypes)) {
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
        
                    $contentName = time() . '_' . basename($contentFile['name']);
                    $contentPath = $uploadDir . $contentName;
        
                    if (!move_uploaded_file($contentFile['tmp_name'], $contentPath)) {
                        $errors['content_err'] = 'Failed to upload the course content.';
                    }
                } else {
                    $errors['content_err'] = 'Invalid file format.';
                }
            }
        
            // If no errors, save to database
            if (empty(array_filter($errors))) {
                if ($contentType == "video") {
                    $course = new CourseVideo();
                }else{
                    $course = new CourseDocument();
                }

                $course->setTitle($data['title']);
                $course->setDescription($data['description']);
                $course->setPrice($data['price']);
                $course->setCategoryId($data['category_id']);
                $course->setTeacherId(user()->getId());
                $course->setThumbnail($thumbnailName);
                $course->setContent($contentName);
        
                if ($course->save() && $course->attachTags($data['tag_ids'])) {
                    flash("success", "Course created successfully!");
                    redirect('courses');
                } else {
                    $errors['general_err'] = 'Something went wrong while creating the course.';
                }
            }
        
            flash("error", array_first_not_null_value($errors));
            back();
        }
        
        public function update($id)
        {
            if (! user()->getIsVerified()) {
                flash("warning", "You can't perfome any action until you are verified.");
                redirect("");
            }
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            // Get existing course
            $course = Course::find($id);
            if (!$course || $course->getTeacherId() != user()->getId()) {
                flash("error", "Course not found.");
                redirect('courses');
            }
        
            $data = [
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'price' => trim($_POST['price']),
                'category_id' => trim($_POST['category_id']),
                'tag_ids' => $_POST['tag_ids'] ?? [],
                'thumbnail' => $_FILES['thumbnail'] ?? null,
                'video_content' => $_FILES['video-content'] ?? null,
                'document_content' => $_FILES['document-content'] ?? null,
            ];
        
            $errors = [
                'title_err' => '',
                'description_err' => '',
                'price_err' => '',
                'category_id_err' => '',
                'tag_ids_err' => '',
                'thumbnail_err' => '',
                'content_err' => '',
                'general_err' => '',
            ];
        
            // Validate basic info
            if (empty($data['title'])) {
                $errors['title_err'] = 'Please enter the course title.';
            }
        
            if (empty($data['description'])) {
                $errors['description_err'] = 'Please enter the course description.';
            }
        
            if (empty($data['price'])) {
                $errors['price_err'] = 'Please enter the course price.';
            }
        
            if (empty($data['category_id'])) {
                $errors['category_id_err'] = 'Please select a course category.';
            }
        
            if (empty($data['tag_ids'])) {
                $errors['tag_ids_err'] = 'Please select at least one tag.';
            }
        
            // Handle thumbnail upload if new thumbnail provided
            $thumbnailName = $course->getThumbnailName();
            if (!empty($data['thumbnail']['name'])) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (in_array($data['thumbnail']['type'], $allowedTypes)) {
                    $uploadDir = IMAGESROOT . 'thumbnails/';
                    
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
        
                    // Delete old thumbnail if exists
                    if (file_exists($uploadDir . $course->getThumbnail())) {
                        unlink($uploadDir . $course->getThumbnail());
                    }
        
                    $thumbnailName = time() . '_' . basename($data['thumbnail']['name']);
                    $thumbnailPath = $uploadDir . $thumbnailName;
        
                    if (!move_uploaded_file($data['thumbnail']['tmp_name'], $thumbnailPath)) {
                        $errors['thumbnail_err'] = 'Failed to upload the thumbnail.';
                    }
                } else {
                    $errors['thumbnail_err'] = 'Invalid image format. Allowed formats are JPG, PNG, and GIF.';
                }
            }
        
            // Handle course content upload if new content provided
            $contentName = $course->getContent();
            $contentType = $course->getContentType();
        
            if (!empty($data['video_content']['name'])) {
                $contentFile = $data['video_content'];
                $allowedTypes = ['video/mp4'];
                $contentType = 'video';
                $uploadDir = VIDEOSROOT;
            } elseif (!empty($data['document_content']['name'])) {
                $contentFile = $data['document_content'];
                $allowedTypes = ['application/pdf'];
                $contentType = 'document';
                $uploadDir = PDFSROOT;
            }
        
            // Process content upload if new file was provided
            if (isset($contentFile) && $contentFile['error'] === UPLOAD_ERR_OK) {
                if (in_array($contentFile['type'], $allowedTypes)) {
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
        
                    // Delete old content if exists
                    $oldContentDir = ($course->getContentType() === 'video') ? VIDEOSROOT : PDFSROOT;
                    if (file_exists($oldContentDir . $course->getContent())) {
                        unlink($oldContentDir . $course->getContent());
                    }
        
                    $contentName = time() . '_' . basename($contentFile['name']);
                    $contentPath = $uploadDir . $contentName;
        
                    if (!move_uploaded_file($contentFile['tmp_name'], $contentPath)) {
                        $errors['content_err'] = 'Failed to upload the course content.';
                    }
                } else {
                    $errors['content_err'] = 'Invalid file format.';
                }
            }
        
            // If no errors, update the course
            if (empty(array_filter($errors))) {
                // Update course type if content type changed
                if ($contentType !== $course->getContentType()) {
                    if ($contentType === "video") {
                        $newCourse = new CourseVideo();
                    } else {
                        $newCourse = new CourseDocument();
                    }
                    // Copy existing data to new course object
                    $newCourse->setId($course->getId());
                    $course = $newCourse;
                }
        
                $course->setTitle($data['title']);
                $course->setDescription($data['description']);
                $course->setPrice($data['price']);
                $course->setCategoryId($data['category_id']);
                $course->setThumbnail($thumbnailName);
                $course->setContent($contentName);
        
                if ($course->update() && $course->unattachTags() && $course->attachTags($data['tag_ids'])) {
                    flash("success", "Course updated successfully!");
                    back();
                } else {
                    $errors['general_err'] = 'Something went wrong while updating the course.';
                }
            }
        
            flash("error", array_first_not_null_value($errors));
            back();
        }

        public function delete($id)
        {
            if (! user()->getIsVerified()) {
                flash("warning", "You can't perfome any action until you are verified.");
                redirect("");
            }
            // Get existing course
            $course = Course::find($id);
            
            if (!$course || $course->getTeacherId() != user()->getId()) {
                flash("error", "Course not found.");
                redirect('courses');
            }

            if ($course->delete()) {
                flash("success", "The course has been deleted successfully.");
                redirect('courses');
            }

            flash("error", "Something went wrong.");
            back();
        }
    }