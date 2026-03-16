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
      <button class="nav-link active" id="example1-tab" data-bs-toggle="tab" data-bs-target="#example1" type="button" role="tab" aria-controls="example1" aria-selected="true">PHP</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="example2-tab" data-bs-toggle="tab" data-bs-target="#example2" type="button" role="tab" aria-controls="example2" aria-selected="false">PHP Guzzle</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="example3-tab" data-bs-toggle="tab" data-bs-target="#example3" type="button" role="tab" aria-controls="example3" aria-selected="false">Javascript Node</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="example4-tab" data-bs-toggle="tab" data-bs-target="#example4" type="button" role="tab" aria-controls="example4" aria-selected="false">Python</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="example5-tab" data-bs-toggle="tab" data-bs-target="#example5" type="button" role="tab" aria-controls="example5" aria-selected="false">Go</button>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active position-relative code-container" id="example1" role="tabpanel" aria-labelledby="example1-tab">
      <pre><code class="language-php">
      &lt;?php

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

      ?&gt;
      </code></pre>
      <button class="btn btn-sm btn-secondary copy-button" onclick="copyCode(this)">&#x2398;</button>
    </div>
    <div class="tab-pane fade position-relative code-container" id="example2" role="tabpanel" aria-labelledby="example2-tab">
      <pre><code class="language-php">
      &lt;?php
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
      ?&gt;
      </code></pre>
      <button class="btn btn-sm btn-primary copy-button" onclick="copyCode(this)">&#x2398;</button>
    </div>
    <div class="tab-pane fade position-relative code-container" id="example3" role="tabpanel" aria-labelledby="example3-tab">
      <pre><code class="language-javascript">
      const axios = require('axios');

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
        .catch((error) => console.error(error));
      </code></pre>
      <button class="btn btn-sm btn-primary copy-button" onclick="copyCode(this)">&#x2398;</button>
    </div>

    <div class="tab-pane fade position-relative code-container" id="example4" role="tabpanel" aria-labelledby="example4-tab">
      <pre><code class="language-python">
      import requests
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
      print(response.json())
      </code></pre>
      <button class="btn btn-sm btn-primary copy-button" onclick="copyCode(this)">&#x2398;</button>
    </div>

    <div class="tab-pane fade position-relative code-container" id="example5" role="tabpanel" aria-labelledby="example5-tab">
      <pre><code class="language-go">
      package main

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
      }
      </code></pre>
      <button class="btn btn-sm btn-primary copy-button" onclick="copyCode(this)">&#x2398;</button>
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
        <th colspan="3" class="text-info">Success Response (HTTP 201)</th>
      </tr>
      <tr>
        <th scope="row">status</th>
        <td>string</td>
        <td>"success"</td>
      </tr>
      <tr>
        <th scope="row">code</th>
        <td>string</td>
        <td>PAYMENT_CREATED</td>
      </tr>
      <tr>
        <th scope="row">data.payment_id</th>
        <td>string</td>
        <td>Unique payment identifier (e.g., pay_a1b2c3d4e5f6)</td>
      </tr>
      <tr>
        <th scope="row">data.amount</th>
        <td>number</td>
        <td>Payment amount</td>
      </tr>
      <tr>
        <th scope="row">data.fees</th>
        <td>number</td>
        <td>Calculated fees</td>
      </tr>
      <tr>
        <th scope="row">data.net_amount</th>
        <td>number</td>
        <td>Amount after fees deduction</td>
      </tr>
      <tr>
        <th scope="row">data.currency</th>
        <td>string</td>
        <td>Currency code (e.g., BDT)</td>
      </tr>
      <tr>
        <th scope="row">data.status</th>
        <td>string</td>
        <td>pending | processing</td>
      </tr>
      <tr>
        <th scope="row">data.checkout_url</th>
        <td>string</td>
        <td>URL to redirect customer for payment completion</td>
      </tr>
      <tr>
        <th colspan="3" class="text-danger">Error Response (HTTP 422 / 500)</th>
      </tr>
      <tr>
        <th scope="row">status</th>
        <td>string</td>
        <td>"error"</td>
      </tr>
      <tr>
        <th scope="row">code</th>
        <td>string</td>
        <td>Error code (e.g., VALIDATION_ERROR)</td>
      </tr>
      <tr>
        <th scope="row">errors / message</th>
        <td>object / string</td>
        <td>Validation errors or error message</td>
      </tr>
    </tbody>
  </table>
</div>
