<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{env('APP_LOGO')}}">
    <title>Register - {{env('APP_NAME')}}</title>

    <script src="https://kit.fontawesome.com/96498722b6.js" crossorigin="anonymous"></script>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div style="background-image:url('{{asset('website-resource/background-login.jpg')}}')" class="tw-bg-gray-50 tw-font-[sans-serif]" >
        <div class="tw-min-h-screen tw-flex tw-flex-col tw-items-center tw-justify-center tw-py-6 tw-px-4">
            <div class="tw-max-w-md tw-w-full">
                <a href="{{route('login')}}">
                    <img src="{{env('APP_LOGO')}}" alt="{{env('APP_LOGO')}}" class="tw-w-40 tw-mx-auto tw-block"/>
                </a>
    
                <div class="tw-p-8 tw-rounded-2xl tw-bg-white tw-bg-opacity-95 tw-shadow">
                    <h2 class="tw-text-gray-800 tw-text-center tw-text-2xl tw-font-bold">Register</h2>
                    <p class="tw-text-center tw-text-sm">Silahkan isi data untuk mendaftar</p>

                    <form class="tw-mt-8 tw-space-y-4" action="{{route('register')}}" method="POST">
                        @csrf

                        <div class="">
                            <label class="tw-text-gray-800 tw-text-sm tw-mb-2 tw-block">Nama Lengkap</label>
                            <div class="tw-relative tw-flex tw-items-center">
                                <input name="nama_lengkap" type="text" class="tw-w-full tw-text-gray-800 tw-text-sm tw-border tw-border-gray-300 tw-px-4 tw-py-3 tw-rounded-md tw-outline-blue-600" placeholder="Nama Lengkap" required/>

                                <span class="tw-w-4 tw-h-4 tw-absolute tw-right-4">
                                    <i class="tw-opacity-70 fas fa-user"></i>
                                </span>
                            </div>
                        </div>

                        <div class="">
                            <label class="tw-text-gray-800 tw-text-sm tw-mb-2 tw-block">Email</label>
                            <div class="tw-relative tw-flex tw-items-center">
                                <input name="email" id="email" type="email" class="tw-w-full tw-text-gray-800 tw-text-sm tw-border tw-border-gray-300 tw-px-4 tw-py-3 tw-rounded-md tw-outline-blue-600" placeholder="nama@email.com" required/>

                                <span class="tw-w-4 tw-h-4 tw-absolute tw-right-4">
                                    <i class="tw-opacity-70 fas fa-envelope"></i>
                                </span>
                            </div>
                            
                            <p class="tw-mt-1 tw-text-xs tw-font-bold tw-invisible" id="alertEmail"></p>
                        </div>

                        <div class="">
                            <label class="tw-text-gray-800 tw-text-sm tw-mb-2 tw-block">Nomor SIM</label>
                            <div class="tw-relative tw-flex tw-items-center">
                                <input name="nomor_sim" id="nomor_sim" type="number" class="tw-w-full tw-text-gray-800 tw-text-sm tw-border tw-border-gray-300 tw-px-4 tw-py-3 tw-rounded-md tw-outline-blue-600" placeholder="00058xxxxxxx" required/>

                                <span class="tw-w-4 tw-h-4 tw-absolute tw-right-4">
                                    <i class="tw-opacity-70 fas fa-id-card"></i>
                                </span>
                            </div>

                            <p class="tw-mt-1 tw-text-xs tw-font-bold tw-invisible" id="alertSim"></p>
                        </div>

                        <div class="">
                            <label class="tw-text-gray-800 tw-text-sm tw-mb-2 tw-block">Alamat</label>
                            <div class="tw-relative tw-flex tw-items-center">
                                <textarea name="alamat" id="alamat" cols="30" rows="3" class="tw-w-full tw-text-gray-800 tw-text-sm tw-border tw-border-gray-300 tw-px-4 tw-py-3 tw-rounded-md tw-outline-blue-600" placeholder="Alamat lengkap" required></textarea>
                            </div>
                        </div>
        
                        <div>
                            <label class="tw-text-gray-800 tw-text-sm tw-mb-2 tw-block">Password</label>
                            <div class="tw-relative tw-flex tw-items-center">
                                <input name="password" id="password" type="password" class="tw-w-full tw-text-gray-800 tw-text-sm tw-border tw-border-gray-300 tw-px-4 tw-py-3 tw-rounded-md tw-outline-blue-600" placeholder="Enter password" required/>

                                <span class="tw-w-4 tw-h-4 tw-absolute tw-right-4 tw-cursor-pointer" id="togglePassword">
                                    <i class="tw-opacity-70 fas fa-eye"></i>
                                </span>
                            </div>

                            <p class="tw-text-sm tw-text-red-600 tw-invisible" id="alertPassword">Minimal 8 karakter</p>
                        </div>
        
                        <div>
                            <label class="tw-text-gray-800 tw-text-sm tw-mb-2 tw-block">Konfirmasi Password</label>
                            <div class="tw-relative tw-flex tw-items-center">
                                <input name="password_confirmation" id="password_confirmation" type="password" class="tw-w-full tw-text-gray-800 tw-text-sm tw-border tw-border-gray-300 tw-px-4 tw-py-3 tw-rounded-md tw-outline-blue-600" placeholder="Enter password" required/>

                                <span class="tw-w-4 tw-h-4 tw-absolute tw-right-4 tw-cursor-pointer" id="toggleKonfirmasiPassword">
                                    <i class="tw-opacity-70 fas fa-eye"></i>
                                </span>
                            </div>

                            <p class="tw-text-sm tw-text-red-600 tw-invisible" id="alertKonfirmasi">Tidak sama dengan password</p>
                        </div>
        
                        <div class="!mt-8">
                            <button type="submit" id="buttonSubmit" class="tw-w-full tw-py-3 tw-px-4 tw-text-sm tw-tracking-wide tw-rounded-lg tw-text-white tw-bg-blue-600 hover:tw-bg-blue-700 focus:tw-outline-none">
                                Daftar
                            </button>
                        </div>
                        <p class="tw-text-gray-800 tw-text-sm !tw-mt-8 tw-text-center">
                            Sudah punya akun? <a href="{{route('login')}}" class="tw-text-blue-600 hover:tw-underline tw-ml-1 tw-whitespace-nowrap tw-font-semibold">Login</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script>
        let debounceTimer;
        const buttonSubmit = document.getElementById('buttonSubmit');

        const email = document.getElementById('email');
        const alertEmail = document.getElementById('alertEmail');
        
        const nomor_sim = document.getElementById('nomor_sim');
        const alertSim = document.getElementById('alertSim');

        const togglePassword = document.querySelector('#togglePassword');
        const toggleKonfirmasiPassword = document.querySelector('#toggleKonfirmasiPassword');

        const password = document.querySelector('#password');
        const alertPassword = document.querySelector('#alertPassword');

        const konfirmasi_password = document.querySelector('#password_confirmation');
        const alertKonfirmasi = document.querySelector('#alertKonfirmasi');

        function toggleVisibility(element, icon) {
            const type = element.getAttribute('type') === 'password' ? 'text' : 'password';
            element.setAttribute('type', type);
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        }

        togglePassword.addEventListener('click', () => toggleVisibility(password, togglePassword.querySelector('i')));
        toggleKonfirmasiPassword.addEventListener('click', () => toggleVisibility(konfirmasi_password, toggleKonfirmasiPassword.querySelector('i')));

        [password, konfirmasi_password].forEach(element => {
            element.addEventListener('input', () => {
                if (element == password) {
                    if (password.value.length < 8) {
                        passValid = false;
                    } else {
                        passValid = true;
                    }
                    alertPassword.classList.toggle('tw-invisible', passValid);
                    const isMatch = password.value === konfirmasi_password.value;
                    buttonSubmit.disabled = !isMatch;
                    alertKonfirmasi.classList.toggle('tw-invisible', isMatch);
                } else {
                    const isMatch = password.value === konfirmasi_password.value;
                    buttonSubmit.disabled = !isMatch;
                    alertKonfirmasi.classList.toggle('tw-invisible', isMatch);
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function(){
            email.addEventListener('input', function () {
                clearTimeout(debounceTimer);

                // Reset alert style
                alertEmail.classList.add('tw-text-gray-600');
                alertEmail.classList.remove('tw-text-green-600', 'tw-text-red-600', 'tw-invisible');
                alertEmail.innerHTML = 'checking...';
                buttonSubmit.disabled = true;

                debounceTimer = setTimeout(() => {
                    const emailValue = this.value.trim();
                    const token = "{{ csrf_token() }}";
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Simple email validation regex


                    if (emailValue === "") {
                        alertEmail.classList.add('tw-text-red-600');
                        alertEmail.classList.remove('tw-text-green-600', 'tw-text-gray-600');
                        alertEmail.innerHTML = 'Email wajib diisi!';
                        buttonSubmit.disabled = true;
                    } else if (!emailRegex.test(emailValue)) {
                        alertEmail.classList.add('tw-text-red-600');
                        alertEmail.classList.remove('tw-text-green-600', 'tw-text-gray-600');
                        alertEmail.innerHTML = 'Masukkan email valid!';
                        buttonSubmit.disabled = true;
                    } else {
                        $.ajax({
                            type: "POST",
                            url: "/check-email",
                            data: {
                                _token: token,
                                email: emailValue
                            },
                            success: function (response) {
                                if (response.exists) {
                                    alertEmail.classList.add('tw-text-red-600');
                                    alertEmail.classList.remove('tw-text-green-600', 'tw-text-gray-600');
                                    alertEmail.innerHTML = response.message;
                                    buttonSubmit.disabled = true;
                                } else {
                                    alertEmail.classList.add('tw-text-green-600');
                                    alertEmail.classList.remove('tw-text-red-600', 'tw-text-gray-600');
                                    alertEmail.innerHTML = response.message;
                                    buttonSubmit.disabled = false;
                                }
                            }
                        });
                    }
                }, 2000); // Delay of 2 seconds
            });

            nomor_sim.addEventListener('input', function () {
                clearTimeout(debounceTimer);

                // Reset alert style
                alertSim.classList.add('tw-text-gray-600');
                alertSim.classList.remove('tw-text-green-600', 'tw-text-red-600', 'tw-invisible');
                alertSim.innerHTML = 'checking...';
                buttonSubmit.disabled = true;
                
                debounceTimer = setTimeout(() => {
                    const simValue = this.value.trim();
                    const token = "{{ csrf_token() }}";

                    if (simValue === "") {
                        alertSim.classList.add('tw-text-red-600');
                        alertSim.classList.remove('tw-text-green-600', 'tw-text-gray-600');
                        alertSim.innerHTML = 'Nomor SIM wajib diisi!';
                        buttonSubmit.disabled = true;
                    } else {
                        $.ajax({
                            type: "POST",
                            url: "/check-sim",
                            data: {
                                _token: token,
                                nomor_sim: simValue
                            },
                            success: function (response) {
                                if (response.exists) {
                                    alertSim.classList.add('tw-text-red-600');
                                    alertSim.classList.remove('tw-text-green-600', 'tw-text-gray-600');
                                    alertSim.innerHTML = response.message;
                                    buttonSubmit.disabled = true;
                                } else {
                                    alertSim.classList.add('tw-text-green-600');
                                    alertSim.classList.remove('tw-text-red-600', 'tw-text-gray-600');
                                    alertSim.innerHTML = response.message;
                                    buttonSubmit.disabled = false;
                                }
                            }
                        });
                    }
                }, 2000); // Delay of 2 seconds
            });
        });
    </script>
    
    @include('sweetalert::alert')
</body>
</html>