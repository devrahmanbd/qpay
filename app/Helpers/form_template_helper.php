<?php

use CodeIgniter\I18n\Time;

function render_elements_form(array $elements): string
{
    $xhtml = '';
    if (!empty($elements)) {
        foreach ($elements as $element) {
            $xhtml .= render_element_form($element);
        }
    }
    return $xhtml;
}

function modal_buttons(string $btn1 = 'Save', string $btn2 = 'Close'): string
{
    return sprintf(
        '<div class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-gray-100">
          <button type="submit" class="px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">%s</button>
          <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">%s</button>
        </div>',
        $btn1,
        $btn2
    );
}

function modal_buttons2(string $btn1 = 'Save', string $btn2 = 'Close'): string
{
    return sprintf(
        '<div class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-gray-100">
          <button type="submit" class="px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">%s</button>
        </div>',
        $btn1
    );
}

function doc_status($value = ''): string
{
    switch ($value) {
        case 1:
            $c = 'bg-blue-100 text-blue-700';
            $t = 'Reviewing';
            break;
        case 2:
            $c = 'bg-yellow-100 text-yellow-700';
            $t = 'Canceled';
            break;
        case 3:
            $c = 'bg-primary-100 text-primary-700';
            $t = 'Verified';
            break;
        default:
            $c = 'bg-yellow-100 text-yellow-700';
            $t = 'Sent for Reviewing';
            break;
    }

    return sprintf('<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium %s">%s</span>', $c, $t);
}

function render_element_form(array $element, $param = null): string
{
    $xhtml = '';

    $type = $element['type'] ?? 'input';
    switch ($type) {
        case 'input':
        case 'password':
            $xhtml = sprintf(
                '<div class="%s">
                    <div class="mb-4">
                        %s
                        %s
                    </div>
                </div> ',
                $element['class_main'],
                $element['label'],
                $element['element']
            );
            break;

        case 'switch':
            $xhtml = sprintf(
                '<div class="%s">
                    <label class="relative inline-flex items-center cursor-pointer gap-3">
                        %s
                        <span class="text-sm text-gray-700">%s</span>
                    </label>
                </div> ',
                $element['class_main'],
                $element['element'],
                $element['label']
            );
            break;

        case 'checkbox':
            $xhtml = sprintf(
                '<div class="%s">
                    <div class="mb-4">
                        <label class="inline-flex items-center gap-2">
                            %s
                            <span class="text-sm text-gray-700">%s</span>
                        </label>
                    </div>
                </div> ',
                $element['class_main'],
                $element['element'],
                $element['label']
            );
            break;

        case 'exchange_option':
            $item1_title = $element['item1']['name'];
            $item2_title = $element['item2']['name'];
            $xhtml = sprintf(
                '<div class="%s">
                    <div class="mb-4">
                        %s
                        <div class="flex items-center">
                            <span class="inline-flex items-center px-3 py-2 border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm rounded-l-lg">1 %s =</span>
                            %s
                            <span class="inline-flex items-center px-3 py-2 border border-l-0 border-gray-300 bg-gray-50 text-gray-500 text-sm rounded-r-lg new-currency-code">%s</span>
                        </div>
                    </div>
                </div>',
                $element['class_main'],
                $element['label'],
                $item1_title,
                $element['element'],
                $item2_title
            );
            break;

        case 'admin-change-provider-service-list':
            $xhtml = sprintf(
                '<div class="%s">
                    <div class="relative">
                        %s
                        %s
                    </div>
                </div>',
                $element['class_main'],
                $element['label'],
                $element['element']
            );
            break;

        case 'button':
            $xhtml = sprintf(
                '<div class="border-t border-gray-100 mt-4 pt-4">
                    <div>
                        %s
                    </div>
                </div>',
                $element['element']
            );
            break;
    }

    return $xhtml;
}

function render_modal_html(array $params = []): string
{
    $params = [
        'btn-class'           => $params['btn-class'] ?? 'border-primary-300 text-primary-700',
        'btn-title'           => $params['btn-title'] ?? 'Detail',
        'modal-id'            => $params['modal-id'] ?? 'modal-1',
        'modal-size'          => $params['modal-size'] ?? 'max-w-2xl',
        'modal-title'         => $params['modal-title'] ?? 'Modal Details',
        'modal-body-content'  => $params['modal-body-content'] ?? 'Modal content',
    ];

    return sprintf(
        '<div x-data="{ open: false }">
            <button @click="open = true" class="inline-flex items-center px-2 py-1 text-xs border rounded-lg hover:bg-gray-50 %s" type="button">%s</button>
            <div x-show="open" x-cloak @click.self="open = false" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 p-4">
                <div class="bg-white rounded-xl shadow-2xl w-full %s max-h-[90vh] overflow-y-auto">
                    <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                        <h4 class="text-lg font-semibold text-gray-800">%s</h4>
                        <button @click="open = false" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <div class="p-5 text-left">%s</div>
                </div>
            </div>
        </div>',
        $params['btn-class'],
        $params['btn-title'],
        $params['modal-size'],
        $params['modal-title'],
        $params['modal-body-content']
    );
}

function render_modal_body_content(string $controllerName, array $item = []): string
{
    switch ($controllerName) {
        case 'refill':
            $apiName = $item['api_name'];
            $details = json_encode(json_decode($item['details']), JSON_PRETTY_PRINT);
            $date = convert_timezone($item['last_updated'], "user");
            return sprintf(
                '<div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">%s</label>
                        <textarea rows="7" readonly class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-50">%s</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Last Update</label>
                        <input type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-50" readonly value="%s">
                    </div>
                </div>',
                $apiName,
                $details,
                $date
            );
            break;

        case 'services':
            $description = !empty($item['desc']) ? html_entity_decode($item['desc'], ENT_QUOTES) : '';
            $description = str_replace("\n", "<br>", $description);
            return sprintf('<div class="text-sm text-gray-600">%s</div>', $description);
            break;
    }

    return '';
}

function convert_timezone(string $dateTime): string
{
    $time = Time::parse($dateTime, 'UTC');
    $request = service('request');
    $userTimezone = $request->getJSON()->userTimezone ?? 'Asia/Dhaka';
    $time->setTimezone($userTimezone);
    return $time->toLocalizedString();
}

if (!function_exists('show_device_status')) {
    function show_device_status($device_key = '', $uid = '')
    {
        $xhtml = null;
        $status = 'Expired';
        $type = 'yellow';
        if (deviceValidation($device_key, $uid)) {
            $status = 'Active';
            $type = 'green';
        }
        $xhtml = sprintf('<span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-%s-100 text-%s-700 ml-auto">%s</span>', $type, $type, $status);
        return $xhtml;
    }
}

if (!function_exists('show_brand_status')) {
    function show_brand_status($brand_key = '', $uid = '')
    {
        $xhtml = null;
        $status = 'Expired';
        $type = 'yellow';
        if (brandValidation($brand_key, $uid)) {
            $status = 'Active';
            $type = 'green';
        }
        $xhtml = sprintf('<span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-%s-100 text-%s-700 ml-auto">%s</span>', $type, $type, $status);
        return $xhtml;
    }
}
