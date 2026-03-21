<?php
$class_element = 'w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none';
$item_infor = @$item->more_information;

$elements = [
  ['label' => form_label('First Name'), 'element' => form_input(['name' => 'first_name', 'value' => @$item->first_name, 'type' => 'text', 'class' => $class_element]), 'class_main' => "w-full"],
  ['label' => form_label('Last Name'), 'element' => form_input(['name' => 'last_name', 'value' => @$item->last_name, 'type' => 'text', 'class' => $class_element]), 'class_main' => "w-full"],
  ['label' => form_label('Email'), 'element' => form_input(['name' => 'email', 'value' => @$item->email, 'type' => 'email', 'readonly' => 'readonly', 'class' => $class_element . ' bg-gray-50']), 'class_main' => "w-full mb-4"],
];

$form_url = admin_url("admin.update");
$redirect_url = admin_url('profile');
$form_attributes = array('class' => 'form actionForm', 'data-redirect' => $redirect_url, 'method' => "POST");
$hidden1 = ['type' => 'account'];
$hidden2 = ['type' => 'password'];
?>

<div class="flex flex-col lg:flex-row gap-6">
  <div class="lg:w-1/3">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
      <div class="flex flex-col items-center mb-6">
        <img class="w-24 h-24 rounded-full object-cover mb-3" src="<?=get_avatar();?>" alt="User avatar">
        <h4 class="text-lg font-semibold text-gray-800 mb-1"><?=$item->first_name?></h4>
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700"><?=PERMISSIONS['name']?></span>
      </div>
      <h5 class="text-sm font-semibold text-gray-700 pb-2 border-b border-gray-200 mb-4">Details</h5>
      <ul class="space-y-3 text-sm">
        <li><span class="font-medium text-gray-600">First Name:</span> <span class="text-gray-800"><?=$item->first_name;?></span></li>
        <li><span class="font-medium text-gray-600">Email:</span> <span class="text-gray-800"><?=$item->email?></span></li>
        <li><span class="font-medium text-gray-600">Status:</span> <?=show_item_status('','',$item->status)?></li>
        <li><span class="font-medium text-gray-600">Role:</span> <span class="text-gray-800"><?=$item->name??'Not Detected';?></span></li>
      </ul>
    </div>
  </div>

  <div class="lg:w-2/3" x-data="{ tab: 'profile' }">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
      <div class="flex border-b border-gray-200">
        <button @click="tab = 'profile'" :class="tab === 'profile' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700'" class="flex-1 px-4 py-3 text-sm font-medium border-b-2 transition-colors">Profile</button>
        <button @click="tab = 'security'" :class="tab === 'security' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700'" class="flex-1 px-4 py-3 text-sm font-medium border-b-2 transition-colors">Security</button>
      </div>

      <div x-show="tab === 'profile'" class="p-6">
        <h6 class="text-sm font-semibold text-gray-700 mb-4">Your account</h6>
        <?php echo form_open($form_url, $form_attributes, $hidden1); ?>
          <?php echo render_elements_form($elements); ?>
          <div class="settings mb-4">
            <input type="text" name="avatar" class="hidden" value="<?=@$item->avatar?>">
            <label for="img" class="cursor-pointer inline-block">
              <img src="<?=get_avatar()?>" class="w-24 h-24 rounded-full object-cover border-2 border-gray-200" alt="">
            </label>
            <input id="img" class="settings_fileupload hidden" data-type="image" type="file" name="files[]">
          </div>
          <button type="submit" class="px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">Save</button>
        <?=form_close();?>
      </div>

      <div x-show="tab === 'security'" x-cloak class="p-6">
        <h6 class="text-sm font-semibold text-gray-700 mb-4">Change Your Password</h6>
        <?php echo form_open($form_url, $form_attributes, $hidden2); ?>
          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1" for="old_password">Old Password</label>
              <input class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" type="password" id="old_password" name="old_password">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1" for="password">New Password</label>
              <input class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" type="password" id="password" name="password">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1" for="confirm_password">Confirm Password</label>
              <input class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" type="password" id="confirm_password" name="confirm_password">
            </div>
          </div>
          <button type="submit" class="mt-4 px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">Change Password</button>
        <?=form_close();?>
      </div>
    </div>
  </div>
</div>
