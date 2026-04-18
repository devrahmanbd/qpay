<?php
$setting_sidebar = [
  'general_setting' => [
    'name' => 'General setting', 'icon' => 'fa fa-cog', 'area_title' => true, 'route-name' => '#',
    'elements' => [
      'website_setting' => ['name' => 'Website setting', 'icon' => 'fa fa-globe', 'area_title' => false, 'route-name' => 'website_setting'],
      'website_logo'    => ['name' => 'Website logo', 'icon' => 'fa fa-image', 'area_title' => false, 'route-name' => 'website_logo'],
      'default'         => ['name' => 'Default setting', 'icon' => 'fa fa-box', 'area_title' => false, 'route-name' => 'default'],
      'affiliate'       => ['name' => 'Affiliate setting', 'icon' => 'fa fa-box', 'area_title' => false, 'route-name' => 'affiliates'],
      'currency'        => ['name' => 'Currency', 'icon' => 'fa fa-dollar-sign', 'area_title' => false, 'route-name' => 'currency'],
      'cookie_policy'   => ['name' => 'Cookie policy', 'icon' => 'fa fa-bookmark', 'area_title' => false, 'route-name' => 'cookie_policy'],
      'terms_policy'    => ['name' => 'Terms policy', 'icon' => 'fa fa-award', 'area_title' => false, 'route-name' => 'terms_policy'],
      'other'           => ['name' => 'Other', 'icon' => 'fa fa-cog', 'area_title' => false, 'route-name' => 'other'],
      'dev_page'        => ['name' => 'Developer Page', 'icon' => 'fa fa-code', 'area_title' => false, 'route-name' => 'dev_page'],
      'home_page'       => ['name' => 'Home Page', 'icon' => 'fa fa-home', 'area_title' => false, 'route-name' => 'home_page'],
    ],
  ],
  'email' => [
    'name' => 'Email', 'icon' => 'fa fa-envelope-open', 'area_title' => true, 'route-name' => '#',
    'elements' => [
      'email_setting'  => ['name' => 'Email setting', 'icon' => 'fa fa-envelope-open', 'area_title' => false, 'route-name' => 'email_setting'],
      'email_template' => ['name' => 'Email template', 'icon' => 'fa fa-box', 'area_title' => false, 'route-name' => 'email_template'],
    ],
  ],
];

$xhtml = '<nav class="bg-white rounded-xl shadow-sm border border-gray-200 p-3">';
foreach ($setting_sidebar as $key => $item) {
  $xhtml .= '<h5 class="flex items-center gap-2 px-3 py-2 mt-3 first:mt-0 text-sm font-semibold text-gray-700"><i class="' . $item['icon'] . ' text-gray-400"></i>' . $item['name'] . '</h5>';
  if (!empty($item['elements'])) {
    foreach ($item['elements'] as $element) {
      $link = admin_url('settings/' . $element['route-name']);
      $class_active = ($element['route-name'] == segment(3)) ? 'bg-primary-50 text-primary-700 font-medium' : 'text-gray-600 hover:bg-gray-50';
      $xhtml .= '<a href="' . $link . '" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors ' . $class_active . '"><i class="' . $element['icon'] . ' w-4 text-center text-gray-400"></i>' . $element['name'] . '</a>';
    }
  }
}
$xhtml .= '</nav>';
echo $xhtml;
