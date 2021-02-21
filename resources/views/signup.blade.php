<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <title>Aslisemua - Sign Up</title>
</head>
<body class="antialiased flex flex-col h-full">
  <main class="flex justify-center items-start w-full h-full">
    {{-- LEFT SIDE --}}
    <form class="flex w-full justify-center items-center p-5" method="get" id="signUpForm" name="signUpForm">
      <div class="flex flex-col p-5 border border-gray-900">
        @csrf
        <h1 class="text-3xl font-serif text-center mb-6">Sign Up To Aslisemua</h1>
        <div class="mb-5 flex flex-col w-full md:w-72">
          <label for="name" class="text-base mb-2">Name</label>
          <input type="text" name="name" id="name" placeholder="Jonathan Morningstar" required class="input-primary">
        </div>
        <div class="mb-5 flex flex-col w-full md:w-72">
          <label for="phone" class="text-base mb-2">Phone Number</label>
          <input type="tel" name="phone" id="phone" placeholder="081281234567" required class="input-primary">
        </div>
        <div class="mb-5 flex flex-col w-full md:w-72">
          <label for="email" class="text-base mb-2">Email</label>
          <input type="email" name="email" id="email" placeholder="jonathan.morningstar@email.com" required class="input-primary">
        </div>
        <div class="mb-5 flex flex-col w-full md:w-72">
          <label for="password" class="text-base mb-2">Password</label>
          <input type="password" name="password" id="password" required class="input-primary">
        </div>
        <div class="mb-5 flex flex-col w-full md:w-72">
          <label for="repeatpassword" class="text-base mb-2">Repeat Password</label>
          <input type="password" name="repeatpassword" id="repeatpassword" required class="input-primary">
        </div>
        <div class="mb-5 flex items-center flex-row w-full md:w-72">
          <input type="radio" id="male" name="gender" value="male" class="mr-2" required>
          <label for="male" class="mr-6">Male</label><br>
          <input type="radio" id="female" name="gender" value="female" class="mr-2" required>
          <label for="female" class="mr-6">Female</label><br>
        </div>
        <div class="mb-5 flex items-start flex-row w-full md:w-72">
          <input type="checkbox" id="agreement" name="agreement" value="male" class="mr-2 w-6 h-6">
          <label for="agreement" class="mr-6">I agree to Aslisemua’s Terms and Conditions & Privacy Policy</label><br>
        </div>
        <button id="signUp" type="submit" class="btn-primary mb-5">Sign Up</button>
        <button id="signUpGoogle" class="bg-white border border-gray-800 py-2 px-6"><i class="fab fa-google mr-2"></i>Sign In With Google</button>
      </div>
    </form>
  </main>
  <script defer src="https://kit.fontawesome.com/8505c87347.js" crossorigin="anonymous"></script>
  <script>
    document.getElementById('signUpForm').addEventListener('submit', signUp, true);

    function signUp(event) {
      event.preventDefault();
      document.getElementById('signUp').setAttribute('disabled', true);
      document.getElementById('signUpGoogle').setAttribute('disabled', true);
      setTimeout(() => {
        alert('submitted');
        document.getElementById('signUp').removeAttribute('disabled');
        document.getElementById('signUpGoogle').removeAttribute('disabled');
      }, 3000);
      // document.signUpForm.submit();
    }
  </script>
</body>
</html>