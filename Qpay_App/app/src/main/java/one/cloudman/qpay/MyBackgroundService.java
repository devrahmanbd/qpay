package one.cloudman.qpay;

import android.app.Notification;
import android.app.NotificationChannel;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.app.Service;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Build;
import android.os.Handler;
import android.os.IBinder;
import android.util.Log;

import androidx.annotation.Nullable;
import androidx.core.app.NotificationCompat;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.toolbox.StringRequest;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

public class MyBackgroundService extends Service {
    private static final String CHANNEL_ID = "MyBackgroundServiceChannel";
    private Handler handler;
    private Runnable runnable;
    private sqlite dbHelper;
    private ArrayList<HashMap<String, String>> arrayList;

    @Override
    public void onCreate() {
        super.onCreate();
        dbHelper = new sqlite(this);
        arrayList = new ArrayList<>();
        handler = new Handler();
        runnable = new Runnable() {
            @Override
            public void run() {
                uploadDataToServer(getApplicationContext());
                handler.postDelayed(this, 30000); // 30 seconds interval
            }
        };
        handler.post(runnable);
        createNotificationChannel();
        startForeground(1, getNotification());
    }

    @Override
    public int onStartCommand(Intent intent, int flags, int startId) {
        if (intent != null && "TRIGGER_SYNC".equals(intent.getAction())) {
            Log.d("MyBackgroundService", "Immediate sync triggered via Intent");
            uploadDataToServer(getApplicationContext());
        }
        return START_STICKY;
    }

    @Override
    public void onDestroy() {
        super.onDestroy();
        handler.removeCallbacks(runnable);
    }

    @Nullable
    @Override
    public IBinder onBind(Intent intent) {
        return null;
    }

    private void createNotificationChannel() {
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
            NotificationChannel serviceChannel = new NotificationChannel(
                    CHANNEL_ID,
                    "Background Service Channel",
                    NotificationManager.IMPORTANCE_DEFAULT
            );
            NotificationManager manager = getSystemService(NotificationManager.class);
            if (manager != null) {
                manager.createNotificationChannel(serviceChannel);
            }
        }
    }

    private Notification getNotification() {
        Intent notificationIntent = new Intent(this, MainActivity.class);
        PendingIntent pendingIntent = PendingIntent.getActivity(this,
                0, notificationIntent, PendingIntent.FLAG_IMMUTABLE);

        return new NotificationCompat.Builder(this, CHANNEL_ID)
                .setContentTitle("QPay Sync Service")
                .setContentText("Monitoring SMS for payment verification...")
                .setSmallIcon(R.drawable.ic_launcher_foreground)
                .setContentIntent(pendingIntent)
                .setOngoing(true)
                .build();
    }

    private void uploadDataToServer(Context context) {
        ArrayList<HashMap<String, String>> dbData = dbHelper.getAllSms();
        if (dbData.isEmpty()) return;

        HashMap<String, String> data = dbData.get(0);
        final String id = data.get(sqlite.COLUMN_ID);
        final String title = data.get(sqlite.COLUMN_TITLE);
        final String body = data.get(sqlite.COLUMN_BODY);

        SharedPreferences preferences = context.getSharedPreferences(context.getString(R.string.app_name), MODE_PRIVATE);
        final String email = preferences.getString("user_email", "");
        final String key = preferences.getString("device_key", "");
        final String device_ip = preferences.getString("device_ip", "");

        if (email.isEmpty() || key.isEmpty()) return;

        String url = "https://qpay.cloudman.one/api/add-data";

        StringRequest postRequest = new StringRequest(Request.Method.POST, url,
                response -> {
                    try {
                        JSONObject jsonResponse = new JSONObject(response);
                        int status = jsonResponse.getInt("status");
                        if (status == 1) {
                            dbHelper.deleteSms(Long.parseLong(id));
                            uploadDataToServer(context); // Recurse
                        } else {
                            RemoteLogger.log(context, "Background upload error: " + response);
                            dbHelper.deleteSms(Long.parseLong(id)); // Delete anyway or handle retry
                            uploadDataToServer(context);
                        }
                    } catch (JSONException e) {
                        RemoteLogger.log(context, "Background JSON error: " + response);
                    }
                },
                error -> {
                    String errMsg = error.getMessage() != null ? error.getMessage() : "Network error";
                    Log.e("MyBackgroundService", "Server error: " + errMsg);
                    RemoteLogger.log(context, "Background sync failed: " + errMsg);
                }
        ) {
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
}
