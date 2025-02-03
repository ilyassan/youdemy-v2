<?php
class Enrollment extends BaseModel {

    private $id;
    private $student_id;
    private $course_id;
    private $is_completed;
    private $created_at;

    private $course_title;

    public function __construct($id = null, $student_id = null, $course_id = null, $is_completed = null, $created_at = null)
    {
        $this->id = $id;
        $this->student_id = $student_id;
        $this->course_id = $course_id;
        $this->is_completed = $is_completed;
        $this->created_at = $created_at;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getStudentId()
    {
        return $this->student_id;
    }

    public function getCourseId()
    {
        return $this->course_id;
    }

    public function getIsCompleted()
    {
        return $this->is_completed;
    }

    public function getCourseTitle()
    {
        return $this->course_title;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setStudentId($student_id)
    {
        $this->student_id = $student_id;
    }

    public function setCourseId($course_id)
    {
        $this->course_id = $course_id;
    }

    public function setIsCompleted($is_completed)
    {
        $this->is_completed = $is_completed;
    }

    public function setCourseTitle($course_title)
    {
        $this->course_title = $course_title;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    public function save()
    {
        $sql = "INSERT INTO enrollments (student_id, course_id) 
                VALUES (:student_id, :course_id)
                RETURNING id, created_at";

        self::$db->query($sql);
        self::$db->bind(':student_id', $this->student_id);
        self::$db->bind(':course_id', $this->course_id);

        $result = self::$db->execute();
        
        if ($result) {
            // Use the result to set id and created_at
            $this->id = $result['id'];
            $this->created_at = $result['created_at'];
            return true;
        } else {
            return false;
        }
    }

    public function update()
    {
        $sql = "UPDATE enrollments
                SET is_completed = :is_completed
                WHERE id = :id";

        self::$db->query($sql);
        self::$db->bind(':is_completed', $this->is_completed);
        self::$db->bind(':id', $this->id);

        return self::$db->execute();
    }

    public static function find(int $student_id, int $course_id) {
        $sql = "SELECT * FROM enrollments
                WHERE student_id = :student_id AND course_id = :course_id";
        self::$db->query($sql);
        self::$db->bind(':student_id', $student_id);
        self::$db->bind(':course_id', $course_id);

        $result = self::$db->single();
        return $result ? new self($result["id"], $result["student_id"], $result["course_id"], $result["is_completed"], $result["created_at"]) : null;
    }

    public static function countBetween($startDate, $endDate, $teacherId)
    {
        $sql = "SELECT COUNT(*) total_enrollments
                FROM enrollments en
                JOIN courses c ON c.id = en.course_id
                WHERE
                c.teacher_id = :teacher_id
                AND en.created_at >= :start_date
                AND en.created_at <= :end_date";
    
        self::$db->query($sql);
        self::$db->bind(':start_date', $startDate);
        self::$db->bind(':end_date', $endDate);
        self::$db->bind(':teacher_id', $teacherId);
    
        if (!self::$db->execute()) {
            return false;
        }
    
        $result = self::$db->single();
    
        if ($result && isset($result["total_enrollments"])) {
            return $result["total_enrollments"];
        } else {
            return 0;
        }
    }

    public static function getRecentEnrollments($limit, $teacherId)
    {
        $sql = "SELECT en.*, c.title as course_title
                FROM enrollments en
                JOIN courses c ON en.course_id = c.id
                WHERE c.teacher_id = :teacher_id
                ORDER BY en.created_at DESC
                LIMIT :limit";

        self::$db->query($sql);
        self::$db->bind(':teacher_id', $teacherId);
        self::$db->bind(':limit', $limit);

        $results = self::$db->results();

        $enrollments = [];
        foreach ($results as $enrollment) {
            $obj = new self($enrollment["id"], $enrollment["student_id"], $enrollment["course_id"], $enrollment["is_completed"], $enrollment["created_at"]);
            $obj->setCourseTitle($enrollment["course_title"]);
            $enrollments[] = $obj;
        }
        return $enrollments;
    }
}
