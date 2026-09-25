<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Category;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonCompletion;
use App\Models\Payment;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Review;
use App\Models\Section;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with toddler & early learning dataset without explicit ages.
     */
    public function run()
    {
        // 1. Create Core Users for KAN Early Learning
        $admin = User::create([
            'name' => 'Alexander Vance',
            'email' => 'admin@lms.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'headline' => 'Director of Early Learning & Academy Dean',
            'bio' => 'Overseeing early childhood pedagogy, interactive learning curriculum, and student safety.',
            'phone' => '+1 (555) 019-2831',
            'status' => 'active',
            'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=300&auto=format&fit=crop&q=80',
        ]);

        $instructor1 = User::create([
            'name' => 'Miss Sarah Jenkins',
            'email' => 'instructor@lms.com',
            'password' => Hash::make('password'),
            'role' => 'instructor',
            'headline' => 'Certified Early Childhood Educator & Sing-Along Specialist',
            'bio' => 'Passionate Montessori and play-based educator with 10+ years helping young minds discover phonics, numbers, and music.',
            'phone' => '+1 (555) 392-8172',
            'status' => 'active',
            'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=300&auto=format&fit=crop&q=80',
        ]);

        $instructor2 = User::create([
            'name' => 'Mr. Marcus Thorne',
            'email' => 'marcus@lms.com',
            'password' => Hash::make('password'),
            'role' => 'instructor',
            'headline' => 'Art & Creative Movement Instructor',
            'bio' => 'Specializing in playful finger painting, nature exploration, and joyful storytelling.',
            'phone' => '+1 (555) 847-1923',
            'status' => 'active',
            'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&auto=format&fit=crop&q=80',
        ]);

        $student1 = User::create([
            'name' => 'Elena Rostova',
            'email' => 'student@lms.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'headline' => 'Little Star Explorer',
            'bio' => 'Loves singing alphabet rhymes, coloring playful animals, and counting stars!',
            'phone' => '+1 (555) 482-9102',
            'status' => 'active',
            'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=300&auto=format&fit=crop&q=80',
        ]);

        $student2 = User::create([
            'name' => 'David Kim',
            'email' => 'david@lms.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'headline' => 'Junior Dinosaur & Jungle Explorer',
            'status' => 'active',
            'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=300&auto=format&fit=crop&q=80',
        ]);

        $student3 = User::create([
            'name' => 'Maya Patel',
            'email' => 'maya@lms.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'headline' => 'Little Artist & Music Lover',
            'status' => 'active',
            'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=300&auto=format&fit=crop&q=80',
        ]);

        // 2. Create Early Learning Categories (NO age numbers)
        $catPhonics = Category::create([
            'name' => 'Phonics & ABCs',
            'slug' => 'phonics-abcs',
            'icon' => 'book-open',
            'description' => 'Alphabet recognition, letter sounds, rhyming songs, and phonemic awareness.',
            'is_active' => true,
        ]);

        $catNumbers = Category::create([
            'name' => 'Numbers & Counting',
            'slug' => 'numbers-counting',
            'icon' => 'hash',
            'description' => 'Number recognition, counting games, basic shapes, and playful pattern matching.',
            'is_active' => true,
        ]);

        $catArts = Category::create([
            'name' => 'Colors & Creative Arts',
            'slug' => 'colors-creative-arts',
            'icon' => 'palette',
            'description' => 'Rainbow colors, finger painting, craft activities, and fine motor skills.',
            'is_active' => true,
        ]);

        $catAnimals = Category::create([
            'name' => 'Animal Safari & Nature',
            'slug' => 'animal-safari-nature',
            'icon' => 'sparkles',
            'description' => 'Discover friendly animals, safari habitats, ocean creatures, and nature sounds.',
            'is_active' => true,
        ]);

        $catMusic = Category::create([
            'name' => 'Nursery Rhymes & Music',
            'slug' => 'nursery-rhymes-music',
            'icon' => 'music',
            'description' => 'Joyful sing-along nursery rhymes, rhythm games, and creative movement.',
            'is_active' => true,
        ]);

        // 3. Create Course 1: Phonics & ABC Alphabet Sing-Along Fun (Paid)
        $course1 = Course::create([
            'instructor_id' => $instructor1->id,
            'category_id' => $catPhonics->id,
            'title' => 'Phonics & ABC Alphabet Sing-Along Fun',
            'slug' => 'phonics-abc-alphabet-sing-along-fun',
            'subtitle' => 'Sing joyful alphabet songs, master phonics letter sounds, and build early reading confidence with interactive story adventures.',
            'description' => "Welcome to the magical world of letters and phonics!
- Sing along with animated alphabet friends from A to Z.
- Master letter sounds and phonemic awareness through catchy nursery rhymes.
- Tracing and phonics games designed to spark curiosity.
- Fun interactive quizzes with instant star rewards!",
            'level' => 'all_levels',
            'language' => 'English',
            'price' => 19.99,
            'discount_price' => 14.99,
            'thumbnail' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=800&auto=format&fit=crop&q=80',
            'preview_video_url' => 'https://www.youtube.com/watch?v=hq3yfQnllfQ',
            'outcomes' => [
                'Recognize all 26 letters of the alphabet (Upper & Lower case)',
                'Master phonics letter sounds with cheerful sing-alongs',
                'Build early vocabulary with 100+ everyday words and objects',
                'Boost listening comprehension and rhythm coordination',
            ],
            'requirements' => [
                'No previous reading skills needed - designed for curious young learners',
                'Headphones or speakers for crystal clear sing-along audio',
            ],
            'status' => 'published',
            'is_featured' => true,
        ]);

        // Course 1 Sections & Lessons
        $c1_sec1 = Section::create(['course_id' => $course1->id, 'title' => 'Part 1: Alphabet Sing-Alongs (Letters A to M)', 'order' => 1]);
        $c1_l1 = Lesson::create([
            'section_id' => $c1_sec1->id,
            'title' => 'Singing the Alphabet Song & Letter A Fun',
            'slug' => 'singing-the-alphabet-song-letter-a-fun',
            'content_type' => 'video',
            'video_url' => 'https://www.youtube.com/watch?v=hq3yfQnllfQ',
            'article_content' => 'Let’s sing along! A is for Apple, B is for Butterfly, C is for Cat!',
            'duration_minutes' => 15,
            'order' => 1,
            'is_preview' => true,
            'is_published' => true,
        ]);
        $c1_l2 = Lesson::create([
            'section_id' => $c1_sec1->id,
            'title' => 'Phonics Letter Sounds: B, C, D & E',
            'slug' => 'phonics-letter-sounds-b-c-d-e',
            'content_type' => 'video',
            'video_url' => 'https://www.youtube.com/watch?v=hq3yfQnllfQ',
            'article_content' => 'Listen to the bouncing ball sound for B, crunchy carrot for C, drumming dance for D!',
            'duration_minutes' => 18,
            'order' => 2,
            'is_preview' => false,
            'is_published' => true,
        ]);
        $c1_l3 = Lesson::create([
            'section_id' => $c1_sec1->id,
            'title' => 'Letter Tracing & Rhyme Game (F to M)',
            'slug' => 'letter-tracing-rhyme-game-f-to-m',
            'content_type' => 'article',
            'video_url' => null,
            'article_content' => 'Trace letters with your magic finger in the air! Follow the bouncing star to draw straight lines and gentle curves.',
            'duration_minutes' => 12,
            'order' => 3,
            'is_preview' => false,
            'is_published' => true,
        ]);

        $c1_sec2 = Section::create(['course_id' => $course1->id, 'title' => 'Part 2: Phonics Fun & Letter Sounds (N to Z)', 'order' => 2]);
        $c1_l4 = Lesson::create([
            'section_id' => $c1_sec2->id,
            'title' => 'N to T Phonics Safari Tour',
            'slug' => 'n-to-t-phonics-safari-tour',
            'content_type' => 'video',
            'video_url' => 'https://www.youtube.com/watch?v=hq3yfQnllfQ',
            'article_content' => 'Explore the safari with N for Nest, O for Owl, P for Penguin, and Q for Queen Bee!',
            'duration_minutes' => 20,
            'order' => 1,
            'is_preview' => false,
            'is_published' => true,
        ]);
        $c1_l5 = Lesson::create([
            'section_id' => $c1_sec2->id,
            'title' => 'U to Z & The Grand ABC Star Finale',
            'slug' => 'u-to-z-grand-abc-star-finale',
            'content_type' => 'video',
            'video_url' => 'https://www.youtube.com/watch?v=hq3yfQnllfQ',
            'article_content' => 'You did it! Sing the grand celebration song from A all the way to Z and collect your shiny stars!',
            'duration_minutes' => 22,
            'order' => 2,
            'is_preview' => false,
            'is_published' => true,
        ]);

        // Course 1 Quiz
        $quiz1 = Quiz::create([
            'course_id' => $course1->id,
            'title' => 'Phonics & Alphabet Star Challenge',
            'description' => 'Listen and choose the matching letter and animal friend!',
            'pass_percentage' => 70,
            'time_limit_minutes' => 10,
            'order' => 1,
        ]);

        Question::create([
            'quiz_id' => $quiz1->id,
            'question_text' => 'Which letter makes the sound for "Apple" 🍎 and "Astronaut"?',
            'options' => ['Letter A', 'Letter B', 'Letter C', 'Letter D'],
            'correct_answer' => '0',
            'explanation' => 'Letter A makes the "Ah" sound for Apple and Astronaut!',
            'points' => 1,
            'order' => 1,
        ]);

        Question::create([
            'quiz_id' => $quiz1->id,
            'question_text' => 'Which friendly animal begins with the letter "B"?',
            'options' => ['Teddy Bear 🐻', 'Elephant 🐘', 'Giraffe 🦒', 'Octopus 🐙'],
            'correct_answer' => '0',
            'explanation' => 'Bear starts with the letter B! B-B-Bear!',
            'points' => 1,
            'order' => 2,
        ]);

        Question::create([
            'quiz_id' => $quiz1->id,
            'question_text' => 'How many letters are there in the English Alphabet song?',
            'options' => ['26 Letters', '10 Letters', '50 Letters', '5 Letters'],
            'correct_answer' => '0',
            'explanation' => 'There are 26 magical letters in the alphabet from A to Z!',
            'points' => 1,
            'order' => 3,
        ]);

        // Course 1 Assignment
        $assign1 = Assignment::create([
            'course_id' => $course1->id,
            'title' => 'Draw and Color Your Favorite Letter A Object 🍎',
            'description' => 'Draw a big colorful Apple, Astronaut, or Alligator on paper. Color it brightly and show off your artwork!',
            'points' => 100,
            'due_date' => now()->addDays(7),
            'status' => 'active',
        ]);

        // 4. Create Course 2: Numbers, Shapes & Counting Adventures (Paid)
        $course2 = Course::create([
            'instructor_id' => $instructor1->id,
            'category_id' => $catNumbers->id,
            'title' => 'Numbers, Shapes & Counting Adventures',
            'slug' => 'numbers-shapes-counting-adventures',
            'subtitle' => 'Count from 1 to 20 with friendly animals, build colorful shapes, and solve playful pattern puzzles.',
            'description' => "Math is an exciting playground!
- Count jumping frogs, smiling stars, and colorful toy blocks.
- Learn to identify circles, squares, triangles, and stars.
- Interactive pattern games that boost early logic and visual recognition.
- Printable activity sheets to practice number tracing.",
            'level' => 'all_levels',
            'language' => 'English',
            'price' => 14.99,
            'discount_price' => 9.99,
            'thumbnail' => 'https://images.unsplash.com/photo-1587654780291-39c9404d746b?w=800&auto=format&fit=crop&q=80',
            'preview_video_url' => 'https://www.youtube.com/watch?v=D0Ajq682yrA',
            'outcomes' => [
                'Count aloud from 1 to 20 with joyful songs',
                'Recognize primary shapes (Circle, Square, Triangle, Rectangle, Star)',
                'Understand concepts of bigger, smaller, more, and less',
                'Develop spatial awareness and sorting skills',
            ],
            'requirements' => [
                'No prior counting experience necessary',
                'Building blocks or counters for hands-on fun',
            ],
            'status' => 'published',
            'is_featured' => true,
        ]);

        $c2_sec1 = Section::create(['course_id' => $course2->id, 'title' => 'Part 1: Counting 1 to 10 with Animal Friends', 'order' => 1]);
        $c2_l1 = Lesson::create([
            'section_id' => $c2_sec1->id,
            'title' => 'Counting Numbers 1 through 5',
            'slug' => 'counting-numbers-1-through-5',
            'content_type' => 'video',
            'video_url' => 'https://www.youtube.com/watch?v=D0Ajq682yrA',
            'article_content' => '1 Little Star, 2 Friendly Bears, 3 Happy Kittens, 4 Flying Birds, 5 Jumping Frogs!',
            'duration_minutes' => 16,
            'order' => 1,
            'is_preview' => true,
            'is_published' => true,
        ]);
        $c2_l2 = Lesson::create([
            'section_id' => $c2_sec1->id,
            'title' => 'Shapes All Around Us (Circles, Squares & Stars)',
            'slug' => 'shapes-all-around-us',
            'content_type' => 'video',
            'video_url' => 'https://www.youtube.com/watch?v=D0Ajq682yrA',
            'article_content' => 'Spot shapes in everyday life! The clock is a circle, the window is a square, the star shines high.',
            'duration_minutes' => 18,
            'order' => 2,
            'is_preview' => false,
            'is_published' => true,
        ]);

        // Course 2 Assignment
        $assign2 = Assignment::create([
            'course_id' => $course2->id,
            'title' => 'Count and Draw 5 Smiling Sunflowers 🌻',
            'description' => 'Draw 5 bright yellow sunflowers with smiling faces on paper. Count each one out loud as you draw!',
            'points' => 100,
            'due_date' => now()->addDays(5),
            'status' => 'active',
        ]);

        // 5. Create Course 3: Colors, Finger Painting & Little Artists Studio (Free)
        $course3 = Course::create([
            'instructor_id' => $instructor2->id,
            'category_id' => $catArts->id,
            'title' => 'Colors, Finger Painting & Little Artists Studio',
            'slug' => 'colors-finger-painting-little-artists-studio',
            'subtitle' => 'Mix primary colors, paint vibrant rainbows, and create expressive art pieces with fun finger painting techniques.',
            'description' => "Unleash your inner artist in our creative color studio!
- Explore primary colors (Red, Blue, Yellow) and discover how they mix into Orange, Green, and Purple!
- Step-by-step finger painting and sponge stamping activities.
- Joyful creative freedom with downloadable coloring templates.
- Earn your official Little Artist Star Certificate!",
            'level' => 'all_levels',
            'language' => 'English',
            'price' => 0.00,
            'discount_price' => null,
            'thumbnail' => 'https://images.unsplash.com/photo-1513364776144-60967b0f800f?w=800&auto=format&fit=crop&q=80',
            'preview_video_url' => 'https://www.youtube.com/watch?v=SLZcWGQQsmg',
            'outcomes' => [
                'Name and distinguish all primary and secondary colors',
                'Understand hands-on color mixing (Blue + Yellow = Green!)',
                'Strengthen fine motor grip and finger dexterity',
                'Create joyful refrigerator-ready artwork masterpieces',
            ],
            'requirements' => [
                'Non-toxic washable finger paints or colored pencils',
                'Paper and paper towels for easy cleanup',
            ],
            'status' => 'published',
            'is_featured' => true,
        ]);

        $c3_sec1 = Section::create(['course_id' => $course3->id, 'title' => 'Part 1: The Rainbow Color Laboratory', 'order' => 1]);
        $c3_l1 = Lesson::create([
            'section_id' => $c3_sec1->id,
            'title' => 'Red, Yellow & Blue: The Primary Color Song',
            'slug' => 'primary-color-song',
            'content_type' => 'video',
            'video_url' => 'https://www.youtube.com/watch?v=SLZcWGQQsmg',
            'article_content' => 'Watch colors magically transform! When blue hugs yellow, green appears!',
            'duration_minutes' => 14,
            'order' => 1,
            'is_preview' => true,
            'is_published' => true,
        ]);
        $c3_l2 = Lesson::create([
            'section_id' => $c3_sec1->id,
            'title' => 'Painting a Colorful Butterfly with Finger Stamps',
            'slug' => 'painting-colorful-butterfly',
            'content_type' => 'video',
            'video_url' => 'https://www.youtube.com/watch?v=SLZcWGQQsmg',
            'article_content' => 'Use gentle thumbprints and finger taps to create symmetrical butterfly wings in bright rainbow shades.',
            'duration_minutes' => 18,
            'order' => 2,
            'is_preview' => false,
            'is_published' => true,
        ]);

        // Course 3 Assignment
        $assign3 = Assignment::create([
            'course_id' => $course3->id,
            'title' => 'Paint a Vibrant Rainbow Artwork 🌈',
            'description' => 'Use your crayons, markers, or paints to make a magical rainbow with Red, Orange, Yellow, Green, Blue, and Purple.',
            'points' => 100,
            'due_date' => now()->addDays(3),
            'status' => 'active',
        ]);

        // 6. Pre-Enroll Demo Student into Courses & Assignments
        
        // Student completed Course 3 (Colors & Little Artists) -> Issued Certificate
        Enrollment::create([
            'user_id' => $student1->id,
            'course_id' => $course3->id,
            'status' => 'completed',
            'enrolled_at' => now()->subDays(10),
            'completed_at' => now()->subDays(2),
        ]);

        LessonCompletion::create(['user_id' => $student1->id, 'lesson_id' => $c3_l1->id, 'completed_at' => now()->subDays(8)]);
        LessonCompletion::create(['user_id' => $student1->id, 'lesson_id' => $c3_l2->id, 'completed_at' => now()->subDays(2)]);

        Certificate::create([
            'user_id' => $student1->id,
            'course_id' => $course3->id,
            'certificate_code' => 'KAN-2026-ART89421',
            'issued_at' => now()->subDays(2),
        ]);

        // Graded Assignment Submission for Student 1 in Course 3
        AssignmentSubmission::create([
            'assignment_id' => $assign3->id,
            'user_id' => $student1->id,
            'submission_text' => 'I painted a big happy rainbow with finger stamps and yellow sunshine!',
            'file_path' => 'https://images.unsplash.com/photo-1513364776144-60967b0f800f?w=800&auto=format&fit=crop&q=80',
            'score' => 98,
            'grade' => '⭐⭐⭐ Super Star!',
            'feedback' => 'Incredible rainbow painting, Elena! Your colors are so bright and cheerful. Super star work! 🌈',
            'status' => 'graded',
            'graded_by' => $instructor2->id,
            'graded_at' => now()->subDays(1),
        ]);

        // Student is actively enrolled in Course 1 (Phonics) with progress
        Enrollment::create([
            'user_id' => $student1->id,
            'course_id' => $course1->id,
            'status' => 'active',
            'enrolled_at' => now()->subDays(5),
        ]);

        LessonCompletion::create(['user_id' => $student1->id, 'lesson_id' => $c1_l1->id, 'completed_at' => now()->subDays(4)]);
        LessonCompletion::create(['user_id' => $student1->id, 'lesson_id' => $c1_l2->id, 'completed_at' => now()->subDays(3)]);
        LessonCompletion::create(['user_id' => $student1->id, 'lesson_id' => $c1_l3->id, 'completed_at' => now()->subDays(1)]);

        // Pending Assignment Submission for Student 1 in Course 1
        AssignmentSubmission::create([
            'assignment_id' => $assign1->id,
            'user_id' => $student1->id,
            'submission_text' => 'I colored letter A with apples and smiling bears!',
            'file_path' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=800&auto=format&fit=crop&q=80',
            'status' => 'submitted',
        ]);

        // Quiz attempt for Student in Course 1
        $questions1 = $quiz1->questions()->orderBy('order')->get();
        QuizAttempt::create([
            'quiz_id' => $quiz1->id,
            'user_id' => $student1->id,
            'score' => 3,
            'total_points' => 3,
            'percentage' => 100.00,
            'is_passed' => true,
            'user_answers' => [
                $questions1[0]->id => 0,
                $questions1[1]->id => 0,
                $questions1[2]->id => 0,
            ],
            'completed_at' => now()->subDays(1),
        ]);

        // Payment record for Course 1
        Payment::create([
            'user_id' => $student1->id,
            'course_id' => $course1->id,
            'transaction_id' => 'TXN-KAN-78921',
            'amount' => 14.99,
            'currency' => 'USD',
            'payment_method' => 'card',
            'status' => 'completed',
            'payload' => ['cardholder' => 'Elena Rostova', 'brand' => 'Visa', 'last4' => '4242'],
            'created_at' => now()->subDays(5),
        ]);

        // Reviews
        Review::create([
            'user_id' => $student1->id,
            'course_id' => $course1->id,
            'rating' => 5,
            'comment' => 'My little one loves the ABC songs so much! Sings them every morning and knows all letter sounds now!',
            'created_at' => now()->subDays(1),
        ]);

        Review::create([
            'user_id' => $student2->id,
            'course_id' => $course1->id,
            'rating' => 5,
            'comment' => 'Wonderful educational videos, catchy rhymes, and very engaging colorful animations.',
            'created_at' => now()->subDays(2),
        ]);
    }
}
