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
        Schema::create('about_uses', function (Blueprint $table) {
            $table->id();
            $table->string('banner_title')->nullable();
            $table->text('banner_subtitle')->nullable();
            $table->string('main_title')->nullable();
            $table->longText('main_description')->nullable();
            $table->string('main_image')->nullable();
            $table->string('team_title')->nullable();
            $table->timestamps();
        });

        Schema::create('about_us_features', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('items')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('about_us_officers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('designation')->nullable();
            $table->string('image')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Seed initial default data matching existing page content
        DB::table('about_uses')->insert([
            'banner_title' => 'আমাদের সম্পর্কে',
            'banner_subtitle' => 'একটি আধুনিক ও ইউজার-ফ্রেন্ডলি সল্যুশন, যা চলচ্চিত্র নির্মাতাদের জন্য এনেছে এক ছাদের নিচে সব সুবিধা। আপনার প্রোডাকশন, এখন সম্পূর্ণ ডিজিটালি নিয়ন্ত্রিত।প্রযোজকদের জন্য তৈরি একটি সহজ ও কার্যকর সফটওয়্যার',
            'main_title' => 'আমাদের সম্পর্কে',
            'main_description' => 'একটি আধুনিক ও ইউজার-ফ্রেন্ডলি সল্যুশন, যা চলচ্চিত্র নির্মাতাদের জন্য এনেছে এক ছাদের নিচে সব সুবিধা। আপনার প্রোডাকশন, এখন সম্পূর্ণ ডিজিটালি নিয়ন্ত্রিত।প্রযোজকদের জন্য তৈরি একটি সহজ ও কার্যকর সফটওয়্যার.',
            'main_image' => '/assets/images/about.png',
            'team_title' => 'কর্মকর্তাবৃন্দ',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('about_us_features')->insert([
            [
                'title' => 'এফডিসি',
                'items' => "বিএফডিসি সাংগঠনিক কাঠামো ১৯৮ ৪ (এনাম কমিটি)\nমুক্তি প্রাপ্ত বাংলা চলচ্চিত্রের তালিকা (১৯৫৬-২০২৪)",
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'এফডিসি',
                'items' => "বিএফডিসি সাংগঠনিক কাঠামো ১৯৮ ৪ (এনাম কমিটি)\nমুক্তি প্রাপ্ত বাংলা চলচ্চিত্রের তালিকা (১৯৫৬-২০২৪)",
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'এফডিসি',
                'items' => "বিএফডিসি সাংগঠনিক কাঠামো ১৯৮ ৪ (এনাম কমিটি)\nমুক্তি প্রাপ্ত বাংলা চলচ্চিত্রের তালিকা (১৯৫৬-২০২৪)",
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        DB::table('about_us_officers')->insert([
            [
                'name' => 'মোঃ মাহফুজ আলম',
                'designation' => 'মাননীয় উপদেষ্টা (তথ্য ও সম্প্রচার মন্ত্রণালয়)',
                'image' => 'https://fdc.portal.gov.bd/sites/default/files/files/fdc.portal.gov.bd/npfblock//2025-02-26-15-05-c1bf9124772d8faf3b96b4936734d2a3.jpeg',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'মাহবুবা ফারজানা',
                'designation' => 'সচিব (তথ্য ও সম্প্রচার মন্ত্রণালয়)',
                'image' => 'https://fdc.portal.gov.bd/sites/default/files/files/fdc.portal.gov.bd/npfblock//2024-10-24-14-31-ef71a0c41b7565ef866afe9702a7c43e.jpg',
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'মাসুমা রহমান তানি',
                'designation' => 'তথ্য ও সম্প্রচার মন্ত্রণালয়',
                'image' => 'https://fdc.portal.gov.bd/sites/default/files/files/fdc.portal.gov.bd/npfblock//2025-02-26-14-58-d24e5616da518d26f3331b5ca7b9c1e8.jpeg',
                'sort_order' => 3,
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
        Schema::dropIfExists('about_us_officers');
        Schema::dropIfExists('about_us_features');
        Schema::dropIfExists('about_uses');
    }
};
