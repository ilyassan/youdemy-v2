<?php
class Teacher extends User
{
    private $is_verified;
    private $total_profits;
    private $total_courses;
    private $students_count;

    public function getIsVerified()
    {
        return $this->is_verified;
    }

    public function getTotalProfits()
    {
        return $this->total_profits;
    }

    public function getTotalCourses()
    {
        return $this->total_courses;
    }

    public function getStudentsCount()
    {
        return $this->students_count;
    }

    public function setIsVerified($is_verified)
    {
        $this->is_verified = $is_verified;
    }

    public function setTotalProfits($total_profits)
    {
        $this->total_profits = $total_profits;
    }

    public function setTotalCourses($total_courses)
    {
        $this->total_courses = $total_courses;
    }

    public function setStudentsCount($students_count)
    {
        $this->students_count = $students_count;
    }

    public function verify()
    {
        $sql = "UPDATE users
                SET is_verified = TRUE
                WHERE id = :id";

        self::$db->query($sql);
        self::$db->bind(':id', $this->id);

        return self::$db->execute();
    }

    public static function getInscriptionsBetween($startDate, $endDate)
    {
        $sql = "SELECT COUNT(*) as teachers_count
                FROM users
                WHERE role_id = :role_id AND created_at BETWEEN :start_date AND :end_date";
        
        self::$db->query($sql);
        self::$db->bind(':role_id', self::$teacherRoleId);
        self::$db->bind(':start_date', $startDate);
        self::$db->bind(':end_date', $endDate);

        $result = self::$db->single();

        return $result["teachers_count"];
    }

    public static function pendingsCount()
    {
        $sql = "SELECT COUNT(*) as teachers_count
                FROM users
                WHERE role_id = :role_id AND is_verified = FALSE";

        self::$db->query($sql);
        self::$db->bind(':role_id', self::$teacherRoleId);

        $result = self::$db->single();

        return $result["teachers_count"];
    }

    public static function getRecentVerifications($limit = 5)
    {
        $sql = "SELECT *
                FROM users
                WHERE role_id = :role_id AND is_verified = FALSE
                ORDER BY created_at DESC
                LIMIT :limit";

        self::$db->query($sql);
        self::$db->bind(':role_id', self::$teacherRoleId);
        self::$db->bind(':limit', $limit);

        $results = self::$db->results();

        $teachers = [];
        foreach ($results as $teacher) {
            $teachers[] = new self($teacher["id"], $teacher["first_name"], $teacher["last_name"], $teacher["email"], $teacher["password"], $teacher["role_id"], $teacher["created_at"]);
        }

        return $teachers;
    }

    public static function all($filters = [])
    {
        $sql = "SELECT 
                    u.*,
                    COUNT(DISTINCT c.id) AS total_courses,
                    SUM(c.price) AS total_profits,
                    COUNT(DISTINCT en.student_id) AS students_count
                FROM users u
                LEFT JOIN courses c ON c.teacher_id = u.id
                LEFT JOIN enrollments en ON en.course_id = c.id
                WHERE u.role_id = :role_id ";
    
        if (!empty($filters["keyword"])) {
            $sql .= "AND (
                        u.first_name ILIKE :keyword
                        OR u.last_name ILIKE :keyword
                        OR u.email ILIKE :keyword
                    ) ";  // PostgreSQL ILIKE for case-insensitive search
        }
    
        if (isset($filters["verified"])) {
            if ($filters["verified"]) {
                $sql .= "AND u.is_verified = TRUE ";
            } else {
                $sql .= "AND u.is_verified = FALSE ";
            }
        }
    
        $sql .= "GROUP BY u.id, u.first_name, u.last_name ";
    
        if (!empty($filters["status"])) {
            if ($filters["status"] == "Active") {
                $sql .= "HAVING total_courses > 0";
            } elseif ($filters["status"] == "Unactive") {
                $sql .= "HAVING total_courses = 0";
            }
        }
    
        self::$db->query($sql);
        self::$db->bind(':role_id', self::$teacherRoleId);
        if (!empty($filters["keyword"])) {
            self::$db->bind(':keyword', "%" . $filters["keyword"] . "%");
        }
    
        $results = self::$db->results();
    
        $teachers = [];
        foreach ($results as $teacher) {
            $obj = new self($teacher["id"], $teacher["first_name"], $teacher["last_name"], $teacher["email"], $teacher["password"], $teacher["role_id"], $teacher["created_at"]);
            $obj->setTotalProfits($teacher["total_profits"]);
            $obj->setTotalCourses($teacher["total_courses"]);
            $obj->setStudentsCount($teacher["students_count"]);
    
            $teachers[] = $obj;
        }
    
        return $teachers;
    }
    
}