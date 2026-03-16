<style type="text/css">
  .copy-button {
    display: none;
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 1;
  }

  .code-container:hover .copy-button {
    display: block;
  }
</style>

<div class="container mt-5">
  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="mexample1-tab" data-bs-toggle="tab" data-bs-target="#mexample1" type="button" role="tab" aria-controls="example1" aria-selected="true">PHP</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="mexample2-tab" data-bs-toggle="tab" data-bs-target="#mexample2" type="button" role="tab" aria-controls="example2" aria-selected="false">PHP Guzzle</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="mexample3-tab" data-bs-toggle="tab" data-bs-target="#mexample3" type="button" role="tab" aria-controls="example3" aria-selected="false">Javascript Node</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="mexample4-tab" data-bs-toggle="tab" data-bs-target="#mexample4" type="button" role="tab" aria-controls="example4" aria-selected="false">Python</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="mexample5-tab" data-bs-toggle="tab" data-bs-target="#mexample5" type="button" role="tab" aria-controls="example5" aria-selected="false">Go</button>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active position-relative code-container" id="mexample1" role="tabpanel" aria-labelledby="example1-tab">
      <pre><code class="language-php">
&lt;?php

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

?&gt;
      </code></pre>
      <button class="btn btn-sm btn-secondary copy-button" onclick="copyCode(this)">Copy <span>&#128203;</span></button>
    </div>
    <div class="tab-pane fade position-relative code-container" id="mexample2" role="tabpanel" aria-labelledby="example2-tab">
      <pre><code class="language-php">
&lt;?php
$client = new Client();
$headers = [
  'API-KEY' => 'YOUR_API_KEY_HERE',
  'Content-Type' => 'application/json'
];
$request = new Request('POST', '<?= PAYMENT_URL ?>api/v1/payment/verify/PAYMENT_ID_HERE', $headers);
$res = $client->sendAsync($request)->wait();
echo $res->getBody();

?&gt;
      </code></pre>
      <button class="btn btn-sm btn-primary copy-button" onclick="copyCode(this)">Copy <span>&#128203;</span></button>
    </div>
    <div class="tab-pane fade position-relative code-container" id="mexample3" role="tabpanel" aria-labelledby="example3-tab">
      <pre><code class="language-javascript">
const axios = require('axios');

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
  .catch((error) => console.error(error));
      </code></pre>
      <button class="btn btn-sm btn-primary copy-button" onclick="copyCode(this)">Copy <span>&#128203;</span></button>
    </div>

    <div class="tab-pane fade position-relative code-container" id="mexample4" role="tabpanel" aria-labelledby="example4-tab">
      <pre><code class="language-python">
import requests

url = "<?= PAYMENT_URL ?>api/v1/payment/verify/PAYMENT_ID_HERE"

headers = {
  'API-KEY': 'YOUR_API_KEY_HERE',
  'Content-Type': 'application/json'
}

response = requests.post(url, headers=headers)
print(response.json())
      </code></pre>
      <button class="btn btn-sm btn-primary copy-button" onclick="copyCode(this)">Copy <span>&#128203;</span></button>
    </div>

    <div class="tab-pane fade position-relative code-container" id="mexample5" role="tabpanel" aria-labelledby="example5-tab">
      <pre><code class="language-go">
package main

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
}
      </code></pre>
      <button class="btn btn-sm btn-primary copy-button" onclick="copyCode(this)">Copy <span>&#128203;</span></button>
    </div>

  </div>
</div>

<span>Sample Response</span>
<div class="container">
  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="m1example1-tab" data-bs-toggle="tab" data-bs-target="#m1example1" type="button" role="tab" aria-controls="example1" aria-selected="true">JSON</button>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active position-relative code-container" id="m1example1" role="tabpanel" aria-labelledby="example1-tab">
      <pre><code class="language-json">
{
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
}
      </code></pre>
      <button class="btn btn-sm btn-primary copy-button" onclick="copyCode(this)">Copy <span>&#128203;</span></button>
    </div>

  </div>

</div>

<h3 class="section-heading">Response Details</h3>
<div class="table-responsive my-4">
  <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">Field Name</th>
        <th scope="col">Type</th>
        <th scope="col">Description</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th colspan="3" class="text-info">Success Response (HTTP 200)</th>
      </tr>
      <tr>
        <th scope="row">data.payment_id</th>
        <td>string</td>
        <td>Unique payment identifier</td>
      </tr>
      <tr>
        <th scope="row">data.amount</th>
        <td>number</td>
        <td>Payment amount</td>
      </tr>
      <tr>
        <th scope="row">data.currency</th>
        <td>string</td>
        <td>Currency code</td>
      </tr>
      <tr>
        <th scope="row">data.status</th>
        <td>string</td>
        <td>pending | processing | completed | failed | refunded</td>
      </tr>
      <tr>
        <th scope="row">data.verified</th>
        <td>boolean</td>
        <td>Whether payment verification succeeded</td>
      </tr>
      <tr>
        <th scope="row">data.transaction_id</th>
        <td>string</td>
        <td>Provider transaction reference</td>
      </tr>
      <tr>
        <th colspan="3" class="text-danger">Error Response (HTTP 400 / 404)</th>
      </tr>
      <tr>
        <th scope="row">status</th>
        <td>string</td>
        <td>"error"</td>
      </tr>
      <tr>
        <th scope="row">code</th>
        <td>string</td>
        <td>MISSING_PAYMENT_ID | PAYMENT_NOT_FOUND</td>
      </tr>
      <tr>
        <th scope="row">message</th>
        <td>string</td>
        <td>Human-readable error description</td>
      </tr>
    </tbody>
  </table>
</div>

<script>
  function copyCode(button) {
    const codeContainer = button.parentElement;
    const codeElement = codeContainer.querySelector("code");
    const codeText = codeElement.innerText;

    const textArea = document.createElement("textarea");
    textArea.value = codeText;
    document.body.appendChild(textArea);
    textArea.select();
    document.execCommand("copy");
    document.body.removeChild(textArea);

    button.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16"><path d="M12.644 3.612a.5.5 0 0 1 .702.702l-6.25 6.25a.5.5 0 0 1-.702 0l-3.5-3.5a.5.5 0 0 1 .704-.708l2.794 2.793 5.546-5.546a.5.5 0 0 1 .612-.076z"/></svg>';
    setTimeout(() => {
      button.innerHTML = 'Copy <span>&#128203;</span>';
    }, 1500);
  }
</script>
