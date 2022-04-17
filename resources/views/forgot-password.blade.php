@extends('layouts.user')

@section('content')
  <div class="flex flex-col text-center items-center">
    <h1 class="text-3xl font-serif mb-3">Forgot your password?</h1>
    <p class="mb-5">Enter your email address and we will send you a password reset link</p>
    <div class="border-gray-900 p-4 flex flex-col text-left items-center border w-full max-w-sm">
      <form class="w-full" id="forgotPasswordForm">
        <div class="w-full mb-5">
          <label for="Email" class="font-bold text-left w-full mb-2">Email address</label>
          <input type="text" name="email" id="email" class="input-primary w-full">
        </div>
        <button type="submit" class="btn-primary uppercase w-full" id="btnSubmit">Request Reset Link</button>
      </form>
    </div>
  </div>
@endsection

@section('script')
  <script>
    document.getElementById('forgotPasswordForm').addEventListener('submit', requestResetPassword, true);
    const btnSubmit = document.getElementById('btnSubmit');

    function requestResetPassword (e) {
      e.preventDefault();
      btnSubmit.setAttribute('disabled', true);
      const email = document.getElementById('email').value;

      axios.get('{{ url('/customers/forgot-password/{id}/edit') }}', { email }).then(response => {
        if (response.status === 200) {
          document.location.href = '{{ route('forgot-password-sent') }}';
        } else {
          throw new Error(response.message)
        }
      }).catch(error => {
        Toastify({
          text: error,
          duration: '5000',
          close: true,
          gravity: 'top',
          position: 'center',
          backgroundColor: '#333',
          stopOnFocus: true
        }).showToast();  
      }).finally(() => {
        btnSubmit.removeAttribute('disabled');
      })
    }
  </script>
@endsection