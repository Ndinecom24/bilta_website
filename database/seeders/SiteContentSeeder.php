<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SiteContentSeeder extends Seeder
{
    private const ABOUT_TEXT_MAX = 191;

    public function run()
    {
        $now = now();

        DB::table('about_us')->updateOrInsert(
            ['id' => 1],
            [
                'mission' => Str::limit('To serve God through the translation of scriptures and essential literature into heart languages for their accessibility and transformation of lives. Acts 2:6-8, mt 28:19-20', self::ABOUT_TEXT_MAX, ''),
                'vision' => Str::limit('To be a transformative force by equipping translators to make scripture and essential literature accessible in every heart language.  ', self::ABOUT_TEXT_MAX, ''),
                'objective' => Str::limit("* To mobilise and build capacity of the local people for Bible translation.\n* Seek to promote the use of the local language in the dissemination of the word of God by embracing the use of other languages\n* To promote literacy and education through production of all types of materials such as newsletters, books, magazines, and videos in the local language.\n", self::ABOUT_TEXT_MAX, ''),
                'description' => Str::limit('BiLTA has a constitution and is registered with the Registrar of Societies in Zambia as a charitable organisation aimed at empowering communities to translate the word of God and other literatures into their own language.', self::ABOUT_TEXT_MAX, ''),
                'who_we_are' => Str::limit("The Bible and Literature Translation Association (BiLTA) was established in 2019. It is a dedicated translation association committed to advancing the translation of the Bible and other essential literature works into local languages. \n", self::ABOUT_TEXT_MAX, ''),
                'what_is' => Str::limit('BiLTA is an acronym standing for “Bible and Literature Translation Association.”In 2012, it was first called Senga Bible and Literature Translation Association (SBLTA), however in January 2021, its name changed to BiLTA so that other language groups could be helped with the translation work of their languages.', self::ABOUT_TEXT_MAX, ''),
                'created_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ]
        );

        DB::table('contact_us')->updateOrInsert(
            ['id' => 1],
            [
                'phone' => '(+26) 0977-539-067',
                'email' => 'infor@bilta.org',
                'address' => 'Plot 324, Flat No 2, Bauhinia Avenue, Off Great East Road, Chelston, Lusaka, Zambia',
                'message' => 'BILTA is passionate about translating the Bible and essential literature materials into local languages.',
                'google_maps' => 'https://www.google.com/maps?q=Chelston,+Lusaka,+Zambia&output=embed',
                'created_by' => 1,
                'facebook_url' => 'https://www.facebook.com/biltazambia',
                'linkedin_url' => 'https://www.linkedin.com',
                'twitter_url' => 'https://x.com',
                'youtube' => 'https://www.youtube.com/@SengaBible',
                'whatsapp_link' => '#',
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ]
        );

        $services = [
            [
                'title' => 'Translation Projects',
                'description' => 'Support and implementation of Bible translation projects for language communities without complete translations.',
            ],
            [
                'title' => 'Liturgical Texts',
                'description' => 'Translation of prayers, hymns, and worship resources for local-language church contexts.',
            ],
            [
                'title' => 'Devotionals & Study Materials',
                'description' => 'Production of discipleship, study, and devotional resources aligned to culture and language.',
            ],
        ];

        foreach ($services as $service) {
            DB::table('our_services')->updateOrInsert(
                ['title' => $service['title']],
                [
                    'description' => $service['description'],
                    'created_by' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                    'deleted_at' => null,
                ]
            );
        }

        $values = [
            ['title' => 'Faithfulness', 'description' => 'We serve communities with integrity, clarity, and biblical truth.'],
            ['title' => 'Collaboration', 'description' => 'We work with churches, translators, and local leaders for lasting impact.'],
            ['title' => 'Excellence', 'description' => 'We pursue quality translation and publishing standards in every project.'],
        ];

        foreach ($values as $value) {
            DB::table('our_values')->updateOrInsert(
                ['title' => $value['title']],
                [
                    'description' => $value['description'],
                    'created_by' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                    'deleted_at' => null,
                ]
            );
        }

        DB::table('home_intros')->updateOrInsert(
            ['id' => 1],
            [
                'name' => 'Welcome to BiLTA',
                'short_description' => 'Bible and Literature Translation Association',
                'long_description' => 'A dedicated translation association advancing Bible and essential literature in local languages.',
                'created_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ]
        );

        $faqs = [
            [
                'question' => 'What does BiLTA do?',
                'answer' => 'BiLTA translates Bible and essential literature materials into local languages for discipleship and literacy.',
            ],
            [
                'question' => 'How can I support BiLTA?',
                'answer' => 'You can support through prayer, partnership, donation, and volunteering in community translation activities.',
            ],
            [
                'question' => 'Where does BiLTA operate?',
                'answer' => 'BiLTA serves language communities in Zambia and collaborates with local churches and translation partners.',
            ],
        ];

        foreach ($faqs as $faq) {
            DB::table('f_a_qs')->updateOrInsert(
                ['question' => $faq['question']],
                [
                    'answer' => $faq['answer'],
                    'created_by' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                    'deleted_at' => null,
                ]
            );
        }
    }
}
