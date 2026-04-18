"use strict";

function toRelativeUrl(url) {
  try { return new URL(url).pathname + new URL(url).search; } catch(e) { return url; }
}

var pageOverlay = {
  show: function() {
    var el = document.getElementById('page-overlay');
    if (el) el.classList.add('active');
  },
  hide: function() {
    var el = document.getElementById('page-overlay');
    if (el) el.classList.remove('active');
  }
};

function is_json(str) {
  try { JSON.parse(str); } catch(e) { return false; }
  return true;
}

function reloadPage(url, newTab) {
  if (newTab) {
    window.open(url, '_blank');
  } else if (url) {
    setTimeout(function() { window.location = url; }, 1500);
  } else {
    setTimeout(function() { location.reload(); }, 1500);
  }
}

function confirm_notice(ms) {
  return confirm('Are you sure to ' + ms + ' ?');
}

var _toastContainer = null;
function _ensureToastContainer() {
  if (!_toastContainer) {
    _toastContainer = document.createElement('div');
    _toastContainer.id = 'qpay-toasts';
    _toastContainer.style.cssText = 'position:fixed;top:1rem;right:1rem;z-index:99999;display:flex;flex-direction:column;gap:0.5rem;max-width:360px;';
    document.body.appendChild(_toastContainer);
  }
  return _toastContainer;
}

function notify(message, type) {
  var container = _ensureToastContainer();
  var colors = {
    success: 'bg-green-500',
    error: 'bg-red-500',
    warning: 'bg-yellow-500',
    info: 'bg-blue-500'
  };
  var bgClass = colors[type] || colors.info;
  var toast = document.createElement('div');
  toast.className = bgClass + ' text-white px-4 py-3 rounded-lg shadow-lg text-sm flex items-center justify-between gap-3 transform transition-all duration-300 translate-x-full opacity-0';
  toast.innerHTML = '<span>' + message + '</span><button class="ml-2 text-white/80 hover:text-white text-lg leading-none">&times;</button>';
  container.appendChild(toast);
  requestAnimationFrame(function() {
    toast.classList.remove('translate-x-full', 'opacity-0');
  });
  toast.querySelector('button').addEventListener('click', function() { removeToast(toast); });
  setTimeout(function() { removeToast(toast); }, 3000);
}

function removeToast(toast) {
  toast.classList.add('translate-x-full', 'opacity-0');
  setTimeout(function() { if (toast.parentNode) toast.parentNode.removeChild(toast); }, 300);
}

function qPost(url, data) {
  return fetch(url, {
    method: 'POST',
    headers: { 
      'Content-Type': 'application/x-www-form-urlencoded',
      'X-Requested-With': 'XMLHttpRequest'
    },
    body: data
  }).then(function(r) { return r.text(); });
}

function qPostJson(url, data) {
  return fetch(url, {
    method: 'POST',
    headers: { 
      'Content-Type': 'application/x-www-form-urlencoded',
      'X-Requested-With': 'XMLHttpRequest'
    },
    body: data
  }).then(function(r) { return r.json(); });
}

function serializeForm(form) {
  return new URLSearchParams(new FormData(form)).toString();
}

function callPostAjax(url, data, type, redirect) {
  pageOverlay.show();
  var isJson = type !== 'get-result-html';
  var fetchFn = isJson ? qPostJson : qPost;
  fetchFn(url, data).then(function(result) {
    pageOverlay.hide();
    switch(type) {
      case 'sort':
      case 'status':
        notify(result.message, result.status);
        break;
      case 'delete-item':
        if (result.status === 'success') {
          var tr = document.querySelector('.tr_' + result.ids);
          if (tr) tr.remove();
        }
        notify(result.message, result.status);
        if (result.redirect_url) reloadPage(redirect, false);
        break;
      case 'copy-to-clipboard':
        if (result.status === 'success') {
          copyToClipBoard({ type: 'text', value: result.value });
        }
        break;
      case 'get-result-html':
        var rh = document.getElementById('result_html');
        if (rh) rh.innerHTML = result;
        break;
      default:
        notify(result.message, result.status);
        if (result.status === 'success') {
          var redir = result.redirect_url || '';
          reloadPage(redir, !!result.new_page);
        }
        break;
    }
  }).catch(function(err) {
    pageOverlay.hide();
    notify('Request failed: ' + err.message, 'error');
  });
}

function copyToClipBoard(params, showToast, message) {
  message = message || 'Copied Successfully';
  if (!params) return;
  var text = '';
  if (params.type === 'text') {
    text = params.value;
  } else if (params.element) {
    var content = params.element.closest('.text-to-cliboard');
    if (content) text = content.querySelector('.content') ? content.querySelector('.content').textContent : '';
  }
  if (navigator.clipboard) {
    navigator.clipboard.writeText(text).then(function() {
      if (showToast) notify(message, 'success');
    });
  } else {
    var ta = document.createElement('textarea');
    ta.value = text;
    document.body.appendChild(ta);
    ta.select();
    document.execCommand('copy');
    document.body.removeChild(ta);
    if (showToast) notify(message, 'success');
  }
}

function preparePrice(value, toFixed) {
  toFixed = 6;
  if (value.countDecimals() > 6) return value.toFixed(toFixed);
  return value.toString();
}
Number.prototype.countDecimals = function() {
  if (Math.floor(this.valueOf()) === this.valueOf()) return 0;
  var str = this.toString();
  if (str.indexOf('.') !== -1 && str.indexOf('-') !== -1) return str.split('-')[1] || 0;
  if (str.indexOf('.') !== -1) return str.split('.')[1].length || 0;
  return str.split('-')[1] || 0;
};

function qUploadFile(url, formData) {
  return fetch(url, { method: 'POST', body: formData })
    .then(function(r) { return r.json(); });
}

document.addEventListener('DOMContentLoaded', function() {

  document.addEventListener('submit', function(e) {
    var form = e.target;
    if (form.classList.contains('actionForm')) {
      e.preventDefault();
      pageOverlay.show();
      var action = toRelativeUrl(form.getAttribute('action'));
      var redirect = form.dataset.redirect;
      var data = serializeForm(form);
      if (!form.querySelector('input[name=token]')) {
        data += '&token=' + encodeURIComponent(token);
      }
      qPost(action, data).then(function(result) {
        pageOverlay.hide();
        if (is_json(result)) {
          var r = JSON.parse(result);
          notify(r.message, r.status);
          if (r.redirect) reloadPage(r.redirect);
          else if (r.status === 'success' && redirect) reloadPage(redirect);
        } else {
          var rn = document.getElementById('result_notification');
          if (rn) rn.innerHTML = result;
        }
      }).catch(function() { pageOverlay.hide(); });
    }

    if (form.classList.contains('actionFormWithoutToast')) {
      e.preventDefault();
      var action2 = toRelativeUrl(form.getAttribute('action'));
      var redirect2 = form.dataset.redirect;
      var data2 = serializeForm(form);
      data2 += '&token=' + encodeURIComponent(token);
      var btn = form.querySelector('.btn-submit');
      if (btn) btn.classList.add('opacity-50', 'pointer-events-none');
      var amr = document.querySelector('.alert-message-reponse');
      if (amr) amr.innerHTML = '';
      qPost(action2, data2).then(function(result) {
        if (btn) btn.classList.remove('opacity-50', 'pointer-events-none');
        if (is_json(result)) {
          var r = JSON.parse(result);
          showAlertMessage(r.message, r.status);
          if (r.status === 'success' && redirect2) reloadPage(redirect2);
        } else {
          var raf = document.getElementById('resultActionForm');
          if (raf) raf.innerHTML = result;
        }
      });
    }

    if (form.classList.contains('actionAddFundsForm')) {
      e.preventDefault();
      pageOverlay.show();
      var action3 = PATH + 'user/add_funds/process';
      var redirect3 = form.dataset.redirect;
      var data3 = serializeForm(form) + '&token=' + encodeURIComponent(token);
      qPost(action3, data3).then(function(result) {
        pageOverlay.hide();
        if (is_json(result)) {
          var r = JSON.parse(result);
          if (r.status === 'success' && r.redirect_url) {
            window.location.href = r.redirect_url;
            return;
          }
          notify(r.message, r.status);
          if (r.status === 'success' && redirect3) reloadPage(redirect3);
        } else {
          var afc = document.querySelector('.add-funds-form-content');
          if (afc) afc.innerHTML = result;
        }
      });
    }

    if (form.classList.contains('ajaxSearchItem')) {
      e.preventDefault();
      pageOverlay.show();
      var action4 = toRelativeUrl(form.getAttribute('action'));
      var data4 = serializeForm(form) + '&token=' + encodeURIComponent(token);
      qPost(action4, data4).then(function(result) {
        pageOverlay.hide();
        var rs = document.getElementById('result_ajaxSearch');
        if (rs) rs.innerHTML = result;
      });
    }
  });

  document.addEventListener('click', function(e) {
    var target = e.target.closest('.ajaxDeleteItem');
    if (target) {
      e.preventDefault();
      var msg = target.dataset.confirm_ms;
      if (!confirm_notice(msg)) return;
      var url = toRelativeUrl(target.getAttribute('href'));
      var data = 'token=' + encodeURIComponent(token);
      callPostAjax(url, data, 'delete-item');
    }

    var toggle = e.target.closest('.ajaxToggleItemStatus');
    if (toggle) {
      var id = toggle.dataset.id;
      var url2 = toggle.dataset.action + id;
      var status = toggle.checked ? 1 : 0;
      var data5 = 'token=' + encodeURIComponent(token) + '&status=' + status;
      callPostAjax(url2, data5, 'status');
    }

    var viewUser = e.target.closest('.ajaxViewUser');
    if (viewUser) {
      e.preventDefault();
      pageOverlay.show();
      var url3 = toRelativeUrl(viewUser.getAttribute('href'));
      var data6 = 'token=' + encodeURIComponent(token);
      callPostAjax(url3, data6, '');
    }

    var bulkAction = e.target.closest('.ajaxActionOptions');
    if (bulkAction) {
      e.preventDefault();
      var type = bulkAction.dataset.type;
      if (['delete','deactive','delete-all','restore'].indexOf(type) !== -1) {
        if (!confirm_notice(type)) return;
      }
      var url4 = toRelativeUrl(bulkAction.getAttribute('href'));
      var selectedIds = [];
      document.querySelectorAll('.check-item:checked').forEach(function(cb) {
        selectedIds.push(cb.value);
      });
      if (selectedIds.length <= 0 && type !== 'delete-all' && type !== 'restore') {
        alert('Please choose at least one item');
        return;
      }
      var data7 = 'ids=' + selectedIds.join(',') + '&token=' + encodeURIComponent(token);
      pageOverlay.show();
      var typePost = '';
      var copyTypes = ['copy_id','copy_order_id','copy_api_refill_id','copy_api_order_id'];
      if (copyTypes.indexOf(type) !== -1) typePost = 'copy-to-clipboard';
      callPostAjax(url4, data7, typePost);
    }

    var checkAll = e.target.closest('.check-all');
    if (checkAll) {
      var name = checkAll.dataset.name;
      document.querySelectorAll('.' + name).forEach(function(cb) {
        cb.checked = checkAll.checked;
      });
    }

    var copyBtn = e.target.closest('.my-copy-btn');
    if (copyBtn) {
      var input = copyBtn.parentElement.querySelector('.text-to-cliboard') || copyBtn.previousElementSibling;
      if (input) {
        copyToClipBoard({ type: 'text', value: input.value }, true, 'Copied Successfully');
      }
    }

    var modalLink = e.target.closest('.ajaxModal');
    if (modalLink) {
      e.preventDefault();
      var url5 = toRelativeUrl(modalLink.getAttribute('href'));
      if (!url5 || url5 === '#') return;
      openModal(url5);
    }
  });

  document.addEventListener('change', function(e) {
    var target = e.target;

    if (target.classList.contains('ajaxChangeSort')) {
      var id = target.dataset.id;
      var url = target.dataset.url + id;
      var sort = target.value;
      var data = 'token=' + encodeURIComponent(token) + '&sort=' + sort;
      callPostAjax(url, data, 'sort');
    }

    if (target.classList.contains('ajaxChange')) {
      pageOverlay.show();
      var id2 = target.value;
      if (id2 === '') { pageOverlay.hide(); return; }
      var url2 = target.dataset.url + id2;
      var data2 = 'token=' + encodeURIComponent(token);
      qPost(url2, data2).then(function(result) {
        pageOverlay.hide();
        var rs = document.getElementById('result_ajaxSearch');
        if (rs) rs.innerHTML = result;
      });
    }

    if (target.classList.contains('ajaxChangeCurrencyCode')) {
      var code = target.value;
      document.querySelectorAll('.new-currency-code').forEach(function(el) { el.textContent = code; });
    }

    if (target.classList.contains('ajaxChangeTicketSubject')) {
      var type = target.value;
      document.querySelectorAll('.ticket_subject').forEach(function(el) { el.classList.add('hidden'); });
      document.querySelectorAll('.' + type + '-ticket_subject').forEach(function(el) { el.classList.remove('hidden'); });
    }
  });

  var searchArea = document.querySelector('.search-area');
  if (searchArea) {
    var btnSearch = searchArea.querySelector('.btn-search');
    var btnClear = searchArea.querySelector('.btn-clear');
    if (btnSearch) {
      btnSearch.addEventListener('click', function() {
        var pathname = window.location.pathname;
        var searchParams = new URLSearchParams(window.location.search);
        var link = '';
        ['status'].forEach(function(p) {
          if (searchParams.has(p)) link += p + '=' + searchParams.get(p) + '&';
        });
        var input = searchArea.querySelector('input[name=query]');
        var pathlink = pathname + '?' + link + 'query=' + (input ? input.value : '');
        var sel = searchArea.querySelector('option:checked');
        if (sel) pathlink += '&field=' + sel.value;
        window.location.href = pathlink;
      });
    }
    if (btnClear) {
      btnClear.addEventListener('click', function() {
        window.location.href = window.location.pathname;
      });
    }
  }

  function get_notification(type, id) {
    type = type || '';
    id = id || '';
    var el = document.querySelector('.notification_open');
    if (!el) return;
    var url = el.dataset.url;
    qPost(url, 'token=' + encodeURIComponent(token) + '&type=' + type + '&id=' + id)
      .then(function(result) {
        var nd = document.querySelector('.notification_data');
        if (nd) nd.innerHTML = result;
      });
  }
  document.addEventListener('click', function(e) {
    if (e.target.closest('.notification_open')) get_notification();
    var ns = e.target.closest('.notification_all, .notification_single');
    if (ns) {
      get_notification(ns.dataset.type || '', ns.dataset.id || '');
    }
  });

  setInterval(function() {
    var tn = document.querySelector('.total_notification');
    if (!tn || !tn.dataset.url) return;
    qPost(tn.dataset.url, 'token=' + encodeURIComponent(token) + '&type=' + user)
      .then(function(result) {
        try {
          var r = JSON.parse(result);
          if (r.notification_count) tn.textContent = r.notification_count;
          var tu = document.querySelector('.total_unread_tickets');
          if (tu && r.tickets_count) tu.textContent = r.tickets_count;
        } catch(e) {}
      });
  }, 5000);

  document.querySelectorAll('.settings_fileupload').forEach(function(el) {
    el.addEventListener('change', function(e) {
      var file = e.target.files[0];
      if (!file) return;
      var preview = el.closest('div').querySelector('.img-fluid') || el.previousElementSibling;
      if (preview && preview.tagName === 'IMG') {
        var reader = new FileReader();
        reader.onload = function(ev) { preview.src = ev.target.result; };
        reader.readAsDataURL(file);
      }
      var type = el.dataset.type || '';
      var formData = new FormData();
      formData.append('file', file);
      formData.append('token', token);
      formData.append('user', user);
      formData.append('type', type);
      pageOverlay.show();
      qUploadFile(PATH + 'upload_files', formData).then(function(result) {
        pageOverlay.hide();
        if (result.status === 'success') {
          var input = el.closest('div').querySelector('input[type=text], input[type=hidden]');
          if (input) input.value = result.link;
          notify(result.message, result.status);
        } else {
          notify(result.message || 'Upload failed', 'error');
        }
      }).catch(function() { pageOverlay.hide(); });
    });
  });

  document.querySelectorAll('.settings_all_fileupload').forEach(function(el) {
    el.addEventListener('change', function(e) {
      var file = e.target.files[0];
      if (!file) return;
      var formData = new FormData();
      formData.append('file', file);
      formData.append('token', token);
      qUploadFile(PATH + 'upload_all_files', formData).then(function(result) {
        if (result.status === 'success') {
          var input = el.closest('div').querySelector('input[type=text], input[type=hidden]');
          if (input) input.value = result.link;
          notify(result.message, result.status);
        } else {
          notify(result.message || 'Upload failed', 'error');
        }
      });
    });
  });

});

function showAlertMessage(message, type) {
  var amr = document.querySelector('.alert-message-reponse');
  if (!amr) return;
  var bgClass = type === 'success' ? 'bg-green-50 border-green-200 text-green-800' : 'bg-yellow-50 border-yellow-200 text-yellow-800';
  amr.innerHTML = '<div class="border rounded-lg px-4 py-3 text-sm ' + bgClass + '">' + message + '</div>';
}

function openModal(url) {
  var overlay = document.getElementById('modal-overlay');
  if (!overlay) {
    overlay = document.createElement('div');
    overlay.id = 'modal-overlay';
    overlay.className = 'fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 p-4';
    overlay.innerHTML = '<div id="modal-content" class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto relative"><button id="modal-close-btn" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 z-10"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button><div id="modal-body" class="p-6"><div class="flex justify-center py-8"><div class="q-spinner"></div></div></div></div>';
    document.body.appendChild(overlay);
    overlay.addEventListener('click', function(e) {
      if (e.target === overlay) closeModal();
    });
    document.getElementById('modal-close-btn').addEventListener('click', closeModal);
  } else {
    overlay.classList.remove('hidden');
    document.getElementById('modal-body').innerHTML = '<div class="flex justify-center py-8"><div class="q-spinner"></div></div>';
  }
  document.body.style.overflow = 'hidden';

  fetch(url, {
    headers: { 'X-Requested-With': 'XMLHttpRequest' }
  }).then(function(r) { return r.text(); }).then(function(html) {
    var body = document.getElementById('modal-body');
    body.innerHTML = html;
    body.querySelectorAll('script').forEach(function(s) {
      var ns = document.createElement('script');
      if (s.src) ns.src = s.src;
      else ns.textContent = s.textContent;
      body.appendChild(ns);
    });
  });
}

function closeModal() {
  var overlay = document.getElementById('modal-overlay');
  if (overlay) {
    overlay.classList.add('hidden');
    document.body.style.overflow = '';
  }
}

function plugin_editor(selector, settings) {
  if (typeof tinymce === 'undefined') return;
  selector = selector || '.tinymce';
  var defaults = {
    selector: selector,
    menubar: false,
    branding: false,
    paste_data_images: true,
    relative_urls: false,
    convert_urls: false,
    inline_styles: true,
    verify_html: false,
    cleanup: false,
    autoresize_bottom_margin: 25,
    plugins: [
      'advlist autolink lists link charmap preview hr anchor pagebreak',
      'searchreplace wordcount',
      'insertdatetime nonbreaking save table directionality',
      'emoticons template paste textcolor colorpicker textpattern',
      'image'
    ],
    image_advtab: true,
    toolbar1: 'forecolor backcolor | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image',
    images_upload_handler: function(blobInfo, success, failure, progress) {
      var formData = new FormData();
      formData.append('file', blobInfo.blob(), blobInfo.filename());
      formData.append('token', token);
      formData.append('user', user);
      qUploadFile(PATH + 'upload_files_tiny', formData).then(function(r) {
        success(r.url);
      }).catch(function() { failure('Upload failed'); });
    }
  };
  if (settings) {
    for (var key in settings) {
      if (key === 'append_plugins') defaults.plugins.push(settings[key]);
      else if (key === 'toolbar') defaults.toolbar1 += ' ' + settings[key];
      else defaults[key] = settings[key];
    }
  }
  return tinymce.init(defaults);
}
