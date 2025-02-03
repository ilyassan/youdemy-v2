<?php
abstract class Course extends BaseModel {

    protected $id;
    protected $title;
    protected $description;
    protected $price;
    protected $thumbnail;
    protected $is_deleted;
    protected $teacher_id;
    protected $category_id;
    protected $created_at;
    protected $updated_at;

    protected $rate;
    protected $rates_count;
    protected $teacher_name;
    protected $category_name;
    protected $enrollments_count;
    protected $is_completed;
    protected $tags;

    public function __construct($id = null, $title = null, $description = null, $price = null, $thumbnail = null, $is_deleted = null, $teacher_id = null, $category_id = null, $created_at = null, $updated_at = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->thumbnail = $thumbnail;
        $this->is_deleted = $is_deleted;
        $this->teacher_id = $teacher_id;
        $this->category_id = $category_id;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getThumbnail()
    {
        return URLASSETS . 'images/thumbnails/' . $this->thumbnail;
    }

    public function getIsDeleted()
    {
        return $this->is_deleted;
    }

    public function getTeacherId()
    {
        return $this->teacher_id;
    }

    public function getCategoryId()
    {
        return $this->category_id;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    public function getRate()
    {
        return number_format($this->rate, 2);
    }

    public function getRatesCount()
    {
        return $this->rates_count;
    }

    public function getTeacherName()
    {
        return $this->teacher_name;
    }

    public function getCategoryName()
    {
        return $this->category_name;
    }

    public function getEnrollmentsCount()
    {
        return $this->enrollments_count;
    }

    public function getIsCompleted()
    {
        return $this->is_completed;
    }

    public function getTags()
    {
        return $this->tags;
    }

    // Setters

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;
    }

    public function setTeacherId($teacher_id)
    {
        $this->teacher_id = $teacher_id;
    }

    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
    }

    public function setIsDeleted($is_deleted)
    {
        $this->is_deleted = $is_deleted;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    public function setRate($rate)
    {
        $this->rate = $rate;
    }

    public function setRatesCount($rates_count)
    {
        $this->rates_count = $rates_count;
    }

    public function setTeacherName($teacher_name)
    {
        $this->teacher_name = $teacher_name;
    }

    public function setIsCompleted($is_completed)
    {
        $this->is_completed = $is_completed;
    }

    public function setCategoryName($category_name)
    {
        $this->category_name = $category_name;
    }

    public function setEnrollmentsCount($enrollments_count)
    {
        $this->enrollments_count = $enrollments_count;
    }

    public function setTags(array $tags)
    {
        $this->tags = $tags;
    }

    abstract public function getContent();
    abstract public function getContentType();
    abstract public function setContent($content);

    abstract public function save();
    abstract public function update();

    // Delete a course from the database
    public function delete()
    {
        $sql = "DELETE FROM courses WHERE id = :id";
        self::$db->query($sql);
        self::$db->bind(':id', $this->id);
        return self::$db->execute();
    }

    // Attach tags to a course
    public function attachTags($ids)
    {
        $sql = "INSERT INTO courses_tags (course_id, tag_id) VALUES ";
        $values = [];
        $params = [];
        foreach ($ids as $index => $tag_id) {
            $values[] = "(:course_id_{$index}, :tag_id_{$index})";
            $params[":course_id_{$index}"] = $this->id;
            $params[":tag_id_{$index}"] = $tag_id;
        }
        $sql .= implode(", ", $values);
        self::$db->query($sql);
        foreach ($params as $key => $value) {
            self::$db->bind($key, $value);
        }

        return self::$db->execute();
    }

    // Unattach tags to a course
    public function unattachTags()
    {
        $sql = "DELETE FROM courses_tags WHERE course_id = :id ";
        
        self::$db->query($sql);
        self::$db->bind(':id', $this->id);

        return self::$db->execute();
    }

    public function isStudentEnrolled($student_id)
    {
        $sql = "SELECT * FROM enrollments
                WHERE course_id = :course_id AND student_id = :student_id";

        self::$db->query($sql);
        self::$db->bind(':course_id', $this->id);
        self::$db->bind(':student_id', $student_id);

        self::$db->execute();
        return self::$db->rowCount() > 0;
    }

    // Find a course by ID
    public static function find(int $id)
    {
        $sql = "SELECT
                    c.*,
                    COUNT(DISTINCT e.id) AS enrollments_count,
                    COUNT(DISTINCT r.id) AS rates_count,
                    AVG(r.rate) AS rate,
                    CONCAT(u.first_name, ' ', u.last_name) AS teacher_name,
                    ca.name AS category_name,
                    STRING_AGG(DISTINCT t.name, ',') AS tags
                FROM courses c
                LEFT JOIN enrollments e ON c.id = e.course_id
                LEFT JOIN rates r ON c.id = r.course_id
                JOIN users u ON c.teacher_id = u.id
                JOIN categories ca ON c.category_id = ca.id
                LEFT JOIN courses_tags ct ON ct.course_id = c.id
                LEFT JOIN tags t ON t.id = ct.tag_id
                WHERE c.id = :id
                GROUP BY c.id, u.first_name, u.last_name, ca.name";
    
        self::$db->query($sql);
        self::$db->bind(':id', $id);
    
        $result = self::$db->single();
    
        if (!$result) {
            return null;
        }
    
        // Instantiate the appropriate class based on the course type
        if (!empty($result["video_name"])) {
            $course = new CourseVideo();
            $course->setContent($result["video_name"]);
        } else {
            $course = new CourseDocument();
            $course->setContent($result["document_name"]);
        }
    
        // Set common properties
        $course->setId($result["id"]);
        $course->setTitle($result["title"]);
        $course->setDescription($result["description"]);
        $course->setPrice($result["price"]);
        $course->setThumbnail($result["thumbnail"]);
        $course->setIsDeleted($result["is_deleted"]);
        $course->setTeacherId($result["teacher_id"]);
        $course->setCategoryId($result["category_id"]);
        $course->setCreatedAt($result["created_at"]);
        $course->setUpdatedAt($result["updated_at"]);
    
        // Set additional attributes
        $course->setEnrollmentsCount($result['enrollments_count']);
        $course->setRate($result['rate']);
        $course->setRatesCount($result['rates_count']);
        $course->setTeacherName($result['teacher_name']);
        $course->setCategoryName($result['category_name']);
        $course->setTags(explode(',', $result["tags"]) ?? []);
    
        return $course;
    }
    
    

    public static function countByFilter($filters = [])
    {
        $sql = "SELECT COUNT(c.id) AS count FROM courses c WHERE 1=1 ";
    
        // Add dynamic filters
        if (isset($filters['keyword']) && !empty($filters['keyword'])) {
            $sql .= " AND (c.title LIKE :keyword OR c.description LIKE :keyword) ";
        }
        if (isset($filters['category_id']) && !empty($filters['category_id'])) {
            $sql .= " AND c.category_id = :category_id ";
        }
        if (isset($filters['min_price']) && !empty($filters['min_price'])) {
            $sql .= " AND c.price >= :min_price ";
        }
        if (isset($filters['max_price']) && !empty($filters['max_price'])) {
            $sql .= " AND c.price <= :max_price ";
        }
    
        self::$db->query($sql);
    
        // Bind params
        if (isset($filters['keyword']) && !empty($filters['keyword'])) {
            self::$db->bind(':keyword', '%' . $filters['keyword'] . '%');
        }
        if (isset($filters['category_id']) && !empty($filters['category_id'])) {
            self::$db->bind(':category_id', $filters['category_id']);
        }
        if (isset($filters['min_price']) && !empty($filters['min_price'])) {
            self::$db->bind(':min_price', $filters['min_price']);
        }
        if (isset($filters['max_price']) && !empty($filters['max_price'])) {
            self::$db->bind(':max_price', $filters['max_price']);
        }
    
        $result = self::$db->single();
    
        return $result["count"];
    }
    

    // Get all courses
    public static function all($filters = [])
    {
        $sql = "SELECT
                    c.*,
                    COUNT(DISTINCT e.id) AS enrollments_count,
                    COUNT(DISTINCT r.id) AS rates_count,
                    AVG(r.rate) AS rate,
                    CONCAT(u.first_name, ' ', u.last_name) AS teacher_name,
                    ca.name AS category_name
                FROM courses c
                LEFT JOIN enrollments e ON c.id = e.course_id
                LEFT JOIN rates r ON c.id = r.course_id
                JOIN users u ON c.teacher_id = u.id
                JOIN categories ca ON c.category_id = ca.id
                WHERE 1=1 ";
    
        // Add dynamic filters
        if (isset($filters['keyword']) && !empty($filters['keyword'])) {
            $sql .= " AND (c.title LIKE :keyword OR c.description LIKE :keyword) ";
        }
        if (isset($filters['category_id']) && !empty($filters['category_id'])) {
            $sql .= " AND c.category_id = :category_id ";
        }
        if (isset($filters['min_price']) && !empty($filters['min_price'])) {
            $sql .= " AND c.price >= :min_price ";
        }
        if (isset($filters['max_price']) && !empty($filters['max_price'])) {
            $sql .= " AND c.price <= :max_price ";
        }
        if (isset($filters['teacher_id']) && !empty($filters['teacher_id'])) {
            $sql .= " AND c.teacher_id = :teacher_id ";
        }
    
        $sql .= " GROUP BY c.id, u.first_name, u.last_name, ca.name ORDER BY enrollments_count DESC";
    
        self::$db->query($sql);
    
        // Bind params
        if (isset($filters['keyword']) && !empty($filters['keyword'])) {
            self::$db->bind(':keyword', '%' . $filters['keyword'] . '%');
        }
        if (isset($filters['category_id']) && !empty($filters['category_id'])) {
            self::$db->bind(':category_id', $filters['category_id']);
        }
        if (isset($filters['min_price']) && !empty($filters['min_price'])) {
            self::$db->bind(':min_price', $filters['min_price']);
        }
        if (isset($filters['max_price']) && !empty($filters['max_price'])) {
            self::$db->bind(':max_price', $filters['max_price']);
        }
        if (isset($filters['teacher_id']) && !empty($filters['teacher_id'])) {
            self::$db->bind(':teacher_id', $filters['teacher_id']);
        }
    
        $results = self::$db->results();
    
        $courses = [];
        foreach ($results as $result) {
            if (!empty($result["video_name"])) {
                $course = new CourseVideo();
                $course->setContent($result["video_name"]);
            } else {
                $course = new CourseDocument();
                $course->setContent($result["document_name"]);
            }
    
            $course->setId($result["id"]);
            $course->setTitle($result["title"]);
            $course->setDescription($result["description"]);
            $course->setPrice($result["price"]);
            $course->setThumbnail($result["thumbnail"]);
            $course->setIsDeleted($result["is_deleted"]);
            $course->setTeacherId($result["teacher_id"]);
            $course->setCategoryId($result["category_id"]);
            $course->setCreatedAt($result["created_at"]);
            $course->setUpdatedAt($result["updated_at"]);
    
            // Set additional attributes
            $course->setEnrollmentsCount($result['enrollments_count']);
            $course->setRate($result['rate']);
            $course->setRatesCount($result['rates_count']);
            $course->setTeacherName($result['teacher_name']);
            $course->setCategoryName($result['category_name']);
    
            $courses[] = $course;
        }
    
        return $courses;
    }
    
    
    public static function paginate(int $page, int $coursesPerPage, $filters = [])
    {
        $offset = ($page - 1) * $coursesPerPage;

        $sql = "SELECT
                    c.*,
                    COUNT(DISTINCT e.id) AS enrollments_count,
                    COUNT(DISTINCT r.id) AS rates_count,
                    AVG(r.rate) AS rate,
                    CONCAT(u.first_name, ' ', u.last_name) AS teacher_name,
                    ca.name AS category_name
                FROM courses c
                LEFT JOIN enrollments e ON c.id = e.course_id
                LEFT JOIN rates r ON c.id = r.course_id
                JOIN users u ON c.teacher_id = u.id
                JOIN categories ca ON c.category_id = ca.id
                WHERE 1=1 ";

        // Add dynamic filters
        if (isset($filters['keyword']) && !empty($filters['keyword'])) {
            $sql .= " AND (c.title LIKE :keyword OR c.description LIKE :keyword) ";
        }
        if (isset($filters['category_id']) && !empty($filters['category_id'])) {
            $sql .= " AND c.category_id = :category_id ";
        }
        if (isset($filters['min_price']) && !empty($filters['min_price'])) {
            $sql .= " AND c.price >= :min_price ";
        }
        if (isset($filters['max_price']) && !empty($filters['max_price'])) {
            $sql .= " AND c.price <= :max_price ";
        }

        $sql .= " GROUP BY c.id, u.first_name, u.last_name, ca.name ORDER BY enrollments_count DESC OFFSET :offset LIMIT :limit";

        self::$db->query($sql);
        self::$db->bind(':offset', $offset);
        self::$db->bind(':limit', $coursesPerPage);

        // Bind filters
        if (isset($filters['keyword']) && !empty($filters['keyword'])) {
            self::$db->bind(':keyword', '%' . $filters['keyword'] . '%');
        }
        if (isset($filters['category_id']) && !empty($filters['category_id'])) {
            self::$db->bind(':category_id', $filters['category_id']);
        }
        if (isset($filters['min_price']) && !empty($filters['min_price'])) {
            self::$db->bind(':min_price', $filters['min_price']);
        }
        if (isset($filters['max_price']) && !empty($filters['max_price'])) {
            self::$db->bind(':max_price', $filters['max_price']);
        }
    

        $results = self::$db->results();
    
        $courses = [];
        foreach ($results as $result) {
            if (!empty($result["video_name"])) {
                $course = new CourseVideo();
                $course->setContent($result["video_name"]);
            } else {
                $course = new CourseDocument();
                $course->setContent($result["document_name"]);
            }
        
            $course->setId($result["id"]);
            $course->setTitle($result["title"]);
            $course->setDescription($result["description"]);
            $course->setPrice($result["price"]);
            $course->setThumbnail($result["thumbnail"]);
            $course->setIsDeleted($result["is_deleted"]);
            $course->setTeacherId($result["teacher_id"]);
            $course->setCategoryId($result["category_id"]);
            $course->setCreatedAt($result["created_at"]);
            $course->setUpdatedAt($result["updated_at"]);
        
            // Set additional attributes
            $course->setEnrollmentsCount($result['enrollments_count']);
            $course->setRate($result['rate']);
            $course->setRatesCount($result['rates_count']);
            $course->setTeacherName($result['teacher_name']);
            $course->setCategoryName($result['category_name']);
    
            $courses[] = $course;
        }
    
        return $courses;
    }

    // Get n courses
    public static function limit(int $n)
    {
        $sql = "SELECT * FROM courses LIMIT :n";

        self::$db->query($sql);
        self::$db->bind(':n', $n);

        $results = self::$db->results();

        $courses = [];
        foreach ($results as $result) {
            if (!empty($result["video_name"])) {
                $course = new CourseVideo();
                $course->setContent($result["video_name"]);
            } else {
                $course = new CourseDocument();
                $course->setContent($result["document_name"]);
            }
        
            $course->setId($result["id"]);
            $course->setTitle($result["title"]);
            $course->setDescription($result["description"]);
            $course->setPrice($result["price"]);
            $course->setThumbnail($result["thumbnail"]);
            $course->setIsDeleted($result["is_deleted"]);
            $course->setTeacherId($result["teacher_id"]);
            $course->setCategoryId($result["category_id"]);
            $course->setCreatedAt($result["created_at"]);
            $course->setUpdatedAt($result["updated_at"]);
    
            $courses[] = $course;
        }

        return $courses;
    }

    // Get courses by category ID for PostgreSQL
    public static function findByCategoryId(int $category_id)
    {
        $sql = "SELECT * FROM courses WHERE category_id = :category_id";
        self::$db->query($sql);
        self::$db->bind(':category_id', $category_id);
        self::$db->execute();

        $results = self::$db->results();

        $courses = [];
        foreach ($results as $result) {
            if (!empty($result["video_name"])) {
                $course = new CourseVideo();
                $course->setContent($result["video_name"]);
            } else {
                $course = new CourseDocument();
                $course->setContent($result["document_name"]);
            }
        
            $course->setId($result["id"]);
            $course->setTitle($result["title"]);
            $course->setDescription($result["description"]);
            $course->setPrice($result["price"]);
            $course->setThumbnail($result["thumbnail"]);
            $course->setIsDeleted($result["is_deleted"]);
            $course->setTeacherId($result["teacher_id"]);
            $course->setCategoryId($result["category_id"]);
            $course->setCreatedAt($result["created_at"]);
            $course->setUpdatedAt($result["updated_at"]);
        
            $courses[] = $course;
        }

        return $courses;
    }

    // Get courses by teacher ID for PostgreSQL
    public static function findByTeacherId(int $teacher_id)
    {
        $sql = "SELECT * FROM courses WHERE teacher_id = :teacher_id";
        self::$db->query($sql);
        self::$db->bind(':teacher_id', $teacher_id);

        $results = self::$db->results();

        $courses = [];
        foreach ($results as $result) {
            if (!empty($result["video_name"])) {
                $course = new CourseVideo();
                $course->setContent($result["video_name"]);
            } else {
                $course = new CourseDocument();
                $course->setContent($result["document_name"]);
            }
        
            $course->setId($result["id"]);
            $course->setTitle($result["title"]);
            $course->setDescription($result["description"]);
            $course->setPrice($result["price"]);
            $course->setThumbnail($result["thumbnail"]);
            $course->setIsDeleted($result["is_deleted"]);
            $course->setTeacherId($result["teacher_id"]);
            $course->setCategoryId($result["category_id"]);
            $course->setCreatedAt($result["created_at"]);
            $course->setUpdatedAt($result["updated_at"]);
        
            $courses[] = $course;
        }

        return $courses;
    }

    // Get student courses
    public static function findByStudentId(int $student_id, $keyword = "")
    {
        $sql = "SELECT
                    c.*,
                    ra.rate as rate,
                    CONCAT(u.first_name, ' ', u.last_name) AS teacher_name,
                    e.is_completed
                FROM enrollments e
                JOIN courses c ON c.id = e.course_id
                LEFT JOIN rates ra ON ra.course_id = c.id AND ra.student_id = :student_id
                JOIN users u ON c.teacher_id = u.id
                WHERE e.student_id = :student_id";
                    
        if (isset($keyword) && !empty($keyword)) {
            $sql .= " AND (c.title LIKE :keyword OR c.description LIKE :keyword) ";
        }

        self::$db->query($sql);
        self::$db->bind(':student_id', $student_id);

        if (isset($keyword) && !empty($keyword)) {
            self::$db->bind(':keyword', '%' . $keyword . '%');
        }

        $results = self::$db->results();

        $courses = [];
        foreach ($results as $result) {
            if (!empty($result["video_name"])) {
                $course = new CourseVideo();
                $course->setContent($result["video_name"]);
            } else {
                $course = new CourseDocument();
                $course->setContent($result["document_name"]);
            }
        
            $course->setId($result["id"]);
            $course->setTitle($result["title"]);
            $course->setDescription($result["description"]);
            $course->setPrice($result["price"]);
            $course->setThumbnail($result["thumbnail"]);
            $course->setIsDeleted($result["is_deleted"]);
            $course->setIsCompleted($result["is_completed"]);
            $course->setTeacherId($result["teacher_id"]);
            $course->setCategoryId($result["category_id"]);
            $course->setCreatedAt($result["created_at"]);
            $course->setUpdatedAt($result["updated_at"]);
        
            $course->setRate($result["rate"]);
            $course->setTeacherName($result['teacher_name']);

            $courses[] = $course;
        }

        return $courses;
    }


    // Get Top N courses by enrollments
    public static function topCourses(int $n)
    {
        $sql = "SELECT
                    c.*,
                    COUNT(e.id) AS enrollments_count,
                    COUNT(r.id) AS rates_count,
                    AVG(r.rate) AS rate,
                    CONCAT(u.first_name, ' ', u.last_name) AS teacher_name
                FROM courses c
                LEFT JOIN enrollments e ON c.id = e.course_id
                LEFT JOIN rates r ON c.id = r.course_id
                JOIN users u ON c.teacher_id = u.id
                GROUP BY c.id, u.first_name, u.last_name
                ORDER BY enrollments_count DESC
                LIMIT :n";

        self::$db->query($sql);
        self::$db->bind(':n', $n);

        $results = self::$db->results();

        $courses = [];
        foreach ($results as $result) {
            if (!empty($result["video_name"])) {
                $course = new CourseVideo();
                $course->setContent($result["video_name"]);
            } else {
                $course = new CourseDocument();
                $course->setContent($result["document_name"]);
            }
        
            $course->setId($result["id"]);
            $course->setTitle($result["title"]);
            $course->setDescription($result["description"]);
            $course->setPrice($result["price"]);
            $course->setThumbnail($result["thumbnail"]);
            $course->setIsDeleted($result["is_deleted"]);
            $course->setTeacherId($result["teacher_id"]);
            $course->setCategoryId($result["category_id"]);
            $course->setCreatedAt($result["created_at"]);
            $course->setUpdatedAt($result["updated_at"]);
        
            $course->setEnrollmentsCount($result['enrollments_count']);
            $course->setRate($result['rate']);
            $course->setRatesCount($result['rates_count']);
            $course->setTeacherName($result['teacher_name']);

            $courses[] = $course;
        }

        return $courses;
    }


    // Get profits of a teacher between two dates
    public static function getProfitsOfTeacherBetween($startDate, $endDate, $teacher_id)
    {
        $sql = "SELECT SUM(c.price) AS total_profit
                FROM courses c
                JOIN enrollments en ON en.course_id = c.id
                WHERE c.teacher_id = :teacher_id
                AND en.created_at BETWEEN :start_date AND :end_date";

        self::$db->query($sql);
        self::$db->bind(':teacher_id', $teacher_id);
        self::$db->bind(':start_date', $startDate);
        self::$db->bind(':end_date', $endDate);

        self::$db->execute(); // Execute the query for PostgreSQL compatibility

        $result = self::$db->single();

        if ($result && isset($result["total_profit"])) {
            return $result["total_profit"];
        } else {
            return 0;
        }
    }

    // Get top course of a teacher by enrollments for PostgreSQL
    public static function topTeacherCourse(int $teacherId)
    {
        $sql = "SELECT
                    c.*,
                    COUNT(*) AS enrollments_count,
                    ca.name AS category_name,
                    AVG(r.rate) AS rate
                FROM courses c
                JOIN enrollments en ON en.course_id = c.id
                JOIN categories ca ON ca.id = c.category_id
                LEFT JOIN rates r ON c.id = r.course_id
                WHERE c.teacher_id = :teacher_id
                GROUP BY c.id, ca.name
                ORDER BY enrollments_count DESC
                LIMIT 1";

        self::$db->query($sql);
        self::$db->bind(':teacher_id', $teacherId);

        self::$db->execute(); // Execute the query to ensure compatibility with PostgreSQL

        $result = self::$db->single();

        if (!$result) {
            return null;
        }

        if (!empty($result["video_name"])) {
            $course = new CourseVideo();
            $course->setContent($result["video_name"]);
        } else {
            $course = new CourseDocument();
            $course->setContent($result["document_name"]);
        }

        $course->setId($result["id"]);
        $course->setTitle($result["title"]);
        $course->setDescription($result["description"]);
        $course->setPrice($result["price"]);
        $course->setThumbnail($result["thumbnail"]);
        $course->setIsDeleted($result["is_deleted"]);
        $course->setTeacherId($result["teacher_id"]);
        $course->setCategoryId($result["category_id"]);
        $course->setCreatedAt($result["created_at"]);
        $course->setUpdatedAt($result["updated_at"]);

        $course->setRate($result["rate"]);
        $course->setCategoryName($result["category_name"]);

        return $course;
    }

    // Get recent courses
    public static function getRecentCourses($limit)
    {
        $sql = "SELECT *
                FROM courses
                ORDER BY created_at DESC
                LIMIT :limit";
        
        self::$db->query($sql);
        self::$db->bind(':limit', $limit);

        $results = self::$db->results();

        $courses = [];
        foreach ($results as $result) {
            if (!empty($result["video_name"])) {
                $course = new CourseVideo();
                $course->setContent($result["video_name"]);
            } else {
                $course = new CourseDocument();
                $course->setContent($result["document_name"]);
            }

            $course->setId($result["id"]);
            $course->setTitle($result["title"]);
            $course->setDescription($result["description"]);
            $course->setPrice($result["price"]);
            $course->setThumbnail($result["thumbnail"]);
            $course->setIsDeleted($result["is_deleted"]);
            $course->setTeacherId($result["teacher_id"]);
            $course->setCategoryId($result["category_id"]);
            $course->setCreatedAt($result["created_at"]);
            $course->setUpdatedAt($result["updated_at"]);

            $courses[] = $course;
        }

        return $courses;
    }
}