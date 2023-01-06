@php
$url = "/setting/{{ Auth::user()->id }}/update"
@endphp

<x-app-layout>
  <x-slot:title>
    Account
  </x-slot>
  <div class="py-4 flex justify-center">
    <div class="block w-10/12 relative">      

      <!-- Session Notification succes or fail update -->
      <x-session-status :status="session('success')" bgColor="green"/>
      <x-session-status :status="session('fail')" bgColor="red"/>
      
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
              <x-input-label for="old_password" :value="__('Old password')" />
              <x-text-input id="old_password" class="block mt-1 w-full h-8" type="password" name="old_password" :value="old('old_password')" autofocus error="{{ $errors->get('old_password') ? true : false }}"/>
              <x-input-error :messages="$errors->get('old_password')" class="mt-2" />
            </div> 

            <!-- New Password -->
            <div class="mb-2">
              <x-input-label for="new_password" :value="__('New password')" />
              <x-text-input id="new_password" class="block mt-1 w-full h-8" type="password" name="new_password" :value="old('new_password')" autofocus error="{{ $errors->get('new_password') ? true : false }}"/>
              <x-input-error :messages="$errors->get('new_password')" class="mt-2" />
            </div> 

            <!-- New Password -->
            <div class="mb-2 mt-4">
              <x-input-label for="confirm_password" :value="__('Confirm password')" />
              <x-text-input id="confirm_password" class="block mt-1 w-full h-8" type="password" name="confirm_password" :value="old('confirm_password')" autofocus error="{{ $errors->get('confirm_password') ? true : false }}"/>
              <x-input-error :messages="$errors->get('confirm_password')" class="mt-2" />
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
              <x-text-input id="name" class="block mt-1 w-full h-8" type="text" name="name" :value="old('name') ?? Auth::user()->name" autofocus error="{{ $errors->get('old_password') ? true : false }}"/>
              <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div> 

            <!-- Email -->
            <div class="mb-2 mt-4">
              <x-input-label for="email" :value="__('Email')" />
              <x-text-input id="email" class="block mt-1 w-full h-8" type="text" name="email" :value="old('email') ?? Auth::user()->email" autofocus error="{{ $errors->get('email') ? true : false }}"/>
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
      {{-- <x-dropdown-form title="Photo Profile" open="{{ old('open_form3') ?? 'false' }}"> --}}
        <x-slot name="form">
          <form action="{{ $url }}" method="post" id="form-photo-profile" enctype="multipart/form-data">
            @csrf
            @method('put')
            <input type="hidden" name="type_form" value="change pprofile">
            <input type="hidden" name="open_form3" value="true">
            
            <!-- Username -->
            @php
            $user_pprofile = Auth::user()->pprofile;
            @endphp
            <div class="mb-2" x-data="{
              previewImage: function(thisEl){
                const FR = new FileReader();

                FR.addEventListener('load', () => {
                  $el.querySelector('#pprofile-icon').src = FR.result;
                  $el.querySelector('#btn-change-pprofile').classList.remove('plus-icon');
                },false);

                FR.readAsDataURL(thisEl.files[0]);
              }
            }">
              <div class="w-full flex justify-center relative align-center items-center">
                <!-- image user -->
                <img id="pprofile-icon" src="http://review-app.test/{{ $user_pprofile ?? 'svg/icon/account_circle_FILL1_wght400_GRAD0_opsz48.svg' }}" class="rounded-full" style="width: 100px; height:100px"  alt="">
             
                <!-- button plus -->
                <input type="file" name="pprofile" accept="image/png, image/gif, image/jpeg, image/bmp" id="pprofile" class="absolute z-10" style="display: none" x-on:change="previewImage($el)">
                <div id="btn-change-pprofile" class="plus-icon z-10 hover:scale-125 cursor-pointer absolute top-1/4" style="width:50px; height: 4rem" onclick="this.previousElementSibling.click()"></div>
              </div>
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

    </div>
  </div>
</x-app-layout>