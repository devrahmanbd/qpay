package one.cloudman.qpay;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

import java.util.ArrayList;
import java.util.HashMap;

public class sqlite extends SQLiteOpenHelper {
    private static final String DATABASE_NAME = "sms_database";
    private static final int DATABASE_VERSION = 2;

    // Table names and columns
    public static final String TABLE_SMS = "sms";
    public static final String TABLE_SYNCED = "synced_sms";
    
    public static final String COLUMN_ID = "id";
    public static final String COLUMN_TITLE = "title";
    public static final String COLUMN_BODY = "body";
    public static final String COLUMN_SYSTEM_ID = "system_id";

    // Create table SQL query
    private static final String CREATE_TABLE_SMS =
            "CREATE TABLE " + TABLE_SMS + "("
                    + COLUMN_ID + " INTEGER PRIMARY KEY AUTOINCREMENT,"
                    + COLUMN_TITLE + " TEXT,"
                    + COLUMN_BODY + " TEXT"
                    + ")";

    private static final String CREATE_TABLE_SYNCED =
            "CREATE TABLE " + TABLE_SYNCED + "("
                    + COLUMN_ID + " INTEGER PRIMARY KEY AUTOINCREMENT,"
                    + COLUMN_SYSTEM_ID + " TEXT UNIQUE"
                    + ")";

    public sqlite(Context context) {
        super(context, DATABASE_NAME, null, DATABASE_VERSION);
    }

    @Override
    public void onCreate(SQLiteDatabase db) {
        db.execSQL(CREATE_TABLE_SMS);
        db.execSQL(CREATE_TABLE_SYNCED);
    }

    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
        if (oldVersion < 2) {
            db.execSQL(CREATE_TABLE_SYNCED);
        } else {
            // Standard fallback
            db.execSQL("DROP TABLE IF EXISTS " + TABLE_SMS);
            db.execSQL("DROP TABLE IF EXISTS " + TABLE_SYNCED);
            onCreate(db);
        }
    }

    public boolean isSmsSynced(String systemId) {
        SQLiteDatabase db = this.getReadableDatabase();
        Cursor cursor = db.query(TABLE_SYNCED, new String[]{COLUMN_ID}, 
                COLUMN_SYSTEM_ID + " = ?", new String[]{systemId}, null, null, null);
        boolean exists = (cursor != null && cursor.getCount() > 0);
        if (cursor != null) cursor.close();
        return exists;
    }

    public void markSmsSynced(String systemId) {
        SQLiteDatabase db = this.getWritableDatabase();
        ContentValues values = new ContentValues();
        values.put(COLUMN_SYSTEM_ID, systemId);
        db.insertWithOnConflict(TABLE_SYNCED, null, values, SQLiteDatabase.CONFLICT_IGNORE);
    }

    public long saveSms(String title, String body) {
        SQLiteDatabase db = this.getWritableDatabase();

        ContentValues values = new ContentValues();
        values.put(COLUMN_TITLE, title);
        values.put(COLUMN_BODY, body);

        return db.insert(TABLE_SMS, null, values);
    }

    public ArrayList<HashMap<String, String>> getAllSms() {
        ArrayList<HashMap<String, String>> smsList = new ArrayList<>();
        SQLiteDatabase db = this.getReadableDatabase();

        String[] projection = {COLUMN_ID, COLUMN_TITLE, COLUMN_BODY};
        Cursor cursor = db.query(TABLE_SMS, projection, null, null, null, null, null);

        if (cursor != null && cursor.moveToFirst()) {
            do {
                HashMap<String, String> sms = new HashMap<>();
                sms.put(COLUMN_ID, String.valueOf(cursor.getLong(cursor.getColumnIndexOrThrow(COLUMN_ID))));
                sms.put(COLUMN_TITLE, cursor.getString(cursor.getColumnIndexOrThrow(COLUMN_TITLE)));
                sms.put(COLUMN_BODY, cursor.getString(cursor.getColumnIndexOrThrow(COLUMN_BODY)));
                smsList.add(sms);
            } while (cursor.moveToNext());

            cursor.close();
        }

        return smsList;
    }

    public void deleteSms(long id) {
        SQLiteDatabase db = this.getWritableDatabase();
        db.delete(TABLE_SMS, COLUMN_ID + " = ?", new String[]{String.valueOf(id)});
        db.close();
    }
}
