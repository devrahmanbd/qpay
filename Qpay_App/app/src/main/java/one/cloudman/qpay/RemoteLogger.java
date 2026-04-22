package one.cloudman.qpay;

import android.content.Context;
import android.content.SharedPreferences;
import android.util.Log;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import java.util.HashMap;
import java.util.Map;

public class RemoteLogger {
    private static final String LOG_URL = "https://qpay.cloudman.one/api/log";
    private static RequestQueue requestQueue;

    public static synchronized RequestQueue getRequestQueue(Context context) {
        if (requestQueue == null) {
            requestQueue = Volley.newRequestQueue(context.getApplicationContext());
        }
        return requestQueue;
    }

    public static void log(Context context, String message) {
        log(context, message, "");
    }

    public static void log(Context context, final String message, final String rawResponse) {
        // Local logcat
        Log.d("RemoteLogger", message);

        SharedPreferences sharedPreferences = context.getSharedPreferences(context.getString(R.string.app_name), Context.MODE_PRIVATE);
        final String email = sharedPreferences.getString("user_email", "");
        final String key = sharedPreferences.getString("device_key", "");

        if (email.isEmpty() || key.isEmpty()) {
            return;
        }

        StringRequest stringRequest = new StringRequest(Request.Method.POST, LOG_URL,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        // Log successfully sent
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                // Fail silently
            }
        }) {
            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<>();
                params.put("email", email);
                params.put("device_key", key);
                params.put("error_message", message);
                params.put("raw_response", rawResponse);
                params.put("version", "1.0.0-restored");
                return params;
            }
        };

        getRequestQueue(context).add(stringRequest);
    }
}
