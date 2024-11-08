<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{env('APP_LOGO')}}">
    <title>Login - {{env('APP_NAME')}}</title>

    <script src="https://kit.fontawesome.com/96498722b6.js" crossorigin="anonymous"></script>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- component -->
    <div class="tw-relative tw-h-screen tw-w-full tw-bg-cover tw-bg-no-repeat" style="background-image:url('{{asset('website-resource/background-login.jpg')}}')">
        <!-- Overlay abu-abu dengan opacity -->
        <div class="tw-absolute tw-inset-0 tw-bg-gray-700 tw-opacity-50"></div>
    
        <!-- Konten login -->
        <div class="tw-flex tw-h-full tw-items-center tw-justify-center">
            <div class="tw-relative tw-rounded-xl tw-bg-gray-800 tw-bg-opacity-50 tw-px-16 tw-py-10 tw-shadow-lg tw-backdrop-blur-md tw-max-sm:px-8">
                <div class="tw-text-white tw-flex tw-flex-col tw-justify-center tw-items-center">
                    <div class="tw-mb-8 tw-flex tw-flex-col tw-justify-center tw-items-center">
                        <img src="{{env('APP_LOGO')}}" width="125" alt="" srcset="" />
                        <h1 class="tw-mb-2 tw-text-2xl">{{env('APP_NAME')}}</h1>
                        <span class="tw-text-gray-300">Silahkan login untuk memulai aplikasi</span>
                    </div>

                    <form action="{{url('/login')}}" method="POST">
                        @csrf

                        <div class="tw-mb-4 tw-text-lg tw-flex tw-flex-col">
                            <input class="tw-rounded-3xl tw-border-none tw-bg-yellow-400 tw-bg-opacity-50 tw-px-12 tw-py-2 tw-text-center tw-text-inherit tw-placeholder-slate-200 tw-shadow-lg tw-outline-none tw-backdrop-blur-md" type="text" name="email" placeholder="Email" required/>

                            @error('email')
                                <span role="alert" class="tw-text-red-400 tw-text-sm tw-mt-2">{{$message}}</span>
                            @enderror
                        </div>
    
                        <div class="tw-mb-4 tw-text-lg tw-relative tw-flex tw-items-center">
                            <input id="password" class="tw-rounded-3xl tw-border-none tw-bg-yellow-400 tw-bg-opacity-50 tw-px-12 tw-py-2 tw-text-center tw-text-inherit tw-placeholder-slate-200 tw-shadow-lg tw-outline-none tw-backdrop-blur-md tw-w-full" type="password" name="password" placeholder="Password" required/>
                            <span id="togglePassword" class="tw-absolute tw-right-4 tw-top-1/2 tw-transform tw--translate-y-1/2 tw-cursor-pointer">
                                <i class="fas fa-eye tw-text-white"></i>
                            </span>
                        </div>

                        <div class="tw-mt-8 tw-flex tw-justify-center tw-text-lg tw-text-black">
                            <button type="submit" class="tw-rounded-3xl tw-bg-yellow-400 tw-bg-opacity-50 tw-px-10 tw-py-2 tw-text-white tw-shadow-xl tw-backdrop-blur-md tw-transition-colors tw-duration-300 hover:tw-bg-yellow-500">Login</button>
                        </div>

                        <div class="tw-mt-5 tw-text-center tw-justify-center tw-text-md tw-text-black">
                            <span class="tw-text-white">Belum punya akun?</span> <a href="{{route('register')}}" class="tw-font-bold tw-text-white hover:tw-text-yellow-500 hover:tw-scale-105">Daftar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    @include('sweetalert::alert')
    
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const icon = togglePassword.querySelector('i');
    
        togglePassword.addEventListener('click', function () {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            // toggle the eye icon
            if (type === 'password') {
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        });
    </script>
</body>
</html>