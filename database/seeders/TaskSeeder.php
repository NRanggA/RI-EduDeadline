<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lecturer1 = User::where('nim', 'D001')->first();
        $lecturer2 = User::where('nim', 'D002')->first();
        $lecturer3 = User::where('nim', 'D003')->first();
        $lecturer4 = User::where('nim', 'D004')->first();
        $lecturer5 = User::where('nim', 'D005')->first();

        // Course 1: Pemrograman Web Lanjut (IS301)
        $course1 = Course::where('code', 'IS301')->first();
        Task::create([
            'title' => 'Buat Aplikasi CRUD dengan Laravel',
            'description' => 'Buatlah aplikasi CRUD lengkap menggunakan Laravel dengan fitur login, validasi form, pagination, dan soft delete.',
            'course_id' => $course1->id,
            'deadline' => Carbon::now()->addDays(10),
            'priority' => 'urgent',
            'attachment_path' => '/attachments/laravel-crud-requirements.pdf',
            'status' => 'pending',
            'created_by' => $lecturer1->id,
            'notes' => 'Gunakan database MySQL, Eloquent ORM, dan repository pattern. Sertakan unit tests minimal 80% coverage.',
        ]);

        Task::create([
            'title' => 'Implementasi API REST dengan JWT',
            'description' => 'Buatlah API REST yang dilengkapi dengan JWT authentication, role-based access control, dan rate limiting.',
            'course_id' => $course1->id,
            'deadline' => Carbon::now()->addDays(14),
            'priority' => 'normal',
            'attachment_path' => '/attachments/api-requirements.pdf',
            'status' => 'pending',
            'created_by' => $lecturer1->id,
            'notes' => 'Dokumentasi API harus lengkap dengan Swagger/OpenAPI. Implement middleware dan validation rules yang ketat.',
        ]);

        Task::create([
            'title' => 'Deployment Aplikasi ke Cloud',
            'description' => 'Deploy aplikasi Laravel Anda ke AWS atau Heroku dengan setup CI/CD pipeline menggunakan GitHub Actions atau GitLab CI.',
            'course_id' => $course1->id,
            'deadline' => Carbon::now()->addDays(7),
            'priority' => 'urgent',
            'attachment_path' => null,
            'status' => 'pending',
            'created_by' => $lecturer1->id,
            'notes' => 'Sertakan dokumentasi setup, environment configuration, dan troubleshooting guide. Domain harus HTTPS.',
        ]);

        Task::create([
            'title' => 'Refactoring Code dan Code Review',
            'description' => 'Lakukan refactoring pada project sebelumnya untuk meningkatkan readability, maintainability, dan performance.',
            'course_id' => $course1->id,
            'deadline' => Carbon::now()->addDays(21),
            'priority' => 'normal',
            'attachment_path' => null,
            'status' => 'pending',
            'created_by' => $lecturer1->id,
            'notes' => 'Gunakan design patterns yang tepat. Dokumentasi perubahan dan improvement yang dilakukan dalam bentuk pull request.',
        ]);

        // Course 2: Basis Data (IS202)
        $course2 = Course::where('code', 'IS202')->first();
        Task::create([
            'title' => 'Desain ER Diagram dan Normalisasi',
            'description' => 'Buatlah ER diagram untuk sistem manajemen inventori dan lakukan normalisasi hingga BCNF (Boyce-Codd Normal Form).',
            'course_id' => $course2->id,
            'deadline' => Carbon::now()->addDays(5),
            'priority' => 'urgent',
            'attachment_path' => '/attachments/database-case-study.pdf',
            'status' => 'pending',
            'created_by' => $lecturer2->id,
            'notes' => 'Gunakan tools seperti Lucidchart, draw.io, atau MySQL Workbench. Jelaskan setiap tahap normalisasi.',
        ]);

        Task::create([
            'title' => 'Query Optimization dan Indexing',
            'description' => 'Optimalkan query-query yang lambat dan terapkan indexing yang tepat. Analisis query execution plan.',
            'course_id' => $course2->id,
            'deadline' => Carbon::now()->addDays(12),
            'priority' => 'normal',
            'attachment_path' => null,
            'status' => 'pending',
            'created_by' => $lecturer2->id,
            'notes' => 'Sertakan query execution plan, before-after comparison, dan analisis performance improvement.',
        ]);

        Task::create([
            'title' => 'Membuat Stored Procedure dan Trigger',
            'description' => 'Implementasikan stored procedures dan triggers untuk business logic kompleks dan data integrity.',
            'course_id' => $course2->id,
            'deadline' => Carbon::now()->addDays(18),
            'priority' => 'normal',
            'attachment_path' => null,
            'status' => 'pending',
            'created_by' => $lecturer2->id,
            'notes' => 'Minimal 3 stored procedures dan 2 triggers. Dokumentasi clear tentang fungsi dan use case masing-masing.',
        ]);

        // Course 3: Algoritma dan Struktur Data (IS101)
        $course3 = Course::where('code', 'IS101')->first();
        Task::create([
            'title' => 'Implementasi Binary Search Tree',
            'description' => 'Implementasikan BST dengan operasi insert, delete, search, dan traversal (inorder, preorder, postorder).',
            'course_id' => $course3->id,
            'deadline' => Carbon::now()->addDays(8),
            'priority' => 'urgent',
            'attachment_path' => '/attachments/bst-requirements.txt',
            'status' => 'pending',
            'created_by' => $lecturer3->id,
            'notes' => 'Analisis kompleksitas waktu untuk setiap operasi. Implementasi harus handle edge cases. Include test cases.',
        ]);

        Task::create([
            'title' => 'Sorting Algorithm Comparison',
            'description' => 'Implementasikan berbagai sorting algorithm dan bandingkan performanya berdasarkan ukuran input.',
            'course_id' => $course3->id,
            'deadline' => Carbon::now()->addDays(15),
            'priority' => 'normal',
            'attachment_path' => null,
            'status' => 'pending',
            'created_by' => $lecturer3->id,
            'notes' => 'Implementasikan minimal: Quick Sort, Merge Sort, Heap Sort, dan Counting Sort. Buatkan comparison chart.',
        ]);

        Task::create([
            'title' => 'Graph Traversal Algorithms',
            'description' => 'Implementasikan DFS (Depth First Search) dan BFS (Breadth First Search) serta aplikasinya.',
            'course_id' => $course3->id,
            'deadline' => Carbon::now()->addDays(22),
            'priority' => 'normal',
            'attachment_path' => null,
            'status' => 'pending',
            'created_by' => $lecturer3->id,
            'notes' => 'Implementasi untuk directed dan undirected graph. Jelaskan use case seperti shortest path dan topological sort.',
        ]);

        // Course 4: Pemrograman Mobile (IS304)
        $course4 = Course::where('code', 'IS304')->first();
        Task::create([
            'title' => 'Buat Todo App dengan Flutter',
            'description' => 'Buatlah aplikasi Todo dengan fitur add, edit, delete, mark complete, dan persistent local storage.',
            'course_id' => $course4->id,
            'deadline' => Carbon::now()->addDays(6),
            'priority' => 'urgent',
            'attachment_path' => '/attachments/flutter-requirements.pdf',
            'status' => 'pending',
            'created_by' => $lecturer1->id,
            'notes' => 'Gunakan Hive atau Sqflite untuk local storage. UI harus responsive dan mengikuti Material Design guidelines.',
        ]);

        Task::create([
            'title' => 'Integrasi dengan REST API',
            'description' => 'Integrasikan aplikasi Flutter dengan backend REST API untuk sync data dan user authentication.',
            'course_id' => $course4->id,
            'deadline' => Carbon::now()->addDays(20),
            'priority' => 'normal',
            'attachment_path' => null,
            'status' => 'pending',
            'created_by' => $lecturer1->id,
            'notes' => 'Implementasi error handling, loading states, dan offline mode. Gunakan Dio atau http package untuk API calls.',
        ]);

        // Course 5: Jaringan Komputer (IS205)
        $course5 = Course::where('code', 'IS205')->first();
        Task::create([
            'title' => 'Analisis Protokol Jaringan dengan Wireshark',
            'description' => 'Capture dan analisis traffic jaringan menggunakan Wireshark untuk memahami protokol TCP/IP dan aplikasi layer.',
            'course_id' => $course5->id,
            'deadline' => Carbon::now()->addDays(11),
            'priority' => 'normal',
            'attachment_path' => '/attachments/wireshark-lab.pdf',
            'status' => 'pending',
            'created_by' => $lecturer4->id,
            'notes' => 'Analisis minimal HTTP, DNS, dan DHCP traffic. Dokumentasi screenshot dan penjelasan lengkap setiap packet.',
        ]);

        Task::create([
            'title' => 'Konfigurasi Subnet dan Routing',
            'description' => 'Design network topology, konfigurasi subnetting, dan setup static routing untuk multiple networks.',
            'course_id' => $course5->id,
            'deadline' => Carbon::now()->addDays(16),
            'priority' => 'normal',
            'attachment_path' => null,
            'status' => 'pending',
            'created_by' => $lecturer4->id,
            'notes' => 'Gunakan Cisco Packet Tracer atau GNS3. Dokumentasi topology diagram dan routing table.',
        ]);

        // Course 6: Keamanan Sistem Informasi (IS401)
        $course6 = Course::where('code', 'IS401')->first();
        Task::create([
            'title' => 'Implementasi Enkripsi dan Hashing',
            'description' => 'Implementasikan berbagai metode enkripsi (AES, RSA) dan hashing (SHA256, bcrypt) dalam aplikasi.',
            'course_id' => $course6->id,
            'deadline' => Carbon::now()->addDays(13),
            'priority' => 'urgent',
            'attachment_path' => '/attachments/crypto-lab.pdf',
            'status' => 'pending',
            'created_by' => $lecturer5->id,
            'notes' => 'Demonstrasikan symmetric dan asymmetric encryption. Jelaskan use case dan security considerations.',
        ]);

        Task::create([
            'title' => 'Vulnerability Assessment dan Penetration Testing',
            'description' => 'Lakukan security assessment pada aplikasi web untuk menemukan vulnerabilities seperti SQL Injection, XSS, CSRF.',
            'course_id' => $course6->id,
            'deadline' => Carbon::now()->addDays(24),
            'priority' => 'normal',
            'attachment_path' => null,
            'status' => 'pending',
            'created_by' => $lecturer5->id,
            'notes' => 'Gunakan tools seperti Burp Suite, OWASP ZAP. Report harus include findings, risk level, dan remediation steps.',
        ]);
    }
}
