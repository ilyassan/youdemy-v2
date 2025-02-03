<?php
class Category extends BaseModel {

    private $id;
    private $name;
    private $created_at;

    public function __construct($id = null, $name, $created_at = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->created_at = $created_at;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    // Save the category
    public function save()
    {
        $sql = "INSERT INTO categories (name) VALUES (:name) RETURNING id, created_at";
        self::$db->query($sql);
        self::$db->bind(':name', $this->name);
        $result = self::$db->single();

        // Set the auto-generated values after insert
        $this->id = $result['id'];
        $this->created_at = $result['created_at'];

        return true;
    }

    // Delete the category
    public function delete()
    {
        $sql = "DELETE FROM categories WHERE id = :id";
        self::$db->query($sql);
        self::$db->bind(':id', $this->id);
        return self::$db->execute();
    }

    // Find a category by ID
    public static function find(int $id)
    {
        $sql = "SELECT * FROM categories WHERE id = :id";
        self::$db->query($sql);
        self::$db->bind(':id', $id);

        $result = self::$db->single();

        if ($result) {
            return new self($result["id"], $result["name"], $result["created_at"]);
        }

        return null; // Return null if category not found
    }

    // Get all categories
    public static function all()
    {
        $sql = "SELECT * FROM categories";

        self::$db->query($sql);

        $results = self::$db->results();

        $categories = [];
        foreach ($results as $category) {
            $categories[] = new self($category["id"], $category["name"], $category["created_at"]);
        }

        return $categories;
    }

    // Get popular categories (with most courses)
    public static function popularCategories()
    {
        $sql = "SELECT ca.*, COUNT(*) as courses_count 
                FROM categories ca
                JOIN courses co ON co.category_id = ca.id
                GROUP BY ca.id
                ORDER BY courses_count DESC
                LIMIT 5";

        self::$db->query($sql);

        $results = self::$db->results();
        return $results;
    }

    // Get recent categories
    public static function getRecentCategories($limit)
    {
        $sql = "SELECT * 
                FROM categories 
                ORDER BY created_at DESC 
                LIMIT :limit";

        self::$db->query($sql);
        self::$db->bind(':limit', $limit);

        $results = self::$db->results();

        $categories = [];
        foreach ($results as $category) {
            $categories[] = new self($category["id"], $category["name"], $category["created_at"]);
        }

        return $categories;
    }
}
?>