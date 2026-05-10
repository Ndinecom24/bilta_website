<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminAndDemoSeeder extends Seeder
{
    private const CREATED_AT_EXPR = 'COALESCE(created_at, NOW())';
    private const ABOUT_TEXT_MAX = 191;

    public function run()
    {
        $now = now();

        $this->seedStatuses($now);
        $activeStatusId = DB::table('statuses')->where('slug', 'active')->value('id') ?: 1;

        $adminId = $this->seedAdminUsers($activeStatusId, $now);

        // Assign roles to seeded users (roles must be seeded first or already exist)
        $this->assignUserRoles();

        $this->seedCorePages($adminId, $now);
        $this->seedServicesAndValues($adminId, $now);
        $this->seedFaqs($adminId, $now);

        [$projectCategoryId, $newsCategoryId] = $this->seedCategories($activeStatusId, $adminId, $now);

        $this->seedTeams($adminId, $now);
        $this->seedProjects($projectCategoryId, $activeStatusId, $adminId, $now);
        $this->seedAudioFiles($activeStatusId, $adminId, $now);
        $this->seedNews($newsCategoryId, $activeStatusId, $adminId, $now);
        $this->seedChairmanMessage($activeStatusId, $adminId, $now);
        $this->seedSponsors($activeStatusId, $adminId, $now);
        $this->seedTestimonials($activeStatusId, $adminId, $now);
    }

    private function seedStatuses($now): void
    {
        $statuses = [
            ['name' => 'Active', 'slug' => 'active'],
            ['name' => 'Inactive', 'slug' => 'inactive'],
            ['name' => 'Pending', 'slug' => 'pending'],
            ['name' => 'Approved', 'slug' => 'approved'],
        ];

        foreach ($statuses as $status) {
            DB::table('statuses')->updateOrInsert(
                ['slug' => $status['slug']],
                [
                    'name' => $status['name'],
                    'slug' => $status['slug'],
                    'updated_at' => $now,
                    'created_at' => DB::raw(self::CREATED_AT_EXPR),
                    'deleted_at' => null,
                ]
            );
        }
    }

    private function seedAdminUsers(int $activeStatusId, $now): int
    {
        $adminUsers = [
            [
                'name' => 'BiLTA Super Admin',
                'email' => 'admin@bilta.org',
                'phone' => '+260977000001',
                'password' => 'Admin@12345',
            ],
            [
                'name' => 'BiLTA Content Manager',
                'email' => 'content@bilta.org',
                'phone' => '+260977000002',
                'password' => 'Content@12345',
            ],
        ];

        foreach ($adminUsers as $adminUser) {
            DB::table('users')->updateOrInsert(
                ['email' => $adminUser['email']],
                [
                    'name' => $adminUser['name'],
                    'email' => $adminUser['email'],
                    'phone' => $adminUser['phone'],
                    'uuid' => (string) Str::uuid(),
                    'status_id' => $activeStatusId,
                    'password' => Hash::make($adminUser['password']),
                    'updated_at' => $now,
                    'created_at' => DB::raw(self::CREATED_AT_EXPR),
                    'deleted_at' => null,
                ]
            );
        }

        return DB::table('users')->where('email', 'admin@bilta.org')->value('id') ?: 1;
    }

    private function seedCorePages(int $adminId, $now): void
    {
        DB::table('about_us')->updateOrInsert(
            ['id' => 1],
            [
                'mission' => Str::limit('To serve God through the translation of scriptures and essential literature into heart languages for their accessibility and transformation of lives. Acts 2:6-8, mt 28:19-20', self::ABOUT_TEXT_MAX, ''),
                'vision' => Str::limit('To be a transformative force by equipping translators to make scripture and essential literature accessible in every heart language.  ', self::ABOUT_TEXT_MAX, ''),
                'objective' => Str::limit("* To mobilise and build capacity of the local people for Bible translation.\n* Seek to promote the use of the local language in the dissemination of the word of God by embracing the use of other languages\n* To promote literacy and education through production of all types of materials such as newsletters, books, magazines, and videos in the local language.\n", self::ABOUT_TEXT_MAX, ''),
                'description' => Str::limit('BiLTA has a constitution and is registered with the Registrar of Societies in Zambia as a charitable organisation aimed at empowering communities to translate the word of God and other literatures into their own language.', self::ABOUT_TEXT_MAX, ''),
                'who_we_are' => Str::limit("The Bible and Literature Translation Association (BiLTA) was established in 2019. It is a dedicated translation association committed to advancing the translation of the Bible and other essential literature works into local languages. \n", self::ABOUT_TEXT_MAX, ''),
                'what_is' => Str::limit('BiLTA is an acronym standing for “Bible and Literature Translation Association.”In 2012, it was first called Senga Bible and Literature Translation Association (SBLTA), however in January 2021, its name changed to BiLTA so that other language groups could be helped with the translation work of their languages.', self::ABOUT_TEXT_MAX, ''),
                'created_by' => $adminId,
                'updated_at' => $now,
                'created_at' => DB::raw(self::CREATED_AT_EXPR),
                'deleted_at' => null,
            ]
        );

        DB::table('contact_us')->updateOrInsert(
            ['id' => 1],
            [
                'phone' => '(+260) 977 539 067',
                'email' => 'info@bilta.org',
                'address' => 'Plot 324, Flat 2, Bauhinia Avenue, Chelston, Lusaka, Zambia',
                'message' => 'We are passionate about translating Scripture and literature into local languages.',
                'google_maps' => 'https://www.google.com/maps?q=Chelston,+Lusaka,+Zambia&output=embed',
                'created_by' => $adminId,
                'facebook_url' => 'https://www.facebook.com/biltazambia',
                'linkedin_url' => 'https://www.linkedin.com/company/bilta',
                'twitter_url' => 'https://x.com/bilta',
                'youtube' => 'https://www.youtube.com/@SengaBible',
                'whatsapp_link' => 'https://wa.me/260977539067',
                'updated_at' => $now,
                'created_at' => DB::raw(self::CREATED_AT_EXPR),
                'deleted_at' => null,
            ]
        );

        DB::table('home_intros')->updateOrInsert(
            ['id' => 1],
            [
                'name' => 'Welcome to BiLTA',
                'short_description' => 'Bible and Literature Translation Association',
                'long_description' => 'BiLTA advances Bible translation, literacy development, and Scripture access in local languages.',
                'created_by' => $adminId,
                'updated_at' => $now,
                'created_at' => DB::raw(self::CREATED_AT_EXPR),
                'deleted_at' => null,
            ]
        );
    }

    private function seedServicesAndValues(int $adminId, $now): void
    {
        $services = [
            ['title' => 'Bible Translation', 'description' => 'Translation of Scripture portions and full Bible books into local languages.'],
            ['title' => 'Literacy Development', 'description' => 'Community literacy programs to improve reading and Scripture engagement.'],
            ['title' => 'Audio Scripture', 'description' => 'Production and distribution of audio Bible resources in local languages.'],
            ['title' => 'Church Partnerships', 'description' => 'Equipping churches with translated and contextual discipleship materials.'],
        ];

        foreach ($services as $service) {
            DB::table('our_services')->updateOrInsert(
                ['title' => $service['title']],
                [
                    'description' => $service['description'],
                    'created_by' => $adminId,
                    'updated_at' => $now,
                    'created_at' => DB::raw(self::CREATED_AT_EXPR),
                    'deleted_at' => null,
                ]
            );
        }

        $values = [
            ['title' => 'Faithfulness', 'description' => 'We serve with biblical integrity and commitment to truth.'],
            ['title' => 'Collaboration', 'description' => 'We work with churches, communities, and ministry partners.'],
            ['title' => 'Excellence', 'description' => 'We pursue quality in translation, publishing, and discipleship resources.'],
            ['title' => 'Stewardship', 'description' => 'We use resources responsibly for long-term ministry impact.'],
        ];

        foreach ($values as $value) {
            DB::table('our_values')->updateOrInsert(
                ['title' => $value['title']],
                [
                    'description' => $value['description'],
                    'created_by' => $adminId,
                    'updated_at' => $now,
                    'created_at' => DB::raw(self::CREATED_AT_EXPR),
                    'deleted_at' => null,
                ]
            );
        }
    }

    private function seedFaqs(int $adminId, $now): void
    {
        $faqs = [
            ['question' => 'What does BiLTA do?', 'answer' => 'BiLTA translates Bible and literature into local languages for church and community use.'],
            ['question' => 'How can I partner with BiLTA?', 'answer' => 'You can partner through prayer, donations, volunteering, or institutional collaboration.'],
            ['question' => 'Where does BiLTA work?', 'answer' => 'BiLTA serves language communities in Zambia and surrounding regions through local partnerships.'],
        ];

        foreach ($faqs as $faq) {
            DB::table('f_a_qs')->updateOrInsert(
                ['question' => $faq['question']],
                [
                    'answer' => $faq['answer'],
                    'created_by' => $adminId,
                    'updated_at' => $now,
                    'created_at' => DB::raw(self::CREATED_AT_EXPR),
                    'deleted_at' => null,
                ]
            );
        }
    }

    private function seedCategories(int $activeStatusId, int $adminId, $now): array
    {
        $categories = [
            ['name' => 'Translation Projects', 'description' => 'Language translation project updates.', 'type' => 'projects'],
            ['name' => 'Literacy Programs', 'description' => 'Literacy and Scripture engagement updates.', 'type' => 'projects'],
            ['name' => 'News & Updates', 'description' => 'Official BiLTA news and announcements.', 'type' => 'news'],
            ['name' => 'Field Reports', 'description' => 'Reports from translation and ministry teams.', 'type' => 'news'],
        ];

        foreach ($categories as $category) {
            DB::table('item_categories')->updateOrInsert(
                ['name' => $category['name'], 'type' => $category['type']],
                [
                    'description' => $category['description'],
                    'status_id' => $activeStatusId,
                    'created_by' => $adminId,
                    'updated_at' => $now,
                    'created_at' => DB::raw(self::CREATED_AT_EXPR),
                ]
            );
        }

        $projectCategoryId = DB::table('item_categories')->where('type', 'projects')->value('id') ?: 1;
        $newsCategoryId = DB::table('item_categories')->where('type', 'news')->value('id') ?: $projectCategoryId;

        return [$projectCategoryId, $newsCategoryId];
    }

    private function seedTeams(int $adminId, $now): void
    {
        $teams = [
            [
                'name' => 'Rev. John Banda',
                'phone' => '+260977101001',
                'email' => 'john.banda@bilta.org',
                'details' => 'Leads translation strategy and partner engagement across field teams.',
                'position' => 'Executive Director',
            ],
            [
                'name' => 'Mary Phiri',
                'phone' => '+260977101002',
                'email' => 'mary.phiri@bilta.org',
                'details' => 'Coordinates literacy and Scripture engagement initiatives.',
                'position' => 'Programs Manager',
            ],
            [
                'name' => 'Peter Zulu',
                'phone' => '+260977101003',
                'email' => 'peter.zulu@bilta.org',
                'details' => 'Supports language survey, drafting, and quality checks.',
                'position' => 'Translation Consultant',
            ],
        ];

        foreach ($teams as $index => $team) {
            DB::table('our_teams')->updateOrInsert(
                ['email' => $team['email']],
                [
                    'name' => $team['name'],
                    'phone' => $team['phone'],
                    'email' => $team['email'],
                    'details' => $team['details'],
                    'position' => $team['position'],
                    'display_order' => $index + 1,
                    'from' => now()->subYears(2),
                    'to' => null,
                    'facebook_url' => 'https://facebook.com',
                    'linkedin_url' => 'https://linkedin.com',
                    'twitter_url' => 'https://x.com',
                    'created_by' => $adminId,
                    'updated_at' => $now,
                    'created_at' => DB::raw(self::CREATED_AT_EXPR),
                    'deleted_at' => null,
                ]
            );
        }
    }

    private function seedProjects(int $projectCategoryId, int $activeStatusId, int $adminId, $now): void
    {
        $projects = [
            [
                'title' => 'Senga New Testament Translation',
                'short_description' => 'Advancing New Testament translation for Senga-speaking communities.',
                'details' => 'This project supports drafting, checking, and community testing for the Senga New Testament.',
                'location' => 'Eastern Province, Zambia',
            ],
            [
                'title' => 'Nsenga Literacy Starter Program',
                'short_description' => 'Literacy primers and reading circles for local church communities.',
                'details' => 'BiLTA runs literacy clubs that help communities read translated Scripture confidently.',
                'location' => 'Lusaka & Eastern Region',
            ],
            [
                'title' => 'Audio Gospel Distribution Initiative',
                'short_description' => 'Recording and sharing Scripture audio for underserved listeners.',
                'details' => 'The audio initiative produces high-quality local-language recordings and community listening sessions.',
                'location' => 'Multiple Districts',
            ],
        ];

        foreach ($projects as $index => $project) {
            DB::table('projects')->updateOrInsert(
                ['title' => $project['title']],
                [
                    'short_description' => $project['short_description'],
                    'post_date' => $now->toDateString(),
                    'author' => 'BiLTA Team',
                    'details' => $project['details'],
                    'location' => $project['location'],
                    'location_map' => 'https://www.google.com/maps?q=Lusaka,+Zambia&output=embed',
                    'created_by' => $adminId,
                    'status_id' => $activeStatusId,
                    'category_id' => $projectCategoryId,
                    'display_order' => $index + 1,
                    'updated_at' => $now,
                    'created_at' => DB::raw(self::CREATED_AT_EXPR),
                    'deleted_at' => null,
                ]
            );
        }
    }

    private function seedNews(int $newsCategoryId, int $activeStatusId, int $adminId, $now): void
    {
        $newsItems = [
            [
                'title' => 'BiLTA Launches New Translation Cluster',
                'short_description' => 'A new cluster project begins to accelerate local-language Scripture access.',
                'details' => 'BiLTA has launched a new translation cluster with partner churches and language leaders.',
            ],
            [
                'title' => 'Community Literacy Trainings Expanded',
                'short_description' => 'Literacy facilitator training expanded to additional districts.',
                'details' => 'More trainers have been equipped to support sustainable reading programs in churches.',
            ],
            [
                'title' => 'Audio Scripture Pilot Report Released',
                'short_description' => 'Pilot feedback shows increased engagement through audio Scripture.',
                'details' => 'Initial pilot communities report strong uptake and improved Scripture engagement outcomes.',
            ],
        ];

        foreach ($newsItems as $index => $newsItem) {
            DB::table('news_item')->updateOrInsert(
                ['title' => $newsItem['title']],
                [
                    'short_description' => $newsItem['short_description'],
                    'post_date' => $now->toDateString(),
                    'author' => 'BiLTA Communications',
                    'details' => $newsItem['details'],
                    'created_by' => $adminId,
                    'status_id' => $activeStatusId,
                    'category_id' => $newsCategoryId,
                    'display_order' => $index + 1,
                    'updated_at' => $now,
                    'created_at' => DB::raw(self::CREATED_AT_EXPR),
                    'deleted_at' => null,
                ]
            );
        }
    }

    private function seedAudioFiles(int $activeStatusId, int $adminId, $now): void
    {
        $projectId = DB::table('projects')->where('title', 'Senga New Testament Translation')->value('id') ?: 5;
        $audioTitle = 'Senga Audio Bible';

        $audioFiles = [
            [
                'title' => $audioTitle,
                'description' => 'Luke 1 vs 1-4',
                'file_url' => 'Luke_001_01-04__SGQPITP1DA.mp3',
            ],
            [
                'title' => $audioTitle,
                'description' => 'Luke 1 vs 5-25',
                'file_url' => 'Luke_001_05-25__SGQPITP1DA.mp3',
            ],
            [
                'title' => $audioTitle,
                'description' => 'Luke 1 vs 26-38',
                'file_url' => 'Luke_001_26-38__SGQPITP1DA.mp3',
            ],
        ];

        foreach ($audioFiles as $audioFile) {
            DB::table('audio_files')->updateOrInsert(
                ['file_url' => $audioFile['file_url']],
                [
                    'title' => $audioFile['title'],
                    'description' => $audioFile['description'],
                    'status_id' => $activeStatusId,
                    'project_id' => $projectId,
                    'created_by' => $adminId,
                    'updated_at' => $now,
                    'created_at' => DB::raw(self::CREATED_AT_EXPR),
                ]
            );
        }
    }

    private function seedChairmanMessage(int $activeStatusId, int $adminId, $now): void
    {
        $chairmanMessage = <<<'HTML'
    <div style="font-family: 'Times New Roman', serif; font-size: 16px; line-height: 1.6; color: #000;"> <p style="text-align: center; font-size: 20px; font-weight: bold; margin-bottom: 20px;">  </p> <p>Dear friends,</p> <p> <span>BILTA is passionate about translating the Bible and essential literature materials into languages that connect with people's hearts and cultures.</span> <span>Our mission is to ensure that these texts inspire faith, foster understanding, and empower communities by making knowledge and truth accessible to all.</span> </p> <p> Through collaboration and dedication, we strive to ensure that no one is left without access to the transformative power of these texts. </p> <p> Thank you for your interest and support as we work together to bring light, understanding, and unity through translation. </p> <p>Blessings,</p> <p style="margin-top: 30px;"> <strong>Rev. Fr. Jackson J. Katete</strong><br> Executive Chairman – BILTA </p> </div>
    HTML;

        $chairmanSummary = Str::limit(trim(strip_tags($chairmanMessage)), self::ABOUT_TEXT_MAX, '');

        DB::table('chairman_messages')->updateOrInsert(
            ['id' => 1],
            [
                'name' => 'Rev. Fr. Jackson J. Katete',
                'title' => '',
                'message' => $chairmanSummary,
                'created_by' => $adminId,
                'status_id' => $activeStatusId,
                'updated_at' => $now,
                'created_at' => DB::raw(self::CREATED_AT_EXPR),
            ]
        );
    }

    private function seedSponsors(int $activeStatusId, int $adminId, $now): void
    {
        $sponsors = [
            [
                'name' => 'Hope Translation Partners',
                'website_url' => 'https://example.org/hope-translation-partners',
                'description' => 'Supports translation training and field coordination.',
            ],
            [
                'name' => 'Scripture Access Network',
                'website_url' => 'https://example.org/scripture-access-network',
                'description' => 'Supports audio Scripture distribution and literacy development.',
            ],
        ];

        foreach ($sponsors as $index => $sponsor) {
            DB::table('sponsors')->updateOrInsert(
                ['name' => $sponsor['name']],
                [
                    'website_url' => $sponsor['website_url'],
                    'description' => $sponsor['description'],
                    'display_order' => $index + 1,
                    'status_id' => $activeStatusId,
                    'created_by' => $adminId,
                    'updated_at' => $now,
                    'created_at' => DB::raw(self::CREATED_AT_EXPR),
                ]
            );
        }
    }

    private function seedTestimonials(int $activeStatusId, int $adminId, $now): void
    {
        $testimonials = [
            [
                'name' => 'Pastor Joseph',
                'title' => 'Church Leader',
                'testimonial' => 'The translated materials have strengthened discipleship in our local church community.',
            ],
            [
                'name' => 'Ruth M.',
                'title' => 'Literacy Facilitator',
                'testimonial' => 'BiLTA literacy tools are practical and have improved reading confidence among participants.',
            ],
        ];

        foreach ($testimonials as $testimonial) {
            DB::table('testimonials')->updateOrInsert(
                ['name' => $testimonial['name'], 'title' => $testimonial['title']],
                [
                    'testimonial' => $testimonial['testimonial'],
                    'status_id' => $activeStatusId,
                    'created_by' => $adminId,
                    'updated_at' => $now,
                    'created_at' => DB::raw(self::CREATED_AT_EXPR),
                    'deleted_at' => null,
                ]
            );
        }
    }

    /**
     * Assign roles to the default admin users.
     * admin@bilta.org   → admin role
     * content@bilta.org → content-manager role
     */
    private function assignUserRoles(): void
    {
        $assignments = [
            'admin@bilta.org' => 'admin',
            'content@bilta.org' => 'content-manager',
        ];

        foreach ($assignments as $email => $roleSlug) {
            $userId = DB::table('users')->where('email', $email)->value('id');
            $roleId = DB::table('roles')->where('slug', $roleSlug)->value('id');

            if ($userId && $roleId) {
                DB::table('users_roles')->updateOrInsert(
                    ['user_id' => $userId, 'role_id' => $roleId],
                    ['user_id' => $userId, 'role_id' => $roleId, 'updated_at' => now(), 'created_at' => now()]
                );
            }
        }
    }
}
