<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    @vite('resources/css/app.css')
    
</head>
<body>
<section class="form-signin">
<div class=" flex justify-center items-center h-screen w-full py-14 bg-transparent">
    <div class="bg-white py-18 px-12 flex flex-col justify-center items-center w-4/12 h-full rounded-md">
        <img src="{{ URL::to('assets/img/logo.png') }}" class="w-auto h-16 rounded-full" alt="Logo" class="w-9 h-9">
        <h2>CUYAPO HRMS - ADMIN LOGIN</h2>

        <div class="w-full sm:mx-auto sm:max-w-sm">
         <form action=" {{ route('login') }} " method="POST"> 
          @csrf 
          <div class="mb-8">
               <label for="username">Username</label>
               <input class="block rounded-lg w-full outline outline-1 outline-offset-1 outline-gray-400 placeholder:text-gray-200 focus:outline-2 focus:outline-offset-2 focus:outline-blue-500" type="text" name="username">
          </div>
          <div class="mb-8">
              <div class="flex flex-row justify-between">
                   <label for="password">Password</label>
                   <a class="text-blue-500 hover:text-blue-300" href="#">Forgot Password?</a>
              </div>
               <input class="block rounded-lg w-full outline outline-1 outline-offset-1 outline-gray-400 placeholder:text-gray-200 focus:outline-2 focus:outline-offset-2 focus:outline-blue-500" type="password" name="password">
          </div>
          <button class="btn w-full" type="submit">LOGIN</button>
          <div class="flex flex-row justify-center items-center mt-4">
             <p class="mr-2">Do you want to back to home page?</p>
             <a class="text-blue-500 hover:text-blue-300" href="{{ route('welcome') }}">Home Page</a>
          </div>
        </form>
        </div>
    </div>
  </div>
</section>
</body>
</html>