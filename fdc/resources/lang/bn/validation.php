<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute অবশ্যই গ্রহণ করতে হবে।',
    'active_url' => ':attribute একটি বৈধ URL নয়।',
    'after' => ':attribute অবশ্যই :date-এর পরের তারিখ হতে হবে।',
    'after_or_equal' => ':attribute অবশ্যই :date-এর পরের বা সমান তারিখ হতে হবে।',
    'alpha' => ':attribute শুধুমাত্র অক্ষর ধারণ করতে পারে।',
    'alpha_dash' => ':attribute শুধুমাত্র অক্ষর, সংখ্যা, ড্যাশ এবং আন্ডারস্কোর ধারণ করতে পারে।',
    'alpha_num' => ':attribute শুধুমাত্র অক্ষর এবং সংখ্যা ধারণ করতে পারে।',
    'array' => ':attribute অবশ্যই একটি অ্যারে হতে হবে।',
    'before' => ':attribute অবশ্যই :date-এর আগের তারিখ হতে হবে।',
    'before_or_equal' => ':attribute অবশ্যই :date-এর আগের বা সমান তারিখ হতে হবে।',
    'between' => [
        'numeric' => ':attribute অবশ্যই :min এবং :max-এর মধ্যে হতে হবে।',
        'file' => ':attribute অবশ্যই :min এবং :max কিলোবাইটের মধ্যে হতে হবে।',
        'string' => ':attribute অবশ্যই :min এবং :max অক্ষরের মধ্যে হতে হবে।',
        'array' => ':attribute অবশ্যই :min এবং :max আইটেমের মধ্যে থাকতে হবে।',
    ],
    'boolean' => ':attribute ফিল্ড অবশ্যই সত্য বা মিথ্যা হতে হবে।',
    'confirmed' => ':attribute নিশ্চিতকরণ মেলে না।',
    'date' => ':attribute একটি বৈধ তারিখ নয়।',
    'date_equals' => ':attribute অবশ্যই :date-এর সমান তারিখ হতে হবে।',
    'date_format' => ':attribute :format ফরম্যাটের সাথে মেলে না।',
    'different' => ':attribute এবং :other অবশ্যই ভিন্ন হতে হবে।',
    'digits' => ':attribute অবশ্যই :digits অঙ্ক হতে হবে।',
    'digits_between' => ':attribute অবশ্যই :min এবং :max অঙ্কের মধ্যে হতে হবে।',
    'dimensions' => ':attribute-এর ছবির মাত্রা অবৈধ।',
    'distinct' => ':attribute ফিল্ডের একটি সদৃশ মান আছে।',
    'email' => ':attribute অবশ্যই একটি বৈধ ইমেল ঠিকানা হতে হবে।',
    'ends_with' => ':attribute অবশ্যই নিম্নলিখিতগুলির মধ্যে একটি দিয়ে শেষ হতে হবে: :values।',
    'exists' => 'নির্বাচিত :attribute অবৈধ।',
    'file' => ':attribute অবশ্যই একটি ফাইল হতে হবে।',
    'filled' => ':attribute ফিল্ডের একটি মান থাকতে হবে।',
    'gt' => [
        'numeric' => ':attribute অবশ্যই :value-এর চেয়ে বড় হতে হবে।',
        'file' => ':attribute অবশ্যই :value কিলোবাইটের চেয়ে বড় হতে হবে।',
        'string' => ':attribute অবশ্যই :value অক্ষরের চেয়ে বড় হতে হবে।',
        'array' => ':attribute-এর :value-এর বেশি আইটেম থাকতে হবে।',
    ],
    'gte' => [
        'numeric' => ':attribute অবশ্যই :value-এর চেয়ে বড় বা সমান হতে হবে।',
        'file' => ':attribute অবশ্যই :value কিলোবাইটের চেয়ে বড় বা সমান হতে হবে।',
        'string' => ':attribute অবশ্যই :value অক্ষরের চেয়ে বড় বা সমান হতে হবে।',
        'array' => ':attribute-এর :value আইটেম বা তার বেশি থাকতে হবে।',
    ],
    'image' => ':attribute অবশ্যই একটি ছবি হতে হবে।',
    'in' => 'নির্বাচিত :attribute অবৈধ।',
    'in_array' => ':attribute ফিল্ড :other-এ বিদ্যমান নেই।',
    'integer' => ':attribute অবশ্যই একটি পূর্ণসংখ্যা হতে হবে।',
    'ip' => ':attribute অবশ্যই একটি বৈধ IP ঠিকানা হতে হবে।',
    'ipv4' => ':attribute অবশ্যই একটি বৈধ IPv4 ঠিকানা হতে হবে।',
    'ipv6' => ':attribute অবশ্যই একটি বৈধ IPv6 ঠিকানা হতে হবে।',
    'json' => ':attribute অবশ্যই একটি বৈধ JSON স্ট্রিং হতে হবে।',
    'lt' => [
        'numeric' => ':attribute অবশ্যই :value-এর চেয়ে ছোট হতে হবে।',
        'file' => ':attribute অবশ্যই :value কিলোবাইটের চেয়ে ছোট হতে হবে।',
        'string' => ':attribute অবশ্যই :value অক্ষরের চেয়ে ছোট হতে হবে।',
        'array' => ':attribute-এর :value-এর কম আইটেম থাকতে হবে।',
    ],
    'lte' => [
        'numeric' => ':attribute অবশ্যই :value-এর চেয়ে ছোট বা সমান হতে হবে।',
        'file' => ':attribute অবশ্যই :value কিলোবাইটের চেয়ে ছোট বা সমান হতে হবে।',
        'string' => ':attribute অবশ্যই :value অক্ষরের চেয়ে ছোট বা সমান হতে হবে।',
        'array' => ':attribute-এর :value-এর বেশি আইটেম থাকা উচিত নয়।',
    ],
    'max' => [
        'numeric' => ':attribute :max-এর চেয়ে বড় নাও হতে পারে।',
        'file' => ':attribute :max কিলোবাইটের চেয়ে বড় নাও হতে পারে।',
        'string' => ':attribute :max অক্ষরের চেয়ে বড় নাও হতে পারে।',
        'array' => ':attribute-এর :max-এর বেশি আইটেম নাও থাকতে পারে।',
    ],
    'mimes' => ':attribute অবশ্যই :values ধরনের একটি ফাইল হতে হবে।',
    'mimetypes' => ':attribute অবশ্যই :values ধরনের একটি ফাইল হতে হবে।',
    'min' => [
        'numeric' => ':attribute অবশ্যই কমপক্ষে :min হতে হবে।',
        'file' => ':attribute অবশ্যই কমপক্ষে :min কিলোবাইট হতে হবে।',
        'string' => ':attribute অবশ্যই কমপক্ষে :min অক্ষর হতে হবে।',
        'array' => ':attribute-এর অবশ্যই কমপক্ষে :min আইটেম থাকতে হবে।',
    ],
    'not_in' => 'নির্বাচিত :attribute অবৈধ।',
    'not_regex' => ':attribute ফরম্যাট অবৈধ।',
    'numeric' => ':attribute অবশ্যই একটি সংখ্যা হতে হবে।',
    'password' => 'পাসওয়ার্ড ভুল।',
    'present' => ':attribute ফিল্ড অবশ্যই উপস্থিত থাকতে হবে।',
    'regex' => ':attribute ফরম্যাট অবৈধ।',
    'required' => ':attribute ফিল্ড আবশ্যক।',
    'required_if' => ':other :value হলে :attribute ফিল্ড আবশ্যক।',
    'required_unless' => ':other :values-এ না থাকলে :attribute ফিল্ড আবশ্যক।',
    'required_with' => ':values উপস্থিত থাকলে :attribute ফিল্ড আবশ্যক।',
    'required_with_all' => ':values উপস্থিত থাকলে :attribute ফিল্ড আবশ্যক।',
    'required_without' => ':values উপস্থিত না থাকলে :attribute ফিল্ড আবশ্যক।',
    'required_without_all' => ':values-এর কোনোটিই উপস্থিত না থাকলে :attribute ফিল্ড আবশ্যক।',
    'same' => ':attribute এবং :other অবশ্যই মিলতে হবে।',
    'size' => [
        'numeric' => ':attribute অবশ্যই :size হতে হবে।',
        'file' => ':attribute অবশ্যই :size কিলোবাইট হতে হবে।',
        'string' => ':attribute অবশ্যই :size অক্ষর হতে হবে।',
        'array' => ':attribute অবশ্যই :size আইটেম ধারণ করতে হবে।',
    ],
    'starts_with' => ':attribute অবশ্যই নিম্নলিখিতগুলির মধ্যে একটি দিয়ে শুরু হতে হবে: :values।',
    'string' => ':attribute অবশ্যই একটি স্ট্রিং হতে হবে।',
    'timezone' => ':attribute অবশ্যই একটি বৈধ জোন হতে হবে।',
    'unique' => ':attribute ইতোমধ্যে নেওয়া হয়েছে।',
    'uploaded' => ':attribute আপলোড করতে ব্যর্থ হয়েছে।',
    'url' => ':attribute ফরম্যাট অবৈধ।',
    'uuid' => ':attribute অবশ্যই একটি বৈধ UUID হতে হবে।',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
