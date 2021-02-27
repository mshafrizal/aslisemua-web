<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <title>Aslisemua - Sign In</title>
</head>
<body class="antialiased flex flex-col h-full">
  <main class="flex justify-between flex-row flex-wrap w-full h-full">
    {{-- LEFT SIDE --}}
    <form class="flex justify-center items-center w-full md:w-1/2 p-4" method="get" id="signInForm" name="signInForm" onsubmit="signIn(event)">
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
        <button class="bg-white border border-gray-800 py-2 px-6"><i class="fab fa-google mr-2"></i>Sign In With Google</button>
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
      <button class="bg-white border text-gray-800 border-gray-800 py-2 px-6 w-full md:w-72"><i class="fab fa-google mr-2"></i>Sign Up With Google</button>
    </div>
  </main>
  <script defer src="https://kit.fontawesome.com/8505c87347.js" crossorigin="anonymous"></script>
  <script>
    document.getElementById('signInForm').addEventListener('submit', signIn, true);
    function signIn(e) {
      e.preventDefault();
      const data = {
        email: 
      }
      axios.get('{{ route('login')}}', data).then(result => {
        console.log(result)
      }).catch(error => {
        throw new Error(error)
      })
      
    }
  </script>
</body>
</html>