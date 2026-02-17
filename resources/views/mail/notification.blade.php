<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $data['subject'] ?? 'Notification Mail' }}</title>
</head>
<body>
@if($data['type'] === 'registration_approval')
    <p>প্রিয় {{ $data['producer_name'] }},</p>
    <p>আমাদের সিস্টেমে আপনার নিবন্ধন সফলভাবে
        @if($data['status']== 'verified') অনুমোদন
        @elseif($data['status']== 'approved') অনুমোদন
        @else প্রত্যাখ্যান @endif
        সম্পন্ন হয়েছে।
    </p>
    @if($data['status']== 'verified')
        <p>আপনার নিবন্ধন অনুমোদিত হয়েছে এবং আপনি এখন থেকে আপনার নিবন্ধন সার্টিফিকেট ডাউনলোড করতে পারবেন।</p>
        <p>সার্টিফিকেটটি আপনার প্রোফাইল থেকে ডাউনলোড করা যাবে।</p>
    @endif
    @if($data['status']== 'approved')
        <p>আপনার নিবন্ধন অনুমোদিত হয়েছে এবং আপনি এখন থেকে FDC থেকে সুযোগ সুবিধা নিতে পারবেন ।</p>
    @endif
@elseif($data['type'] === 'service_acceptance')
    <p>প্রিয় {{ $data['producer_name'] }},</p>
    @if($data['status'] === 'reject')
        <p>আপনার {{ $data['service_name'] }} (শিরোনাম : {{ $data['title'] }}) বিষয়ে  করা আবেদন  সফলভাবে  প্রত্যাখ্যান করা হয়েছে। </p>
    @else
        <p>আপনার {{ $data['service_name'] }} (শিরোনাম : {{ $data['title'] }}) বিষয়ে  করা আবেদন  সফলভাবে  গ্রহণ করা হয়েছে। </p>
        <p>এখন আপনি আপনার প্রোফাইলে লগইন করে আপনার শিডিউল বুক করতে পারবেন। </p>
        <p>অনুগ্রহ করে আপনার আবেদন প্রক্রিয়ার পরবর্তী ধাপ সম্পন্ন করার জন্য সঠিক সময় অনুযায়ী শিডিউল বুক করুন। আপনার প্রদত্ত তথ্য যাচাইয়ের পর আমাদের দল আপনাকে প্রয়োজনীয় পরবর্তী নির্দেশনা সরবাহ করবে। </p>
    @endif
    <p>আপনার সহযোগীতার জন্য ধন্যবাদ।</p>
@else
    <h3>নোটিফিকেশন</h3>
    <p>{{ $data['message'] ?? '' }}</p>
@endif

<br>
<strong>ধন্যবাদ,</strong><br>
{{ strtoupper(config('app.name')) }}
</body>
</html>
