<?php
class Rate extends BaseModel {

    private $id;
    private $rate;
    private $student_id;
    private $course_id;
    private $created_at;

    private $course_title;

    public function __construct($id = null, $rate = null, $student_id = null, $course_id = null, $created_at = null)
    {
        $this->id = $id;
        $this->rate = $rate;
        $this->student_id = $student_id;
        $this->course_id = $course_id;
        $this->created_at = $created_at;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getRate()
    {
        return $this->rate;
    }

    public function getStudentId()
    {
        return $this->student_id;
    }

    public function getCourseId()
    {
        return $this->course_id;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getCourseTitle()
    {
        return $this->course_title;
    }

    public function setRate($rate)
    {
        $this->rate = $rate;
    }

    public function setCourseTitle($course_title)
    {
        $this->course_title = $course_title;
    }

    public function save()
    {
        $sql = "INSERT INTO rates (rate, student_id, course_id) 
                VALUES (:rate, :student_id, :course_id)";

        self::$db->query($sql);
        self::$db->bind(':rate', $this->rate);
        self::$db->bind(':student_id', $this->student_id);
        self::$db->bind(':course_id', $this->course_id);

        return self::$db->execute();
    }

    public function update()
    {
        $sql = "UPDATE rates
                SET rate = :rate
                WHERE id = :id";

        self::$db->query($sql);
        self::$db->bind(':rate', $this->rate);
        self::$db->bind(':id', $this->id);
        return self::$db->execute();
    }

    public function delete()
    {
        $sql = "DELETE FROM rates
                WHERE id = :id";

        self::$db->query($sql);
        self::$db->bind(':id', $this->id);
        
        return self::$db->execute();
    }

    public static function getRateOfStudent($student_id, $course_id)
    {
        $sql = "SELECT * FROM rates
                WHERE student_id = :student_id AND course_id = :course_id";

        self::$db->query($sql);
        self::$db->bind(':student_id', $student_id);
        self::$db->bind(':course_id', $course_id);

        $result = self::$db->single();
        return $result ? new self($result["id"], $result["rate"], $result["student_id"], $result["course_id"], $result["created_at"]) : null;
    }

    public static function getRecentRates($limit, $teacher_id)
    {
        $sql = "SELECT r.*, c.title as course_title
                FROM rates r
                JOIN courses c ON r.course_id = c.id
                WHERE c.teacher_id = :teacher_id
                ORDER BY r.created_at DESC
                LIMIT :limit";

        self::$db->query($sql);
        self::$db->bind(':teacher_id', $teacher_id);
        self::$db->bind(':limit', $limit);

        $results = self::$db->results();

        $rates = [];
        foreach ($results as $rate) {
            $obj = new self($rate["id"], $rate["rate"], $rate["student_id"], $rate["course_id"], $rate["created_at"]);
            $obj->setCourseTitle($rate["course_title"]);
            $rates[] = $obj;
        }
        return $rates;
    }

    public static function teacherAvgRate($teacherId)
    {
        $sql = "SELECT AVG(r.rate) as avg_rate
                FROM rates r
                JOIN courses c ON c.id = r.course_id
                WHERE c.teacher_id = :teacher_id";

        self::$db->query($sql);
        self::$db->bind(':teacher_id', $teacherId);

        $result = self::$db->single();

        return $result["avg_rate"] ?? 0;
    }

}