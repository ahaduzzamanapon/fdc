<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PhotoGallery;
use DB;

class DecadePhotoGallerySeeder extends Seeder
{
    public function run()
    {
        DB::table('photo_galleries')->truncate();

        $data = [
            // --- 1960s (১৯৬০ - ১৯৬৯) ---
            ['film_name' => 'আসিয়া', 'type' => 'পূর্ণদৈর্ঘ্য ড্রামা', 'release_date' => '1960-04-15', 'image' => 'images/galleries/gallery1.jpg'],
            ['film_name' => 'রাজধানী', 'type' => 'সামাজিক চলচ্চিত্র', 'release_date' => '1960-09-23', 'image' => 'images/galleries/gallery2.jpg'],
            ['film_name' => 'হারানো দিন', 'type' => 'রোমান্টিক ক্লাসিক', 'release_date' => '1961-05-10', 'image' => 'images/galleries/gallery3.jpg'],
            ['film_name' => 'আপনার পর', 'type' => 'সামাজিক ড্রামা', 'release_date' => '1961-11-17', 'image' => 'images/galleries/gallery4.jpg'],
            ['film_name' => 'সূর্যস্নান', 'type' => 'ক্লাসিক চলচ্চিত্র', 'release_date' => '1962-03-08', 'image' => 'images/galleries/gallery5.jpg'],
            ['film_name' => 'জোয়ার এলো', 'type' => 'সঙ্গীতনির্ভর ছায়াছবি', 'release_date' => '1962-08-20', 'image' => 'images/galleries/gallery6.jpg'],
            ['film_name' => 'কাঁচের দেয়াল', 'type' => 'জাতীয় পুরস্কারপ্রাপ্ত চলচ্চিত্র', 'release_date' => '1963-01-25', 'image' => 'images/galleries/gallery7.jpg'],
            ['film_name' => 'ধলেশ্বরী', 'type' => 'লোককাহিনী চলচ্চিত্র', 'release_date' => '1963-07-14', 'image' => 'images/galleries/gallery8.jpg'],
            ['film_name' => 'সঙ্গম', 'type' => 'প্রথম রঙিন চলচ্চিত্র', 'release_date' => '1964-02-12', 'image' => 'images/galleries/gallery9.jpg'],
            ['film_name' => 'মিলন', 'type' => 'রোমান্টিক ড্রামা', 'release_date' => '1964-10-09', 'image' => 'images/galleries/gallery10.jpg'],
            ['film_name' => 'রূপবান', 'type' => 'লোকগাথাভিত্তিক মেগা হিট', 'release_date' => '1965-06-25', 'image' => 'images/galleries/gallery11.jpg'],
            ['film_name' => 'নদী ও নারী', 'type' => 'সাহিত্যধর্মী চলচ্চিত্র', 'release_date' => '1965-12-03', 'image' => 'images/galleries/gallery12.jpg'],
            ['film_name' => 'বেহুলা', 'type' => 'পৌরাণিক ক্লাসিক', 'release_date' => '1966-04-18', 'image' => 'images/galleries/gallery13.jpg'],
            ['film_name' => 'কাগজের নৌকা', 'type' => 'সামাজিক ড্রামা', 'release_date' => '1966-10-21', 'image' => 'images/galleries/gallery14.jpg'],
            ['film_name' => 'নবাব সিরাজউদ্দৌলা', 'type' => 'ঐতিহাসিক মহাকাব্যিক চলচ্চিত্র', 'release_date' => '1967-03-17', 'image' => 'images/galleries/gallery15.jpg'],
            ['film_name' => 'আগুন নিয়ে খেলা', 'type' => 'রোমান্টিক অ্যাকশন', 'release_date' => '1967-09-08', 'image' => 'images/galleries/gallery16.jpg'],
            ['film_name' => 'পরশমণি', 'type' => 'ফ্যান্টাসি ড্রামা', 'release_date' => '1968-01-19', 'image' => 'images/galleries/gallery17.jpg'],
            ['film_name' => 'দুই ভাই', 'type' => 'পারিবারিক ড্রামা', 'release_date' => '1968-07-26', 'image' => 'images/galleries/gallery18.jpg'],
            ['film_name' => 'নীল আকাশের নিচে', 'type' => 'কালজয়ী রোমান্টিক ক্লাসিক', 'release_date' => '1969-05-09', 'image' => 'images/galleries/gallery19.jpg'],
            ['film_name' => 'ময়নামতি', 'type' => 'রোমান্টিক ড্রামা', 'release_date' => '1969-11-14', 'image' => 'images/galleries/gallery20.jpg'],

            // --- 1970s (১৯৭০ - ১৯৭৯) ---
            ['film_name' => 'জীবন থেকে নেয়া', 'type' => 'রাজনৈতিক সত্যচিত্র', 'release_date' => '1970-02-20', 'image' => 'images/galleries/gallery1.jpg'],
            ['film_name' => 'পিচ ঢালা পথ', 'type' => 'সামাজিক ড্রামা', 'release_date' => '1970-08-14', 'image' => 'images/galleries/gallery2.jpg'],
            ['film_name' => 'জলছবি', 'type' => 'সামাজিক চলচ্চিত্র', 'release_date' => '1971-03-05', 'image' => 'images/galleries/gallery3.jpg'],
            ['film_name' => 'স্বরলিপি', 'type' => 'সঙ্গীতনির্ভর রোমান্স', 'release_date' => '1971-10-12', 'image' => 'images/galleries/gallery4.jpg'],
            ['film_name' => 'ওরা ১১ জন', 'type' => 'প্রথম মুক্তিযুদ্ধভিত্তিক চলচ্চিত্র', 'release_date' => '1972-01-07', 'image' => 'images/galleries/gallery5.jpg'],
            ['film_name' => 'বাঘা বাঙালি', 'type' => 'মুক্তিযুদ্ধভিত্তিক চলচ্চিত্র', 'release_date' => '1972-06-23', 'image' => 'images/galleries/gallery6.jpg'],
            ['film_name' => 'তিতাস একটি নদীর নাম', 'type' => 'অনবদ্য ধ্রুপদী ক্লাসিক', 'release_date' => '1973-04-13', 'image' => 'images/galleries/gallery7.jpg'],
            ['film_name' => 'রংবাজ', 'type' => 'অ্যাকশন রোমান্স', 'release_date' => '1973-09-28', 'image' => 'images/galleries/gallery8.jpg'],
            ['film_name' => 'সংগ্রাম', 'type' => 'মুক্তিযুদ্ধভিত্তিক ইতিহাস', 'release_date' => '1974-03-22', 'image' => 'images/galleries/gallery9.jpg'],
            ['film_name' => 'আলোর মিছিল', 'type' => 'দেশপ্রেমিক ড্রামা', 'release_date' => '1974-11-08', 'image' => 'images/galleries/gallery10.jpg'],
            ['film_name' => 'সুজন সখী', 'type' => 'রোমান্টিক লোকগাথা', 'release_date' => '1975-05-16', 'image' => 'images/galleries/gallery11.jpg'],
            ['film_name' => 'চাবুক', 'type' => 'অ্যাকশন থ্রিলার', 'release_date' => '1975-10-03', 'image' => 'images/galleries/gallery12.jpg'],
            ['film_name' => 'নয়নমণি', 'type' => 'জাতীয় পুরস্কারপ্রাপ্ত চলচ্চিত্র', 'release_date' => '1976-02-27', 'image' => 'images/galleries/gallery13.jpg'],
            ['film_name' => 'সূর্যগ্রহণ', 'type' => 'সামাজিক ড্রামা', 'release_date' => '1976-08-20', 'image' => 'images/galleries/gallery14.jpg'],
            ['film_name' => 'বসুন্ধরা', 'type' => 'জাতীয় পুরস্কারপ্রাপ্ত ক্লাসিক', 'release_date' => '1977-04-01', 'image' => 'images/galleries/gallery15.jpg'],
            ['film_name' => 'অনন্ত প্রেম', 'type' => 'রোমান্টিক ট্র্যাজেডি', 'release_date' => '1977-09-16', 'image' => 'images/galleries/gallery16.jpg'],
            ['film_name' => 'অশিক্ষিত', 'type' => 'সামাজিক সচেতনতামূলক চলচ্চিত্র', 'release_date' => '1978-01-13', 'image' => 'images/galleries/gallery17.jpg'],
            ['film_name' => 'গোলাপী এখন ট্রেনে', 'type' => 'জাতীয় পুরস্কারপ্রাপ্ত শ্রেষ্ঠ চলচ্চিত্র', 'release_date' => '1978-06-30', 'image' => 'images/galleries/gallery18.jpg'],
            ['film_name' => 'সূর্য দীঘল বাড়ী', 'type' => 'আন্তর্জাতিক পুরস্কারপ্রাপ্ত ক্লাসিক', 'release_date' => '1979-03-09', 'image' => 'images/galleries/gallery19.jpg'],
            ['film_name' => 'রূপালী সৈকতে', 'type' => 'সামাজিক ড্রামা', 'release_date' => '1979-10-19', 'image' => 'images/galleries/gallery20.jpg'],

            // --- 1980s (১৯৮০ - ১৯৮৯) ---
            ['film_name' => 'ছুটির ঘণ্টা', 'type' => 'হৃদয়স্পর্শী সামাজিক ড্রামা', 'release_date' => '1980-05-02', 'image' => 'images/galleries/gallery1.jpg'],
            ['film_name' => 'জীবন তরী', 'type' => 'পারিবারিক ছায়াছবি', 'release_date' => '1980-11-14', 'image' => 'images/galleries/gallery2.jpg'],
            ['film_name' => 'জন্ম থেকে জ্বলছি', 'type' => 'সঙ্গীতধর্মী রোমান্স', 'release_date' => '1981-04-10', 'image' => 'images/galleries/gallery3.jpg'],
            ['film_name' => 'লাল সবুজের পালা', 'type' => 'মুক্তিযুদ্ধ ও পরবর্তী ড্রামা', 'release_date' => '1981-09-18', 'image' => 'images/galleries/gallery4.jpg'],
            ['film_name' => 'বড় ভালো লোক ছিল', 'type' => 'আধ্যাত্মিক ড্রামা', 'release_date' => '1982-06-18', 'image' => 'images/galleries/gallery5.jpg'],
            ['film_name' => 'রজনীগন্ধা', 'type' => 'রোমান্টিক গল্প', 'release_date' => '1982-12-03', 'image' => 'images/galleries/gallery6.jpg'],
            ['film_name' => 'পুরস্কার', 'type' => 'শিশুতোষ জাতীয় পুরস্কারপ্রাপ্ত', 'release_date' => '1983-03-11', 'image' => 'images/galleries/gallery7.jpg'],
            ['film_name' => 'নাজমা', 'type' => 'পারিবারিক ড্রামা', 'release_date' => '1983-10-21', 'image' => 'images/galleries/gallery8.jpg'],
            ['film_name' => 'ভাত দে', 'type' => 'জাতীয় পুরস্কারপ্রাপ্ত কালজয়ী চলচ্চিত্র', 'release_date' => '1984-07-27', 'image' => 'images/galleries/gallery9.jpg'],
            ['film_name' => 'প্রিন্সেস টিনা খান', 'type' => 'সামাজিক প্রেক্ষাপট', 'release_date' => '1984-11-30', 'image' => 'images/galleries/gallery10.jpg'],
            ['film_name' => 'শুভদা', 'type' => 'শরৎচন্দ্র সাহিত্যধর্মী চলচ্চিত্র', 'release_date' => '1985-02-15', 'image' => 'images/galleries/gallery11.jpg'],
            ['film_name' => 'রামের সুমতি', 'type' => 'সাহিত্যধর্মী পিরিয়ড ড্রামা', 'release_date' => '1985-08-23', 'image' => 'images/galleries/gallery12.jpg'],
            ['film_name' => 'ঢাকা ৮৬', 'type' => 'রোমান্টিক সামাজিক', 'release_date' => '1986-09-12', 'image' => 'images/galleries/gallery13.jpg'],
            ['film_name' => 'পরিণীতা', 'type' => 'সাহিত্য নির্ভর ড্রামা', 'release_date' => '1986-12-19', 'image' => 'images/galleries/gallery14.jpg'],
            ['film_name' => 'রাজলক্ষ্মী শ্রীকান্ত', 'type' => 'মহাকাব্যিক প্রেমকাহিনী', 'release_date' => '1987-05-29', 'image' => 'images/galleries/gallery15.jpg'],
            ['film_name' => 'সহযাত্রী', 'type' => 'সামাজিক চলচ্চিত্র', 'release_date' => '1987-11-06', 'image' => 'images/galleries/gallery16.jpg'],
            ['film_name' => 'আগমন', 'type' => 'পারিবারিক আবেগঘন চলচ্চিত্র', 'release_date' => '1988-08-05', 'image' => 'images/galleries/gallery17.jpg'],
            ['film_name' => 'যোগাযোগ', 'type' => 'পারিবারিক ড্রামা', 'release_date' => '1988-12-16', 'image' => 'images/galleries/gallery18.jpg'],
            ['film_name' => 'বেদের মেয়ে জোসনা', 'type' => 'সর্বকালের সেরা ব্যবসায়িক ইতিহাস', 'release_date' => '1989-06-09', 'image' => 'images/galleries/gallery19.jpg'],
            ['film_name' => 'ক্ষতিপূরণ', 'type' => 'অ্যাকশন থ্রিলার', 'release_date' => '1989-10-27', 'image' => 'images/galleries/gallery20.jpg'],

            // --- 1990s (১৯৯০ - ১৯৯৯) ---
            ['film_name' => 'দাঙ্গা', 'type' => 'আইকনিক অ্যাকশন থ্রিলার', 'release_date' => '1990-03-16', 'image' => 'images/galleries/gallery1.jpg'],
            ['film_name' => 'স্নেহের প্রতিদান', 'type' => 'পারিবারিক ড্রামা', 'release_date' => '1990-09-21', 'image' => 'images/galleries/gallery2.jpg'],
            ['film_name' => 'পিতা মাতা সন্তান', 'type' => 'সামাজিক পারিবারিক ক্লাসিক', 'release_date' => '1991-07-12', 'image' => 'images/galleries/gallery3.jpg'],
            ['film_name' => 'সান্ত্বনা', 'type' => 'পারিবারিক ড্রামা', 'release_date' => '1991-11-29', 'image' => 'images/galleries/gallery4.jpg'],
            ['film_name' => 'শঙ্খনীল কারাগার', 'type' => 'হুমায়ূন আহমেদ উপন্যাস চলচ্চিত্র', 'release_date' => '1992-04-24', 'image' => 'images/galleries/gallery5.jpg'],
            ['film_name' => 'চাকর', 'type' => 'অ্যাকশন রোমান্স', 'release_date' => '1992-10-16', 'image' => 'images/galleries/gallery6.jpg'],
            ['film_name' => 'কেয়ামত থেকে কেয়ামত', 'type' => 'আইকনিক ট্রেন্ডসেটিং রোমান্স', 'release_date' => '1993-03-25', 'image' => 'images/galleries/gallery7.jpg'],
            ['film_name' => 'পদ্মা নদীর মাঝি', 'type' => 'আন্তর্জাতিক পুরস্কৃত ক্লাসিক', 'release_date' => '1993-09-03', 'image' => 'images/galleries/gallery8.jpg'],
            ['film_name' => 'আগুনের পরশমণি', 'type' => 'মুক্তিযুদ্ধভিত্তিক কালজয়ী চলচ্চিত্র', 'release_date' => '1994-12-16', 'image' => 'images/galleries/gallery9.jpg'],
            ['film_name' => 'তুমি আমার', 'type' => 'রোমান্টিক হিট', 'release_date' => '1994-06-10', 'image' => 'images/galleries/gallery10.jpg'],
            ['film_name' => 'স্বপ্নের ঠিকানা', 'type' => 'অলটাইম মেগা ব্লকবাস্টার', 'release_date' => '1995-09-08', 'image' => 'images/galleries/gallery11.jpg'],
            ['film_name' => 'দেনমোহর', 'type' => 'রোমান্টিক সামাজিক', 'release_date' => '1995-03-03', 'image' => 'images/galleries/gallery12.jpg'],
            ['film_name' => 'সত্যের মৃত্যু নেই', 'type' => 'রেকর্ড সৃষ্টিকারী ড্রামা', 'release_date' => '1996-05-17', 'image' => 'images/galleries/gallery13.jpg'],
            ['film_name' => 'সীমানা পেরিয়ে', 'type' => 'ঐতিহাসিক সত্যচিত্র', 'release_date' => '1996-11-08', 'image' => 'images/galleries/gallery14.jpg'],
            ['film_name' => 'আনন্দ অশ্রু', 'type' => 'রোমান্টিক ট্র্যাজেডি ক্লাসিক', 'release_date' => '1997-10-10', 'image' => 'images/galleries/gallery15.jpg'],
            ['film_name' => 'প্রেম পিয়াসী', 'type' => 'রোমান্টিক চলচ্চিত্র', 'release_date' => '1997-04-18', 'image' => 'images/galleries/gallery16.jpg'],
            ['film_name' => 'হঠাৎ বৃষ্টি', 'type' => 'ভারত-বাংলাদেশ যৌথ প্রযোজনা হিট', 'release_date' => '1998-11-20', 'image' => 'images/galleries/gallery17.jpg'],
            ['film_name' => 'শান্ত কেন মাস্তান', 'type' => 'অ্যাকশন ব্লকবাস্টার', 'release_date' => '1998-05-15', 'image' => 'images/galleries/gallery18.jpg'],
            ['film_name' => 'শ্রাবণ মেঘের দিন', 'type' => 'হুমায়ূন আহমেদ সঙ্গীতনির্ভর কালজয়ী', 'release_date' => '1999-07-23', 'image' => 'images/galleries/gallery19.jpg'],
            ['film_name' => 'আম্মাজান', 'type' => 'সর্বকালের অন্যতম ব্যবসায়িক সফল', 'release_date' => '1999-02-12', 'image' => 'images/galleries/gallery20.jpg'],

            // --- 2000s (২০০০ - ২০০৯) ---
            ['film_name' => 'কুলি', 'type' => 'অ্যাকশন রোমান্স', 'release_date' => '2000-04-14', 'image' => 'images/galleries/gallery1.jpg'],
            ['film_name' => 'ইতিহাস', 'type' => 'সামাজিক অ্যাকশন ড্রামা', 'release_date' => '2000-10-20', 'image' => 'images/galleries/gallery2.jpg'],
            ['film_name' => 'লালসালু', 'type' => 'আন্তর্জাতিক পুরস্কারপ্রাপ্ত ক্লাসিক', 'release_date' => '2001-11-09', 'image' => 'images/galleries/gallery3.jpg'],
            ['film_name' => 'ধারদেনা', 'type' => 'সামাজিক কাহিনী', 'release_date' => '2001-05-18', 'image' => 'images/galleries/gallery4.jpg'],
            ['film_name' => 'মাটির ময়না', 'type' => 'কান উৎসব পুরস্কৃত ও অস্কার সাবমিশন', 'release_date' => '2002-05-17', 'image' => 'images/galleries/gallery5.jpg'],
            ['film_name' => 'ও প্রিয়া তুমি কোথায়', 'type' => 'রোমান্টিক হিট', 'release_date' => '2002-11-01', 'image' => 'images/galleries/gallery6.jpg'],
            ['film_name' => 'চন্দ্রকথা', 'type' => 'হুমায়ূন আহমেদ নাটকীয় রূপায়ণ', 'release_date' => '2003-09-12', 'image' => 'images/galleries/gallery7.jpg'],
            ['film_name' => 'দুই দুয়ারী', 'type' => 'জাতীয় পুরস্কারপ্রাপ্ত চলচ্চিত্র', 'release_date' => '2003-03-21', 'image' => 'images/galleries/gallery8.jpg'],
            ['film_name' => 'জয়যাত্রা', 'type' => 'মুক্তিযুদ্ধভিত্তিক জাতীয় পুরস্কারপ্রাপ্ত', 'release_date' => '2004-12-16', 'image' => 'images/galleries/gallery9.jpg'],
            ['film_name' => 'শ্যামল ছায়া', 'type' => 'মুক্তিযুদ্ধভিত্তিক ড্রামা', 'release_date' => '2004-06-25', 'image' => 'images/galleries/gallery10.jpg'],
            ['film_name' => 'হাজার বছর ধরে', 'type' => 'জহির রায়হান উপন্যাস চলচ্চিত্র', 'release_date' => '2005-08-19', 'image' => 'images/galleries/gallery11.jpg'],
            ['film_name' => 'মোল্লা বাড়ির বউ', 'type' => 'হাস্যরসাত্মক সামাজিক হিট', 'release_date' => '2005-02-11', 'image' => 'images/galleries/gallery12.jpg'],
            ['film_name' => 'হৃদয়ের কথা', 'type' => 'মেগা হিট রোমান্স', 'release_date' => '2006-03-24', 'image' => 'images/galleries/gallery13.jpg'],
            ['film_name' => 'শুভা', 'type' => 'রবীন্দ্রনাথ সাহিত্য ছায়াছবি', 'release_date' => '2006-10-06', 'image' => 'images/galleries/gallery14.jpg'],
            ['film_name' => 'দারুচিনি দ্বীপ', 'type' => 'জাতীয় পুরস্কারপ্রাপ্ত সেরা ছবি', 'release_date' => '2007-08-31', 'image' => 'images/galleries/gallery15.jpg'],
            ['film_name' => 'আহা!', 'type' => 'আন্তর্জাতিক প্রশংসিত ড্রামা', 'release_date' => '2007-02-16', 'image' => 'images/galleries/gallery16.jpg'],
            ['film_name' => 'চন্দ্রগ্রহণ', 'type' => 'সাহিত্যিক ড্রামা', 'release_date' => '2008-05-09', 'image' => 'images/galleries/gallery17.jpg'],
            ['film_name' => 'থার্ড পারসন সিঙ্গুলার নাম্বার', 'type' => 'আধুনিক সামাজিক ড্রামা', 'release_date' => '2008-11-28', 'image' => 'images/galleries/gallery18.jpg'],
            ['film_name' => 'মনপুরা', 'type' => 'রেকর্ডভাঙা কালজয়ী মিউজিক্যাল রোমান্স', 'release_date' => '2009-02-13', 'image' => 'images/galleries/gallery19.jpg'],
            ['film_name' => 'গঙ্গাযাত্রা', 'type' => 'জাতীয় পুরস্কারপ্রাপ্ত চলচ্চিত্র', 'release_date' => '2009-09-18', 'image' => 'images/galleries/gallery20.jpg'],

            // --- 2010s (২০১০ - ২০১৯) ---
            ['film_name' => 'গহীনে শব্দ', 'type' => 'সামাজিক সচেতনতামূলক ড্রামা', 'release_date' => '2010-03-26', 'image' => 'images/galleries/gallery1.jpg'],
            ['film_name' => 'রানওয়ে', 'type' => 'আন্তর্জাতিক সমাদৃত ড্রামা', 'release_date' => '2010-10-15', 'image' => 'images/galleries/gallery2.jpg'],
            ['film_name' => 'গেরিলা', 'type' => 'মুক্তিযুদ্ধভিত্তিক সেরা মহাকাব্যিক', 'release_date' => '2011-04-14', 'image' => 'images/galleries/gallery3.jpg'],
            ['film_name' => 'আমার বন্ধু রাশেদ', 'type' => 'মুক্তিযুদ্ধভিত্তিক শিশুতোষ কালজয়ী', 'release_date' => '2011-09-30', 'image' => 'images/galleries/gallery4.jpg'],
            ['film_name' => 'ঘেটুপুত্র কমলা', 'type' => 'হুমায়ূন আহমেদ শেষ মাস্টারপিস', 'release_date' => '2012-09-07', 'image' => 'images/galleries/gallery5.jpg'],
            ['film_name' => 'পিতা', 'type' => 'মুক্তিযুদ্ধভিত্তিক ইতিহাস', 'release_date' => '2012-03-23', 'image' => 'images/galleries/gallery6.jpg'],
            ['film_name' => 'টেলিভিশন', 'type' => 'বুসান আন্তর্জাতিক পুরস্কৃত ছায়াছবি', 'release_date' => '2013-01-25', 'image' => 'images/galleries/gallery7.jpg'],
            ['film_name' => 'মৃত্তিকা মায়া', 'type' => 'জাতীয় পুরস্কারপ্রাপ্ত শ্রেষ্ঠ চলচ্চিত্র', 'release_date' => '2013-10-04', 'image' => 'images/galleries/gallery8.jpg'],
            ['film_name' => 'পিঁপড়াবিদ্যা', 'type' => 'সাইকোলজিক্যাল স্যাটায়ার', 'release_date' => '2014-10-24', 'image' => 'images/galleries/gallery9.jpg'],
            ['film_name' => 'বৃহন্নলা', 'type' => 'আন্তর্জাতিক পুরস্কারপ্রাপ্ত ড্রামা', 'release_date' => '2014-04-11', 'image' => 'images/galleries/gallery10.jpg'],
            ['film_name' => 'অনিল বাগচীর একদিন', 'type' => 'মুক্তিযুদ্ধভিত্তিক জাতীয় পুরস্কারপ্রাপ্ত', 'release_date' => '2015-12-11', 'image' => 'images/galleries/gallery11.jpg'],
            ['film_name' => 'ছুঁয়ে দিলে মন', 'type' => 'রোমান্টিক ব্লকবাস্টার', 'release_date' => '2015-04-10', 'image' => 'images/galleries/gallery12.jpg'],
            ['film_name' => 'অজ্ঞাতনামা', 'type' => 'অস্কার অফিশিয়াল এন্ট্রি ও এশিয়ান অ্যাওয়ার্ড', 'release_date' => '2016-08-19', 'image' => 'images/galleries/gallery13.jpg'],
            ['film_name' => 'শিকারী', 'type' => 'যৌথ প্রযোজনা অ্যাকশন থ্রিলার', 'release_date' => '2016-07-07', 'image' => 'images/galleries/gallery14.jpg'],
            ['film_name' => 'ঢাকা অ্যাটাক', 'type' => 'মেগা ব্লকবাস্টার পুলিশ থ্রিলার', 'release_date' => '2017-10-06', 'image' => 'images/galleries/gallery15.jpg'],
            ['film_name' => 'খাঁচা', 'type' => 'দেশভাগ কেন্দ্রিক ইতিহাস চলচ্চিত্র', 'release_date' => '2017-09-22', 'image' => 'images/galleries/gallery16.jpg'],
            ['film_name' => 'দেবী', 'type' => 'মিসির আলি উপন্যাস সাইকোলজিক্যাল থ্রিলার', 'release_date' => '2018-10-19', 'image' => 'images/galleries/gallery17.jpg'],
            ['film_name' => 'পোড়ামন ২', 'type' => 'মেগা হিট রোমান্টিক ট্র্যাজেডি', 'release_date' => '2018-06-16', 'image' => 'images/galleries/gallery18.jpg'],
            ['film_name' => 'ফাগুন হাওয়ায়', 'type' => 'ভাষা আন্দোলনভিত্তিক ঐতিহাসিক চলচ্চিত্র', 'release_date' => '2019-02-15', 'image' => 'images/galleries/gallery19.jpg'],
            ['film_name' => 'আলফা', 'type' => 'আন্তর্জাতিক প্রশংসিত ড্রামা', 'release_date' => '2019-04-26', 'image' => 'images/galleries/gallery20.jpg'],

            // --- 2020s (২০২০ - ২০২৬) ---
            ['film_name' => 'গণ্ডি', 'type' => 'রোমান্টিক কমেডি ড্রামা', 'release_date' => '2020-02-07', 'image' => 'images/galleries/gallery1.jpg'],
            ['film_name' => 'বিশ্বসুন্দরী', 'type' => 'রোমান্টিক পারিবারিক হিট', 'release_date' => '2020-12-11', 'image' => 'images/galleries/gallery2.jpg'],
            ['film_name' => 'নোনা জলের কাব্য', 'type' => 'আন্তর্জাতিক সমাদৃত ক্লাইমেট ড্রামা', 'release_date' => '2021-11-26', 'image' => 'images/galleries/gallery3.jpg'],
            ['film_name' => 'রিকশা গার্ল', 'type' => 'আন্তর্জাতিক পুরস্কারপ্রাপ্ত ফিচার', 'release_date' => '2021-05-07', 'image' => 'images/galleries/gallery4.jpg'],
            ['film_name' => 'হাওয়া', 'type' => 'মেগা ব্লকবাস্টার মিস্ট্রি ড্রামা', 'release_date' => '2022-07-29', 'image' => 'images/galleries/gallery5.jpg'],
            ['film_name' => 'পরাণ', 'type' => 'ব্লকবাস্টার রোমান্টিক থ্রিলার', 'release_date' => '2022-07-10', 'image' => 'images/galleries/gallery6.jpg'],
            ['film_name' => 'প্রিয়তমা', 'type' => 'অল-টাইম রেকর্ড গড়ে সর্বোচ্চ আয়কারী', 'release_date' => '2023-06-29', 'image' => 'images/galleries/gallery7.jpg'],
            ['film_name' => 'সুরঙ্গ', 'type' => 'মেগা ব্লকবাস্টার ক্রাইম থ্রিলার', 'release_date' => '2023-06-29', 'image' => 'images/galleries/gallery8.jpg'],
            ['film_name' => 'তুফান', 'type' => 'সর্বকালের রেকর্ড সৃষ্টিকারী মেগা অ্যাকশন', 'release_date' => '2024-06-17', 'image' => 'images/galleries/gallery9.jpg'],
            ['film_name' => 'রাজকুমার', 'type' => 'মেগা রোমান্টিক ফ্যামিলি থ্রিলার', 'release_date' => '2024-04-11', 'image' => 'images/galleries/gallery10.jpg'],
            ['film_name' => 'প্রিয়দর্শিনী', 'type' => 'আধুনিক সামাজিক ড্রামা', 'release_date' => '2025-01-10', 'image' => 'images/galleries/gallery11.jpg'],
            ['film_name' => 'বরফ গলার নদী', 'type' => 'সাহিত্যধর্মী পিরিয়ড ক্লাসিক', 'release_date' => '2026-02-20', 'image' => 'images/galleries/gallery12.jpg'],
        ];

        foreach ($data as $item) {
            PhotoGallery::create($item);
        }
    }
}
