package one.cloudman.qpay;

import static android.content.Context.MODE_PRIVATE;

import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.telephony.SmsMessage;
import android.os.Build;
import android.util.Log;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class SmsReceiver extends BroadcastReceiver {
    private sqlite databaseHelper;

    @Override
    public void onReceive(Context context, Intent intent) {
        databaseHelper = new sqlite(context);

        if (intent != null && "android.provider.Telephony.SMS_RECEIVED".equals(intent.getAction())) {
            SmsMessage[] messages = android.provider.Telephony.Sms.Intents.getMessagesFromIntent(intent);
            StringBuilder fullMessage = new StringBuilder();
            String smsAddress = "";
            for (SmsMessage message : messages) {
                fullMessage.append(message.getDisplayMessageBody());
                smsAddress = message.getOriginatingAddress().toString();
            }

            String smsBody = fullMessage.toString().trim();
            RemoteLogger.log(context, "New SMS Intercepted (Live): From=" + smsAddress);

            if (isPaymentSMS(smsBody, smsAddress)) {
                RemoteLogger.log(context, "Payment SMS detected! Saving and triggering service.");
                saveSmsToDatabase(context, smsAddress, smsBody);
                
                // Trigger immediate sync in background service
                Intent serviceIntent = new Intent(context, MyBackgroundService.class);
                serviceIntent.setAction("TRIGGER_SYNC");
                if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
                    context.startForegroundService(serviceIntent);
                } else {
                    context.startService(serviceIntent);
                }
            } else {
                Log.d("SmsReceiver", "SMS ignored: Not a payment pattern.");
            }
        }
    }

    private void sendSmsToServer(final Context context, final String body, final String title) {
        SharedPreferences preferences = context.getSharedPreferences(context.getString(R.string.app_name), MODE_PRIVATE);
        final String email = preferences.getString("user_email", "");
        final String key = preferences.getString("device_key", "");
        final String device_ip = preferences.getString("device_ip", "");

        String url = "https://qpay.cloudman.one/api/add-data";

        StringRequest postRequest = new StringRequest(Request.Method.POST, url,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        RemoteLogger.log(context, "Server response (live): " + response);
                        handleVerificationResponse(context, response, title, body);
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        String errMsg = error.getMessage() != null ? error.getMessage() : "Unknown Error";
                        RemoteLogger.log(context, "Server error (live): " + errMsg);
                        saveSmsToDatabase(context, title, body);
                    }
                }) {
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                Map<String, String> params = new HashMap<>();
                params.put("email", email);
                params.put("device_key", key);
                params.put("device_ip", device_ip);
                params.put("address", title);
                params.put("message", body);
                return params;
            }

            @Override
            public String getBodyContentType() {
                return "application/x-www-form-urlencoded; charset=UTF-8";
            }
        };

        RemoteLogger.getRequestQueue(context).add(postRequest);
    }

    private boolean isPaymentSMS(String body, String address) {
        if (body == null) return false;
        String b = body.toLowerCase();
        String a = address.toLowerCase();

        // 1. Instant Trust for Payment Shortcodes
        if (a.contains("bkash") || a.contains("nagad") || a.contains("rocket") || 
            a.equals("16167") || a.equals("247") || a.equals("16216") || 
            a.contains("tap") || a.contains("upay") || a.contains("cellfin")) {
            return true;
        }

        // 2. Keyword Trust
        return b.contains("trxid") || 
               b.contains("txnid:") || 
               b.contains("money received") || 
               b.contains("successfully credited") || 
               b.contains("you have received") || 
               b.contains("cash out") || 
               b.contains("credited by tk") ||
               b.contains("received tk") ||
               b.contains("successful") ||
               b.contains("payment") ||
               b.contains("transaction");
    }

    private void handleVerificationResponse(Context context, String response, String title, String body) {
        try {
            JSONObject jsonResponse = new JSONObject(response);
            int status = jsonResponse.getInt("status");
            if (status != 1) {
                saveSmsToDatabase(context, title, body);
            }
        } catch (JSONException e) {
            saveSmsToDatabase(context, title, body);
        }
    }

    private void saveSmsToDatabase(Context context, String title, String body) {
        if (databaseHelper == null) databaseHelper = new sqlite(context);
        databaseHelper.saveSms(title, body);
    }
}
