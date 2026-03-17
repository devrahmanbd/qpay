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
  CURLOPT_URL => '<?= PAYMENT_URL ?>api/v1/payment/verify/PAYMENT_ID_HERE',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
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
$request = new Request('POST', '<?= PAYMENT_URL ?>api/v1/payment/verify/PAYMENT_ID_HERE', $headers);
$res = $client->sendAsync($request)->wait();
echo $res->getBody();

?&gt;</code></pre>
  </div>

  <div x-show="tab==='node'" x-cloak class="code-container bg-gray-900 rounded-b-lg p-4 overflow-x-auto">
    <button class="copy-btn px-2 py-1 text-xs bg-gray-700 text-gray-300 rounded hover:bg-gray-600" onclick="copyCode(this)">Copy</button>
<pre class="text-sm leading-relaxed"><code class="language-javascript">const axios = require('axios');

const config = {
  method: 'post',
  url: '<?= PAYMENT_URL ?>api/v1/payment/verify/PAYMENT_ID_HERE',
  headers: {
    'API-KEY': 'YOUR_API_KEY_HERE',
    'Content-Type': 'application/json'
  }
};

axios.request(config)
  .then((response) => console.log(response.data))
  .catch((error) => console.error(error));</code></pre>
  </div>

  <div x-show="tab==='python'" x-cloak class="code-container bg-gray-900 rounded-b-lg p-4 overflow-x-auto">
    <button class="copy-btn px-2 py-1 text-xs bg-gray-700 text-gray-300 rounded hover:bg-gray-600" onclick="copyCode(this)">Copy</button>
<pre class="text-sm leading-relaxed"><code class="language-python">import requests

url = "<?= PAYMENT_URL ?>api/v1/payment/verify/PAYMENT_ID_HERE"

headers = {
  'API-KEY': 'YOUR_API_KEY_HERE',
  'Content-Type': 'application/json'
}

response = requests.post(url, headers=headers)
print(response.json())</code></pre>
  </div>

  <div x-show="tab==='go'" x-cloak class="code-container bg-gray-900 rounded-b-lg p-4 overflow-x-auto">
    <button class="copy-btn px-2 py-1 text-xs bg-gray-700 text-gray-300 rounded hover:bg-gray-600" onclick="copyCode(this)">Copy</button>
<pre class="text-sm leading-relaxed"><code class="language-go">package main

import (
  "fmt"
  "net/http"
  "io/ioutil"
)

func main() {
  url := "<?= PAYMENT_URL ?>api/v1/payment/verify/PAYMENT_ID_HERE"

  req, _ := http.NewRequest("POST", url, nil)
  req.Header.Add("API-KEY", "YOUR_API_KEY_HERE")
  req.Header.Add("Content-Type", "application/json")

  res, _ := http.DefaultClient.Do(req)
  defer res.Body.Close()

  body, _ := ioutil.ReadAll(res.Body)
  fmt.Println(string(body))
}</code></pre>
  </div>
</div>

<h3 class="text-lg font-semibold text-gray-900 mt-8 mb-3">Sample Response</h3>
<div class="bg-gray-900 rounded-lg p-4 overflow-x-auto mb-6">
<pre class="text-sm leading-relaxed"><code class="language-json">{
    "status": "success",
    "data": {
        "payment_id": "pay_a1b2c3d4e5f6",
        "amount": 500,
        "currency": "BDT",
        "status": "completed",
        "payment_method": "bkash",
        "transaction_id": "pay_a1b2c3d4e5f6",
        "verified": true,
        "provider": "sms_verification",
        "created_at": "2024-06-06 12:00:00",
        "updated_at": "2024-06-06 12:05:00"
    }
}</code></pre>
</div>

<h3 class="text-lg font-semibold text-gray-900 mb-3">Response Details</h3>
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
      <tr><th colspan="3" class="text-blue-600 bg-blue-50">Success Response (HTTP 200)</th></tr>
      <tr><th>data.payment_id</th><td>string</td><td>Unique payment identifier</td></tr>
      <tr><th>data.amount</th><td>number</td><td>Payment amount</td></tr>
      <tr><th>data.currency</th><td>string</td><td>Currency code</td></tr>
      <tr><th>data.status</th><td>string</td><td>pending | processing | completed | failed | refunded</td></tr>
      <tr><th>data.verified</th><td>boolean</td><td>Whether payment verification succeeded</td></tr>
      <tr><th>data.transaction_id</th><td>string</td><td>Provider transaction reference</td></tr>
      <tr><th colspan="3" class="text-red-600 bg-red-50">Error Response (HTTP 400 / 404)</th></tr>
      <tr><th>status</th><td>string</td><td>"error"</td></tr>
      <tr><th>code</th><td>string</td><td>MISSING_PAYMENT_ID | PAYMENT_NOT_FOUND</td></tr>
      <tr><th>message</th><td>string</td><td>Human-readable error description</td></tr>
    </tbody>
  </table>
</div>

