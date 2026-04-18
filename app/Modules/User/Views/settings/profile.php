<?php

$class_element = 'form-control';

$item_infor = @$item->more_information;

$elements = [
  [
    'label'      => form_label('First Name'),
    'element'    => form_input(['name' => 'first_name', 'value' => @$item->first_name, 'type' => 'text', 'class' => $class_element]),
    'class_main' => "w-full",
  ],
  [
    'label'      => form_label('Last Name'),
    'element'    => form_input(['name' => 'last_name', 'value' => @$item->last_name, 'type' => 'text', 'class' => $class_element]),
    'class_main' => "w-full",
  ],
  [
    'label'      => form_label('Mobile Number'),
    'element'    => form_input(['name' => 'phone', 'value' => @$item->phone, 'type' => 'text', 'readonly' => 'readonly', 'class' => $class_element]),
    'class_main' => "w-full",
  ],
  [
    'label'      => form_label('Email'),
    'element'    => form_input(['name' => 'email', 'value' => @$item->email, 'type' => 'email', 'readonly' => 'readonly', 'class' => $class_element . ' opacity-60']),
    'class_main' => "w-full mb-4",
  ],
];

$form_url = user_url("update");
$redirect_url = user_url('profile');
$form_attributes = array('class' => 'form actionForm', 'data-redirect' => $redirect_url, 'method' => "POST");
$hidden1 = ['type' => 'account'];
$hidden2 = ['type' => 'password'];
?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
  <div class="lg:col-span-1">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
      <div class="flex flex-col items-center text-center mb-6">
        <img class="w-24 h-24 rounded-full object-cover mb-3" src="<?= get_avatar('user'); ?>" alt="User avatar">
        <h4 class="text-lg font-semibold text-gray-800"><?= $item->first_name ?></h4>
      </div>
      <div class="space-y-3 text-sm">
        <div class="flex items-center gap-2">
          <span class="font-medium text-gray-700">First Name:</span>
          <span class="text-gray-600"><?= $item->first_name; ?></span>
        </div>
        <div class="flex items-center gap-2">
          <span class="font-medium text-gray-700">Email:</span>
          <span class="text-gray-600"><?= $item->email ?></span>
        </div>
        <div class="flex items-center gap-2">
          <span class="font-medium text-gray-700">Status:</span>
          <?= show_item_status('', '', $item->status) ?>
        </div>
      </div>
    </div>
  </div>

  <div class="lg:col-span-2" x-data="{ tab: 'profile' }">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
      <div class="flex border-b border-gray-200">
        <button @click="tab = 'profile'" :class="tab === 'profile' ? 'text-primary-600 border-primary-600' : 'text-gray-500 border-transparent hover:text-gray-700'" class="flex items-center gap-2 px-5 py-3 text-sm font-medium border-b-2 transition-colors">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
          Profile
        </button>
        <button @click="tab = 'security'" :class="tab === 'security' ? 'text-primary-600 border-primary-600' : 'text-gray-500 border-transparent hover:text-gray-700'" class="flex items-center gap-2 px-5 py-3 text-sm font-medium border-b-2 transition-colors">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
          Security
        </button>
      </div>

      <div class="p-6">
        <div x-show="tab === 'profile'">
          <h6 class="text-base font-semibold text-gray-800 mb-4">Your account</h6>
          <?php echo form_open($form_url, $form_attributes, $hidden1); ?>
          <?php echo render_elements_form($elements); ?>

          <div class="mb-4">
            <input type="text" name="avatar" class="hidden" value="<?= @$item->avatar ?>">
            <label for="img" class="cursor-pointer inline-block">
              <div class="relative w-24 h-24 rounded-full overflow-hidden border-2 border-gray-200 hover:border-primary-400 transition-colors">
                <img src="<?= get_avatar('user') ?>" class="img-fluid w-full h-full object-cover" alt="">
                <div class="absolute inset-0 bg-black/30 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                  <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><circle cx="12" cy="13" r="3"/></svg>
                </div>
              </div>
            </label>
            <input id="img" class="settings_fileupload hidden" data-type="image" type="file" name="files[]">
          </div>

          <button type="submit" class="px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">Save</button>
          <?= form_close(); ?>
        </div>

        <div x-show="tab === 'security'" x-cloak>
          <h6 class="text-base font-semibold text-gray-800 mb-4">Change Your Password</h6>
          <?php echo form_open($form_url, $form_attributes, $hidden2); ?>
          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1" for="old_password">Old Password</label>
              <input class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none" type="password" id="old_password" name="old_password">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1" for="password">New Password</label>
              <input class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none" type="password" id="password" name="password">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1" for="confirm_password">Confirm Password</label>
              <input class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none" type="password" id="confirm_password" name="confirm_password">
            </div>
          </div>
          <button type="submit" class="mt-4 px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">Change Password</button>
          <?= form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</div>
