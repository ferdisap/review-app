@php
$url = "/setting/". Auth::user()->id ."/update"
@endphp

<x-app-layout>
  <x-slot:title>
    Account
  </x-slot>

  <div class="py-4 flex justify-center">
    <div class="block w-10/12 relative">      

      <!-- Session Notification succes or fail update -->
      <x-session-status :status="session('success')" bgColor="bg-green-200"/>
      <x-session-status :status="session('fail')" bgColor="bg-red-200"/>
      
      <!-- Form1: change password  -->
      <x-dropdown-form title="Change Password" open="{{ old('open_form1') ?? 'false' }}">
        <x-slot name="form">
          <form action="{{ $url }}" method="post" id="form-change-password">
            @csrf
            @method('put')
            <input type="hidden" name="type_form" value="change password">
            <input type="hidden" name="open_form1" value="true">
            
            <!-- Old Password -->
            <div class="mb-2">
              <x-input-label for="oldPassword" :value="__('Old password')" />
              <x-text-input id="oldPassword" class="block mt-1 w-full h-8" type="password" name="oldPassword" :value="old('oldPassword')" autofocus error="{{ $errors->get('oldPassword') ? true : false }}"/>
              <x-input-error :messages="$errors->get('oldPassword')" class="mt-2" />
            </div> 

            <!-- New Password -->
            <div class="mb-2">
              <x-input-label for="newPassword" :value="__('New password')" />
              <x-text-input id="newPassword" class="block mt-1 w-full h-8" type="password" name="newPassword" :value="old('newPassword')" autofocus error="{{ $errors->get('newPassword') ? true : false }}"/>
              <x-input-error :messages="$errors->get('newPassword')" class="mt-2" />
            </div> 

            <!-- New Password -->
            <div class="mb-2 mt-4">
              <x-input-label for="newPassword_confirmation" :value="__('Confirm password')" />
              <x-text-input id="newPassword_confirmation" class="block mt-1 w-full h-8" type="password" name="newPassword_confirmation" :value="old('newPassword_confirmation')" autofocus error="{{ $errors->get('newPassword_confirmation') ? true : false }}"/>
              <x-input-error :messages="$errors->get('newPassword_confirmation')" class="mt-2" />
            </div> 

            <!-- button UPDATE -->
            <div class="text-end mt-5">
              <x-primary-button>
                Update
              </x-primary-button>
            </div>
          </form>
        </x-slot>
      </x-dropdown-form>   

      <!-- Form2: personal information  -->
      <x-dropdown-form title="Personal Information" open="{{ old('open_form2') ?? 'false' }}">
        <x-slot name="form">
          <form action="{{ $url }}" method="post" id="form-personal-information">
            @csrf
            @method('put')
            <input type="hidden" name="type_form" value="change personal information">
            <input type="hidden" name="open_form2" value="true">
            
            <!-- Username -->
            <div class="mb-2">
              <x-input-label for="username" :value="__('Username')" />
              <x-text-input id="username" class="block mt-1 w-full h-8" type="text" name="username" :value="old('username') ?? Auth::user()->username" autofocus error="{{ $errors->get('username') ? true : false }}"/>
              <x-input-error :messages="$errors->get('username')" class="mt-2" />
            </div> 

            <!-- Name -->
            <div class="mb-2">
              <x-input-label for="name" :value="__('Name')" />
              <x-text-input id="name" class="block mt-1 w-full h-8" type="text" name="name" :value="old('name') ?? Auth::user()->name" autofocus error="{{ $errors->get('oldPassword') ? true : false }}"/>
              <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div> 

            <!-- Email -->
            <div class="mb-2 mt-4">
              <x-input-label for="email" :value="__('Email')" />
              <x-text-input id="email" class="block mt-1 w-full h-8 text-slate-400" type="text" :value="old('email') ?? Auth::user()->email" autofocus error="{{ $errors->get('email') ? true : false }}" disabled="true"/>
              <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div> 

            <!-- button UPDATE -->
            <div class="text-end mt-5">
              <x-primary-button>
                Update
              </x-primary-button>
            </div>
          </form>
        </x-slot>
      </x-dropdown-form>   
      
      <!-- Form3: Profile Photo -->
      <x-dropdown-form title="Photo Profile" open="{{ old('open_form3') ?? 'true' }}">
        <x-slot name="form">
          @php
          $user_pprofile = isset(Auth::user()->pprofile) ? asset(Auth::user()->pprofile) : null;
          @endphp

          <form action="{{ $url }}" method="post" id="form-photo-profile" enctype="multipart/form-data">
            @csrf
            @method('put')
            <input type="hidden" name="type_form" value="change pprofile">
            <input type="hidden" name="open_form3" value="true">
                      
            @props(['disabled' => false,
              'error' => $errors->get('pprofile') ? true : false,
              'error_css' => ' ring-2 ring-offset-2 ring-pink-400 outline-none',
              'noerror_css' => ' focus:ring-sky-500 focus:border-sky-500 focus:outline-none focus:ring-2',
              'basic_css' => 'border-gray-300 rounded-full shadow-sm bg-slate-100 pprofile-img',
            ])
            {{-- @dd(request()->getSchemeAndHttpHost()) --}}
            <div x-data class="mb-2 w-full flex justify-center relative align-center items-center cursor-pointer"
                 onclick="this.querySelector('input').click()">
                 <!-- image user -->
                 <div class="bg-gray-300 rounded-full absolute opacity-25 hover:bg-gray-400 z-10" style="height: 100px; width:100px"></div>
                 <img id="pprofile-icon" 
                      src="{{ '/svg/icon/account_circle_FILL1_wght400_GRAD0_opsz48.svg' }}" 
                      {!! $attributes->merge(['class' => $basic_css . ($error ? $error_css : $noerror_css) ]) !!} 
                      style="width: 100px; height:100px"
                      alt="photo profile">

                 <img id="pprofile-icon" 
                      src="{{ request()->getSchemeAndHttpHost() }}/photos/pprofile/{{ Auth::user()->username }}.jpg" 
                      {!! $attributes->merge(['class' => $basic_css . ($error ? $error_css : $noerror_css) ]) !!} 
                      style="width: 100px; height:100px"
                      alt="photo profile">   

                 <input  type="file" 
                         name="pprofile" 
                         accept="image/png, image/gif, image/jpeg, image/bmp" 
                         id="pprofile" 
                         class="absolute z-10" 
                         style="display: none" 
                         {{-- x-on:change="previewImage($el)"> --}}
                         x-on:change="$store.previewThumbnail.show($el, '#pprofile-icon')">
            </div>
            <x-input-error :messages="$errors->get('pprofile')" class="mt-2 text-center" />

            <!-- button UPDATE -->
            <div class="text-end mt-5">
              <x-primary-button>
                Update
              </x-primary-button>
            </div>
          </form>
        </x-slot>
      </x-dropdown-form>

    </div>
  </div>
</x-app-layout>