package one.cloudman.qpay;

import android.Manifest;
import android.annotation.SuppressLint;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.IntentFilter;
import android.content.pm.PackageManager;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.Build;
import android.os.Bundle;
import android.os.Handler;
import android.os.PowerManager;
import android.net.Uri;
import android.database.Cursor;
import android.provider.Settings;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;
import androidx.core.app.NotificationManagerCompat;
import androidx.core.content.ContextCompat;

import com.airbnb.lottie.LottieAnimationView;
import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.jetbrains.annotations.Nullable;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;
import android.content.SharedPreferences;
import android.content.ClipData;
import android.content.ClipboardManager;

public class MainActivity extends AppCompatActivity {
    private static final int SMS_PERMISSION_CODE = 101;
    private static final int NOTIFICATION_PERMISSION_CODE = 102;
    private static final int LOCATION_PERMISSION_CODE = 103;
    private static final int REQUEST_CODE_IGNORE_BATTERY_OPTIMIZATIONS = 1001;

    private RequestQueue queue;
    private NetworkChangeReceiver networkChangeReceiver;
    private TextView status;
    ImageView nowifi;
    private ListView listView;
    private ProgressBar progressBar;


    private final ArrayList<HashMap<String, String>> arrayList = new ArrayList<>();
    private final sqlite dbHelper = new sqlite(this);

    private int syncIntervalMins = 15;
    private boolean highIntensityActive = false;

    private final Handler mHandler = new Handler();
    private long lastFullSyncTime = 0;
    private final Runnable mRunnable = new Runnable() {
        @Override
        public void run() {
            if (isConnectedToInternet()) {
                fetchServerLogs();
                
                // Dynamic Periodic re-scan for missed SMS
                long currentTime = System.currentTimeMillis();
                long dynamicIntervalMs = (long) syncIntervalMins * 60 * 1000;
                if (currentTime - lastFullSyncTime > dynamicIntervalMs) {
                    lastFullSyncTime = currentTime;
                    syncExistingSMS();
                }
            }
            mHandler.postDelayed(this, 10000); // Heartbeat every 10 seconds
        }
    };

    @SuppressLint("MissingInflatedId")
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        initializeViews();
        initializeNetworkChangeReceiver();
        checkAndRequestPermissions();
        initializeListView();
        initializeVolleyQueue();

        saveSmsToDatabase();
        if (checkSmsPermission() && checkReadSmsPermission() && checkLocationPermissions()) {
            syncExistingSMS();
        }
        mHandler.post(mRunnable);
    }

    private void initializeViews() {
        listView = findViewById(R.id.listView);
        progressBar = findViewById(R.id.progressbar);
        status = findViewById(R.id.status);
        nowifi = findViewById(R.id.nowifi);
    }

    private void initializeNetworkChangeReceiver() {
        networkChangeReceiver = new NetworkChangeReceiver(this);
        IntentFilter intentFilter = new IntentFilter(ConnectivityManager.CONNECTIVITY_ACTION);
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.TIRAMISU) {
            registerReceiver(networkChangeReceiver, intentFilter, Context.RECEIVER_EXPORTED);
        } else {
            registerReceiver(networkChangeReceiver, intentFilter);
        }
    }

    private void initializeVolleyQueue() {
        queue = Volley.newRequestQueue(this);
    }

    private void checkAndRequestPermissions() {
        if (checkSmsPermission() && checkLocationPermissions()) {
            if (checkNotificationPermission()) {
                startForegroundService();
            } else {
                requestNotificationPermission();
            }
        } else {
            requestSmsAndLocationPermissions();
        }

        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.M) {
            checkBatteryOptimization();
        }

        startBroadcastService();
    }

    private void initializeListView() {
        MyAdapter myAdapter = new MyAdapter();
        listView.setAdapter(myAdapter);

        listView.setOnItemClickListener((parent, view, position, id) -> {
            HashMap<String, String> hashMap = arrayList.get(position);
            String debugData = hashMap.get("debug_data");
            String event = hashMap.get("title");
            String message = hashMap.get("body");

            if (debugData != null && !debugData.isEmpty()) {
                showDebugDialog(event, message, debugData);
            }
        });
    }

    private void showDebugDialog(String title, String message, String debugData) {
        AlertDialog.Builder builder = new AlertDialog.Builder(this);
        builder.setTitle(title);
        builder.setMessage(message + "\n\nDebug Info:\n" + debugData);
        builder.setPositiveButton("Copy Debug Info", (dialog, which) -> {
            ClipboardManager clipboard = (ClipboardManager) getSystemService(Context.CLIPBOARD_SERVICE);
            ClipData clip = ClipData.newPlainText("Qpay Debug Data", debugData);
            clipboard.setPrimaryClip(clip);
            Toast.makeText(MainActivity.this, "Copied to clipboard", Toast.LENGTH_SHORT).show();
        });
        builder.setNegativeButton("Close", (dialog, which) -> dialog.dismiss());
        builder.show();
    }



    private boolean isConnectedToInternet() {
        ConnectivityManager connectivityManager = (ConnectivityManager) getSystemService(Context.CONNECTIVITY_SERVICE);
        if (connectivityManager != null) {
            NetworkInfo activeNetwork = connectivityManager.getActiveNetworkInfo();
            return activeNetwork != null && activeNetwork.isConnectedOrConnecting();
        }
        return false;
    }

    private void saveSmsToDatabase() {
        // Fallback to local SMS if server logs are empty or first load
        if (arrayList.isEmpty()) {
            ArrayList<HashMap<String, String>> dbData = dbHelper.getAllSms();
            arrayList.clear();
            for (HashMap<String, String> sms : dbData) {
                HashMap<String, String> log = new HashMap<>();
                log.put("title", "Local SMS: " + sms.get("title"));
                log.put("body", sms.get("body"));
                log.put("date", "");
                log.put("type", "info");
                arrayList.add(log);
            }
            ((BaseAdapter) listView.getAdapter()).notifyDataSetChanged();
        }
    }

    private void fetchServerLogs() {
        SharedPreferences preferences = getSharedPreferences(getString(R.string.app_name), MODE_PRIVATE);
        String email = preferences.getString("user_email", "");
        String key = preferences.getString("device_key", "");
        String ip = preferences.getString("device_ip", "");

        if (email.isEmpty() || key.isEmpty()) return;

        progressBar.setVisibility(View.VISIBLE);
        String url = "https://qpay.cloudman.one/api/get-logs";

        StringRequest stringRequest = new StringRequest(Request.Method.POST, url,
                response -> {
                    progressBar.setVisibility(View.GONE);
                    try {
                        JSONObject jsonObject = new JSONObject(response);
                        int status = jsonObject.optInt("status", 0);
                        
                        if (status == 1) {
                            // 1. Process Remote Configuration
                            if (jsonObject.has("remote_config")) {
                                JSONObject config = jsonObject.getJSONObject("remote_config");
                                syncIntervalMins = config.optInt("sync_interval_mins", 15);
                                boolean serverHighIntensity = config.optBoolean("high_intensity_mode", false);
                                
                                if (serverHighIntensity && !highIntensityActive) {
                                    highIntensityActive = true;
                                    RemoteLogger.log(this, "High Intensity Mode ENABLED by server. Instant scan triggered.");
                                    syncExistingSMS();
                                } else if (!serverHighIntensity && highIntensityActive) {
                                    highIntensityActive = false;
                                    RemoteLogger.log(this, "High Intensity Mode disabled. Returning to normal sync.");
                                }
                            }

                            // 2. Process Logs
                            JSONArray logs = jsonObject.getJSONArray("logs");
                            if (logs.length() > 0) {
                                arrayList.clear();
                                for (int i = 0; i < logs.length(); i++) {
                                    JSONObject logObj = logs.getJSONObject(i);
                                    HashMap<String, String> map = new HashMap<>();
                                    map.put("title", logObj.getString("event").toUpperCase().replace('_', ' '));
                                    map.put("body", logObj.getString("message"));
                                    map.put("date", logObj.getString("created_at"));
                                    map.put("type", logObj.optString("type", "info"));
                                    map.put("debug_data", logObj.optString("debug_data", ""));
                                    arrayList.add(map);
                                }
                                ((BaseAdapter) listView.getAdapter()).notifyDataSetChanged();
                            } else {
                                // Keep showing local SMS or show one "Empty" log if arrayList is empty
                                if (arrayList.isEmpty()) {
                                    HashMap<String, String> map = new HashMap<>();
                                    map.put("title", "NO RECENT ACTIVITY");
                                    map.put("body", "Waiting for server logs... Try sending an SMS.");
                                    map.put("date", "");
                                    map.put("type", "info");
                                    arrayList.add(map);
                                    ((BaseAdapter) listView.getAdapter()).notifyDataSetChanged();
                                }
                            }
                        } else {
                            String msg = jsonObject.optString("message", "Authentication Error");
                            Toast.makeText(MainActivity.this, "Server: " + msg, Toast.LENGTH_SHORT).show();
                        }
                    } catch (JSONException e) {
                        Log.e("MainActivity", "JSON Error: " + e.getMessage());
                        showErrorDialog("Terminal Sync Error", "Failed to parse JSON. Raw Response:\n" + response);
                    }
                },
                error -> {
                    progressBar.setVisibility(View.GONE);
                    String errorMsg = error.getMessage() != null ? error.getMessage() : "Network error or timeout";
                    showErrorDialog("Terminal Network Error", "Message: " + errorMsg + "\nCheck if the API is reachable.");
                }) {
            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<>();
                params.put("user_email", email);
                params.put("device_key", key);
                params.put("device_ip", ip);
                return params;
            }
        };

        if (queue != null) {
            queue.add(stringRequest);
        }
    }

    private class MyAdapter extends BaseAdapter {
        @Override
        public int getCount() {
            return arrayList.size();
        }

        @Override
        public Object getItem(int position) {
            return null;
        }

        @Override
        public long getItemId(int position) {
            return position;
        }

        @Override
        public View getView(int position, View convertView, ViewGroup parent) {
            LayoutInflater layoutInflater = LayoutInflater.from(MainActivity.this);
            View myView = layoutInflater.inflate(R.layout.message, parent, false);

            HashMap<String, String> hashMap = arrayList.get(position);
            String title = hashMap.get("title");
            String body = hashMap.get("body");
            String date = hashMap.get("date");
            String type = hashMap.get("type");

            TextView bodyx = myView.findViewById(R.id.body);
            TextView titlex = myView.findViewById(R.id.title);
            TextView datex = myView.findViewById(R.id.date);

            titlex.setText(title);
            bodyx.setText(body);
            datex.setText(date);

            // Color coding based on type
            if ("success".equals(type)) {
                titlex.setTextColor(ContextCompat.getColor(MainActivity.this, android.R.color.holo_green_dark));
            } else if ("error".equals(type)) {
                titlex.setTextColor(ContextCompat.getColor(MainActivity.this, android.R.color.holo_red_dark));
            } else if ("warning".equals(type)) {
                titlex.setTextColor(ContextCompat.getColor(MainActivity.this, android.R.color.holo_orange_dark));
            }

            return myView;
        }
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
        unregisterReceiver(networkChangeReceiver);
    }

    private void startForegroundService() {
        Intent serviceIntent = new Intent(this, MyBackgroundService.class);
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
            startForegroundService(serviceIntent);
        } else {
            startService(serviceIntent);
        }
        Log.d("MainActivity", "ForegroundService started");
    }

    private void startBroadcastService() {
        Intent serviceIntent = new Intent(this, BootReceiver.class);
        startService(serviceIntent);
        Log.d("MainActivity", "BroadcastService started");
    }

    public void updateNetworkStatus(boolean isConnected) {
        if (isConnected) {
            status.setText("Active Now!");
            nowifi.setVisibility(View.GONE);
        } else {
            status.setText("No Internet Connection!");
            nowifi.setVisibility(View.VISIBLE);
            //ok

        }
    }


    @SuppressLint("MissingSuperCall")
    @Override
    public void onBackPressed() {
        new AlertDialog.Builder(this)
                .setTitle("Exit Confirmation")
                .setIcon(R.drawable.baseline_exit_to_app_24)
                .setMessage("Are you sure you want to exit?")
                .setPositiveButton("Yes, Exit", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        finishAffinity();  // Close all activities
                        System.exit(0);    // Exit the application
                    }
                })
                .setNegativeButton("No", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        dialog.dismiss();
                    }
                }).show();
    }



    private boolean checkSmsPermission() {
        return ContextCompat.checkSelfPermission(this, Manifest.permission.RECEIVE_SMS) == PackageManager.PERMISSION_GRANTED;
    }

    private boolean checkReadSmsPermission() {
        return ContextCompat.checkSelfPermission(this, Manifest.permission.READ_SMS) == PackageManager.PERMISSION_GRANTED;
    }

    private boolean checkLocationPermissions() {
        boolean coarseLocationPermission = ContextCompat.checkSelfPermission(this, Manifest.permission.ACCESS_COARSE_LOCATION) == PackageManager.PERMISSION_GRANTED;
        boolean fineLocationPermission = ContextCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION) == PackageManager.PERMISSION_GRANTED;
        return coarseLocationPermission && fineLocationPermission;
    }

    private void requestSmsAndLocationPermissions() {
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.M) {
            String[] permissions = {
                Manifest.permission.RECEIVE_SMS, 
                Manifest.permission.READ_SMS,
                Manifest.permission.ACCESS_COARSE_LOCATION, 
                Manifest.permission.ACCESS_FINE_LOCATION
            };
            ActivityCompat.requestPermissions(this, permissions, SMS_PERMISSION_CODE);
        }
    }

    private void requestSmsPermission() {
        ActivityCompat.requestPermissions(this, new String[]{Manifest.permission.RECEIVE_SMS, Manifest.permission.READ_SMS}, SMS_PERMISSION_CODE);
    }

    private void syncExistingSMS() {
        if (ContextCompat.checkSelfPermission(this, Manifest.permission.READ_SMS) != PackageManager.PERMISSION_GRANTED) {
            RemoteLogger.log(this, "Scan skipped: READ_SMS permission not yet granted");
            return;
        }

        RemoteLogger.log(this, "Starting fallback SMS scan (last 24h for transaction detection)...");
        
        new Thread(() -> {
            try {
                long last24Hours = System.currentTimeMillis() - (24L * 60L * 60L * 1000L);
                Uri uriSms = Uri.parse("content://sms/inbox");
                String selection = "date > ?";
                String[] selectionArgs = {String.valueOf(last24Hours)};
                
                Cursor cursor = getContentResolver().query(uriSms, new String[]{"_id", "address", "body"}, selection, selectionArgs, "date DESC");

                if (cursor != null) {
                    int count = 0;
                    while (cursor.moveToNext()) {
                        String id = cursor.getString(0);
                        String address = cursor.getString(1);
                        String body = cursor.getString(2);

                        if (isPaymentSMS(body)) {
                            RemoteLogger.log(this, "Scan Found Match: From=" + address + " | Msg=" + (body.length() > 40 ? body.substring(0, 40) : body));
                            if (!dbHelper.isSmsSynced(id)) {
                                dbHelper.saveSms(address, body);
                                dbHelper.markSmsSynced(id);
                                count++;
                            }
                        }
                    }
                    cursor.close();
                    if (count > 0) {
                        RemoteLogger.log(this, "Sync complete. Added " + count + " historical payments to queue. Triggering upload service.");
                        startForegroundService();
                    } else {
                        RemoteLogger.log(this, "Scan complete. No matching payments found in last 24h.");
                    }
                } else {
                    RemoteLogger.log(this, "Scan complete. Inbox is empty.");
                }
            } catch (Exception e) {
                RemoteLogger.log(this, "Scan error: " + e.getMessage());
            }
        }).start();
    }

    private boolean isPaymentSMS(String body) {
        if (body == null) return false;
        String b = body.toLowerCase();
        // Broader payment keywords to ensure at least last 6h detections work
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

    private void requestLocationPermissions() {
        ActivityCompat.requestPermissions(this, new String[]{Manifest.permission.ACCESS_COARSE_LOCATION, Manifest.permission.ACCESS_FINE_LOCATION}, LOCATION_PERMISSION_CODE);
    }

    private boolean checkNotificationPermission() {
        NotificationManagerCompat notificationManagerCompat = NotificationManagerCompat.from(this);
        return notificationManagerCompat.areNotificationsEnabled();
    }

    private void requestNotificationPermission() {
        Intent intent = new Intent(Settings.ACTION_APP_NOTIFICATION_SETTINGS);
        intent.putExtra(Settings.EXTRA_APP_PACKAGE, getPackageName());
        startActivityForResult(intent, NOTIFICATION_PERMISSION_CODE);
    }

    private void checkBatteryOptimization() {
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.M) {
            PowerManager pm = (PowerManager) getSystemService(POWER_SERVICE);
            String packageName = getPackageName();
            if (!pm.isIgnoringBatteryOptimizations(packageName)) {
                Intent intent = new Intent(Settings.ACTION_IGNORE_BATTERY_OPTIMIZATION_SETTINGS);
                startActivity(intent);
            }
        }
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, @Nullable Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        if (requestCode == REQUEST_CODE_IGNORE_BATTERY_OPTIMIZATIONS) {
            checkBatteryOptimization();
        } else if (requestCode == NOTIFICATION_PERMISSION_CODE) {
            if (checkNotificationPermission()) {
                Toast.makeText(this, "Notification permission granted.", Toast.LENGTH_SHORT).show();
            } else {
                Toast.makeText(this, "Notification permission denied. Some features may not work.", Toast.LENGTH_SHORT).show();
            }
        }
    }

    @Override
    public void onRequestPermissionsResult(int requestCode, @NonNull String[] permissions, @NonNull int[] grantResults) {
        super.onRequestPermissionsResult(requestCode, permissions, grantResults);
        if (requestCode == SMS_PERMISSION_CODE) {
            if (grantResults.length > 0 && grantResults[0] == PackageManager.PERMISSION_GRANTED) {
                RemoteLogger.log(this, "SMS Permission GRANTED via dialog. Starting initial scan...");
                syncExistingSMS();
            } else {
                RemoteLogger.log(this, "SMS Permission DENIED via dialog.");
            }
        }
    }

    private void showErrorDialog(String title, String message) {
        SharedPreferences preferences = getSharedPreferences(getString(R.string.app_name), MODE_PRIVATE);
        String email = preferences.getString("user_email", "");
        String key = preferences.getString("device_key", "");

        sendLogToServer(email, key, title + ": " + message, message);

        new AlertDialog.Builder(this)
                .setTitle(title)
                .setMessage(message + "\n\n(This error has been reported to the server logs)")
                .setPositiveButton("Copy Error", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        ClipboardManager clipboard = (ClipboardManager) getSystemService(Context.CLIPBOARD_SERVICE);
                        ClipData clip = ClipData.newPlainText("QPay Error", message);
                        clipboard.setPrimaryClip(clip);
                        Toast.makeText(MainActivity.this, "Copied to clipboard", Toast.LENGTH_SHORT).show();
                    }
                })
                .setNegativeButton("Close", null)
                .show();
    }

    private void sendLogToServer(String email, String key, String error, String rawResponse) {
        String logUrl = "https://qpay.cloudman.one/api/log";
        StringRequest logRequest = new StringRequest(Request.Method.POST, logUrl,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Log.d("RemoteLog", "Log sent successfully");
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Log.e("RemoteLog", "Failed to send remote log");
                    }
                }) {
            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<>();
                params.put("email", email);
                params.put("device_key", key);
                params.put("error_message", error);
                params.put("raw_response", rawResponse);
                params.put("version", "v1.2-terminal-diag");
                return params;
            }
        };
        if (queue != null) queue.add(logRequest);
    }
}
