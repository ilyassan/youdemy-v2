<?php
class Student extends User
{
    private $is_banned;
    private $total_courses;
    private $total_spents;


    public function getIsBanned()
    {
        return $this->is_banned;
    }
    public function getTotalCourses()
    {
        return $this->total_courses;
    }
    public function getTotalSpents()
    {
        return $this->total_spents;
    }
    
    public function setIsBanned($is_banned)
    {
        $this->is_banned = $is_banned;
    }
    public function setTotalCourses($total_courses)
    {
        $this->total_courses = $total_courses;
    }
    public function setTotalSpents($total_spents)
    {
        $this->total_spents = $total_spents;
    }

    public function ban()
    {
        $sql = "UPDATE users 
                SET is_banned = TRUE
                WHERE id = :id";

        self::$db->query($sql);
        self::$db->bind(':id', $this->id);

        return self::$db->execute();
    }

    public function unBan()
    {
        $sql = "UPDATE users 
                SET is_banned = FALSE
                WHERE id = :id";

        self::$db->query($sql);
        self::$db->bind(':id', $this->id);

        return self::$db->execute();
    }

    public static function studentsCountOfTeacher($teacherId)
    {
        $sql = "SELECT COUNT(*) as count
                FROM users u
                JOIN enrollments en ON en.student_id = u.id
                JOIN courses c ON c.id = en.course_id
                WHERE c.teacher_id = :teacher_id";

        self::$db->query($sql);
        self::$db->bind(':teacher_id', $teacherId);

        $result = self::$db->single();

        return $result["count"];
    }

    public static function all($filters = [])
    {
        $sql = "SELECT
                    u.*,
                    COUNT(en.course_id) AS total_courses
                FROM users u
                JOIN enrollments en ON en.student_id = u.id
                WHERE u.role_id = :role_id ";

        if (!empty($filters["keyword"])) {
            $sql .= "AND (
                        u.first_name ILIKE :keyword
                        OR u.last_name ILIKE :keyword
                        OR u.email ILIKE :keyword
                    ) ";
        }

        if (isset($filters["banned"])) {
            if ($filters["banned"]) {
                $sql .= "AND u.is_banned = TRUE ";
            } else {
                $sql .= "AND u.is_banned = FALSE ";
            }
        }

        $sql .= "GROUP BY u.id ";

        if (!empty($filters["status"])) {
            if ($filters["status"] == "Active") {
                $sql .= "HAVING COUNT(en.course_id) > 0";
            } elseif ($filters["status"] == "Unactive") {
                $sql .= "HAVING COUNT(en.course_id) = 0";
            }
        }

        self::$db->query($sql);
        self::$db->bind(":role_id", self::$studentRoleId);
        if (!empty($filters["keyword"])) {
            self::$db->bind(':keyword', "%" . $filters["keyword"] . "%");
        }

        $results = self::$db->results();

        $students = [];
        foreach ($results as $student) {
            $obj = new self(
                $student["id"],
                $student["first_name"],
                $student["last_name"],
                $student["email"],
                $student["password"],
                $student["role_id"]
            );

            $obj->setTotalCourses($student["total_courses"]);

            $students[] = $obj;
        }

        return $students;
    }

    public static function teacherStudents($teacherId, $keyword = "")
    {
        $sql = "SELECT
                    u.*,
                    COUNT(en.course_id) AS total_courses,
                    SUM(c.price) AS total_spents
                FROM users u
                JOIN enrollments en ON en.student_id = u.id
                JOIN courses c ON c.id = en.course_id
                WHERE c.teacher_id = :teacher_id AND u.role_id = :role_id
                GROUP BY u.id, u.first_name, u.last_name ";

        if (!empty($keyword)) {
            $sql .= "HAVING u.first_name ILIKE :keyword
                    OR u.last_name ILIKE :keyword
                    OR COUNT(en.course_id)::text ILIKE :keyword
                    OR SUM(c.price)::text ILIKE :keyword";
        }

        self::$db->query($sql);
        self::$db->bind(":teacher_id", $teacherId);
        self::$db->bind(":role_id", self::$studentRoleId);

        if (!empty($keyword)) {
            self::$db->bind(":keyword", "%" . $keyword . "%");
        }

        $results = self::$db->results();

        $students = [];
        foreach ($results as $student) {
            $obj = new self(
                $student["id"],
                $student["first_name"],
                $student["last_name"],
                $student["email"],
                $student["password"],
                $student["role_id"]
            );

            $obj->setTotalCourses($student["total_courses"]);
            $obj->setTotalSpents($student["total_spents"]);

            $students[] = $obj;
        }

        return $students;
    }

    public static function activeStudentsBetween($startDate, $endDate)
    {
        $sql = "SELECT COUNT(DISTINCT u.id) as active_students_count
                FROM users u
                JOIN enrollments en ON en.student_id = u.id
                WHERE u.role_id = :role_id AND en.created_at BETWEEN :start_date AND :end_date";

        self::$db->query($sql);
        self::$db->bind(':role_id', self::$studentRoleId);
        self::$db->bind(':start_date', $startDate);
        self::$db->bind(':end_date', $endDate);

        $result = self::$db->single();

        return $result["active_students_count"];
    }

    public static function bannedStudentsCount()
    {
        $sql = "SELECT COUNT(*) as banned_students_count
                FROM users
                WHERE role_id = :role_id AND is_banned = TRUE";

        self::$db->query($sql);
        self::$db->bind(':role_id', self::$studentRoleId);

        $result = self::$db->single();

        return $result["banned_students_count"];
    }

    public static function getInscriptionsBetween($startDate, $endDate)
    {
        $sql = "SELECT COUNT(*) as students_count
                FROM users
                WHERE role_id = :role_id AND created_at BETWEEN :start_date AND :end_date";

        self::$db->query($sql);
        self::$db->bind(':role_id', self::$studentRoleId);
        self::$db->bind(':start_date', $startDate);
        self::$db->bind(':end_date', $endDate);

        $result = self::$db->single();

        return $result["students_count"];
    }
}