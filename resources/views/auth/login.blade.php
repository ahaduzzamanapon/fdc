<!DOCTYPE html>
<html lang="bn">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>এফডিসি লগইন</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@100..900&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    p {
      margin: 8px;
      padding: 0;
    }
    body {
      background-color: #D9DDFF;
      
      font-family: 'Segoe UI', sans-serif;
    }

    .login-wrapper {
      background: #ECF2FAB8;
     

      border-radius: 16px;
      max-width: 550px;
      width: 100%;
      margin: auto;
    }

    .form-control {
      background-color: rgba(255, 255, 255, 0.6);
      border: none;
      border-radius: 4px;
      color: #000;
    }

    .form-control::placeholder {
      color: #555;
    }

    .form-icon {
      position: absolute;
      left: 10px;
      top: 50%;
      transform: translateY(-50%);
      color: #333;
    }

    .input-group {
      position: relative;
      margin-bottom: 20px;
    }

    .input-group input {
      padding-left: 13px;
    }

    .btn-login {
      background-color: #001bfe;
      color: white;
      font-weight: bold;
    }

    .logo-text {
      font-size: 1.2rem;
      font-weight: bold;
      display: flex;
      align-items: center;
      gap: 10px;
      justify-self: center;
    }

    .logo-text img {
      height: 6.5rem;
    }

    @media (max-width: 576px) {
      .logo-text img {
        height: 5rem;
      }
    }

    .login_text {
      font-family: 'Noto Sans Bengali', sans-serif;
      font-weight: 600;
      font-size: 20px;
      line-height: 19.5px;
      vertical-align: middle;
    }

    .helper-text {
      font-size: 0.9rem;
    }

    .text-link {
      text-decoration: none;
    }

    footer {
      font-family: "Noto Sans Bengali", sans-serif;
      font-weight: 500;
      font-size: 16px !important;
      border-top: 2px solid #5f5e5e;
      padding: 18px 0px 0px 0px;
      display: flex;
      place-content: center;
      justify-content: space-between;
      flex-wrap: wrap;
      color: #000000;
      margin-top: 18px;
    }

    @media (max-width: 576px) {
      .login-wrapper {
        padding: 30px 20px;
      }

      footer {
        font-family: "Noto Sans Bengali", sans-serif;
        font-weight: 500;
        font-size: 16px !important;
        border-top: 2px solid #5f5e5e;
        padding: 18px 0px 0px 0px;
        display: flex;
        place-content: center;
        justify-content: space-between;
        flex-wrap: wrap;
        color: #000000;
        margin-top: 18px;
        place-content: center;
        gap: 13px;
      }
    }

    .btn:hover {
      color: #ffffff;
      background-color: #0314a3;
      border-color: var(--bs-btn-hover-border-color);
    }
  </style>
</head>

<body
  style="">

  <div class="container d-flex flex-column justify-content-center align-items-center min-vh-100">
    <div class="login-wrapper text-center text-dark">
      <div style="padding: 40px 30px;">
        <div class="logo-text mb-4">
          <img src="{{ asset('images/logo.svg') }}" alt="logo">
        </div>
         @include('flash::message')
        <ul class="nav nav-tabs mb-4 col-md-12" id="myTab" role="tablist">
          <li class="nav-item col-md-6" role="presentation">
            <button class="nav-link active col-md-12" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button"
              role="tab" aria-controls="login" aria-selected="true">প্রশাসনিক</button>
          </li>
          <li class="nav-item col-md-6" role="presentation">
            <button class="nav-link col-md-12" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button"
              role="tab" aria-controls="register" aria-selected="false">প্রযোজক</button>
          </li>
        </ul>

        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
            <form action="{{ route('login') }}" method="POST">
              @csrf
              <p
                style="justify-self: left;font-family: 'Noto Sans Bengali', sans-serif;font-weight: 600;font-size: 16px;line-height: 100%;vertical-align: middle;color: #000000;">
                মোবাইল/ইমেইল</p>
              <div class="input-group mb-3">
                <svg width="68" height="51" viewBox="0 0 68 51" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M0 4C0 1.79086 1.79086 0 4 0H68V51H4C1.79086 51 0 49.2091 0 47V4Z" fill="#001BFE" />
                  <path
                    d="M34 26C37.3141 26 40 23.3141 40 20C40 16.6859 37.3141 14 34 14C30.6859 14 28 16.6859 28 20C28 23.3141 30.6859 26 34 26ZM38.4906 27.5281L36.25 36.5L34.75 30.125L36.25 27.5H31.75L33.25 30.125L31.75 36.5L29.5094 27.5281C26.1672 27.6875 23.5 30.4203 23.5 33.8V35.75C23.5 36.9922 24.5078 38 25.75 38H42.25C43.4922 38 44.5 36.9922 44.5 35.75V33.8C44.5 30.4203 41.8328 27.6875 38.4906 27.5281Z"
                    fill="white" />
                </svg>
                <input type="text" class="form-control" name="username" placeholder="মোবাইল/ইমেইল" required>
              </div>
              <p
                style="justify-self: left;font-family: 'Noto Sans Bengali', sans-serif;font-weight: 600;font-size: 16px;line-height: 100%;vertical-align: middle;color: #000000;">
                পাসওয়ার্ড</p>
              <div class="input-group mb-3">
                <svg width="68" height="51" viewBox="0 0 68 51" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M0 4C0 1.79086 1.79086 0 4 0H68V51H4C1.79086 51 0 49.2091 0 47V4Z" fill="#001BFE" />
                  <g clip-path="url(#clip0_157_63)">
                    <path
                      d="M42.4375 21.75H41.5V18C41.5 13.8637 38.1363 10.5 34 10.5C29.8637 10.5 26.5 13.8637 26.5 18V21.75H25.5625C24.0125 21.75 22.75 23.0112 22.75 24.5625V37.6875C22.75 39.2388 24.0125 40.5 25.5625 40.5H42.4375C43.9875 40.5 45.25 39.2388 45.25 37.6875V24.5625C45.25 23.0112 43.9875 21.75 42.4375 21.75ZM29 18C29 15.2425 31.2425 13 34 13C36.7575 13 39 15.2425 39 18V21.75H29V18ZM35.25 31.4025V34.25C35.25 34.94 34.6912 35.5 34 35.5C33.3088 35.5 32.75 34.94 32.75 34.25V31.4025C32.0062 30.9688 31.5 30.1712 31.5 29.25C31.5 27.8712 32.6212 26.75 34 26.75C35.3788 26.75 36.5 27.8712 36.5 29.25C36.5 30.1712 35.9938 30.9688 35.25 31.4025Z"
                      fill="white" />
                  </g>
                  <defs>
                    <clipPath id="clip0_157_63">
                      <rect width="30" height="30" fill="white" transform="translate(19 10.5)" />
                    </clipPath>
                  </defs>
                </svg>
                <input type="password" class="form-control" name="password" placeholder="পাসওয়ার্ড" required>
              </div>

              <div class="d-flex justify-content-between helper-text mb-3">
                <a style="font-family: 'Noto Sans Bengali', sans-serif;font-weight: 500;font-size: 16px;line-height: 120%;color: #000000;"
                  href="#" class="text-link">পাসওয়ার্ড ভুলে গেছেন?</a>
              </div>
              <button type="submit" class="btn btn-login w-100">লগইন করুন</button>
            </form>
          </div>
          <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
            <form action="{{ route('producers_login') }}" method="POST">
              @csrf
              <p
                style="justify-self: left;font-family: 'Noto Sans Bengali', sans-serif;font-weight: 600;font-size: 16px;line-height: 100%;vertical-align: middle;color: #000000;">
                মোবাইল/ইমেইল</p>
              <div class="input-group mb-3">
                <svg width="68" height="51" viewBox="0 0 68 51" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M0 4C0 1.79086 1.79086 0 4 0H68V51H4C1.79086 51 0 49.2091 0 47V4Z" fill="#001BFE" />
                  <path
                    d="M34 26C37.3141 26 40 23.3141 40 20C40 16.6859 37.3141 14 34 14C30.6859 14 28 16.6859 28 20C28 23.3141 30.6859 26 34 26ZM38.4906 27.5281L36.25 36.5L34.75 30.125L36.25 27.5H31.75L33.25 30.125L31.75 36.5L29.5094 27.5281C26.1672 27.6875 23.5 30.4203 23.5 33.8V35.75C23.5 36.9922 24.5078 38 25.75 38H42.25C43.4922 38 44.5 36.9922 44.5 35.75V33.8C44.5 30.4203 41.8328 27.6875 38.4906 27.5281Z"
                    fill="white" />
                </svg>
                <input type="text" class="form-control" name="username" placeholder="মোবাইল/ইমেইল" required>
              </div>
              <p
                style="justify-self: left;font-family: 'Noto Sans Bengali', sans-serif;font-weight: 600;font-size: 16px;line-height: 100%;vertical-align: middle;color: #000000;">
                পাসওয়ার্ড</p>


              <div class="input-group mb-3">
                <svg width="68" height="51" viewBox="0 0 68 51" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M0 4C0 1.79086 1.79086 0 4 0H68V51H4C1.79086 51 0 49.2091 0 47V4Z" fill="#001BFE" />
                  <g clip-path="url(#clip0_157_63)">
                    <path
                      d="M42.4375 21.75H41.5V18C41.5 13.8637 38.1363 10.5 34 10.5C29.8637 10.5 26.5 13.8637 26.5 18V21.75H25.5625C24.0125 21.75 22.75 23.0112 22.75 24.5625V37.6875C22.75 39.2388 24.0125 40.5 25.5625 40.5H42.4375C43.9875 40.5 45.25 39.2388 45.25 37.6875V24.5625C45.25 23.0112 43.9875 21.75 42.4375 21.75ZM29 18C29 15.2425 31.2425 13 34 13C36.7575 13 39 15.2425 39 18V21.75H29V18ZM35.25 31.4025V34.25C35.25 34.94 34.6912 35.5 34 35.5C33.3088 35.5 32.75 34.94 32.75 34.25V31.4025C32.0062 30.9688 31.5 30.1712 31.5 29.25C31.5 27.8712 32.6212 26.75 34 26.75C35.3788 26.75 36.5 27.8712 36.5 29.25C36.5 30.1712 35.9938 30.9688 35.25 31.4025Z"
                      fill="white" />
                  </g>
                  <defs>
                    <clipPath id="clip0_157_63">
                      <rect width="30" height="30" fill="white" transform="translate(19 10.5)" />
                    </clipPath>
                  </defs>
                </svg>

                <input type="password" class="form-control" name="password" placeholder="পাসওয়ার্ড" required>
              </div>

              <div class="d-flex justify-content-between helper-text mb-3">
                <a style="font-family: 'Noto Sans Bengali', sans-serif;font-weight: 500;font-size: 16px;line-height: 120%;color: #000000;"
                  href="#" class="text-link">পাসওয়ার্ড ভুলে গেছেন?</a>
                <span
                  style="font-family: 'Noto Sans Bengali', sans-serif;font-weight: 500;font-size: 16px;line-height: 120%;color: #000000;"
                  href="#" class="">অ্যাকাউন্ট নেই? <a href="{{ route('register') }}" class="text-primary text-link">
                    নিবন্ধন</a> </span>
              </div>
              <button type="submit" class="btn btn-login w-100">লগইন করুন</button>
            </form>
          </div>




        </div>
        <footer class="text-center">
          <span>Copyrights © 2025 - FDC</span>
          <span> কারিগরি সহায়তায়: <a href="https://mysoftheaven.com"><svg width="130" height="23" viewBox="0 0 130 23"
                fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <rect width="129.749" height="22.8986" fill="url(#pattern0_18_49)" />
                <defs>
                  <pattern id="pattern0_18_49" patternContentUnits="objectBoundingBox" width="1" height="1">
                    <use xlink:href="#image0_18_49" transform="matrix(0.00289855 0 0 0.016424 0 -0.00914325)" />
                  </pattern>
                  <image id="image0_18_49" width="345" height="62" preserveAspectRatio="none"
                    xlink:href="data:image/png;base64,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" />
                </defs>
              </svg>
            </a></span>
        </footer>
      </div>
    </div>

</body>

</html>