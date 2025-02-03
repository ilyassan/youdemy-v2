DROP TABLE IF EXISTS courses_tags;
DROP TABLE IF EXISTS tags;
DROP TABLE IF EXISTS rates;
DROP TABLE IF EXISTS enrollments;
DROP TABLE IF EXISTS courses;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS roles;
DROP TABLE IF EXISTS categories;



CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    is_banned BOOL DEFAULT 0,
    is_verified BOOL DEFAULT 0,
    role_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY(role_id) REFERENCES roles(id)
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    price INT NOT NULL,
    thumbnail VARCHAR(255),
    document_name VARCHAR(255),
    video_name VARCHAR(255),
    is_deleted BOOLEAN DEFAULT FALSE,
    teacher_id INT NOT NULL,
    category_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (teacher_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

CREATE TABLE enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    is_completed BOOL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

CREATE TABLE rates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    rate INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

CREATE TABLE tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE courses_tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    tag_id INT NOT NULL,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
);


INSERT INTO roles (name) VALUES
('admin'),
('teacher'),
('student');


INSERT INTO users (first_name, last_name, email, password, is_banned, is_verified, role_id, created_at) 
VALUES 
('John', 'Doe', 'admin@example.com', 'admin123', 0, 1, 1, '2024-09-15'),
('Alice', 'Smith', 'alice.smith@example.com', 'teacher123', 0, 1, 2, '2024-10-10'),
('Bob', 'Johnson', 'bob.johnson@example.com', 'teacher123', 0, 1, 2, '2024-11-05'),
('Charlie', 'Brown', 'charlie.brown@example.com', 'teacher123', 0, 1, 2, '2024-12-01'),
('David', 'Williams', 'david.williams@example.com', 'teacher123', 0, 1, 2, '2024-12-20'),
('Eva', 'Jones', 'eva.jones@example.com', 'teacher123', 0, 1, 2, '2025-01-10'),
('Frank', 'Garcia', 'frank.garcia@example.com', 'teacher123', 0, 1, 2, '2024-09-01'),
('Grace', 'Martinez', 'grace.martinez@example.com', 'teacher123', 0, 1, 2, '2024-10-25'),
('Henry', 'Davis', 'henry.davis@example.com', 'teacher123', 0, 1, 2, '2024-11-15'),
('Ivy', 'Rodriguez', 'ivy.rodriguez@example.com', 'teacher123', 0, 1, 2, '2024-12-05'),
('Jack', 'Miller', 'jack.miller@example.com', 'teacher123', 0, 1, 2, '2025-01-05'),
('Karen', 'Wilson', 'karen.wilson@example.com', 'teacher123', 0, 0, 2, '2024-09-08'),
('Liam', 'Moore', 'liam.moore@example.com', 'teacher123', 0, 0, 2, '2024-10-18'),
('Mia', 'Taylor', 'mia.taylor@example.com', 'teacher123', 0, 0, 2, '2024-11-10'),
('Noah', 'Anderson', 'noah.anderson@example.com', 'teacher123', 0, 1, 2, '2024-12-15'),
('Olivia', 'Thomas', 'olivia.thomas@example.com', 'teacher123', 0, 1, 2, '2025-01-01'),
('Emma', 'Johnson', 'emma.johnson@example.com', 'student123', 0, 1, 3, '2024-09-25'),
('Liam', 'Smith', 'liam.smith@example.com', 'student123', 0, 1, 3, '2024-10-05'),
('Olivia', 'Brown', 'olivia.brown@example.com', 'student123', 0, 1, 3, '2024-11-20'),
('Noah', 'Davis', 'noah.davis@example.com', 'student123', 0, 1, 3, '2024-12-10'),
('Ava', 'Miller', 'ava.miller@example.com', 'student123', 0, 1, 3, '2025-01-15'),
('William', 'Wilson', 'william.wilson@example.com', 'student123', 0, 1, 3, '2024-09-30'),
('Sophia', 'Moore', 'sophia.moore@example.com', 'student123', 0, 1, 3, '2024-10-20'),
('James', 'Taylor', 'james.taylor@example.com', 'student123', 0, 1, 3, '2024-11-25'),
('Isabella', 'Anderson', 'isabella.anderson@example.com', 'student123', 0, 1, 3, '2024-12-25'),
('Benjamin', 'Thomas', 'benjamin.thomas@example.com', 'student123', 0, 1, 3, '2025-01-20'),
('Mia', 'Jackson', 'mia.jackson@example.com', 'student123', 0, 1, 3, '2024-09-10'),
('Elijah', 'White', 'elijah.white@example.com', 'student123', 0, 1, 3, '2024-10-15'),
('Amelia', 'Harris', 'amelia.harris@example.com', 'student123', 0, 1, 3, '2024-11-30'),
('Lucas', 'Martin', 'lucas.martin@example.com', 'student123', 0, 1, 3, '2024-12-30'),
('Harper', 'Thompson', 'harper.thompson@example.com', 'student123', 0, 1, 3, '2025-01-21'),
('Alexander', 'Garcia', 'alexander.garcia@example.com', 'student123', 0, 1, 3, '2024-09-12'),
('Evelyn', 'Martinez', 'evelyn.martinez@example.com', 'student123', 0, 1, 3, '2024-10-22'),
('Michael', 'Robinson', 'michael.robinson@example.com', 'student123', 0, 1, 3, '2024-11-18'),
('Ella', 'Clark', 'ella.clark@example.com', 'student123', 0, 1, 3, '2024-12-18'),
('Daniel', 'Rodriguez', 'daniel.rodriguez@example.com', 'student123', 0, 1, 3, '2025-01-12'),
('Avery', 'Lewis', 'avery.lewis@example.com', 'student123', 0, 1, 3, '2024-09-18'),
('Logan', 'Lee', 'logan.lee@example.com', 'student123', 0, 1, 3, '2024-10-28'),
('Scarlett', 'Walker', 'scarlett.walker@example.com', 'student123', 0, 1, 3, '2024-11-22'),
('Matthew', 'Hall', 'matthew.hall@example.com', 'student123', 0, 1, 3, '2024-12-22'),
('Abigail', 'Allen', 'abigail.allen@example.com', 'student123', 0, 1, 3, '2025-01-18'),
('Jackson', 'Young', 'jackson.young@example.com', 'student123', 0, 1, 3, '2024-09-20'),
('Sofia', 'Hernandez', 'sofia.hernandez@example.com', 'student123', 0, 1, 3, '2024-10-30'),
('David', 'King', 'david.king@example.com', 'student123', 0, 1, 3, '2024-11-28'),
('Madison', 'Wright', 'madison.wright@example.com', 'student123', 0, 1, 3, '2024-12-28'),
('Joseph', 'Lopez', 'joseph.lopez@example.com', 'student123', 0, 1, 3, '2025-01-14'),
('Chloe', 'Scott', 'chloe.scott@example.com', 'student123', 0, 1, 3, '2024-09-22'),
('Samuel', 'Green', 'samuel.green@example.com', 'student123', 0, 1, 3, '2024-10-12'),
('Victoria', 'Adams', 'victoria.adams@example.com', 'student123', 0, 1, 3, '2024-11-12'),
('Henry', 'Baker', 'henry.baker@example.com', 'student123', 0, 1, 3, '2024-12-12'),
('Grace', 'Gonzalez', 'grace.gonzalez@example.com', 'student123', 0, 1, 3, '2025-01-16'),
('Owen', 'Nelson', 'owen.nelson@example.com', 'student123', 0, 1, 3, '2024-09-28'),
('Lily', 'Carter', 'lily.carter@example.com', 'student123', 0, 1, 3, '2024-10-08'),
('Sebastian', 'Mitchell', 'sebastian.mitchell@example.com', 'student123', 0, 1, 3, '2024-11-08'),
('Hannah', 'Perez', 'hannah.perez@example.com', 'student123', 0, 1, 3, '2024-12-08'),
('Carter', 'Roberts', 'carter.roberts@example.com', 'student123', 0, 1, 3, '2025-01-19'),
('Zoe', 'Turner', 'zoe.turner@example.com', 'student123', 0, 1, 3, '2024-09-30'),
('Wyatt', 'Phillips', 'wyatt.phillips@example.com', 'student123', 0, 1, 3, '2024-10-25'),
('Addison', 'Campbell', 'addison.campbell@example.com', 'student123', 0, 1, 3, '2024-11-25'),
('Gabriel', 'Parker', 'gabriel.parker@example.com', 'student123', 0, 1, 3, '2024-12-25'),
('Natalie', 'Evans', 'natalie.evans@example.com', 'student123', 0, 1, 3, '2025-01-21'),
('Luke', 'Edwards', 'luke.edwards@example.com', 'student123', 0, 1, 3, '2024-09-05'),
('Leah', 'Collins', 'leah.collins@example.com', 'student123', 0, 1, 3, '2024-10-05'),
('Dylan', 'Stewart', 'dylan.stewart@example.com', 'student123', 0, 1, 3, '2024-11-05'),
('Audrey', 'Sanchez', 'audrey.sanchez@example.com', 'student123', 0, 1, 3, '2024-12-05'),
('Isaac', 'Morris', 'isaac.morris@example.com', 'student123', 0, 1, 3, '2025-01-05'),
('Bella', 'Rogers', 'bella.rogers@example.com', 'student123', 0, 1, 3, '2024-09-08'),
('Nathan', 'Reed', 'nathan.reed@example.com', 'student123', 0, 1, 3, '2024-10-08'),
('Ellie', 'Cook', 'ellie.cook@example.com', 'student123', 0, 1, 3, '2024-11-08'),
('Ryan', 'Morgan', 'ryan.morgan@example.com', 'student123', 0, 1, 3, '2024-12-08'),
('Stella', 'Bell', 'stella.bell@example.com', 'student123', 0, 1, 3, '2025-01-08'),
('Eli', 'Murphy', 'eli.murphy@example.com', 'student123', 0, 1, 3, '2024-09-12'),
('Claire', 'Bailey', 'claire.bailey@example.com', 'student123', 0, 1, 3, '2024-10-12'),
('Caleb', 'Rivera', 'caleb.rivera@example.com', 'student123', 0, 1, 3, '2024-11-12'),
('Aria', 'Cooper', 'aria.cooper@example.com', 'student123', 0, 1, 3, '2024-12-12'),
('Mason', 'Richardson', 'mason.richardson@example.com', 'student123', 0, 1, 3, '2025-01-12'),
('Lucy', 'Cox', 'lucy.cox@example.com', 'student123', 0, 1, 3, '2024-09-14'),
('Aaron', 'Howard', 'aaron.howard@example.com', 'student123', 0, 1, 3, '2024-10-14'),
('Anna', 'Ward', 'anna.ward@example.com', 'student123', 0, 1, 3, '2024-11-14'),
('Hunter', 'Torres', 'hunter.torres@example.com', 'student123', 0, 1, 3, '2024-12-14'),
('Layla', 'Peterson', 'layla.peterson@example.com', 'student123', 0, 1, 3, '2025-01-14'),
('Evan', 'Gray', 'evan.gray@example.com', 'student123', 0, 1, 3, '2024-09-16'),
('Nora', 'Ramirez', 'nora.ramirez@example.com', 'student123', 0, 1, 3, '2024-10-16'),
('Adrian', 'James', 'adrian.james@example.com', 'student123', 0, 1, 3, '2024-11-16'),
('Hazel', 'Watson', 'hazel.watson@example.com', 'student123', 0, 1, 3, '2024-12-16'),
('Jordan', 'Brooks', 'jordan.brooks@example.com', 'student123', 0, 1, 3, '2025-01-16'),
('Violet', 'Kelly', 'violet.kelly@example.com', 'student123', 0, 1, 3, '2024-09-18'),
('Christian', 'Sanders', 'christian.sanders@example.com', 'student123', 0, 1, 3, '2024-10-18'),
('Savannah', 'Price', 'savannah.price@example.com', 'student123', 0, 1, 3, '2024-11-18'),
('Landon', 'Bennett', 'landon.bennett@example.com', 'student123', 0, 1, 3, '2024-12-18'),
('Brooklyn', 'Wood', 'brooklyn.wood@example.com', 'student123', 0, 1, 3, '2025-01-18'),
('Colton', 'Barnes', 'colton.barnes@example.com', 'student123', 0, 1, 3, '2024-09-20'),
('Paisley', 'Ross', 'paisley.ross@example.com', 'student123', 0, 1, 3, '2024-10-20'),
('Roman', 'Henderson', 'roman.henderson@example.com', 'student123', 0, 1, 3, '2024-11-20'),
('Skylar', 'Coleman', 'skylar.coleman@example.com', 'student123', 0, 1, 3, '2024-12-20'),
('Axel', 'Jenkins', 'axel.jenkins@example.com', 'student123', 0, 1, 3, '2025-01-20'),
('Aurora', 'Perry', 'aurora.perry@example.com', 'student123', 0, 1, 3, '2024-09-22'),
('Dominic', 'Powell', 'dominic.powell@example.com', 'student123', 0, 1, 3, '2024-10-22'),
('Brianna', 'Long', 'brianna.long@example.com', 'student123', 0, 1, 3, '2024-11-22'),
('Austin', 'Patterson', 'austin.patterson@example.com', 'student123', 0, 1, 3, '2024-12-22'),
('Genesis', 'Hughes', 'genesis.hughes@example.com', 'student123', 0, 1, 3, '2025-01-22'),
('Adam', 'Flores', 'adam.flores@example.com', 'student123', 0, 1, 3, '2024-09-24'),
('Emilia', 'Washington', 'emilia.washington@example.com', 'student123', 0, 1, 3, '2024-10-24'),
('Xavier', 'Butler', 'xavier.butler@example.com', 'student123', 0, 1, 3, '2024-11-24'),
('Caroline', 'Simmons', 'caroline.simmons@example.com', 'student123', 0, 1, 3, '2024-12-24'),
('Ian', 'Foster', 'ian.foster@example.com', 'student123', 0, 1, 3, '2025-01-24'),
('Nevaeh', 'Gonzales', 'nevaeh.gonzales@example.com', 'student123', 0, 1, 3, '2024-09-26'),
('Elias', 'Bryant', 'elias.bryant@example.com', 'student123', 0, 1, 3, '2024-10-26'),
('Ruby', 'Alexander', 'ruby.alexander@example.com', 'student123', 0, 1, 3, '2024-11-26'),
('Tristan', 'Russell', 'tristan.russell@example.com', 'student123', 0, 1, 3, '2024-12-26'),
('Piper', 'Griffin', 'piper.griffin@example.com', 'student123', 0, 1, 3, '2025-01-26'),
('Jason', 'Diaz', 'jason.diaz@example.com', 'student123', 0, 1, 3, '2024-09-28'),
('Eva', 'Hayes', 'eva.hayes@example.com', 'student123', 0, 1, 3, '2024-10-28'),
('Cameron', 'Myers', 'cameron.myers@example.com', 'student123', 0, 1, 3, '2024-11-28'),
('Luna', 'Ford', 'luna.ford@example.com', 'student123', 0, 1, 3, '2024-12-28'),
('Kevin', 'Hamilton', 'kevin.hamilton@example.com', 'student123', 0, 1, 3, '2025-01-28'),
('Aaliyah', 'Graham', 'aaliyah.graham@example.com', 'student123', 0, 1, 3, '2024-09-30'),
('Zachary', 'Sullivan', 'zachary.sullivan@example.com', 'student123', 0, 1, 3, '2024-10-30'),
('Elena', 'Wallace', 'elena.wallace@example.com', 'student123', 0, 1, 3, '2024-11-30'),
('Chase', 'Woods', 'chase.woods@example.com', 'student123', 0, 1, 3, '2024-12-30'),
('Naomi', 'Cole', 'naomi.cole@example.com', 'student123', 0, 1, 3, '2025-01-30'),
('Brayden', 'West', 'brayden.west@example.com', 'student123', 0, 1, 3, '2024-09-02'),
('Aubrey', 'Jordan', 'aubrey.jordan@example.com', 'student123', 0, 1, 3, '2024-10-02'),
('Gavin', 'Owens', 'gavin.owens@example.com', 'student123', 0, 1, 3, '2024-11-02'),
('Alice', 'Reynolds', 'alice.reynolds@example.com', 'student123', 1, 1, 3, '2024-12-02'),
('Liam', 'Fisher', 'liam.fisher@example.com', 'student123', 1, 1, 3, '2025-01-02'),
('Olivia', 'Ellis', 'olivia.ellis@example.com', 'student123', 1, 1, 3, '2024-09-04'),
('Noah', 'Harrison', 'noah.harrison@example.com', 'student123', 1, 1, 3, '2024-10-04'),
('Ava', 'Gibson', 'ava.gibson@example.com', 'student123', 1, 1, 3, '2024-11-04'),
('William', 'Mcdonald', 'william.mcdonald@example.com', 'student123', 1, 1, 3, '2024-12-04'),
('Sophia', 'Cruz', 'sophia.cruz@example.com', 'student123', 1, 1, 3, '2025-01-04'),
('James', 'Marshall', 'james.marshall@example.com', 'student123', 1, 1, 3, '2024-09-06'),
('Isabella', 'Ortiz', 'isabella.ortiz@example.com', 'student123', 1, 1, 3, '2024-10-06'),
('Benjamin', 'Gomez', 'benjamin.gomez@example.com', 'student123', 1, 1, 3, '2024-11-06');


-- Insert 10 categories
INSERT INTO categories (name) VALUES
('Programming'),
('Mathematics'),
('Science'),
('History'),
('Art'),
('Music'),
('Literature'),
('Business'),
('Health'),
('Technology');

-- Insert 30 tags
INSERT INTO tags (name) VALUES
('Beginner'),
('Intermediate'),
('Advanced'),
('Web Development'),
('Data Science'),
('Machine Learning'),
('Algebra'),
('Calculus'),
('Physics'),
('Chemistry'),
('World History'),
('US History'),
('Painting'),
('Sculpture'),
('Classical Music'),
('Jazz'),
('Fiction'),
('Non-Fiction'),
('Entrepreneurship'),
('Marketing'),
('Nutrition'),
('Fitness'),
('Cybersecurity'),
('Artificial Intelligence'),
('Mobile Development'),
('Game Development'),
('Database Management'),
('Cloud Computing'),
('Networking'),
('UI/UX Design');

---- Insert courses (each teacher has 6 courses except one teacher who has none)
-- Insert courses for verified teachers (12 teachers, since 3 are not verified)
-- Each teacher will have between 4 to 6 courses.

-- Teacher 1 (Alice Smith)
INSERT INTO courses (title, description, price, thumbnail, document_name, video_name, teacher_id, category_id, created_at, updated_at) VALUES
-- Teacher 2 (Alice Smith, created_at: 2024-10-10)
('Intro to Programming', 'Learn the basics of programming.', 50, 'Intro Programming.jpg', 'Intro Programming.pdf', NULL, 2, 1, '2024-10-12', NULL),
('Web Development Basics', 'Build your first website.', 60, 'Web Development Basics.jpg', NULL, 'Web Development Basics.mp4', 2, 2, '2024-10-15', '2024-10-20'),
('Advanced JavaScript', 'Master JavaScript concepts.', 70, 'Advanced JavaScript.jpg', 'Advanced JavaScript.pdf', NULL, 2, 3, '2024-10-18', NULL),
('Database Design', 'Learn how to design databases.', 80, 'Database Design.jpg', NULL, 'Database Design.mp4', 2, 4, '2024-10-22', '2024-11-01'),

-- Teacher 3 (Bob Johnson, created_at: 2024-11-05)
('Python for Beginners', 'Start your journey with Python.', 55, 'Python for Beginners.jpg', NULL, 'Python for Beginners.mp4', 3, 5, '2024-11-08', NULL),
('Data Science', 'Explore the world of data science.', 75, 'Data Science.jpg', NULL, 'Data Science.mp4', 3, 6, '2024-11-12', '2024-11-20'),
('Machine Learning Basics', 'Introduction to machine learning.', 85, 'Machine Learning Basics.jpg', 'Machine Learning Basics.pdf', NULL, 3, 7, '2024-11-15', NULL),
('AI and Ethics', 'Understand the ethics of AI.', 90, 'AI and Ethics.jpg', NULL, 'AI and Ethics.mp4', 3, 8, '2024-11-18', '2024-12-01'),

-- Teacher 4 (Charlie Brown, created_at: 2024-12-01)
('Graphic Design Basics', 'Learn the fundamentals of graphic design.', 45, 'Graphic Design Basics.jpg', 'Graphic Design Basics.pdf', NULL, 4, 9, '2024-12-05', NULL),
('UI/UX Design', 'Design user-friendly interfaces.', 65, 'UIUX Design.jpg', NULL, 'UIUX Design.mp4', 4, 10, '2024-12-08', '2024-12-15'),
('Advanced Photoshop', 'Master Photoshop techniques.', 75, 'Advanced Photoshop.jpg', 'Advanced Photoshop.pdf', NULL, 4, 1, '2024-12-12', NULL),
('Illustrator for Beginners', 'Get started with Adobe Illustrator.', 55, 'Illustrator.jpg', NULL, 'Illustrator.mp4', 4, 2, '2024-12-18', '2025-01-05'),

-- Teacher 5 (David Williams, created_at: 2024-12-20)
('Mobile Development', 'Build your first mobile app.', 70, 'Mobile Development.jpg', 'Mobile Development.pdf', NULL, 5, 3, '2024-12-22', NULL),
('Flutter Basics', 'Learn Flutter for cross-platform apps.', 80, 'Flutter Basics.jpg', NULL, 'Flutter Basics.mp4', 5, 4, '2024-12-25', '2025-01-05'),
('React Native Crash Course', 'Quickly build apps with React Native.', 90, 'React Native.jpg', 'React Native.pdf', NULL, 5, 5, '2024-12-28', NULL),
('Swift for iOS', 'Start developing iOS apps with Swift.', 100, 'Swift.jpg', NULL, 'Swift.mp4', 5, 6, '2025-01-02', '2025-01-15'),

-- Teacher 6 (Eva Jones, created_at: 2025-01-10)
('Digital Marketing Basics', 'Learn the fundamentals of digital marketing.', 50, 'Digital Marketing Basics.jpg', 'Digital Marketing Basics.pdf', NULL, 6, 7, '2025-01-12', NULL),
('SEO for Beginners', 'Optimize your website for search engines.', 60, 'SEO for Beginners.jpg', NULL, 'SEO for Beginners.mp4', 6, 8, '2025-01-14', '2025-01-18'),
('Social Media Marketing', 'Master social media strategies.', 70, 'Social Media Marketing.jpg', 'Social Media Marketing.pdf', NULL, 6, 9, '2025-01-16', NULL),
('Content Marketing', 'Create engaging content for your audience.', 80, 'Content Marketing.jpg', NULL, 'Content Marketing.mp4', 6, 10, '2025-01-18', '2025-01-21'),

-- Teacher 7 (Frank Garcia, created_at: 2024-11-20)
('Cybersecurity Basics', 'Protect yourself online.', 60, 'Cybersecurity Basics.jpg', 'Cybersecurity Basics.pdf', NULL, 7, 1, '2024-11-22', NULL),
('Ethical Hacking', 'Learn ethical hacking techniques.', 80, 'Ethical Hacking.jpg', NULL, 'Ethical Hacking.mp4', 7, 2, '2024-11-25', '2024-12-05'),
('Network Security', 'Secure your network infrastructure.', 90, 'Network Security.jpg', NULL, 'Network Security.mp4', 7, 3, '2024-11-28', NULL),
('Penetration Testing', 'Test your systems for vulnerabilities.', 100, 'Penetration Testing.jpg', 'Penetration Testing.pdf', NULL, 7, 4, '2024-12-01', '2024-12-10'),

-- Teacher 8 (Grace Martinez, created_at: 2024-12-15)
('Cloud Computing Basics', 'Understand cloud computing concepts.', 70, 'Cloud Computing Basics.jpg', NULL, 'Cloud Computing Basics.mp4', 8, 5, '2024-12-18', NULL),
('AWS Fundamentals', 'Learn the basics of Amazon Web Services.', 90, 'AWS Fundamentals.jpg', 'AWS Fundamentals.pdf', NULL, 8, 6, '2024-12-20', '2025-01-05'),
('Azure for Beginners', 'Get started with Microsoft Azure.', 80, 'Azure for Beginner.jpg', 'Azure for Beginner.pdf', NULL, 8, 7, '2024-12-22', NULL),
('Google Cloud Essentials', 'Master Google Cloud Platform.', 100, 'Google Cloud.jpg', 'Google Cloud.pdf', NULL, 8, 8, '2024-12-25', '2025-01-10'),

-- Teacher 9 (Henry Davis, created_at: 2025-01-05)
('Blockchain Basics', 'Learn the fundamentals of blockchain.', 75, 'Blockchain Basics.jpg', NULL, "Blockchain Basics.mp4", 9, 9, '2025-01-08', NULL),
('Cryptocurrency 101', 'Understand how cryptocurrencies work.', 85, 'Cryptocurrency.jpg', 'Cryptocurrency.mp4', NULL, 9, 10, '2025-01-10', '2025-01-15'),
('Smart Contracts', 'Create and deploy smart contracts.', 95, 'Smart Contracts.jpg', 'Smart Contracts.pdf', NULL, 9, 1, '2025-01-12', NULL),
('Ethereum Development', 'Build decentralized apps on Ethereum.', 105, 'Ethereum Development.jpg', 'Ethereum Development.pdf', NULL, 9, 2, '2025-01-15', '2025-01-20'),

-- Teacher 10 (Ivy Rodriguez, created_at: 2025-01-10)
('Game Development Basics', 'Start creating your own games.', 65, 'Game Development Basics.jpg', NULL, "Game Development Basics.mp4", 10, 3, '2025-01-12', NULL),
('Unity for Beginners', 'Learn Unity game development.', 75, 'Unity.jpg', NULL, 'Unity.mp4', 10, 4, '2025-01-14', '2025-01-18'),
('Unreal Engine Crash Course', 'Quickly build games with Unreal Engine.', 85, 'Unreal Engine.jpg', 'Unreal Engine.pdf', NULL, 10, 5, '2025-01-16', NULL),
('2D Game Design', 'Design and develop 2D games.', 95, '2D Game.jpg', '2D Game.jpg', NULL, 10, 6, '2025-01-18', '2025-01-21'),

-- Teacher 11 (Jack Miller, created_at: 2025-01-15)
('DevOps Fundamentals', 'Learn the basics of DevOps.', 70, 'DevOps Fundamental.jpg', 'DevOps Fundamental.pdf', NULL, 11, 7, '2025-01-17', NULL),
('Docker for Beginners', 'Containerize your applications.', 80, 'Docker for Beginners.jpg', NULL, 'Docker for Beginners.mp4', 11, 8, '2025-01-18', '2025-01-20'),
('Kubernetes Essentials', 'Manage containerized applications with Kubernetes.', 90, 'Kubernetes.jpg', 'Kubernetes.pdf', NULL, 11, 9, '2025-01-19', NULL),
('CI/CD Pipelines', 'Automate your development workflows.', 100, 'CI/CD Pipelines.jpg', 'CI/CD Pipelines.pdf', NULL, 11, 10, '2025-01-20', '2025-01-21'),

-- Teacher 14 (Noah Anderson, created_at: 2025-01-20)
('Data Structures and Algorithms', 'Master the fundamentals of DSA.', 75, 'Data Structures and Algorithms.jpg', 'Data Structures and Algorithms.pdf', NULL, 14, 1, '2025-01-21', NULL),
('Dynamic Programming', 'Solve complex problems with DP.', 85, 'Dynamic Programming.jpg', NULL, 'Dynamic Programming.mp4', 14, 2, '2025-01-21', NULL),
('Graph Algorithms', 'Learn graph traversal and algorithms.', 95, 'Graph Algorithms.jpg', NULL, 'Graph Algorithms.mp4', 14, 3, '2025-01-21', NULL),
('Competitive Programming', 'Prepare for coding competitions.', 105, 'Competitive Programming.jpg', 'Competitive Programming.pdf', NULL, 14, 4, '2025-01-21', NULL),

-- Teacher 15 (Olivia Thomas, created_at: 2025-01-25)
('Public Speaking Basics', 'Improve your public speaking skills.', 50, 'Public Speaking.jpg', 'Public Speaking.pdf', NULL, 15, 5, '2025-01-21', NULL),
('Effective Communication', 'Communicate clearly and confidently.', 60, 'Effective Communication.jpg', 'Effective Communication.pdf', NULL, 15, 6, '2025-01-21', NULL),
('Leadership Skills', 'Develop your leadership abilities.', 70, 'Leadership Skills.jpg', 'Leadership Skills.pdf', NULL, 15, 7, '2025-01-21', NULL),
('Time Management', 'Manage your time effectively.', 80, 'Time Management.jpg', 'Time Management.pdf', NULL, 15, 8, '2025-01-21', NULL);


-- Insert enrollments (students enroll in courses)
-- Enroll banned students (10 students) in 0 to 3 courses
-- Banned students have IDs 101 to 110 (as per the previous user insertion script).

-- Banned Student 101 (Alice Reynolds)
INSERT INTO enrollments (student_id, course_id, is_completed, created_at) VALUES
-- Enrollments for Banned Students
(101, 1, 0, '2024-10-15'), -- Enrolled in "Introduction to Programming" (not completed)
(101, 3, 1, '2024-10-20'), -- Enrolled in "Advanced JavaScript" (completed)

-- Banned Student 102 (Liam Fisher)
(102, 5, 0, '2024-11-12'), -- Enrolled in "Python for Beginners" (not completed)

-- Banned Student 103 (Olivia Ellis)
(103, 7, 1, '2024-11-18'), -- Enrolled in "Machine Learning Basics" (completed)

-- Banned Student 105 (Ava Gibson)
(105, 9, 0, '2024-12-08'), -- Enrolled in "Graphic Design Basics" (not completed)
(105, 11, 1, '2024-12-15'), -- Enrolled in "Advanced Photoshop" (completed)

-- Banned Student 106 (William Mcdonald)
(106, 13, 0, '2024-12-25'), -- Enrolled in "Mobile App Development" (not completed)

-- Banned Student 108 (James Marshall)
(108, 17, 1, '2025-01-14'), -- Enrolled in "Digital Marketing Basics" (completed)

-- Banned Student 109 (Isabella Ortiz)
(109, 19, 0, '2025-01-18'), -- Enrolled in "Social Media Marketing" (not completed)

-- Enrollments for Non-Banned Students
-- Non-banned Student 1 (Emma Johnson)
(1, 2, 1, '2024-10-18'), -- Enrolled in "Web Development Basics" (completed)
(1, 4, 0, '2024-10-25'), -- Enrolled in "Database Design" (not completed)
(1, 6, 1, '2024-11-15'), -- Enrolled in "Data Science Fundamentals" (completed)

-- Non-banned Student 2 (Liam Smith)
(2, 8, 0, '2024-11-22'), -- Enrolled in "AI and Ethics" (not completed)
(2, 10, 1, '2024-12-01'), -- Enrolled in "UI/UX Design" (completed)

-- Non-banned Student 3 (Olivia Brown)
(3, 12, 1, '2024-12-20'), -- Enrolled in "Illustrator for Beginners" (completed)

-- Non-banned Student 4 (Noah Davis)
(4, 14, 0, '2024-12-28'), -- Enrolled in "Flutter Basics" (not completed)
(4, 16, 1, '2025-01-05'), -- Enrolled in "Swift for iOS Development" (completed)

-- Non-banned Student 5 (Ava Miller)
(5, 18, 1, '2025-01-12'), -- Enrolled in "SEO for Beginners" (completed)
(5, 20, 0, '2025-01-18'), -- Enrolled in "Content Marketing" (not completed)

-- Non-banned Student 6 (William Wilson)
(6, 22, 0, '2024-11-28'), -- Enrolled in "Ethical Hacking" (not completed)
(6, 24, 1, '2024-12-10'), -- Enrolled in "Penetration Testing" (completed)

-- Non-banned Student 7 (Sophia Moore)
(7, 26, 1, '2024-12-22'), -- Enrolled in "AWS Fundamentals" (completed)

-- Non-banned Student 8 (James Taylor)
(8, 28, 0, '2024-12-30'), -- Enrolled in "Google Cloud Essentials" (not completed)
(8, 30, 1, '2025-01-10'), -- Enrolled in "Cryptocurrency 101" (completed)

-- Non-banned Student 9 (Isabella Anderson)
(9, 32, 1, '2025-01-15'), -- Enrolled in "Ethereum Development" (completed)

-- Non-banned Student 10 (Benjamin Thomas)
(10, 34, 0, '2025-01-18'), -- Enrolled in "Unity for Beginners" (not completed)
(10, 36, 1, '2025-01-21'), -- Enrolled in "2D Game Design" (completed)

-- Non-banned Student 11 (Mia Jackson)
(11, 38, 1, '2025-01-19'), -- Enrolled in "Docker for Beginners" (completed)
(11, 40, 0, '2025-01-21'), -- Enrolled in "CI/CD Pipelines" (not completed)

-- Non-banned Student 12 (Elijah White)
(12, 42, 0, '2025-01-21'), -- Enrolled in "Dynamic Programming" (not completed)

-- Non-banned Student 13 (Amelia Harris)
(13, 44, 1, '2025-01-21'), -- Enrolled in "Competitive Programming" (completed)

-- Non-banned Student 14 (Lucas Martin)
(14, 46, 0, '2025-01-21'), -- Enrolled in "Effective Communication" (not completed)

-- Non-banned Student 15 (Harper Thompson)
(15, 48, 1, '2025-01-21'), -- Enrolled in "Time Management" (completed)

-- Non-banned Student 16 (Alexander Garcia)
(16, 1, 1, '2024-10-15'), -- Enrolled in "Introduction to Programming" (completed)
(16, 3, 0, '2024-10-20'), -- Enrolled in "Advanced JavaScript" (not completed)
(16, 5, 1, '2024-11-12'), -- Enrolled in "Python for Beginners" (completed)

-- Non-banned Student 17 (Evelyn Martinez)
(17, 7, 0, '2024-11-18'), -- Enrolled in "Machine Learning Basics" (not completed)
(17, 9, 1, '2024-12-08'), -- Enrolled in "Graphic Design Basics" (completed)

-- Non-banned Student 18 (Michael Robinson)
(18, 11, 1, '2024-12-15'), -- Enrolled in "Advanced Photoshop" (completed)

-- Non-banned Student 19 (Ella Clark)
(19, 13, 0, '2024-12-25'), -- Enrolled in "Mobile App Development" (not completed)
(19, 15, 1, '2025-01-05'), -- Enrolled in "React Native Crash Course" (completed)

-- Non-banned Student 20 (Daniel Rodriguez)
(20, 17, 1, '2025-01-14'), -- Enrolled in "Digital Marketing Basics" (completed)
(20, 19, 0, '2025-01-18'), -- Enrolled in "Social Media Marketing" (not completed)

-- Non-banned Student 21 (Avery Lewis)
(21, 21, 0, '2024-11-22'), -- Enrolled in "Cybersecurity Basics" (not completed)
(21, 23, 1, '2024-12-01'), -- Enrolled in "Network Security" (completed)

-- Non-banned Student 22 (Logan Lee)
(22, 25, 1, '2024-12-22'), -- Enrolled in "Cloud Computing Basics" (completed)

-- Non-banned Student 23 (Scarlett Walker)
(23, 27, 0, '2024-12-30'), -- Enrolled in "Azure for Beginners" (not completed)
(23, 29, 1, '2025-01-10'), -- Enrolled in "Blockchain Basics" (completed)

-- Non-banned Student 24 (Matthew Hall)
(24, 31, 1, '2025-01-15'), -- Enrolled in "Smart Contracts" (completed)

-- Non-banned Student 25 (Abigail Allen)
(25, 33, 0, '2025-01-18'), -- Enrolled in "Game Development Basics" (not completed)
(25, 35, 1, '2025-01-21'), -- Enrolled in "Unreal Engine Crash Course" (completed)

-- Non-banned Student 26 (Jackson Young)
(26, 37, 1, '2025-01-19'), -- Enrolled in "DevOps Fundamentals" (completed)
(26, 39, 0, '2025-01-21'), -- Enrolled in "Kubernetes Essentials" (not completed)

-- Non-banned Student 27 (Sofia Hernandez)
(27, 41, 0, '2025-01-21'), -- Enrolled in "Data Structures and Algorithms" (not completed)

-- Non-banned Student 28 (David King)
(28, 43, 1, '2025-01-21'), -- Enrolled in "Graph Algorithms" (completed)

-- Non-banned Student 29 (Madison Wright)
(29, 45, 0, '2025-01-21'), -- Enrolled in "Public Speaking Basics" (not completed)

-- Non-banned Student 30 (Joseph Lopez)
(30, 47, 1, '2025-01-21'), -- Enrolled in "Leadership Skills" (completed)
-- Non-banned Student 31 (Chloe Scott)
(31, 2, 1, '2024-10-18'), -- Enrolled in "Web Development Basics" (completed)
(31, 4, 0, '2024-10-25'), -- Enrolled in "Database Design" (not completed)
(31, 6, 1, '2024-11-15'), -- Enrolled in "Data Science Fundamentals" (completed)

-- Non-banned Student 32 (Samuel Green)
(32, 8, 0, '2024-11-22'), -- Enrolled in "AI and Ethics" (not completed)
(32, 10, 1, '2024-12-01'), -- Enrolled in "UI/UX Design" (completed)

-- Non-banned Student 33 (Victoria Adams)
(33, 12, 1, '2024-12-20'), -- Enrolled in "Illustrator for Beginners" (completed)

-- Non-banned Student 34 (Henry Baker)
(34, 14, 0, '2024-12-28'), -- Enrolled in "Flutter Basics" (not completed)
(34, 16, 1, '2025-01-05'), -- Enrolled in "Swift for iOS Development" (completed)

-- Non-banned Student 35 (Grace Gonzalez)
(35, 18, 1, '2025-01-12'), -- Enrolled in "SEO for Beginners" (completed)
(35, 20, 0, '2025-01-18'), -- Enrolled in "Content Marketing" (not completed)

-- Non-banned Student 36 (Owen Nelson)
(36, 22, 0, '2024-11-28'), -- Enrolled in "Ethical Hacking" (not completed)
(36, 24, 1, '2024-12-10'), -- Enrolled in "Penetration Testing" (completed)

-- Non-banned Student 37 (Lily Carter)
(37, 26, 1, '2024-12-22'), -- Enrolled in "AWS Fundamentals" (completed)

-- Non-banned Student 38 (Sebastian Mitchell)
(38, 28, 0, '2024-12-30'), -- Enrolled in "Google Cloud Essentials" (not completed)
(38, 30, 1, '2025-01-10'), -- Enrolled in "Cryptocurrency 101" (completed)

-- Non-banned Student 39 (Hannah Perez)
(39, 32, 1, '2025-01-15'), -- Enrolled in "Ethereum Development" (completed)

-- Non-banned Student 40 (Carter Roberts)
(40, 34, 0, '2025-01-18'), -- Enrolled in "Unity for Beginners" (not completed)
(40, 36, 1, '2025-01-21'), -- Enrolled in "2D Game Design" (completed)

-- Non-banned Student 41 (Zoe Turner)
(41, 38, 1, '2025-01-19'), -- Enrolled in "Docker for Beginners" (completed)
(41, 40, 0, '2025-01-21'), -- Enrolled in "CI/CD Pipelines" (not completed)

-- Non-banned Student 42 (Wyatt Phillips)
(42, 42, 0, '2025-01-21'), -- Enrolled in "Dynamic Programming" (not completed)

-- Non-banned Student 43 (Addison Campbell)
(43, 44, 1, '2025-01-21'), -- Enrolled in "Competitive Programming" (completed)

-- Non-banned Student 44 (Gabriel Parker)
(44, 46, 0, '2025-01-21'), -- Enrolled in "Effective Communication" (not completed)

-- Non-banned Student 45 (Natalie Evans)
(45, 48, 1, '2025-01-21'), -- Enrolled in "Time Management" (completed)

-- Non-banned Student 46 (Luke Edwards)
(46, 1, 1, '2024-10-15'), -- Enrolled in "Introduction to Programming" (completed)
(46, 3, 0, '2024-10-20'), -- Enrolled in "Advanced JavaScript" (not completed)
(46, 5, 1, '2024-11-12'), -- Enrolled in "Python for Beginners" (completed)

-- Non-banned Student 47 (Leah Collins)
(47, 7, 0, '2024-11-18'), -- Enrolled in "Machine Learning Basics" (not completed)
(47, 9, 1, '2024-12-08'), -- Enrolled in "Graphic Design Basics" (completed)

-- Non-banned Student 48 (Dylan Stewart)
(48, 11, 1, '2024-12-15'), -- Enrolled in "Advanced Photoshop" (completed)

-- Non-banned Student 49 (Audrey Sanchez)
(49, 13, 0, '2024-12-25'), -- Enrolled in "Mobile App Development" (not completed)
(49, 15, 1, '2025-01-05'), -- Enrolled in "React Native Crash Course" (completed)

-- Non-banned Student 50 (Isaac Morris)
(50, 17, 1, '2025-01-14'), -- Enrolled in "Digital Marketing Basics" (completed)
(50, 19, 0, '2025-01-18'), -- Enrolled in "Social Media Marketing" (not completed)

-- Non-banned Student 51 (Bella Rogers)
(51, 21, 0, '2024-11-22'), -- Enrolled in "Cybersecurity Basics" (not completed)
(51, 23, 1, '2024-12-01'), -- Enrolled in "Network Security" (completed)

-- Non-banned Student 52 (Nathan Reed)
(52, 25, 1, '2024-12-22'), -- Enrolled in "Cloud Computing Basics" (completed)

-- Non-banned Student 53 (Ellie Cook)
(53, 27, 0, '2024-12-30'), -- Enrolled in "Azure for Beginners" (not completed)
(53, 29, 1, '2025-01-10'), -- Enrolled in "Blockchain Basics" (completed)

-- Non-banned Student 54 (Ryan Morgan)
(54, 31, 1, '2025-01-15'), -- Enrolled in "Smart Contracts" (completed)

-- Non-banned Student 55 (Stella Bell)
(55, 33, 0, '2025-01-18'), -- Enrolled in "Game Development Basics" (not completed)
(55, 35, 1, '2025-01-21'), -- Enrolled in "Unreal Engine Crash Course" (completed)

-- Non-banned Student 56 (Eli Murphy)
(56, 37, 1, '2025-01-19'), -- Enrolled in "DevOps Fundamentals" (completed)
(56, 39, 0, '2025-01-21'), -- Enrolled in "Kubernetes Essentials" (not completed)

-- Non-banned Student 57 (Claire Bailey)
(57, 41, 0, '2025-01-21'), -- Enrolled in "Data Structures and Algorithms" (not completed)

-- Non-banned Student 58 (Caleb Rivera)
(58, 43, 1, '2025-01-21'), -- Enrolled in "Graph Algorithms" (completed)

-- Non-banned Student 59 (Aria Cooper)
(59, 45, 0, '2025-01-21'), -- Enrolled in "Public Speaking Basics" (not completed)

-- Non-banned Student 60 (Mason Richardson)
(60, 47, 1, '2025-01-21'), -- Enrolled in "Leadership Skills" (completed)

-- Non-banned Student 61 (Lucy Cox)
(61, 2, 1, '2024-10-18'), -- Enrolled in "Web Development Basics" (completed)
(61, 4, 0, '2024-10-25'), -- Enrolled in "Database Design" (not completed)
(61, 6, 1, '2024-11-15'), -- Enrolled in "Data Science Fundamentals" (completed)

-- Non-banned Student 62 (Aaron Howard)
(62, 8, 0, '2024-11-22'), -- Enrolled in "AI and Ethics" (not completed)
(62, 10, 1, '2024-12-01'), -- Enrolled in "UI/UX Design" (completed)

-- Non-banned Student 63 (Anna Ward)
(63, 12, 1, '2024-12-20'), -- Enrolled in "Illustrator for Beginners" (completed)

-- Non-banned Student 64 (Hunter Torres)
(64, 14, 0, '2024-12-28'), -- Enrolled in "Flutter Basics" (not completed)
(64, 16, 1, '2025-01-05'), -- Enrolled in "Swift for iOS Development" (completed)

-- Non-banned Student 65 (Layla Peterson)
(65, 18, 1, '2025-01-12'), -- Enrolled in "SEO for Beginners" (completed)
(65, 20, 0, '2025-01-18'), -- Enrolled in "Content Marketing" (not completed)

-- Non-banned Student 66 (Evan Gray)
(66, 22, 0, '2024-11-28'), -- Enrolled in "Ethical Hacking" (not completed)
(66, 24, 1, '2024-12-10'), -- Enrolled in "Penetration Testing" (completed)

-- Non-banned Student 67 (Nora Ramirez)
(67, 26, 1, '2024-12-22'), -- Enrolled in "AWS Fundamentals" (completed)

-- Non-banned Student 68 (Adrian James)
(68, 28, 0, '2024-12-30'), -- Enrolled in "Google Cloud Essentials" (not completed)
(68, 30, 1, '2025-01-10'), -- Enrolled in "Cryptocurrency 101" (completed)

-- Non-banned Student 69 (Hazel Watson)
(69, 32, 1, '2025-01-15'), -- Enrolled in "Ethereum Development" (completed)

-- Non-banned Student 70 (Jordan Brooks)
(70, 34, 0, '2025-01-18'), -- Enrolled in "Unity for Beginners" (not completed)
(70, 36, 1, '2025-01-21'), -- Enrolled in "2D Game Design" (completed)

-- Non-banned Student 71 (Violet Kelly)
(71, 38, 1, '2025-01-19'), -- Enrolled in "Docker for Beginners" (completed)
(71, 40, 0, '2025-01-21'), -- Enrolled in "CI/CD Pipelines" (not completed)

-- Non-banned Student 72 (Christian Sanders)
(72, 42, 0, '2025-01-21'), -- Enrolled in "Dynamic Programming" (not completed)

-- Non-banned Student 73 (Savannah Price)
(73, 44, 1, '2025-01-21'), -- Enrolled in "Competitive Programming" (completed)

-- Non-banned Student 74 (Landon Bennett)
(74, 46, 0, '2025-01-21'), -- Enrolled in "Effective Communication" (not completed)

-- Non-banned Student 75 (Brooklyn Wood)
(75, 48, 1, '2025-01-21'), -- Enrolled in "Time Management" (completed)

-- Non-banned Student 76 (Colton Barnes)
(76, 1, 1, '2024-10-15'), -- Enrolled in "Introduction to Programming" (completed)
(76, 3, 0, '2024-10-20'), -- Enrolled in "Advanced JavaScript" (not completed)
(76, 5, 1, '2024-11-12'), -- Enrolled in "Python for Beginners" (completed)

-- Non-banned Student 77 (Paisley Ross)
(77, 7, 0, '2024-11-18'), -- Enrolled in "Machine Learning Basics" (not completed)
(77, 9, 1, '2024-12-08'), -- Enrolled in "Graphic Design Basics" (completed)

-- Non-banned Student 78 (Roman Henderson)
(78, 11, 1, '2024-12-15'), -- Enrolled in "Advanced Photoshop" (completed)

-- Non-banned Student 79 (Skylar Coleman)
(79, 13, 0, '2024-12-25'), -- Enrolled in "Mobile App Development" (not completed)
(79, 15, 1, '2025-01-05'), -- Enrolled in "React Native Crash Course" (completed)

-- Non-banned Student 80 (Axel Jenkins)
(80, 17, 1, '2025-01-14'), -- Enrolled in "Digital Marketing Basics" (completed)
(80, 19, 0, '2025-01-18'), -- Enrolled in "Social Media Marketing" (not completed)

-- Non-banned Student 81 (Aurora Perry)
(81, 21, 0, '2024-11-22'), -- Enrolled in "Cybersecurity Basics" (not completed)
(81, 23, 1, '2024-12-01'), -- Enrolled in "Network Security" (completed)

-- Non-banned Student 82 (Dominic Powell)
(82, 25, 1, '2024-12-22'), -- Enrolled in "Cloud Computing Basics" (completed)

-- Non-banned Student 83 (Brianna Long)
(83, 27, 0, '2024-12-30'), -- Enrolled in "Azure for Beginners" (not completed)
(83, 29, 1, '2025-01-10'), -- Enrolled in "Blockchain Basics" (completed)

-- Non-banned Student 84 (Austin Patterson)
(84, 31, 1, '2025-01-15'), -- Enrolled in "Smart Contracts" (completed)

-- Non-banned Student 85 (Genesis Hughes)
(85, 33, 0, '2025-01-18'), -- Enrolled in "Game Development Basics" (not completed)
(85, 35, 1, '2025-01-21'), -- Enrolled in "Unreal Engine Crash Course" (completed)

-- Non-banned Student 86 (Adam Flores)
(86, 37, 1, '2025-01-19'), -- Enrolled in "DevOps Fundamentals" (completed)
(86, 39, 0, '2025-01-21'), -- Enrolled in "Kubernetes Essentials" (not completed)

-- Non-banned Student 87 (Emilia Washington)
(87, 41, 0, '2025-01-21'), -- Enrolled in "Data Structures and Algorithms" (not completed)

-- Non-banned Student 88 (Xavier Butler)
(88, 43, 1, '2025-01-21'), -- Enrolled in "Graph Algorithms" (completed)

-- Non-banned Student 89 (Caroline Simmons)
(89, 45, 0, '2025-01-21'), -- Enrolled in "Public Speaking Basics" (not completed)

-- Non-banned Student 90 (Ian Foster)
(90, 47, 1, '2025-01-21'), -- Enrolled in "Leadership Skills" (completed)

-- Non-banned Student 91 (Nevaeh Gonzales)
(91, 2, 1, '2024-10-18'), -- Enrolled in "Web Development Basics" (completed)
(91, 4, 0, '2024-10-25'), -- Enrolled in "Database Design" (not completed)
(91, 6, 1, '2024-11-15'), -- Enrolled in "Data Science Fundamentals" (completed)

-- Non-banned Student 92 (Elias Bryant)
(92, 8, 0, '2024-11-22'), -- Enrolled in "AI and Ethics" (not completed)
(92, 10, 1, '2024-12-01'), -- Enrolled in "UI/UX Design" (completed)

-- Non-banned Student 93 (Ruby Alexander)
(93, 12, 1, '2024-12-20'), -- Enrolled in "Illustrator for Beginners" (completed)

-- Non-banned Student 94 (Tristan Russell)
(94, 14, 0, '2024-12-28'), -- Enrolled in "Flutter Basics" (not completed)
(94, 16, 1, '2025-01-05'), -- Enrolled in "Swift for iOS Development" (completed)

-- Non-banned Student 95 (Piper Griffin)
(95, 18, 1, '2025-01-12'), -- Enrolled in "SEO for Beginners" (completed)
(95, 20, 0, '2025-01-18'), -- Enrolled in "Content Marketing" (not completed)

-- Non-banned Student 96 (Jason Diaz)
(96, 22, 0, '2024-11-28'), -- Enrolled in "Ethical Hacking" (not completed)
(96, 24, 1, '2024-12-10'), -- Enrolled in "Penetration Testing" (completed)

-- Non-banned Student 97 (Eva Hayes)
(97, 26, 1, '2024-12-22'), -- Enrolled in "AWS Fundamentals" (completed)

-- Non-banned Student 98 (Eva Hayes)
(98, 26, 1, '2025-01-21'), -- Enrolled in "AWS Fundamentals" (completed)

-- Non-banned Student 99 (Eva Hayes)
(99, 26, 1, '2025-01-21'); -- Enrolled in "AWS Fundamentals" (completed)


-- Insert rates (students rate courses)
-- Ratings for Student 1 (Emma Johnson)
INSERT INTO rates (student_id, course_id, rate) VALUES
(1, 2, 5), -- Rated "Web Development Basics" with 5 stars
(1, 4, 4), -- Rated "Database Design" with 4 stars
(1, 6, 5), -- Rated "Data Science Fundamentals" with 5 stars

-- Ratings for Student 2 (Liam Smith)
(2, 8, 3), -- Rated "AI and Ethics" with 3 stars
(2, 10, 5), -- Rated "UI/UX Design" with 5 stars

-- Ratings for Student 3 (Olivia Brown)
(3, 12, 4), -- Rated "Illustrator for Beginners" with 4 stars

-- Ratings for Student 4 (Noah Davis)
(4, 14, 3), -- Rated "Flutter Basics" with 3 stars
(4, 16, 5), -- Rated "Swift for iOS Development" with 5 stars

-- Ratings for Student 5 (Ava Miller)
(5, 18, 5), -- Rated "SEO for Beginners" with 5 stars
(5, 20, 4), -- Rated "Content Marketing" with 4 stars

-- Ratings for Student 6 (William Wilson)
(6, 22, 4), -- Rated "Ethical Hacking" with 4 stars
(6, 24, 5), -- Rated "Penetration Testing" with 5 stars

-- Ratings for Student 7 (Sophia Moore)
(7, 26, 5), -- Rated "AWS Fundamentals" with 5 stars

-- Ratings for Student 8 (James Taylor)
(8, 28, 3), -- Rated "Google Cloud Essentials" with 3 stars
(8, 30, 4), -- Rated "Cryptocurrency 101" with 4 stars

-- Ratings for Student 9 (Isabella Anderson)
(9, 32, 5), -- Rated "Ethereum Development" with 5 stars

-- Ratings for Student 10 (Benjamin Thomas)
(10, 34, 4), -- Rated "Unity for Beginners" with 4 stars
(10, 36, 5), -- Rated "2D Game Design" with 5 stars

-- Ratings for Student 11 (Mia Jackson)
(11, 38, 5), -- Rated "Docker for Beginners" with 5 stars
(11, 40, 4), -- Rated "CI/CD Pipelines" with 4 stars

-- Ratings for Student 12 (Elijah White)
(12, 42, 3), -- Rated "Dynamic Programming" with 3 stars

-- Ratings for Student 13 (Amelia Harris)
(13, 44, 5), -- Rated "Competitive Programming" with 5 stars

-- Ratings for Student 14 (Lucas Martin)
(14, 46, 4), -- Rated "Effective Communication" with 4 stars

-- Ratings for Student 15 (Harper Thompson)
(15, 48, 5), -- Rated "Time Management" with 5 stars

-- Ratings for Student 16 (Alexander Garcia)
(16, 1, 5), -- Rated "Introduction to Programming" with 5 stars
(16, 3, 4), -- Rated "Advanced JavaScript" with 4 stars
(16, 5, 5), -- Rated "Python for Beginners" with 5 stars

-- Ratings for Student 17 (Evelyn Martinez)
(17, 7, 3), -- Rated "Machine Learning Basics" with 3 stars
(17, 9, 5), -- Rated "Graphic Design Basics" with 5 stars

-- Ratings for Student 18 (Michael Robinson)
(18, 11, 4), -- Rated "Advanced Photoshop" with 4 stars

-- Ratings for Student 19 (Ella Clark)
(19, 13, 3), -- Rated "Mobile App Development" with 3 stars
(19, 15, 5), -- Rated "React Native Crash Course" with 5 stars

-- Ratings for Student 20 (Daniel Rodriguez)
(20, 17, 5), -- Rated "Digital Marketing Basics" with 5 stars
(20, 19, 4), -- Rated "Social Media Marketing" with 4 stars

-- Ratings for Student 21 (Avery Lewis)
(21, 21, 4), -- Rated "Cybersecurity Basics" with 4 stars
(21, 23, 5), -- Rated "Network Security" with 5 stars

-- Ratings for Student 22 (Logan Lee)
(22, 25, 5), -- Rated "Cloud Computing Basics" with 5 stars

-- Ratings for Student 23 (Scarlett Walker)
(23, 27, 3), -- Rated "Azure for Beginners" with 3 stars
(23, 29, 4), -- Rated "Blockchain Basics" with 4 stars

-- Ratings for Student 24 (Matthew Hall)
(24, 31, 5), -- Rated "Smart Contracts" with 5 stars

-- Ratings for Student 25 (Abigail Allen)
(25, 33, 4), -- Rated "Game Development Basics" with 4 stars
(25, 35, 5), -- Rated "Unreal Engine Crash Course" with 5 stars

-- Ratings for Student 26 (Jackson Young)
(26, 37, 5), -- Rated "DevOps Fundamentals" with 5 stars
(26, 39, 4), -- Rated "Kubernetes Essentials" with 4 stars

-- Ratings for Student 27 (Sofia Hernandez)
(27, 41, 3), -- Rated "Data Structures and Algorithms" with 3 stars

-- Ratings for Student 28 (David King)
(28, 43, 5), -- Rated "Graph Algorithms" with 5 stars

-- Ratings for Student 29 (Madison Wright)
(29, 45, 4), -- Rated "Public Speaking Basics" with 4 stars

-- Ratings for Student 30 (Joseph Lopez)
(30, 47, 5), -- Rated "Leadership Skills" with 5 stars

-- Ratings for Student 31 (Chloe Scott)
(31, 2, 5), -- Rated "Web Development Basics" with 5 stars
(31, 4, 4), -- Rated "Database Design" with 4 stars
(31, 6, 5), -- Rated "Data Science Fundamentals" with 5 stars

-- Ratings for Student 32 (Samuel Green)
(32, 8, 3), -- Rated "AI and Ethics" with 3 stars
(32, 10, 5), -- Rated "UI/UX Design" with 5 stars

-- Ratings for Student 33 (Victoria Adams)
(33, 12, 4), -- Rated "Illustrator for Beginners" with 4 stars

-- Ratings for Student 34 (Henry Baker)
(34, 14, 3), -- Rated "Flutter Basics" with 3 stars
(34, 16, 5), -- Rated "Swift for iOS Development" with 5 stars

-- Ratings for Student 35 (Grace Gonzalez)
(35, 18, 5), -- Rated "SEO for Beginners" with 5 stars
(35, 20, 4), -- Rated "Content Marketing" with 4 stars

-- Ratings for Student 36 (Owen Nelson)
(36, 22, 4), -- Rated "Ethical Hacking" with 4 stars
(36, 24, 5), -- Rated "Penetration Testing" with 5 stars

-- Ratings for Student 37 (Lily Carter)
(37, 26, 5), -- Rated "AWS Fundamentals" with 5 stars

-- Ratings for Student 38 (Sebastian Mitchell)
(38, 28, 3), -- Rated "Google Cloud Essentials" with 3 stars
(38, 30, 4), -- Rated "Cryptocurrency 101" with 4 stars

-- Ratings for Student 39 (Hannah Perez)
(39, 32, 5), -- Rated "Ethereum Development" with 5 stars

-- Ratings for Student 40 (Carter Roberts)
(40, 34, 4), -- Rated "Unity for Beginners" with 4 stars
(40, 36, 5), -- Rated "2D Game Design" with 5 stars

-- Ratings for Student 41 (Zoe Turner)
(41, 38, 5), -- Rated "Docker for Beginners" with 5 stars
(41, 40, 4), -- Rated "CI/CD Pipelines" with 4 stars

-- Ratings for Student 42 (Wyatt Phillips)
(42, 42, 3), -- Rated "Dynamic Programming" with 3 stars

-- Ratings for Student 43 (Addison Campbell)
(43, 44, 5), -- Rated "Competitive Programming" with 5 stars

-- Ratings for Student 44 (Gabriel Parker)
(44, 46, 4), -- Rated "Effective Communication" with 4 stars

-- Ratings for Student 45 (Natalie Evans)
(45, 48, 5), -- Rated "Time Management" with 5 stars

-- Ratings for Student 46 (Luke Edwards)
(46, 1, 5), -- Rated "Introduction to Programming" with 5 stars
(46, 3, 4), -- Rated "Advanced JavaScript" with 4 stars
(46, 5, 5), -- Rated "Python for Beginners" with 5 stars

-- Ratings for Student 47 (Leah Collins)
(47, 7, 3), -- Rated "Machine Learning Basics" with 3 stars
(47, 9, 5), -- Rated "Graphic Design Basics" with 5 stars

-- Ratings for Student 48 (Dylan Stewart)
(48, 11, 4), -- Rated "Advanced Photoshop" with 4 stars

-- Ratings for Student 49 (Audrey Sanchez)
(49, 13, 3), -- Rated "Mobile App Development" with 3 stars
(49, 15, 5), -- Rated "React Native Crash Course" with 5 stars

-- Ratings for Student 50 (Isaac Morris)
(50, 17, 5), -- Rated "Digital Marketing Basics" with 5 stars
(50, 19, 4), -- Rated "Social Media Marketing" with 4 stars

-- Ratings for Student 51 (Bella Rogers)
(51, 21, 4), -- Rated "Cybersecurity Basics" with 4 stars
(51, 23, 5), -- Rated "Network Security" with 5 stars

-- Ratings for Student 52 (Nathan Reed)
(52, 25, 5), -- Rated "Cloud Computing Basics" with 5 stars

-- Ratings for Student 53 (Ellie Cook)
(53, 27, 3), -- Rated "Azure for Beginners" with 3 stars
(53, 29, 4), -- Rated "Blockchain Basics" with 4 stars

-- Ratings for Student 54 (Ryan Morgan)
(54, 31, 5), -- Rated "Smart Contracts" with 5 stars

-- Ratings for Student 55 (Stella Bell)
(55, 33, 4), -- Rated "Game Development Basics" with 4 stars
(55, 35, 5), -- Rated "Unreal Engine Crash Course" with 5 stars

-- Ratings for Student 56 (Eli Murphy)
(56, 37, 5), -- Rated "DevOps Fundamentals" with 5 stars
(56, 39, 4), -- Rated "Kubernetes Essentials" with 4 stars

-- Ratings for Student 57 (Claire Bailey)
(57, 41, 3), -- Rated "Data Structures and Algorithms" with 3 stars

-- Ratings for Student 58 (Caleb Rivera)
(58, 43, 5), -- Rated "Graph Algorithms" with 5 stars

-- Ratings for Student 59 (Aria Cooper)
(59, 45, 4), -- Rated "Public Speaking Basics" with 4 stars

-- Ratings for Student 60 (Mason Richardson)
(60, 47, 5), -- Rated "Leadership Skills" with 5 stars

-- Ratings for Student 61 (Lucy Cox)
(61, 2, 5), -- Rated "Web Development Basics" with 5 stars
(61, 4, 4), -- Rated "Database Design" with 4 stars
(61, 6, 5), -- Rated "Data Science Fundamentals" with 5 stars

-- Ratings for Student 62 (Aaron Howard)
(62, 8, 3), -- Rated "AI and Ethics" with 3 stars
(62, 10, 5), -- Rated "UI/UX Design" with 5 stars

-- Ratings for Student 63 (Anna Ward)
(63, 12, 4), -- Rated "Illustrator for Beginners" with 4 stars

-- Ratings for Student 64 (Hunter Torres)
(64, 14, 3), -- Rated "Flutter Basics" with 3 stars
(64, 16, 5), -- Rated "Swift for iOS Development" with 5 stars

-- Ratings for Student 65 (Layla Peterson)
(65, 18, 5), -- Rated "SEO for Beginners" with 5 stars
(65, 20, 4), -- Rated "Content Marketing" with 4 stars

-- Ratings for Student 66 (Evan Gray)
(66, 22, 4), -- Rated "Ethical Hacking" with 4 stars
(66, 24, 5), -- Rated "Penetration Testing" with 5 stars

-- Ratings for Student 67 (Nora Ramirez)
(67, 26, 5), -- Rated "AWS Fundamentals" with 5 stars

-- Ratings for Student 68 (Adrian James)
(68, 28, 3), -- Rated "Google Cloud Essentials" with 3 stars
(68, 30, 4), -- Rated "Cryptocurrency 101" with 4 stars

-- Ratings for Student 69 (Hazel Watson)
(69, 32, 5), -- Rated "Ethereum Development" with 5 stars

-- Ratings for Student 70 (Jordan Brooks)
(70, 34, 4), -- Rated "Unity for Beginners" with 4 stars
(70, 36, 5), -- Rated "2D Game Design" with 5 stars

-- Ratings for Student 71 (Violet Kelly)
(71, 38, 5), -- Rated "Docker for Beginners" with 5 stars
(71, 40, 4), -- Rated "CI/CD Pipelines" with 4 stars

-- Ratings for Student 72 (Christian Sanders)
(72, 42, 3), -- Rated "Dynamic Programming" with 3 stars

-- Ratings for Student 73 (Savannah Price)
(73, 44, 5), -- Rated "Competitive Programming" with 5 stars

-- Ratings for Student 74 (Landon Bennett)
(74, 46, 4), -- Rated "Effective Communication" with 4 stars

-- Ratings for Student 75 (Brooklyn Wood)
(75, 48, 5), -- Rated "Time Management" with 5 stars

-- Ratings for Student 76 (Colton Barnes)
(76, 1, 5), -- Rated "Introduction to Programming" with 5 stars
(76, 3, 4), -- Rated "Advanced JavaScript" with 4 stars
(76, 5, 5), -- Rated "Python for Beginners" with 5 stars

-- Ratings for Student 77 (Paisley Ross)
(77, 7, 3), -- Rated "Machine Learning Basics" with 3 stars
(77, 9, 5), -- Rated "Graphic Design Basics" with 5 stars

-- Ratings for Student 78 (Roman Henderson)
(78, 11, 4), -- Rated "Advanced Photoshop" with 4 stars

-- Ratings for Student 79 (Skylar Coleman)
(79, 13, 3), -- Rated "Mobile App Development" with 3 stars
(79, 15, 5), -- Rated "React Native Crash Course" with 5 stars

-- Ratings for Student 80 (Axel Jenkins)
(80, 17, 5), -- Rated "Digital Marketing Basics" with 5 stars
(80, 19, 4), -- Rated "Social Media Marketing" with 4 stars

-- Ratings for Student 81 (Aurora Perry)
(81, 21, 4), -- Rated "Cybersecurity Basics" with 4 stars
(81, 23, 5), -- Rated "Network Security" with 5 stars

-- Ratings for Student 82 (Dominic Powell)
(82, 25, 5), -- Rated "Cloud Computing Basics" with 5 stars

-- Ratings for Student 83 (Brianna Long)
(83, 27, 3), -- Rated "Azure for Beginners" with 3 stars
(83, 29, 4), -- Rated "Blockchain Basics" with 4 stars

-- Ratings for Student 84 (Austin Patterson)
(84, 31, 5), -- Rated "Smart Contracts" with 5 stars

-- Ratings for Student 85 (Genesis Hughes)
(85, 33, 4), -- Rated "Game Development Basics" with 4 stars
(85, 35, 5), -- Rated "Unreal Engine Crash Course" with 5 stars

-- Ratings for Student 86 (Adam Flores)
(86, 37, 5), -- Rated "DevOps Fundamentals" with 5 stars
(86, 39, 4), -- Rated "Kubernetes Essentials" with 4 stars

-- Ratings for Student 87 (Emilia Washington)
(87, 41, 3), -- Rated "Data Structures and Algorithms" with 3 stars

-- Ratings for Student 88 (Xavier Butler)
(88, 43, 5), -- Rated "Graph Algorithms" with 5 stars

-- Ratings for Student 89 (Caroline Simmons)
(89, 45, 4), -- Rated "Public Speaking Basics" with 4 stars

-- Ratings for Student 90 (Ian Foster)
(90, 47, 5), -- Rated "Leadership Skills" with 5 stars

-- Ratings for Student 91 (Nevaeh Gonzales)
(91, 2, 5), -- Rated "Web Development Basics" with 5 stars
(91, 4, 4), -- Rated "Database Design" with 4 stars
(91, 6, 5), -- Rated "Data Science Fundamentals" with 5 stars

-- Ratings for Student 92 (Elias Bryant)
(92, 8, 3), -- Rated "AI and Ethics" with 3 stars
(92, 10, 5), -- Rated "UI/UX Design" with 5 stars

-- Ratings for Student 93 (Ruby Alexander)
(93, 12, 4), -- Rated "Illustrator for Beginners" with 4 stars

-- Ratings for Student 94 (Tristan Russell)
(94, 14, 3), -- Rated "Flutter Basics" with 3 stars
(94, 16, 5), -- Rated "Swift for iOS Development" with 5 stars

-- Ratings for Student 95 (Piper Griffin)
(95, 18, 5), -- Rated "SEO for Beginners" with 5 stars
(95, 20, 4), -- Rated "Content Marketing" with 4 stars

-- Ratings for Student 96 (Jason Diaz)
(96, 22, 4), -- Rated "Ethical Hacking" with 4 stars
(96, 24, 5), -- Rated "Penetration Testing" with 5 stars

-- Ratings for Student 97 (Eva Hayes)
(97, 26, 5), -- Rated "AWS Fundamentals" with 5 stars

-- Ratings for Student 98 (Cameron Myers)
(98, 28, 3), -- Rated "Google Cloud Essentials" with 3 stars
(98, 30, 4), -- Rated "Cryptocurrency 101" with 4 stars

-- Ratings for Student 99 (Luna Ford)
(99, 32, 5), -- Rated "Ethereum Development" with 5 stars

-- Ratings for Student 100 (Kevin Hamilton)
(100, 34, 4), -- Rated "Unity for Beginners" with 4 stars
(100, 36, 5); -- Rated "2D Game Design" with 5 stars



-- Course 1: "Introduction to Programming"
INSERT INTO courses_tags (course_id, tag_id) VALUES
(1, 1), -- Beginner
(1, 4), -- Web Development
(1, 27), -- Database Management

-- Course 2: "Web Development Basics"
(2, 1), -- Beginner
(2, 4), -- Web Development
(2, 30), -- UI/UX Design

-- Course 3: "Advanced JavaScript"
(3, 3), -- Advanced
(3, 4), -- Web Development
(3, 24), -- Artificial Intelligence

-- Course 4: "Database Design"
(4, 2), -- Intermediate
(4, 27), -- Database Management

-- Course 5: "Python for Beginners"
(5, 1), -- Beginner
(5, 5), -- Data Science
(5, 6), -- Machine Learning

-- Course 6: "Data Science Fundamentals"
(6, 2), -- Intermediate
(6, 5), -- Data Science
(6, 6), -- Machine Learning

-- Course 7: "Machine Learning Basics"
(7, 2), -- Intermediate
(7, 6), -- Machine Learning
(7, 24), -- Artificial Intelligence

-- Course 8: "AI and Ethics"
(8, 3), -- Advanced
(8, 24), -- Artificial Intelligence

-- Course 9: "Graphic Design Basics"
(9, 1), -- Beginner
(9, 13), -- Painting
(9, 30), -- UI/UX Design

-- Course 10: "UI/UX Design"
(10, 2), -- Intermediate
(10, 30), -- UI/UX Design

-- Course 11: "Advanced Photoshop"
(11, 3), -- Advanced
(11, 13), -- Painting
(11, 14), -- Sculpture

-- Course 12: "Illustrator for Beginners"
(12, 1), -- Beginner
(12, 13), -- Painting
(12, 30), -- UI/UX Design

-- Course 13: "Mobile App Development"
(13, 2), -- Intermediate
(13, 25), -- Mobile Development

-- Course 14: "Flutter Basics"
(14, 1), -- Beginner
(14, 25), -- Mobile Development

-- Course 15: "React Native Crash Course"
(15, 2), -- Intermediate
(15, 25), -- Mobile Development

-- Course 16: "Swift for iOS Development"
(16, 2), -- Intermediate
(16, 25), -- Mobile Development

-- Course 17: "Digital Marketing Basics"
(17, 1), -- Beginner
(17, 20), -- Marketing

-- Course 18: "SEO for Beginners"
(18, 1), -- Beginner
(18, 20), -- Marketing

-- Course 19: "Social Media Marketing"
(19, 2), -- Intermediate
(19, 20), -- Marketing

-- Course 20: "Content Marketing"
(20, 2), -- Intermediate
(20, 20), -- Marketing

-- Course 21: "Cybersecurity Basics"
(21, 1), -- Beginner
(21, 23), -- Cybersecurity

-- Course 22: "Ethical Hacking"
(22, 3), -- Advanced
(22, 23), -- Cybersecurity

-- Course 23: "Network Security"
(23, 2), -- Intermediate
(23, 23), -- Cybersecurity
(23, 29), -- Networking

-- Course 24: "Penetration Testing"
(24, 3), -- Advanced
(24, 23), -- Cybersecurity

-- Course 25: "Cloud Computing Basics"
(25, 1), -- Beginner
(25, 28), -- Cloud Computing

-- Course 26: "AWS Fundamentals"
(26, 2), -- Intermediate
(26, 28), -- Cloud Computing

-- Course 27: "Azure for Beginners"
(27, 1), -- Beginner
(27, 28), -- Cloud Computing

-- Course 28: "Google Cloud Essentials"
(28, 2), -- Intermediate
(28, 28), -- Cloud Computing

-- Course 29: "Blockchain Basics"
(29, 1), -- Beginner
(29, 24), -- Artificial Intelligence

-- Course 30: "Cryptocurrency 101"
(30, 2), -- Intermediate
(30, 24), -- Artificial Intelligence

-- Course 31: "Smart Contracts"
(31, 3), -- Advanced
(31, 24), -- Artificial Intelligence

-- Course 32: "Ethereum Development"
(32, 3), -- Advanced
(32, 24), -- Artificial Intelligence

-- Course 33: "Game Development Basics"
(33, 1), -- Beginner
(33, 26), -- Game Development

-- Course 34: "Unity for Beginners"
(34, 1), -- Beginner
(34, 26), -- Game Development

-- Course 35: "Unreal Engine Crash Course"
(35, 2), -- Intermediate
(35, 26), -- Game Development

-- Course 36: "2D Game Design"
(36, 2), -- Intermediate
(36, 26), -- Game Development

-- Course 37: "DevOps Fundamentals"
(37, 2), -- Intermediate
(37, 28), -- Cloud Computing

-- Course 38: "Docker for Beginners"
(38, 1), -- Beginner
(38, 28), -- Cloud Computing

-- Course 39: "Kubernetes Essentials"
(39, 2), -- Intermediate
(39, 28), -- Cloud Computing

-- Course 40: "CI/CD Pipelines"
(40, 3), -- Advanced
(40, 28), -- Cloud Computing

-- Course 41: "Data Structures and Algorithms"
(41, 2), -- Intermediate
(41, 7), -- Algebra
(41, 8), -- Calculus

-- Course 42: "Dynamic Programming"
(42, 3), -- Advanced
(42, 7), -- Algebra
(42, 8), -- Calculus

-- Course 43: "Graph Algorithms"
(43, 3), -- Advanced
(43, 7), -- Algebra
(43, 8), -- Calculus

-- Course 44: "Competitive Programming"
(44, 3), -- Advanced
(44, 7), -- Algebra
(44, 8), -- Calculus

-- Course 45: "Public Speaking Basics"
(45, 1), -- Beginner
(45, 18), -- Non-Fiction

-- Course 46: "Effective Communication"
(46, 2), -- Intermediate
(46, 18), -- Non-Fiction

-- Course 47: "Leadership Skills"
(47, 2), -- Intermediate
(47, 19), -- Entrepreneurship

-- Course 48: "Time Management"
(48, 1), -- Beginner
(48, 19); -- Entrepreneurship