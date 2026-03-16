"use strict";
(function () {
  var _token = window.token || '';
  var _path = window.PATH || '';
  var _user = window.user || '';

  window.QApp = {
    token: function () { return _token; },
    path: function () { return _path; },
    user: function () { return _user; },
    setToken: function (t) { _token = t; window.token = t; }
  };

  function is_json(str) {
    try { JSON.parse(str); } catch (e) { return false; }
    return true;
  }
  window.is_json = is_json;

  function reloadPage(url, newTab) {
    if (newTab) {
      window.open(url, '_blank');
    } else if (url) {
      setTimeout(function () { window.location = url; }, 2500);
    } else {
      setTimeout(function () { location.reload(); }, 2500);
    }
  }
  window.reloadPage = reloadPage;

  function confirm_notice(ms) {
    return confirm('Are you sure to ' + ms + ' ?');
  }
  window.confirm_notice = confirm_notice;

  var toastContainer = null;
  function ensureToastContainer() {
    if (toastContainer) return toastContainer;
    toastContainer = document.createElement('div');
    toastContainer.id = 'qpay-toast-container';
    toastContainer.style.cssText = 'position:fixed;top:16px;right:16px;z-index:99999;display:flex;flex-direction:column;gap:8px;max-width:360px;';
    document.body.appendChild(toastContainer);
    return toastContainer;
  }

  function notify(message, type) {
    var c = ensureToastContainer();
    var colors = {
      success: { bg: '#059669', icon: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>' },
      error: { bg: '#dc2626', icon: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>' },
      warning: { bg: '#d97706', icon: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>' },
      info: { bg: '#2563eb', icon: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>' }
    };
    var style = colors[type] || colors.info;
    var toast = document.createElement('div');
    toast.style.cssText = 'display:flex;align-items:center;gap:10px;padding:12px 16px;border-radius:8px;color:#fff;font-size:14px;font-family:system-ui,sans-serif;box-shadow:0 4px 12px rgba(0,0,0,.15);opacity:0;transform:translateX(40px);transition:all .3s ease;background:' + style.bg;
    var iconSpan = document.createElement('span');
    iconSpan.style.flexShrink = '0';
    iconSpan.innerHTML = style.icon;
    var msgSpan = document.createElement('span');
    msgSpan.style.flex = '1';
    msgSpan.textContent = message;
    var closeBtn = document.createElement('button');
    closeBtn.style.cssText = 'background:none;border:none;color:#fff;cursor:pointer;padding:0;margin-left:8px;font-size:18px;line-height:1';
    closeBtn.innerHTML = '&times;';
    closeBtn.onclick = function() { toast.remove(); };
    toast.appendChild(iconSpan);
    toast.appendChild(msgSpan);
    toast.appendChild(closeBtn);
    c.appendChild(toast);
    requestAnimationFrame(function () {
      toast.style.opacity = '1';
      toast.style.transform = 'translateX(0)';
    });
    setTimeout(function () {
      toast.style.opacity = '0';
      toast.style.transform = 'translateX(40px)';
      setTimeout(function () { if (toast.parentElement) toast.remove(); }, 300);
    }, 3500);
  }
  window.notify = notify;

  var pageOverlay = {
    show: function () {
      var el = document.getElementById('page-overlay');
      if (el && !el.classList.contains('active')) {
        el.classList.add('active');
        var img = el.querySelector('.page-loading-image');
        if (img) img.classList.remove('d-none', 'hidden');
      }
    },
    hide: function () {
      var el = document.getElementById('page-overlay');
      if (el) {
        el.classList.remove('active');
        var img = el.querySelector('.page-loading-image');
        if (img) img.classList.add('hidden');
      }
    }
  };
  window.pageOverlay = pageOverlay;

  var alertMessage = {
    show: function (message, type) {
      var el = document.querySelector('.alert-message-reponse');
      if (!el) return;
      var cls = type === 'success' ? 'bg-green-100 text-green-800 border-green-300' : 'bg-yellow-100 text-yellow-800 border-yellow-300';
      el.innerHTML = '<div class="border rounded-lg p-3 ' + cls + '">' + message + '</div>';
    },
    hide: function () {
      var el = document.querySelector('.alert-message-reponse');
      if (el) el.innerHTML = '';
    }
  };
  window.alertMessage = alertMessage;

  function qpost(url, data, options) {
    options = options || {};
    var headers = { 'X-Requested-With': 'XMLHttpRequest' };
    var body;
    if (data instanceof FormData) {
      if (!data.has('token') && _token) data.append('token', _token);
      body = data;
    } else if (typeof data === 'object' && data !== null) {
      headers['Content-Type'] = 'application/x-www-form-urlencoded';
      var params = new URLSearchParams(data);
      if (!params.has('token') && _token) params.append('token', _token);
      body = params.toString();
    } else if (typeof data === 'string') {
      headers['Content-Type'] = 'application/x-www-form-urlencoded';
      if (data.indexOf('token=') === -1 && _token) {
        data += (data ? '&' : '') + 'token=' + encodeURIComponent(_token);
      }
      body = data;
    } else {
      headers['Content-Type'] = 'application/x-www-form-urlencoded';
      body = 'token=' + encodeURIComponent(_token);
    }

    return fetch(url, {
      method: 'POST',
      headers: headers,
      body: body,
      credentials: 'same-origin'
    }).then(function (resp) {
      var ct = resp.headers.get('content-type') || '';
      if (options.responseType === 'html' || ct.indexOf('text/html') !== -1) {
        return resp.text();
      }
      return resp.text().then(function (txt) {
        if (is_json(txt)) return JSON.parse(txt);
        return txt;
      });
    });
  }
  window.qpost = qpost;

  function callPostAjax(element, url, data, type, redirect) {
    var dataType = type === 'get-result-html' ? 'html' : 'json';
    pageOverlay.show();
    qpost(url, data, { responseType: dataType }).then(function (result) {
      switch (type) {
        case 'sort':
        case 'status':
          notifyJS(element, result.status, result.message);
          break;
        case 'delete-item':
          if (result.status === 'success') {
            var rows = document.querySelectorAll('.tr_' + result.ids);
            rows.forEach(function (r) { r.remove(); });
          }
          setTimeout(function () { notify(result.message, result.status); }, 2000);
          if (result.redirect_url) reloadPage(redirect, false);
          break;
        case 'copy-to-clipboard':
          if (result.status === 'success') copyToClipBoard({ type: 'text', value: result.value });
          break;
        case 'get-result-html':
          setTimeout(function () {
            var rh = document.getElementById('result_html');
            if (rh) rh.innerHTML = result;
          }, 1000);
          break;
        default:
          setTimeout(function () {
            notify(result.message, result.status);
            if (result.status === 'success') {
              var redir = result.redirect_url || '';
              reloadPage(redir, !!result.new_page);
            }
          }, 2000);
          break;
      }
      pageOverlay.hide();
    }).catch(function (err) {
      console.error('callPostAjax error:', err);
      pageOverlay.hide();
    });
  }
  window.callPostAjax = callPostAjax;

  function notifyJS(element, className, message) {
    notify(message, className);
  }
  window.notifyJS = notifyJS;

  function copyToClipBoard(params, showToast, message) {
    if (!params) return;
    message = message || 'Copied Successfully';
    var text = '';
    if (params.type === 'text') {
      text = params.value;
    } else if (params.element) {
      var content = params.element.closest('.text-to-cliboard');
      if (content) {
        var inner = content.querySelector('.content');
        if (inner) text = inner.textContent;
      }
    }
    if (navigator.clipboard && text) {
      navigator.clipboard.writeText(text).then(function () {
        if (showToast) notify(message, 'success');
      });
    } else if (text) {
      var ta = document.createElement('textarea');
      ta.value = text;
      ta.style.position = 'fixed';
      ta.style.opacity = '0';
      document.body.appendChild(ta);
      ta.select();
      document.execCommand('copy');
      ta.remove();
      if (showToast) notify(message, 'success');
    }
  }
  window.copyToClipBoard = copyToClipBoard;

  function preparePrice(value, toFixed) {
    toFixed = 6;
    if (value.countDecimals() > 6) return value.toFixed(toFixed);
    return value.toString();
  }
  window.preparePrice = preparePrice;

  Number.prototype.countDecimals = function () {
    if (Math.floor(this.valueOf()) === this.valueOf()) return 0;
    var str = this.toString();
    if (str.indexOf('.') !== -1 && str.indexOf('-') !== -1) return str.split('-')[1] || 0;
    if (str.indexOf('.') !== -1) return str.split('.')[1].length || 0;
    return str.split('-')[1] || 0;
  };

  function sendXMLPostRequest(url, params) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        try {
          var response = JSON.parse(xhr.responseText);
          console.log(response.status);
        } catch (err) {
          console.error('Error parsing XMLPost response:', err);
        }
      }
    };
    xhr.send(params);
  }
  window.sendXMLPostRequest = sendXMLPostRequest;

  document.addEventListener('DOMContentLoaded', function () {
    document.addEventListener('submit', function (e) {
      var form = e.target;

      if (form.classList.contains('actionForm')) {
        e.preventDefault();
        pageOverlay.show();
        var action = form.getAttribute('action');
        var redirectUrl = form.dataset.redirect;
        var formData = new FormData(form);
        var params = new URLSearchParams(formData).toString();
        if (params.indexOf('token=') === -1 && _token) {
          params += (params ? '&' : '') + 'token=' + encodeURIComponent(_token);
        }
        qpost(action, params).then(function (result) {
          setTimeout(function () { pageOverlay.hide(); }, 1000);
          if (typeof result === 'object') {
            setTimeout(function () { notify(result.message, result.status); }, 1000);
            if (result.redirect) {
              reloadPage(result.redirect);
            } else if (result.status === 'success' && redirectUrl) {
              setTimeout(function () { reloadPage(redirectUrl); }, 1000);
            }
          } else {
            setTimeout(function () {
              var rn = document.getElementById('result_notification');
              if (rn) rn.innerHTML = result;
            }, 1000);
          }
        }).catch(function (err) {
          pageOverlay.hide();
          notify('An error occurred. Please try again.', 'error');
          console.error('actionForm error:', err);
        });
        return;
      }

      if (form.classList.contains('actionFormWithoutToast')) {
        e.preventDefault();
        alertMessage.hide();
        var action2 = form.getAttribute('action');
        var redirectUrl2 = form.dataset.redirect;
        var formData2 = new FormData(form);
        var params2 = new URLSearchParams(formData2).toString();
        if (params2.indexOf('token=') === -1 && _token) {
          params2 += '&token=' + encodeURIComponent(_token);
        }
        var submitBtn = form.querySelector('.btn-submit');
        if (submitBtn) submitBtn.classList.add('opacity-50', 'pointer-events-none');
        qpost(action2, params2).then(function (result) {
          if (typeof result === 'object') {
            setTimeout(function () { alertMessage.show(result.message, result.status); }, 1500);
            if (result.status === 'success' && redirectUrl2) {
              setTimeout(function () { reloadPage(redirectUrl2); }, 2000);
            }
          } else {
            setTimeout(function () {
              var raf = document.getElementById('resultActionForm');
              if (raf) raf.innerHTML = result;
            }, 1500);
          }
          setTimeout(function () {
            if (submitBtn) submitBtn.classList.remove('opacity-50', 'pointer-events-none');
          }, 1500);
        });
        return;
      }

      if (form.classList.contains('actionAddFundsForm')) {
        e.preventDefault();
        pageOverlay.show();
        var action3 = _path + 'user/add_funds/process';
        var redirectUrl3 = form.dataset.redirect;
        var formData3 = new FormData(form);
        var params3 = new URLSearchParams(formData3).toString();
        if (params3.indexOf('token=') === -1 && _token) {
          params3 += '&token=' + encodeURIComponent(_token);
        }
        qpost(action3, params3).then(function (result) {
          setTimeout(function () { pageOverlay.hide(); }, 1500);
          if (typeof result === 'object') {
            if (result.status === 'success' && result.redirect_url) {
              window.location.href = result.redirect_url;
            }
            setTimeout(function () { notify(result.message, result.status); }, 1500);
            if (result.status === 'success' && redirectUrl3) {
              setTimeout(function () { reloadPage(redirectUrl3); }, 2000);
            }
          } else {
            setTimeout(function () {
              var afc = document.querySelector('.add-funds-form-content');
              if (afc) afc.innerHTML = result;
            }, 100);
          }
        });
        return;
      }

      if (form.classList.contains('ajaxSearchItem')) {
        e.preventDefault();
        pageOverlay.show();
        var action4 = form.getAttribute('action');
        var formData4 = new FormData(form);
        var params4 = new URLSearchParams(formData4).toString();
        if (params4.indexOf('token=') === -1 && _token) {
          params4 += '&token=' + encodeURIComponent(_token);
        }
        qpost(action4, params4, { responseType: 'html' }).then(function (result) {
          setTimeout(function () {
            pageOverlay.hide();
            var rs = document.getElementById('result_ajaxSearch');
            if (rs) rs.innerHTML = result;
          }, 300);
        });
        return;
      }
    });

    document.addEventListener('click', function (e) {
      var el = e.target.closest('.ajaxViewUser');
      if (el) {
        e.preventDefault();
        pageOverlay.show();
        var url = el.getAttribute('href');
        callPostAjax(el, url, 'token=' + encodeURIComponent(_token), '');
        return;
      }

      var del = e.target.closest('.ajaxDeleteItem');
      if (del) {
        e.preventDefault();
        var msg = del.dataset.confirm_ms;
        if (!confirm_notice(msg)) return;
        var delUrl = del.getAttribute('href');
        callPostAjax(del, delUrl, 'token=' + encodeURIComponent(_token), 'delete-item');
        return;
      }

      var action = e.target.closest('.ajaxActionOptions');
      if (action) {
        e.preventDefault();
        var actionType = action.dataset.type;
        if (['delete', 'deactive', 'delete-all', 'restore'].indexOf(actionType) !== -1) {
          if (!confirm_notice(actionType)) return;
        }
        var actionUrl = action.getAttribute('href');
        var selectedIds = [];
        document.querySelectorAll('.check-item:checked').forEach(function (cb) {
          selectedIds.push(cb.value);
        });
        if (selectedIds.length <= 0 && actionType !== 'delete-all' && actionType !== 'restore') {
          alert('Please choose at least one item');
        } else {
          var ids = selectedIds.join(',');
          var actionData = 'ids=' + encodeURIComponent(ids) + '&token=' + encodeURIComponent(_token);
          pageOverlay.show();
          var typePost = '';
          var copyTypes = ['copy_id', 'copy_order_id', 'copy_api_refill_id', 'copy_api_order_id'];
          if (copyTypes.indexOf(actionType) !== -1) typePost = 'copy-to-clipboard';
          callPostAjax(action, actionUrl, actionData, typePost);
        }
        return;
      }

      var toggle = e.target.closest('.ajaxToggleItemStatus');
      if (toggle) {
        var tid = toggle.dataset.id;
        var turl = toggle.dataset.action + tid;
        var tstatus = toggle.checked ? 1 : 0;
        var tdata = 'token=' + encodeURIComponent(_token) + '&status=' + tstatus;
        callPostAjax(toggle, turl, tdata, 'status');
        return;
      }

      var langLink = e.target.closest('.ajaxChangeLanguageSecond');
      if (langLink) {
        e.preventDefault();
        window.location.href = langLink.dataset.url + '?ids=' + langLink.dataset.ids + '&redirect=' + langLink.dataset.redirect;
        return;
      }

      var checkAll = e.target.closest('.check-all');
      if (checkAll) {
        var name = checkAll.dataset.name;
        document.querySelectorAll('.' + name).forEach(function (cb) {
          cb.checked = checkAll.checked;
        });
        return;
      }

      var searchBtn = e.target.closest('.search-area .btn-search');
      if (searchBtn) {
        var area = document.querySelector('.search-area');
        var input = area ? area.querySelector('input[name=query]') : null;
        var sp = new URLSearchParams(window.location.search);
        var link = '';
        if (sp.has('status')) link += 'status=' + sp.get('status') + '&';
        var pathlink = window.location.pathname + '?' + link + 'query=' + (input ? input.value : '');
        var sel = area ? area.querySelector('option:checked') : null;
        if (sel && sel.value) pathlink += '&field=' + sel.value;
        window.location.href = pathlink;
        return;
      }

      var clearBtn = e.target.closest('.search-area .btn-clear');
      if (clearBtn) {
        window.location.href = window.location.pathname;
        return;
      }
    });

    document.addEventListener('change', function (e) {
      if (e.target.classList.contains('ajaxChangeLanguage')) {
        var el2 = e.target;
        window.location.href = el2.dataset.url + '?ids=' + el2.value + '&redirect=' + el2.dataset.redirect;
        return;
      }

      if (e.target.classList.contains('ajaxChange')) {
        pageOverlay.show();
        var el3 = e.target;
        var val = el3.value;
        if (!val) { pageOverlay.hide(); return; }
        var chUrl = el3.dataset.url + val;
        qpost(chUrl, 'token=' + encodeURIComponent(_token), { responseType: 'html' }).then(function (result) {
          pageOverlay.hide();
          var rs = document.getElementById('result_ajaxSearch');
          if (rs) rs.innerHTML = result;
        });
        return;
      }

      if (e.target.classList.contains('ajaxChangeTicketSubject')) {
        var type = e.target.value;
        document.querySelectorAll('.ticket_subject').forEach(function (el4) { el4.classList.add('hidden', 'd-none'); });
        document.querySelectorAll('.' + type + '-ticket_subject').forEach(function (el5) { el5.classList.remove('hidden', 'd-none'); });
        return;
      }

      if (e.target.classList.contains('ajaxChangeSort')) {
        var sortEl = e.target;
        var sortUrl = sortEl.dataset.url + sortEl.dataset.id;
        var sortData = 'token=' + encodeURIComponent(_token) + '&sort=' + encodeURIComponent(sortEl.value);
        callPostAjax(sortEl, sortUrl, sortData, 'sort');
        return;
      }

      if (e.target.classList.contains('ajaxChangeCurrencyCode')) {
        document.querySelectorAll('.new-currency-code').forEach(function (el6) {
          el6.textContent = e.target.value;
        });
      }
    });

    if (_user) {
      setInterval(function () {
        var el = document.querySelector('.total_notification');
        if (!el) return;
        var dataUrl = el.dataset.url || el.getAttribute('data-url');
        if (!dataUrl) return;
        qpost(dataUrl, { token: _token, type: _user }).then(function (result) {
          if (typeof result === 'object') {
            if (result.notification_count) {
              document.querySelectorAll('.total_notification').forEach(function (n) {
                n.textContent = result.notification_count;
              });
            }
            if (result.tickets_count) {
              document.querySelectorAll('.total_unread_tickets').forEach(function (t) {
                t.textContent = result.tickets_count;
              });
            }
          }
        }).catch(function () {});
      }, 15000);
    }
  });
})();
