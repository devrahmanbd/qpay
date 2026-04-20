/**
 * QPay NodeJS SDK
 * 
 * A lightweight, async/await client for the QPay Payment Gateway.
 * 
 * @version 1.2.0
 * @author QPay
 */

const https = require('https');
const http = require('http');
const crypto = require('crypto');
const { URL } = require('url');

class QPay {
  static VERSION = '1.2.0';
  static API_VERSION = 'v1';

  /**
   * @param {string} apiKey - Your secret API key
   * @param {Object} options - Configuration options
   * @param {string} options.baseUrl - The QPay API URL (e.g. https://qpay.cloudman.one)
   * @param {number} [options.timeout=30000] - Request timeout in ms
   */
  constructor(apiKey, options = {}) {
    if (!apiKey) throw new Error('API key is required.');
    if (!options.baseUrl) throw new Error('baseUrl is required (e.g. https://qpay.cloudman.one).');

    this.apiKey = apiKey;
    this.baseUrl = options.baseUrl.replace(/\/+$/, '');
    this.timeout = options.timeout || 30000;
  }

  get isTestMode() {
    return this.apiKey.includes('_test_');
  }

  /**
   * Create a new payment
   */
  async createPayment(params) {
    if (!params || !params.amount) throw new Error("'amount' is required.");
    return this._request('POST', '/payment/create', params);
  }

  /**
   * Verify a payment status with the provider
   */
  async verifyPayment(paymentId) {
    if (!paymentId) throw new Error('Payment ID is required.');
    return this._request('GET', `/payment/verify/${paymentId}`);
  }

  /**
   * Get payment details
   */
  async getPaymentStatus(paymentId) {
    if (!paymentId) throw new Error('Payment ID is required.');
    return this._request('GET', `/payment/status/${paymentId}`);
  }

  /**
   * List available payment methods
   */
  async getPaymentMethods() {
    return this._request('GET', '/payment/methods');
  }

  /**
   * Get merchant account balance
   */
  async getBalance() {
    return this._request('GET', '/balance');
  }

  /**
   * Create a refund
   */
  async createRefund(params) {
    if (!params || !params.payment_id) throw new Error("'payment_id' is required.");
    return this._request('POST', '/refunds', params);
  }

  /**
   * Verify a webhook signature
   */
  static verifyWebhookSignature(payload, signatureHeader, secret, tolerance = 300) {
    if (!payload || !signatureHeader || !secret) return false;

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

    try {
      const expectedBuf = Buffer.from(expected, 'utf8');
      const receivedBuf = Buffer.from(parts.v1, 'utf8');
      return crypto.timingSafeEqual(expectedBuf, receivedBuf);
    } catch {
      return false;
    }
  }

  /**
   * Internal request handler
   */
  _request(method, endpoint, data = {}) {
    return new Promise((resolve, reject) => {
      let path = `/api/${QPay.API_VERSION}${endpoint}`;

      if (method === 'GET' && Object.keys(data).length > 0) {
        const qs = new URLSearchParams(data).toString();
        path += `?${qs}`;
      }

      const parsedUrl = new URL(this.baseUrl);
      const isHttps = parsedUrl.protocol === 'https:';
      const transport = isHttps ? https : http;

      const options = {
        hostname: parsedUrl.hostname,
        port: parsedUrl.port || (isHttps ? 443 : 80),
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
            const error = new Error(parsed.message || `HTTP ${res.statusCode} error`);
            error.statusCode = res.statusCode;
            error.response = parsed;
            reject(error);
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

module.exports = { QPay };
