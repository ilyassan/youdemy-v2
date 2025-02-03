<?php
class Tag extends BaseModel {

    private $id;
    private $name;

    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function save()
    {
        $sql = "INSERT INTO tags (name)
                VALUES (:name)
                ";
        self::$db->query($sql);
        self::$db->bind(':name', $this->name);

        return self::$db->execute();
    }

    public function delete()
    {
        $sql = "DELETE FROM tags WHERE id = :id";
        self::$db->query($sql);
        self::$db->bind(':id', $this->id);
        
        return self::$db->execute();
    }

    public static function find(int $id) {
        $sql = "SELECT * FROM tags
                WHERE id = :id";
        self::$db->query($sql);
        self::$db->bind(':id', $id);

        $result = self::$db->single();
        return new self($result["id"], $result["name"]);
    }
    
    public static function all()
    {
        $sql = "SELECT * FROM tags";

        self::$db->query($sql);

        $results = self::$db->results();

        $tags = [];
        foreach ($results as $tag) {
            $tags[] = new self($tag["id"], $tag["name"]);
        }
        return $tags;
    }

    public static function getPopularTags(int $n)
    {
        $sql = "SELECT t.id, t.name, COUNT(ct.course_id) AS course_count
                FROM tags t
                LEFT JOIN courses_tags ct ON t.id = ct.tag_id
                GROUP BY t.id
                ORDER BY course_count DESC
                LIMIT :n";
    
        self::$db->query($sql);
        self::$db->bind(':n', $n);
    
        $results = self::$db->results();
    
        $tags = [];
        foreach ($results as $result) {
            $tags[] = new self(
                $result["id"],
                $result["name"]
            );
        }
    
        return $tags;
    }
}