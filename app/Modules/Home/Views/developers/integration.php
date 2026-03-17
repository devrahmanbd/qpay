<style>
  .code-container { position: relative; }
  .copy-btn { position:absolute; top:8px; right:8px; opacity:0; transition:opacity .2s; }
  .code-container:hover .copy-btn { opacity:1; }
</style>

<div x-data="{ tab: 'php' }" class="mt-4">
  <div class="flex flex-wrap gap-1 border-b border-gray-200 mb-0">
    <button @click="tab='php'" :class="tab==='php' ? 'border-b-2 border-primary-600 text-primary-600' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 text-sm font-medium">PHP</button>
    <button @click="tab='guzzle'" :class="tab==='guzzle' ? 'border-b-2 border-primary-600 text-primary-600' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 text-sm font-medium">PHP Guzzle</button>
    <button @click="tab='node'" :class="tab==='node' ? 'border-b-2 border-primary-600 text-primary-600' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 text-sm font-medium">Node.js</button>
    <button @click="tab='python'" :class="tab==='python' ? 'border-b-2 border-primary-600 text-primary-600' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 text-sm font-medium">Python</button>
    <button @click="tab='go'" :class="tab==='go' ? 'border-b-2 border-primary-600 text-primary-600' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 text-sm font-medium">Go</button>
  </div>

  <div x-show="tab==='php'" class="code-container bg-gray-900 rounded-b-lg p-4 overflow-x-auto">
    <button class="copy-btn px-2 py-1 text-xs bg-gray-700 text-gray-300 rounded hover:bg-gray-600" onclick="copyCode(this)">Copy</button>
<pre class="text-sm leading-relaxed"><code class="language-php">&lt;?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => '<?= PAYMENT_URL ?>api/v1/payment/create',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => json_encode([
    'amount' => 500,
    'currency' => 'BDT',
    'customer_name' => 'John Doe',
    'customer_email' => 'john@gmail.com',
    'success_url' => 'https://yourdomain.com/success',
    'cancel_url' => 'https://yourdomain.com/cancel',
    'metadata' => ['order_id' => '12345']
  ]),
  CURLOPT_HTTPHEADER => array(
    'API-KEY: YOUR_API_KEY_HERE',
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);
curl_close($curl);
echo $response;

?&gt;</code></pre>
  </div>

  <div x-show="tab==='guzzle'" x-cloak class="code-container bg-gray-900 rounded-b-lg p-4 overflow-x-auto">
    <button class="copy-btn px-2 py-1 text-xs bg-gray-700 text-gray-300 rounded hover:bg-gray-600" onclick="copyCode(this)">Copy</button>
<pre class="text-sm leading-relaxed"><code class="language-php">&lt;?php
$client = new Client();
$headers = [
  'API-KEY' => 'YOUR_API_KEY_HERE',
  'Content-Type' => 'application/json'
];
$body = json_encode([
  'amount' => 500,
  'currency' => 'BDT',
  'customer_name' => 'John Doe',
  'customer_email' => 'john@gmail.com',
  'success_url' => 'https://yourdomain.com/success',
  'cancel_url' => 'https://yourdomain.com/cancel',
  'metadata' => ['order_id' => '12345']
]);
$request = new Request('POST', '<?= PAYMENT_URL ?>api/v1/payment/create', $headers, $body);
$res = $client->sendAsync($request)->wait();
echo $res->getBody();
?&gt;</code></pre>
  </div>

  <div x-show="tab==='node'" x-cloak class="code-container bg-gray-900 rounded-b-lg p-4 overflow-x-auto">
    <button class="copy-btn px-2 py-1 text-xs bg-gray-700 text-gray-300 rounded hover:bg-gray-600" onclick="copyCode(this)">Copy</button>
<pre class="text-sm leading-relaxed"><code class="language-javascript">const axios = require('axios');

const data = {
  amount: 500,
  currency: 'BDT',
  customer_name: 'John Doe',
  customer_email: 'john@gmail.com',
  success_url: 'https://yourdomain.com/success',
  cancel_url: 'https://yourdomain.com/cancel',
  metadata: { order_id: '12345' }
};

const config = {
  method: 'post',
  url: '<?= PAYMENT_URL ?>api/v1/payment/create',
  headers: {
    'API-KEY': 'YOUR_API_KEY_HERE',
    'Content-Type': 'application/json'
  },
  data: data
};

axios.request(config)
  .then((response) => console.log(response.data))
  .catch((error) => console.error(error));</code></pre>
  </div>

  <div x-show="tab==='python'" x-cloak class="code-container bg-gray-900 rounded-b-lg p-4 overflow-x-auto">
    <button class="copy-btn px-2 py-1 text-xs bg-gray-700 text-gray-300 rounded hover:bg-gray-600" onclick="copyCode(this)">Copy</button>
<pre class="text-sm leading-relaxed"><code class="language-python">import requests
import json

url = "<?= PAYMENT_URL ?>api/v1/payment/create"

payload = json.dumps({
  "amount": 500,
  "currency": "BDT",
  "customer_name": "John Doe",
  "customer_email": "john@gmail.com",
  "success_url": "https://yourdomain.com/success",
  "cancel_url": "https://yourdomain.com/cancel",
  "metadata": {"order_id": "12345"}
})
headers = {
  'API-KEY': 'YOUR_API_KEY_HERE',
  'Content-Type': 'application/json'
}

response = requests.post(url, headers=headers, data=payload)
print(response.json())</code></pre>
  </div>

  <div x-show="tab==='go'" x-cloak class="code-container bg-gray-900 rounded-b-lg p-4 overflow-x-auto">
    <button class="copy-btn px-2 py-1 text-xs bg-gray-700 text-gray-300 rounded hover:bg-gray-600" onclick="copyCode(this)">Copy</button>
<pre class="text-sm leading-relaxed"><code class="language-go">package main

import (
  "fmt"
  "strings"
  "net/http"
  "io/ioutil"
)

func main() {
  url := "<?= PAYMENT_URL ?>api/v1/payment/create"

  payload := strings.NewReader(`{
    "amount": 500,
    "currency": "BDT",
    "customer_name": "John Doe",
    "customer_email": "john@gmail.com",
    "success_url": "https://yourdomain.com/success",
    "cancel_url": "https://yourdomain.com/cancel",
    "metadata": {"order_id": "12345"}
  }`)

  req, _ := http.NewRequest("POST", url, payload)
  req.Header.Add("API-KEY", "YOUR_API_KEY_HERE")
  req.Header.Add("Content-Type", "application/json")

  res, _ := http.DefaultClient.Do(req)
  defer res.Body.Close()

  body, _ := ioutil.ReadAll(res.Body)
  fmt.Println(string(body))
}</code></pre>
  </div>
</div>

<h3 class="text-lg font-semibold text-gray-900 mt-8 mb-3">Response Details</h3>
<div class="overflow-x-auto mb-4">
  <table class="docs-table">
    <thead>
      <tr>
        <th>Field Name</th>
        <th>Type</th>
        <th>Description</th>
      </tr>
    </thead>
    <tbody>
      <tr><th colspan="3" class="text-blue-600 bg-blue-50">Success Response (HTTP 201)</th></tr>
      <tr><th>status</th><td>string</td><td>"success"</td></tr>
      <tr><th>code</th><td>string</td><td>PAYMENT_CREATED</td></tr>
      <tr><th>data.payment_id</th><td>string</td><td>Unique payment identifier (e.g., pay_a1b2c3d4e5f6)</td></tr>
      <tr><th>data.amount</th><td>number</td><td>Payment amount</td></tr>
      <tr><th>data.fees</th><td>number</td><td>Calculated fees</td></tr>
      <tr><th>data.net_amount</th><td>number</td><td>Amount after fees deduction</td></tr>
      <tr><th>data.currency</th><td>string</td><td>Currency code (e.g., BDT)</td></tr>
      <tr><th>data.status</th><td>string</td><td>pending | processing</td></tr>
      <tr><th>data.checkout_url</th><td>string</td><td>URL to redirect customer for payment completion</td></tr>
      <tr><th colspan="3" class="text-red-600 bg-red-50">Error Response (HTTP 422 / 500)</th></tr>
      <tr><th>status</th><td>string</td><td>"error"</td></tr>
      <tr><th>code</th><td>string</td><td>Error code (e.g., VALIDATION_ERROR)</td></tr>
      <tr><th>errors / message</th><td>object / string</td><td>Validation errors or error message</td></tr>
    </tbody>
  </table>
</div>
