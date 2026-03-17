const https = require('https');
const http = require('http');
const { URL } = require('url');

class QPay {
  static VERSION = '1.0.0';
  static API_VERSION = 'v1';

  constructor(apiKey, options = {}) {
    if (!apiKey) throw new Error('API key is required.');
    this.apiKey = apiKey;
    this.baseUrl = (options.baseUrl || 'https://your-qpay-domain.com').replace(/\/+$/, '');
    this.timeout = options.timeout || 30000;
  }

  get isTestMode() {
    return this.apiKey.includes('_test_');
  }

  async createPayment(params) {
    if (!params || !params.amount) throw new Error("'amount' is required.");
    return this._request('POST', '/payment/create', params);
  }

  async verifyPayment(paymentId) {
    if (!paymentId) throw new Error('Payment ID is required.');
    return this._request('GET', `/payment/verify/${paymentId}`);
  }

  async getPaymentStatus(paymentId) {
    if (!paymentId) throw new Error('Payment ID is required.');
    return this._request('GET', `/payment/status/${paymentId}`);
  }

  async listPayments(params = {}) {
    return this._request('GET', '/payments', params);
  }

  async createRefund(paymentId, reason = '') {
    if (!paymentId) throw new Error('Payment ID is required.');
    const data = { payment_id: paymentId };
    if (reason) data.reason = reason;
    return this._request('POST', '/refunds', data);
  }

  async getBalance() {
    return this._request('GET', '/balance');
  }

  async getPaymentMethods() {
    return this._request('GET', '/payment/methods');
  }

  static verifyWebhookSignature(payload, signatureHeader, secret, tolerance = 300) {
    const crypto = require('crypto');
    const parts = {};
    signatureHeader.split(',').forEach(part => {
      const [key, value] = part.trim().split('=', 2);
      if (key && value) parts[key] = value;
    });

    if (!parts.t || !parts.v1) return false;

    const timestamp = parseInt(parts.t, 10);
    if (tolerance > 0 && Math.abs(Math.floor(Date.now() / 1000) - timestamp) > tolerance) {
      return false;
    }

    const expected = crypto
      .createHmac('sha256', secret)
      .update(`${timestamp}.${payload}`)
      .digest('hex');

    return crypto.timingSafeEqual(Buffer.from(expected), Buffer.from(parts.v1));
  }

  _request(method, endpoint, data = {}) {
    return new Promise((resolve, reject) => {
      let path = `/api/${QPay.API_VERSION}${endpoint}`;

      if (method === 'GET' && Object.keys(data).length > 0) {
        const qs = new URLSearchParams(data).toString();
        path += `?${qs}`;
      }

      const parsed = new URL(this.baseUrl);
      const isHttps = parsed.protocol === 'https:';
      const transport = isHttps ? https : http;

      const options = {
        hostname: parsed.hostname,
        port: parsed.port || (isHttps ? 443 : 80),
        path: path,
        method: method,
        headers: {
          'API-KEY': this.apiKey,
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'User-Agent': `QPay-Node-SDK/${QPay.VERSION}`,
        },
        timeout: this.timeout,
      };

      const req = transport.request(options, (res) => {
        let body = '';
        res.on('data', chunk => body += chunk);
        res.on('end', () => {
          let parsed;
          try {
            parsed = JSON.parse(body);
          } catch {
            parsed = { raw: body };
          }

          if (res.statusCode >= 400) {
            const err = new QPayError(
              parsed.message || `HTTP ${res.statusCode} error`,
              res.statusCode,
              parsed.code || 'API_ERROR',
              parsed
            );
            reject(err);
            return;
          }

          resolve(parsed);
        });
      });

      req.on('error', err => reject(new Error(`QPay API request failed: ${err.message}`)));
      req.on('timeout', () => { req.destroy(); reject(new Error('QPay API request timed out.')); });

      if (method === 'POST') {
        req.write(JSON.stringify(data));
      }

      req.end();
    });
  }
}

class QPayError extends Error {
  constructor(message, httpCode, errorCode, responseBody) {
    super(message);
    this.name = 'QPayError';
    this.httpCode = httpCode;
    this.errorCode = errorCode;
    this.responseBody = responseBody;
  }
}

module.exports = { QPay, QPayError };
module.exports.default = QPay;
