<?php

if (!function_exists('show_empty_item')) {
    function show_empty_item()
    {
        $xhtml = null;
        $image_page = base_url('public/assets/img/no-result.svg');
        $content = lan("look_like_there_are_no_results_in_here");
        $xhtml = sprintf('<div class="w-full text-center py-12">
            <img class="mx-auto mb-4 opacity-60" src="%s" alt="Empty Data" style="max-height:120px;max-width:120px;">
            <p class="text-gray-500 text-sm">%s</p>
        </div>', $image_page, $content);
        return $xhtml;
    }
}
if (!function_exists('show_pagination')) {
    function show_pagination($pagination)
    {
        $xhtml = null;
        if (!empty($pagination)) {
            $xhtml .= sprintf('<div class="w-full flex justify-end mt-4">%s</div>', $pagination->links());
        }
        return $xhtml;
    }
}

if (!function_exists("ticket_status_title")) {
    function ticket_status_title($key)
    {
        switch ($key) {
            case 'new':
                return lan('New');
                break;
            case 'pending':
                return lan('Pending');
                break;

            case 'closed':
                return lan('Closed');
                break;

            case 'answered':
                return lan('Answered');
                break;
        }
    }
}
if (!function_exists('show_item_ticket_message_detail')) {
    function show_item_ticket_message_detail($controller_name, $item = [], $task = '')
    {
        $xhtml = null;
        $xhtml_footer = null;
        if (isset($item['support']) && $item['support']) {
            $class_item  = 'flex-row-reverse tr_' . $item['ids'];
            $img_class  = 'ml-3 mb-4';
            $img_url          = get_avatar('admin');
            $type = 'sent';
            if ($task == 'user') {
                $edit_item_link = null;
                $delete_item_link = null;
            } else {
                $edit_item_link   = admin_url($controller_name . '/edit_item_ticket_message/' . $item['ids']);
                $delete_item_link = admin_url($controller_name . '/delete_item_ticket_message/' . $item['ids']);
                $xhtml_footer = sprintf(
                    '<div class="mt-2 flex gap-2">
                        <a href="%s" class="ajaxModal inline-flex items-center gap-1 px-2 py-1 text-xs bg-blue-50 text-blue-600 rounded hover:bg-blue-100">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Edit
                        </a>
                        <a href="%s" class="ajaxDeleteItem inline-flex items-center gap-1 px-2 py-1 text-xs bg-red-50 text-red-600 rounded hover:bg-red-100" data-confirm_ms="delete this message">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Delete
                        </a>
                    </div>',
                    $edit_item_link,
                    $delete_item_link
                );
            }
        } else {
            $class_item  = '';
            $img_url = get_avatar('user', $item['id']);
            $img_class = 'mr-3';
            $type = 'received';
        }
        $content = str_replace("\n", "<br>", esc($item['message']));
        $created = time_ago($item['created_at']);
        $author  = $item['first_name'];
        if (isset($item['author'])) {
            $author  = $item['author'];
        }
        $bg_class = $type === 'sent' ? 'bg-primary-50 border-primary-100' : 'bg-gray-50 border-gray-100';
        $xhtml   = sprintf(
            '<div class="flex gap-3 mb-4 %s">
                <div class="%s flex-shrink-0"><img class="rounded-full w-10 h-10 object-cover" src="%s" alt="Avatar" /></div>
                <div class="flex-1 border rounded-lg p-3 %s">
                    <div class="flex items-center gap-2 mb-1">
                        <strong class="text-sm text-gray-800">%s</strong>
                        <span class="text-xs text-gray-400">%s</span>
                    </div>
                    <div class="text-sm text-gray-600">%s</div>
                    %s
                </div>
            </div>',
            $class_item,
            $img_class,
            $img_url,
            $bg_class,
            $author,
            $created,
            $item['message'],
            $xhtml_footer
        );
        return $xhtml;
    }
}

if (!function_exists('show_filter_status_button')) {
    function show_filter_status_button($controller_name, $items_status_button = [], $params = [], $type = '')
    {
        $xhtml = null;
        $config_status       = app_config('config')['status'];
        if ($items_status_button && count($items_status_button) > 0) {

            $current_tmpl_status = (in_array($controller_name, array_keys($config_status))) ? $controller_name . '_status' : 'status';
            $tmpl_status         = app_config('template')[$current_tmpl_status];

            $xhtml .= '<div class="flex flex-wrap gap-2">';
            array_unshift($items_status_button, [
                'status' => 'all',
                'count'  => array_sum(array_column($items_status_button, 'count'))
            ]);

            $param_search = $params['search'];
            $current_search = array_combine(array_keys($param_search), array_values($param_search));
            foreach ($items_status_button as $key => $item) {
                if ($type == 'user') {
                    $link = user_url($controller_name) . '?status=' . $item['status'];
                } else {
                    $link = admin_url($controller_name) . '?status=' . $item['status'];
                }
                if ($current_search['query'] != "") {
                    $link .= '&' . http_build_query($current_search);
                }
                $current_status = (array_key_exists($item['status'], $tmpl_status)) ? $item['status'] : 'all';
                $is_active = get('status') == $item['status'];
                $active_class = $is_active ? 'bg-primary-600 text-white border-primary-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50';
                $xhtml .= sprintf(
                    '<a href="%s" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium border rounded-lg transition-colors %s">%s <span class="text-xs px-1.5 py-0.5 rounded-full %s">%s</span></a>',
                    $link,
                    $active_class,
                    $tmpl_status[$current_status]['name'],
                    $is_active ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-600',
                    $item['count']
                );
            }
            $xhtml .= '</div>';
        }
        return $xhtml;
    }
}

if (!function_exists('show_search_area')) {
    function show_search_area($controller_name, $params, $task = 'admin')
    {
        $xhtml = null;
        $tmpl_search_fields   = app_config('template')['search_field'];
        $field_in_controller  = app_config('config')['search'];
        $current_controller = (array_key_exists($controller_name, $field_in_controller)) ? $controller_name : 'default';
        $param_search = $params['search'];
        $xhtml_fields = null;
        $class_btn_clear = (!empty($param_search['query'])) ? '' : 'hidden';
        $search_placeholder = lang("Search_for_");
        if ($task == 'admin') {
            $xhtml_fields = '<select name="field" class="border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none">';
            foreach ($field_in_controller[$current_controller] as $item) {
                $selected = ($item == $param_search['field']) ? 'selected' : '';
                $xhtml_fields .= sprintf('<option value="%s" %s>%s</option>', $item, $selected,  $tmpl_search_fields[$item]['name']);
            }
            $xhtml_fields .= '</select>';
            $search_placeholder = 'Search for…';
        }
        $xhtml = sprintf(
            '<div class="flex gap-2">
                <input type="text" name="query" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none" placeholder="%s" value="%s">
                %s
                <button class="btn-search inline-flex items-center px-3 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors" type="button">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </button>
                <button class="btn-clear inline-flex items-center px-3 py-2 border border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition-colors %s" type="button">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>',
            $search_placeholder,
            $param_search['query'],
            $xhtml_fields,
            $class_btn_clear
        );
        return $xhtml;
    }
}


if (!function_exists('show_item_check_box')) {
    function show_item_check_box($type = null, $ids = '', $class_input = "check-all", $data_name = 'check_1')
    {
        $xhtml       = null;
        $xhtml_input = null;
        switch ($type) {
            case 'check_items':
                $xhtml_input = sprintf('<input type="checkbox" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500 check-items %s" data-name="%s">', $class_input, $data_name);
                break;
            case 'check_item':
                $xhtml_input = sprintf('<input type="checkbox" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500 check-item %s" name="ids[]" value="%s">', $data_name, $ids);
                break;
        }
        $xhtml = sprintf('<label class="inline-flex items-center">%s</label>', $xhtml_input);
        return $xhtml;
    }
}

if (!function_exists('show_item_sort')) {
    function show_item_sort($controller_name, $id, $sort)
    {
        $xhtml = null;
        $link = admin_url($controller_name . '/change_sort/');
        $xhtml = sprintf('<input type="text" class="w-16 text-center border border-gray-300 rounded-lg px-2 py-1 text-sm ajaxChangeSort focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none" data-url="%s" data-id="%s" min="1" value="%s">', $link, $id, $sort);
        return $xhtml;
    }
}
if (!function_exists('getAnchor')) {
    function getAnchor($message)
    {
        $anchor = '';
        $pattern = '/<a\s[^>]*href\s*=\s*(["\']??)([^"\'>]*)\\1[^>]*>.*?<\/a>/i';
        if (preg_match($pattern, $message, $matches)) {
            $extractedLink = $matches[0];
            $anchor = '<svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>' . $extractedLink;
        }
        return $anchor;
    }
}

if (!function_exists('show_item_status')) {
    function show_item_status($controller_name = '', $id = '', $status = '', $type = null, $task = null, $user = '')
    {
        $xhtml = null;
        switch ($type) {
            case 'switch':
                $link = $user == 'user' ? user_url($controller_name . '/change_status/') : admin_url($controller_name . '/change_status/');
                $checked = ($status) ? 'checked' : '';
                $xhtml = sprintf('<label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="item_status" data-id="%s" data-status="%s" data-action="%s" class="sr-only peer ajaxToggleItemStatus" %s>
                                    <div class="w-9 h-5 bg-gray-200 peer-focus:ring-2 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[\'\'] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-600"></div>
                                </label>', $id, $status, $link, $checked);
                break;
            default:
                $config_status       = app_config('config')['status'];
                $current_tmpl_status = (in_array($controller_name, array_keys($config_status))) ? $controller_name . '_status' : 'status';
                if (in_array($controller_name, ['order', 'dripfeed', 'subscriptions', 'refill', 'affiliates'])) {
                    $tmpl_status         = app_config('template')['order_status'];
                } else {
                    $tmpl_status         = app_config('template')[$current_tmpl_status];
                }
                $current_tmpl_status = (array_key_exists($status, $tmpl_status)) ? $tmpl_status[$status] : $tmpl_status['1'];
                $status_name = $current_tmpl_status['name'];
                if ($task == 'user') {
                    $status_name = lang($status_name);
                }
                $badge_colors = [
                    'badge-success' => 'bg-green-100 text-green-700',
                    'badge-danger' => 'bg-red-100 text-red-700',
                    'badge-warning' => 'bg-yellow-100 text-yellow-700',
                    'badge-info' => 'bg-blue-100 text-blue-700',
                    'badge-primary' => 'bg-primary-100 text-primary-700',
                    'badge-secondary' => 'bg-gray-100 text-gray-700',
                    'bg-success' => 'bg-green-100 text-green-700',
                    'bg-danger' => 'bg-red-100 text-red-700',
                    'bg-warning' => 'bg-yellow-100 text-yellow-700',
                    'bg-info' => 'bg-blue-100 text-blue-700',
                    'bg-primary' => 'bg-primary-100 text-primary-700',
                    'bg-secondary' => 'bg-gray-100 text-gray-700',
                ];
                $old_class = $current_tmpl_status['class'];
                $tw_class = 'bg-gray-100 text-gray-700';
                foreach ($badge_colors as $bs => $tw) {
                    if (strpos($old_class, $bs) !== false) { $tw_class = $tw; break; }
                }
                $xhtml = sprintf('<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium %s">%s</span>', $tw_class, $status_name);
                break;
        }
        return $xhtml;
    }
}


if (!function_exists('show_high_light')) {
    function show_high_light($input, $param_search = '', $field = '')
    {
        if ($param_search['query'] !== "") {
            if ($param_search['field'] == 'all' || $param_search['field'] == $field) {
                $input = preg_replace('#' . preg_quote($param_search['query']) . '#i', '<span class="bg-yellow-200 px-0.5 rounded">\\0</span>', $input);
            }
        }
        return $input;
    }
}


if (!function_exists('show_item_datetime')) {
    function show_item_datetime($datetime = 'Asia/Dhaka', $type = 'long')
    {
        $datetime = convert_timezone($datetime);
        $new_datetime = date(app_config('template')['datetime'][$type], strtotime($datetime));
        return $new_datetime;
    }
}

if (!function_exists('show_bulk_btn_action')) {
    function show_bulk_btn_action($controller_name, $user = '', $trash = '')
    {
        $xhtml = null;
        $ml = '';
        $tmpl_buttons = app_config('template')['bulk_action'];
        $btn_area     = app_config('config')['bulk_action'];
        $curent_btn_area = (array_key_exists($controller_name, $btn_area)) ? $btn_area[$controller_name] : $btn_area['default'];

        if (!empty($trash)) {
            $trash_link = admin_url($controller_name . '/bulk_action/delete-all');
            $restore_link = admin_url($controller_name . '/bulk_action/restore');
            $ml .= sprintf('<a class="inline-flex items-center gap-1 px-3 py-2 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700 mr-2 ajaxActionOptions" href="%s" data-type="restore">Restore %s</a>', $restore_link, $trash);
            $ml .= sprintf('<a class="inline-flex items-center gap-1 px-3 py-2 text-sm bg-red-600 text-white rounded-lg hover:bg-red-700 mr-2 ajaxActionOptions" href="%s" data-type="delete-all">Clean %s</a>', $trash_link, $trash);
        }

        $xhtml .= '<div class="flex items-center gap-2">';
        $xhtml .= $ml;
        $xhtml .= '<div x-data="{ open: false }" class="relative">';
        $xhtml .= '<button @click="open = !open" class="inline-flex items-center gap-1 px-3 py-2 text-sm border border-primary-300 text-primary-700 rounded-lg hover:bg-primary-50 transition-colors">Actions <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></button>';
        $xhtml .= '<div x-show="open" @click.outside="open = false" x-cloak x-transition class="absolute right-0 mt-1 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">';

        foreach ($curent_btn_area as $item) {
            $current_btn = $tmpl_buttons[$item];
            $link        = $user == 'user' ? user_url($controller_name . $current_btn['route-name'] . $item) : admin_url($controller_name . $current_btn['route-name'] . $item);
            $action_type = 'data-type="' . $item . '"';
            $xhtml .= sprintf('<a href="%s" %s class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 ajaxActionOptions">%s</a>', $link, $action_type, $current_btn['name']);
        }

        $xhtml .= '</div></div></div>';
        return $xhtml;
    }
}


if (!function_exists('render_table_thead')) {
    function render_table_thead($columns, $check_items = true, $show_number = true, $action =  true, $params = [])
    {
        $xhtml = '<thead><tr class="border-b border-gray-200">';
        if (isset($params['sort-table']) && $params['sort-table']) {
            $xhtml .= '<th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"><svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg></th>';
        }
        if ($check_items) {
            $data_name = (isset($params['checkbox_data_name'])) ? $params['checkbox_data_name'] : 'check_1';
            $show_check_items = show_item_check_box('check_items', '', 'check-all', $data_name);
            $xhtml .= sprintf('<th class="px-4 py-3 text-center w-10">%s</th>', $show_check_items);
        }
        if ($show_number) {
            $xhtml .= '<th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-10">Sl.</th>';
        }
        if (!empty($columns)) {
            foreach ($columns as $column) {
                $xhtml .= sprintf('<th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider %s">%s</th>', $column['class'], $column['name']);
            }
        }
        if ($action) {
            $xhtml .= '<th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>';
        }
        $xhtml .= '</tr></thead>';
        return $xhtml;
    }
}


if (!function_exists('show_item_button_action')) {
    function show_item_button_action($controller_name, $ids, $format = 'dropdown', $item_data = [], $user = '')
    {
        $xhtml = null;
        $tmpl_buttons = app_config('template')['button'];
        $btn_area = app_config('config')['button'];
        $curent_btn_area = (array_key_exists($controller_name, $btn_area)) ? $btn_area[$controller_name] : $btn_area['default'];

        switch ($format) {
            case 'btn-group':
                $xhtml .= '<div class="flex items-center gap-1">';
                foreach ($curent_btn_area as $item) {
                    $current_btn = $tmpl_buttons[$item];
                    $link = $user == 'user' ? user_url($controller_name . $current_btn['route-name'] . $ids) : admin_url($controller_name . $current_btn['route-name'] . $ids);
                    $confirm_message = "";
                    if ($item == 'delete') {
                        $confirm_message = "delete this item";
                    }
                    $xhtml .= sprintf(
                        '<a href="%s" class="inline-flex items-center justify-center w-8 h-8 text-gray-500 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors %s" data-confirm_ms="%s" title="%s">
                            <i class="%s"></i>
                        </a>',
                        $link,
                        $current_btn['class'],
                        $confirm_message,
                        $current_btn['name'],
                        $current_btn['icon']
                    );
                }
                $xhtml .= '</div>';
                break;

            default:
                $xhtml .= '<div x-data="{ open: false }" class="relative inline-block">';
                $xhtml .= '<button @click="open = !open" class="p-1.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01"/></svg></button>';
                $xhtml .= '<div x-show="open" @click.outside="open = false" x-cloak x-transition class="absolute right-0 mt-1 w-40 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">';
                foreach ($curent_btn_area as $item) {
                    $current_btn = $tmpl_buttons[$item];
                    $link = $user == 'user' ? user_url($controller_name . $current_btn['route-name'] . $ids) : admin_url($controller_name . $current_btn['route-name'] . $ids);
                    $confirm_message = "";
                    if ($item == 'delete') {
                        $confirm_message = "delete this item";
                    }
                    $xhtml .= sprintf('<a href="%s" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 %s" data-confirm_ms="%s">%s</a>', $link, $current_btn['class'], $confirm_message, $current_btn['name']);
                }
                $xhtml .= '</div></div>';
                break;
        }
        return $xhtml;
    }
}

if (!function_exists('convert_string_number_list_to_array')) {
    function convert_str_number_list_to_array($str)
    {
        $ar = [];
        if (!is_string($str)) {
            return $ar;
        }
        $str = rtrim($str, ',');
        $str = ltrim($str, ',');
        return $ar = explode(',', $str);
    }
}

if (!function_exists('show_item_ticket_subject')) {
    function show_item_ticket_subject($controller_name, $item_data, $params = [])
    {
        $xhtml = null;
        $xhtml_un_read = null;
        if ($item_data['is_admin_read'] == 0) {
            $xhtml_un_read = '<span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700 ml-2">Unread</span>';
        }
        $link    = admin_url($controller_name . '/view/' . $item_data['ids']);
        $subject = show_high_light(esc($item_data['subject']), $params['search'], 'subject');

        $xhtml   = sprintf('<a href="%s" class="text-primary-600 hover:text-primary-700 hover:underline">%s%s</a>', $link, $subject, $xhtml_un_read);
        return $xhtml;
    }
}

if (!function_exists('show_view_ticket_button_group')) {
    function show_view_ticket_button_group($controller_name, $item = [])
    {
        $xhtml = null;
        $xhtml_dropdown = null;
        $closed_link = admin_url($controller_name . "/change_status/closed/" . $item['ids']);
        $dropdowns = [
            'answered' =>  'Mark as Answered',
            'pending'  =>  'Mark as Pending',
            'unread'   =>  'Mark as Unread',
        ];
        if ($dropdowns) {
            $xhtml_dropdown = '<div x-data="{ open: false }" class="relative inline-block">
            <button @click="open = !open" class="px-3 py-2 border border-primary-300 text-primary-700 rounded-r-lg hover:bg-primary-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div x-show="open" @click.outside="open = false" x-cloak x-transition class="absolute right-0 mt-1 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">';
            foreach ($dropdowns as $key => $dropdown) {
                $link = admin_url($controller_name . "/change_status/" . $key . '/' . $item['ids']);
                $xhtml_dropdown .= sprintf('<a href="%s" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">%s</a>', $link, $dropdown);
            }
            $xhtml_dropdown .= '</div></div>';
        }
        $xhtml   = sprintf(
            '<div class="flex items-center justify-end gap-0 m-3">
                <a href="%s" class="px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-l-lg hover:bg-primary-700 transition-colors">Close ticket</a>
                %s
            </div>',
            $closed_link,
            $xhtml_dropdown
        );
        return $xhtml;
    }
}


if (!function_exists('get_addon_details')) {
    function get_addon_details($addon = '')
    {
        $xhtml = null;
        $dir = APPPATH . "Modules/Blocks/Addons/" . $addon;
        try {
            $file = searchFileInFolder($dir, 'info.json');
            if ($file) {
                $data = get_json_content_from_file($file);
            }
            $name = isset($data['name']) ? $data['name'] : $addon;
            $description = isset($data['description']) ? $data['description'] : $addon;
            $logo = isset($data['logo']) ? $data['logo'] : get_logo();
            $xhtml   = sprintf(
                '<div class="bg-gray-50 rounded-xl p-4 flex items-center gap-4">
                    <img class="w-12 h-12 rounded-full object-cover" src="%s" alt="">
                    <div>
                        <p class="text-sm text-gray-500">%s</p>
                        <h6 class="font-semibold text-gray-800">%s</h6>
                    </div>
                </div>',
                $logo,
                $description,
                $name
            );
            return $xhtml;
        } catch (Exception $e) {
            $xhtml   = sprintf(
                '<div class="bg-gray-50 rounded-xl p-4 flex items-center gap-4">
                    <svg class="w-10 h-10 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    <div>
                        <p class="text-sm text-gray-500">Addon</p>
                        <h6 class="font-semibold text-gray-800">%s</h6>
                    </div>
                </div>',
                $addon
            );
            return $xhtml;
        }
    }
}

if (!function_exists('plan_message')) {
    function plan_message($type, $count)
    {
        $labels = [
            'brand' => 'Brand',
            'device' => 'Device',
            'transaction' => 'Transaction',
        ];
        $label = $labels[$type] ?? ucfirst($type);
        if ($count == -1 || $count === 'unlimited') {
            return 'Unlimited ' . $label . 's';
        }
        return $count . ' ' . $label . ($count != 1 ? 's' : '');
    }
}

if (!function_exists('duration_type')) {
    function duration_type($name, $type, $duration, $badge = true, $show_name = false)
    {
        $xhtml = null;
        $duration = ($duration == -1) ? "Unlimited" : $duration;
        switch ($type) {
            case '1':
                $type = 'Days';
                $status = 'green';
                break;
            case '2':
                $type = 'Months';
                $status = 'blue';
                break;
            case '3':
                $type = 'Years';
                $status = 'yellow';
                break;

            default:
                $type = 'Not Identified';
                $status = 'red';
                break;
        }
        if (!$show_name) {
            $name = '';
        }

        $badge_class = ($badge) ? "bg-" . $status . "-100 text-" . $status . "-700" : '';

        $xhtml = sprintf('<span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium %s">%s %s / %s</span>', $badge_class, $name, $duration, $type);
        return $xhtml;
    }
}
