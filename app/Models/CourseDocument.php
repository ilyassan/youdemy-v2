<?php
class CourseDocument extends Course
{
    private $document_name;

    public function getContent()
    {
        return URLASSETS . 'pdfs/' . $this->document_name;
    }

    public function getContentType()
    {
        return "pdf";
    }

    public function setContent($document_name)
    {
        $this->document_name = $document_name;
    }  

    public function save()
    {
        $sql = "INSERT INTO courses (title, description, price, thumbnail, document_name, video_name, teacher_id, category_id) 
                VALUES (:title, :description, :price, :thumbnail, :document_name, :video_name, :teacher_id, :category_id)
                RETURNING id";
        self::$db->query($sql);
        self::$db->bind(':title', $this->title);
        self::$db->bind(':description', $this->description);
        self::$db->bind(':price', $this->price);
        self::$db->bind(':thumbnail', $this->thumbnail);
        self::$db->bind(':document_name', $this->document_name);
        self::$db->bind(':video_name', null);
        self::$db->bind(':teacher_id', $this->teacher_id);
        self::$db->bind(':category_id', $this->category_id);

        $result = self::$db->single();

        if ($result) {
            $this->id = $result['id'];
            return true;
        } else {
            return false;
        }
    }

    public function update()
    {
        $sql = "UPDATE courses 
                SET title = :title, 
                    description = :description, 
                    price = :price, 
                    thumbnail = :thumbnail, 
                    document_name = :document_name,
                    video_name = :video_name,
                    category_id = :category_id 
                WHERE id = :id";
        self::$db->query($sql);
        self::$db->bind(':title', $this->title);
        self::$db->bind(':description', $this->description);
        self::$db->bind(':price', $this->price);
        self::$db->bind(':thumbnail', $this->thumbnail);
        self::$db->bind(':document_name', $this->document_name);
        self::$db->bind(':video_name', null);
        self::$db->bind(':category_id', $this->category_id);
        self::$db->bind(':id', $this->id);

        return self::$db->execute();
    }
}
