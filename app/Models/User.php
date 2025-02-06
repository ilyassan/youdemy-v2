<?php
class User extends BaseModel
{
    protected $id;
    protected $first_name;
    protected $last_name;
    protected $email;
    protected $password;
    protected $role_id;
    protected $created_at;

    static public $adminRoleId = 1;
    static public $teacherRoleId = 2;
    static public $studentRoleId = 3;

    public function __construct($id = null, $first_name = null, $last_name = null, $email = null, $password = null, $role_id = null, $created_at = null)
    {
        $this->id = $id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->password = $password;
        $this->role_id = $role_id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFirstName()
    {
        return $this->first_name;
    }

    public function getLastName()
    {
        return $this->last_name;
    }

     function getFullName()
    {
        return $this->first_name . " " . $this->last_name;
    }

    public function getEmail()
    {
        return $this->email;
    }
    
    public function getPassword()
    {
        return $this->password;
    }
    
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    
    public function getRoleId()
    {
        return $this->role_id;
    }
    
    public function getRoleName()
    {
        switch ($this->getRoleId()) {
            case self::$adminRoleId:
                return "admin";
            case self::$teacherRoleId:
                return "teacher";
            case self::$studentRoleId:
                return "student";
            default:
                return "visitor";
        }
    }

    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setRoleId($role_id)
    {
        $this->role_id = $role_id;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    public function isAdmin()
    {
        return $this->getRoleId() == self::$adminRoleId;
    }

    public function isTeacher()
    {
        return $this->getRoleId() == self::$teacherRoleId;
    }

    public function isStudent()
    {
        return $this->getRoleId() == self::$studentRoleId;
    }
    

    public function save()
    {
        $sql = "INSERT INTO users (first_name, last_name, email, password, role_id) VALUES (:first_name, :last_name, :email, :password, :role_id)";
        self::$db->query($sql);
        self::$db->bind(':first_name', $this->first_name);
        self::$db->bind(':last_name', $this->last_name);
        self::$db->bind(':email', $this->email);
        self::$db->bind(':password', $this->password);
        self::$db->bind(':role_id', $this->role_id);

        return self::$db->execute();
    }

    public static function find($id): Teacher | Student | self | null
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        self::$db->query($sql);
        self::$db->bind(':id', $id);
        
        $result = self::$db->single();

        if (self::$db->rowCount() > 0) {
            switch ($result["role_id"]) {
                case self::$adminRoleId:
                    return new self($result["id"], $result["first_name"], $result["last_name"], $result["email"], $result["password"], $result["role_id"]);
                case self::$teacherRoleId:
                    $teacher = new Teacher($result["id"], $result["first_name"], $result["last_name"], $result["email"], $result["password"], $result["role_id"]);
                    $teacher->setIsVerified($result["is_verified"]);
                    return $teacher;
                case self::$studentRoleId:
                    $student =  new Student($result["id"], $result["first_name"], $result["last_name"], $result["email"], $result["password"], $result["role_id"]);
                    $student->setIsBanned($result["is_banned"]);
                    return $student;
            }
        } else {
            return null;
        }
    }

    public static function findUserByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        self::$db->query($sql);
        self::$db->bind(':email', $email);
        $result = self::$db->single();

        if (self::$db->rowCount() > 0) {
            return new self($result["id"], $result["first_name"], $result["last_name"], $result["email"], $result["password"], $result["role_id"]);
        } else {
            return false;
        }
    }
}