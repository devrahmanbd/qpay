<?php
defined('APP_NAMESPACE') OR exit('No direct script access allowed');
if (!function_exists('show_page_header_filter')) {
    function show_page_header_filter($controller_name, $data_filter = [],$type='')
    {
        $xhtml = null;
        $show_by_status_button = show_filter_status_button($controller_name, $data_filter['items_status_count'], $data_filter['params'],$type);
        $show_search_area      = show_search_area($controller_name, $data_filter['params']);
        $xhtml = sprintf(
            '<div class="mb-4">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div x-data="{ open: true }" class="overflow-hidden">
                        <div class="flex items-center justify-between px-5 py-3 border-b border-gray-100">
                            <h3 class="text-sm font-medium text-primary-600 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                                Filter
                            </h3>
                            <button @click="open = !open" class="text-gray-400 hover:text-gray-600">
                                <svg :class="open ? \'rotate-180\' : \'\'" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                        </div>
                        <div x-show="open" x-collapse class="p-4">
                            <div class="flex flex-col md:flex-row gap-4">
                                <div class="flex-1">%s</div>
                                <div class="w-full md:w-80 search-area">%s</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>', $show_by_status_button, $show_search_area
        );
        return $xhtml;
    }
}

if (!function_exists('show_page_header')) {
    function show_page_header($controller_name, $params = [],$type='')
    {
        $xhtml = null;
        $xhtml_page_options = null;
        $class_page_type = (isset($params['page-options-type']) && $params['page-options-type'] == 'ajax-modal') ? 'ajaxModal' : '';
        switch ($params['page-options']) {
            case 'add-new':
                $add_new_link = ($type=='user')?user_url($controller_name . "/update"):admin_url($controller_name . "/update");
                $xhtml_page_options = sprintf(
                    '<div class="flex justify-end">
                        <a href="%s" class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors %s">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Add new
                        </a>
                    </div>', $add_new_link, $class_page_type
                );
                break;
            case 'search':
                $show_search_area = show_search_area($controller_name, $params['search_params']);
                $xhtml_page_options = sprintf(
                    '<div class="search-area">%s</div>', $show_search_area
                );
                break;
        }

        $xhtml = sprintf(
            '<div class="flex items-center justify-between mb-6">
                <h1 class="text-xl font-semibold text-gray-800">%s</h1>
                <div>%s</div>
            </div>', ucfirst($controller_name), $xhtml_page_options
        );
        return $xhtml;
    }
}
