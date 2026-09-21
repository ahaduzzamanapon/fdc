<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cinema_heritage_pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('banner_subtitle')->nullable();
            $table->longText('main_description')->nullable();
            $table->string('banner_image')->nullable();
            $table->timestamps();
        });

        Schema::create('cinema_heritage_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('page_id');
            $table->string('title');
            $table->string('sub_title')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->foreign('page_id')->references('id')->on('cinema_heritage_pages')->onDelete('cascade');
        });

        // Seed initial data for 4 pages
        $page1Id = DB::table('cinema_heritage_pages')->insertGetId([
            'slug' => 'classic_films',
            'title' => 'কালজয়ী বাংলা চলচ্চিত্র',
            'banner_subtitle' => 'বাংলা চলচ্চিত্রের ইতিহাসে অমর ও কালজয়ী কিছু অনন্য সৃষ্টি...',
            'main_description' => 'বাংলা চলচ্চিত্রের দীর্ঘ যাত্রায় যে চলচ্চিত্রগুলো আমাদের শিল্প, সংস্কৃতি ও সমাজকে গভীরভাবে প্রভাবিত করেছে এবং আজ পর্যন্ত কালজয়ী হিসেবে সমাদৃত।',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $page2Id = DB::table('cinema_heritage_pages')->insertGetId([
            'slug' => 'top_grossing_films',
            'title' => 'বছরভিত্তিক সর্বোচ্চ ব্যবসাসফল সিনেমা',
            'banner_subtitle' => 'বছরের সেরা ও সর্বোচ্চ বক্স অফিস অর্জনকারী জনপ্রিয় চলচ্চিত্রসমূহ...',
            'main_description' => 'বাংলাদেশের চলচ্চিত্র বাজারে বিভিন্ন বছরে দর্শকপ্রিয়তা ও বাণিজ্যিক সাফল্যের শীর্ষে থাকা জনপ্রিয় ব্যবসাসফল সিনেমাসমূহ।',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $page3Id = DB::table('cinema_heritage_pages')->insertGetId([
            'slug' => 'national_film_awards',
            'title' => 'জাতীয় চলচ্চিত্র পুরস্কার',
            'banner_subtitle' => 'বাংলাদেশের সর্বশ্রেষ্ঠ রাষ্ট্রীয় চলচ্চিত্র সম্মাননা ও পুরস্কারপ্রাপ্ত সৃষ্টিসমূহ...',
            'main_description' => 'জাতীয় চলচ্চিত্র পুরস্কার বাংলাদেশের চলচ্চিত্র শিল্পের সবচেয়ে মর্যাদাপূর্ণ ও সর্বোচ্চ সম্মাননা। চলচ্চিত্রে অবদানের জন্য প্রতি বছর এ পুরস্কার প্রদান করা হয়।',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $page4Id = DB::table('cinema_heritage_pages')->insertGetId([
            'slug' => 'international_films',
            'title' => 'আন্তর্জাতিক পর্যায়ে বাংলা চলচ্চিত্র',
            'banner_subtitle' => 'আন্তর্জাতিক উৎসব ও বিশ্বমঞ্চে বাংলাদেশের নাম উজ্জ্বল করা সিনেমাসমূহ...',
            'main_description' => 'বিশ্বের বিভিন্ন মর্যাদাপূর্ণ চলচ্চিত্র উৎসবে (যেমন কান, ভেনিস, বুসান, রটারড্যাম) অংশগ্রহণ ও পুরস্কৃত হওয়া আন্তর্জাতিক অঙ্গনে বাংলা চলচ্চিত্রের গৌরবোজ্জ্বল অর্জন।',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Seed sample items for page 1 (Classic Films)
        DB::table('cinema_heritage_items')->insert([
            [
                'page_id' => $page1Id,
                'title' => 'পথের পাঁচালী',
                'sub_title' => 'পরিচালক: সত্যজিৎ রায় | বছর: ১৯৫৫',
                'description' => 'বাংলা চলচ্চিত্রের বিশ্বমঞ্চে পদার্পণ ও কালজয়ী মাস্টারপিস।',
                'image' => null,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_id' => $page1Id,
                'title' => 'নবাব সিরাজউদ্দৌলা',
                'sub_title' => 'পরিচালক: খান আতাউর রহমান | বছর: ১৯৬৭',
                'description' => 'বাংলার শেষ স্বাধীন নবাবের ঐতিহাসিক ঘটনাভিত্তিক কালজয়ী সিনেমা।',
                'image' => null,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_id' => $page1Id,
                'title' => 'জীবন থেকে নেয়া',
                'sub_title' => 'পরিচালক: জহির রায়হান | বছর: ১৯৭০',
                'description' => 'জাতীয় সচেতনতা ও মুক্তিযুদ্ধের প্রেরণা জোগানো কালজয়ী সৃষ্টি।',
                'image' => null,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Seed sample items for page 2 (Top Grossing)
        DB::table('cinema_heritage_items')->insert([
            [
                'page_id' => $page2Id,
                'title' => 'বেদের মেয়ে জোসনা',
                'sub_title' => 'পরিচালক: তোজাম্মেল হক বকুল | বছর: ১৯৮৯',
                'description' => 'বাংলাদেশের ইতিহাসের অন্যতম সর্বোচ্চ ব্যবসাসফল ও জনপ্রিয় সিনেমা।',
                'image' => null,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_id' => $page2Id,
                'title' => 'প্রিয়া আমার প্রিয়া',
                'sub_title' => 'পরিচালক: বদিউল আলম খোকন | বছর: ২০০৮',
                'description' => '২০০৮ সালের সর্বোচ্চ ব্যবসাসফল ও রেকর্ড সৃষ্টিকারী সিনেমা।',
                'image' => null,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_id' => $page2Id,
                'title' => 'প্রিয়তমা',
                'sub_title' => 'পরিচালক: হিমেল আশরাফ | বছর: ২০২৩',
                'description' => 'সাম্প্রতিক সময়ের অন্যতম সর্বোচ্চ আয়ের ব্যবসাসফল সিনেমা।',
                'image' => null,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Seed sample items for page 3 (National Awards)
        DB::table('cinema_heritage_items')->insert([
            [
                'page_id' => $page3Id,
                'title' => 'লাঠিয়াল',
                'sub_title' => 'প্রথম জাতীয় চলচ্চিত্র পুরস্কার বিজয়ী চলচ্চিত্র | ১৯৭৫',
                'description' => '১৯৭৫ সালে অনুষ্ঠিত ১ম জাতীয় চলচ্চিত্র পুরস্কারে শ্রেষ্ঠ চলচ্চিত্র হিসেবে ভূষিত।',
                'image' => null,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_id' => $page3Id,
                'title' => 'সীমানা পেরিয়ে',
                'sub_title' => 'জাতীয় পুরস্কার বিজয়ী | ১৯৭৭',
                'description' => 'আলমগীর কবির পরিচালিত ও বহু বিভাগে জাতীয় চলচ্চিত্র পুরস্কার বিজয়ী সিনেমা।',
                'image' => null,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Seed sample items for page 4 (International)
        DB::table('cinema_heritage_items')->insert([
            [
                'page_id' => $page4Id,
                'title' => 'মাটির ময়না',
                'sub_title' => 'পরিচালক: তারেক মাসুদ | বছর: ২০০২',
                'description' => 'কান চলচ্চিত্র উৎসবে "FIPRESCI Prize" বিজয়ী এবং অস্কারে বাংলাদেশের প্রথম আনুষ্ঠানিক প্রবেশ।',
                'image' => null,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_id' => $page4Id,
                'title' => 'রেহানা মরিয়ম নূর',
                'sub_title' => 'পরিচালক: আবদুল্লাহ মোহাম্মদ সাদ | বছর: ২০২১',
                'description' => 'কান চলচ্চিত্র উৎসবের মর্যাদাপূর্ণ "Un Certain Regard" বিভাগে প্রথম অভূতপূর্ব সিলেকশন।',
                'image' => null,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cinema_heritage_items');
        Schema::dropIfExists('cinema_heritage_pages');
    }
};
