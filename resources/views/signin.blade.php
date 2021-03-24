<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <title>Aslisemua - Sign In</title>
</head>
<body class="antialiased flex flex-col h-full">
  <main class="flex justify-between flex-row flex-wrap w-full h-full">
    {{-- LEFT SIDE --}}
    <form class="flex justify-center items-center w-full md:w-1/2 p-4" id="signInForm" name="signInForm">
      <div class="flex flex-col">
        @csrf
        <h1 class="text-3xl font-serif text-center mb-6">Welcome Back</h1>
        <div class="mb-5 flex flex-col w-full md:w-72">
          <label for="email" class="text-base mb-2">Email</label>
          <input type="text" name="email" id="email" placeholder="your@email.com" required class="input-primary">
        </div>
        <div class="mb-5 flex flex-col w-full md:w-72">
          <label for="email" class="text-base mb-2">Password</label>
          <input type="password" name="password" id="password" required class="input-primary">
        </div>
        <p class="text-xs mb-5">Forgot password? <a class="text-red-800 font-bold hover:underline" href="#">Click here</a></p>
        <button type="submit" class="btn-primary mb-5">Sign In</button>
        <a href="{{ route('googlesignin') }}" class="bg-white border border-gray-800 py-2 px-6 text-justify"><i class="fab fa-google mr-2"></i>Sign In With Google</a>
      </div>
    </form>
    {{-- RIGHT SIDE --}}
    <div class="flex flex-col justify-center items-center w-full md:w-1/2 p-4 text-white" id="signInRightSide">
      <h1 class="text-3xl font-serif text-center mb-16">New User</h1>
      <div class="mb-16 h-16 text-center">
        <p class="text-lg mb-3">Create an account to start buying and selling your wardrobe</p>
        <p class="text-lg mb-3">Set up your profile, manage your orders, build your wishlist and more</p>
      </div>
      <a href="{{ route('signup') }}" class="mb-5 text-center btn-primary w-full md:w-72">Sign Up</a>
    </div>
  </main>
  <script src="{{asset('js/app.js')}}"></script>
  <script defer src="https://kit.fontawesome.com/8505c87347.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script>
    document.getElementById('signInForm').addEventListener('submit', signIn, true);
    function signIn(e) {
      e.preventDefault();
      const data = {
        email: document.getElementById('email').value,
        password: document.getElementById('password').value
      };
      axios.post('{{ route('login')}}', data).then(result => {
        if (result.status === 200) {
          Toastify({
            text: 'Login success',
            duration: '3000',
            close: true,
            gravity: 'top',
            position: 'center',
            backgroundColor: '#333',
            stopOnFocus: true
          }).showToast();
          saveDataInLocalStorage(result.data);
          setTimeout(() => {
            document.location.href = '{{ route('profile.personal-info') }}';
          }, 2000);
        } else {
          throw new Error(result.message);
        }
      }).catch(error => {
          Toastify({
            text: error,
            duration: '3000',
            close: true,
            gravity: 'top',
            position: 'center',
            backgroundColor: '#333',
            stopOnFocus: true
          }).showToast();
      })
      function saveDataInLocalStorage (data) {
        Object.keys(data.data).forEach(key => localStorage.setItem(key, data.data[key]));
      }
    }
  </script>
</body>
</html>