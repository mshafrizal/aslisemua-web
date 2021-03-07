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
<body class="antialiased flex flex-col h-full relative">
  @include('partials.snackbar')
  <main class="flex justify-center items-start w-full h-full">
    {{-- LEFT SIDE --}}
    <form class="flex w-full justify-center items-center p-5" method="post" id="signUpForm" name="signUpForm">
      <div class="flex flex-col p-5 border border-gray-900 ">
        @csrf
        <h1 class="text-3xl font-serif text-center mb-6">Sign Up To Aslisemua</h1>
        <div class="mb-5 flex flex-col w-full md:w-72">
          <label for="name" class="text-base mb-2">Name</label>
          <input type="text" name="name" id="name" placeholder="Jonathan Morningstar" required class="input-primary w-full md:w-72">
        </div>
        <div class="mb-5 flex flex-col w-full md:w-72">
          <label for="phone_number" class="text-base mb-2">Phone Number</label>
          <input type="tel" name="phone_number" id="phone_number" placeholder="081281234567" required class="input-primary w-full md:w-72">
        </div>
        <div class="mb-5 flex flex-col w-full md:w-72">
          <label for="email" class="text-base mb-2">Email</label>
          <input type="email" name="email" id="email" placeholder="jonathan.morningstar@email.com" required class="input-primary w-full md:w-72">
        </div>
        <div class="mb-5 flex flex-col w-full md:w-72">
          <label for="city" class="text-base mb-2">City</label>
          <input type="text" name="city" id="city" placeholder="city" required class="input-primary w-full md:w-72">
        </div>
        <div class="mb-5 flex flex-col w-full md:w-72">
          <label for="district" class="text-base mb-2">District</label>
          <input type="text" name="district" id="district" placeholder="district" required class="input-primary w-full md:w-72">
        </div>
        <div class="mb-5 flex flex-col w-full md:w-72">
          <label for="postal_code" class="text-base mb-2">Postal Code</label>
          <input type="text" name="postal_code" id="postal_code" placeholder="11480" required class="input-primary w-full md:w-72">
        </div>
        <div class="mb-5 flex flex-col w-full md:w-72">
          <label for="address" class="text-base mb-2">Address</label>
          <textarea id="address" class="border border-gray-900 p-2"></textarea>
        </div>
        <div class="mb-5 flex flex-col w-full md:w-72">
          <label for="password" class="text-base mb-2">Password</label>
          <input type="password" name="password" id="password" required class="input-primary w-full md:w-72">
        </div>
        <div class="mb-5 flex flex-col w-full md:w-72">
          <label for="repeatpassword" class="text-base mb-2">Repeat Password</label>
          <input type="password" name="repeatpassword" id="repeatpassword" required class="input-primary w-full md:w-72">
        </div>
        <div class="mb-5 flex items-center flex-row w-full md:w-72">
          <input type="radio" id="male" name="gender" value="male" class="mr-2" required>
          <label for="male" class="mr-6">Male</label><br>
          <input type="radio" id="female" name="gender" value="female" class="mr-2" required>
          <label for="female" class="mr-6">Female</label><br>
        </div>
        <div class="mb-5 flex items-start flex-row w-full md:w-72">
          <input type="checkbox" id="agreement" name="agreement" value="male" class="mr-2 w-6 h-6" required>
          <label for="agreement" class="mr-6  md:w-72">I agree to Aslisemua’s Terms and Conditions & Privacy Policy</label><br>
        </div>
        <button id="signUp" type="submit" class="btn-primary mb-5 md:w-72">Sign Up</button>
      </div>
    </form>
  </main>
  <script src="{{asset('js/app.js')}}"></script>
  <script defer src="https://kit.fontawesome.com/8505c87347.js" crossorigin="anonymous"></script>
  <script>
    document.getElementById('signUpForm').addEventListener('submit', signUp, true);

    async function signUp(event) {
      event.preventDefault();
      document.getElementById('signUp').setAttribute('disabled', true);
      const data = {
        name: document.getElementById('name').value,
        email: document.getElementById('email').value,
        gender: document.querySelector('input[name="gender"]:checked').value,
        password: document.getElementById('password').value,
        phone_number: document.getElementById('phone_number').value,
        postal_code: document.getElementById('postal_code').value,
        city: document.getElementById('city').value,
        district: document.getElementById('district').value,
        address: document.getElementById('address').value,
      }
      if (checkPassword()) {
        await axios.post('/api/v1/customers/register', data).then(result => {
          if (result.status === 201) {
            document.location.href = '{{ route('profile.personal-info') }}';
          } else {
            throw new Error(result.message)
          }
        }).catch(error => showAlert('snackbar', {
          type: 'warning',
          message: error
        })).finally(() => {
          document.getElementById('signUp').removeAttribute('disabled');
        })
      } else {
        showAlert('snackbar', {
          type: 'warning',
          message: 'Please check your password again'
        })
        document.getElementById('signUp').removeAttribute('disabled');
      }
    }

    function checkPassword () {
      console.log(document.getElementById('password').value);
      if (document.getElementById('password').value === document.getElementById('repeatpassword').value) return true
      else return false
    }
  </script>
</body>
</html>