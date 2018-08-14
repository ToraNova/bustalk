package altf4.bustalk;

//util imports

import android.Manifest;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.os.AsyncTask;
import android.os.Handler;
import android.support.v4.app.ActivityCompat;
import android.support.v4.content.ContextCompat;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;

//widget imports
import android.widget.Button;
import android.widget.TextView;

import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.URL;
import java.net.HttpURLConnection;
import java.util.List;

public class push extends AppCompatActivity implements View.OnClickListener{
    //declaration of variables and constants
    public static final String DebugTag = "DEV_PUSH_DEBUG_MSG";
    static final int period = 3000;
    public int count = 0;
    public String driver_id = "";
    public String bus_number = "";

    private TextView status;
    private Runnable runnableCode;
    private Handler handler;
    private Location currentLocation;
    private double longitude;
    private double latitude;

    //-------------------------------------------------------------------------------------------------
    //Location declares
    //-------------------------------------------------------------------------------------------------
    private static final long MIN_DISTANCE_CHANGE_FOR_UPDATES = 10; // 10 meters
    private static final long MIN_TIME_BW_UPDATES = 1000 * 60 * 1; // 1 minute
    protected LocationManager locationManager;
    boolean isNetwork_Location = false;
    boolean isGPS_Location = false;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        //set view upon entering this interface
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_push);

        //receive values from previous activity
        Intent intent = getIntent();
        Bundle bundle = intent.getExtras();
        driver_id = bundle.getString("driver_id");
        bus_number = bundle.getString("bus_number");
        Log.d(DebugTag, "Driver id: " + driver_id + "\t\t\tBus number: " + bus_number);

        //map xml to java
        status = findViewById(R.id.lblOutputStatus);

        //obtain location service
        locationManager = (LocationManager)this.getSystemService(LOCATION_SERVICE);

        //-------------------------------------------------------------------------------------------------
        //PERMISSION CHECKING -----------------------------------------------------------------------------
        //-------------------------------------------------------------------------------------------------
        if( ! checkLocationPermission()) {
            if (ContextCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION)
                    != PackageManager.PERMISSION_GRANTED) {
                Log.d(DebugTag, "No permission on Fine location");
                ActivityCompat.requestPermissions(this,
                        new String[]{Manifest.permission.ACCESS_FINE_LOCATION},
                        1);
            }

            if (ContextCompat.checkSelfPermission(this, Manifest.permission.INTERNET)
                    != PackageManager.PERMISSION_GRANTED) {
                Log.d(DebugTag, "No permission on Internet");
                ActivityCompat.requestPermissions(this,
                        new String[]{Manifest.permission.INTERNET},
                        1);
            }
        }else{
            Log.d(DebugTag,"Permission for Fine Location and Internet is granted");
            isGPS_Location = locationManager.isProviderEnabled(LocationManager.GPS_PROVIDER);
            isNetwork_Location = locationManager.isProviderEnabled(LocationManager.NETWORK_PROVIDER);
            locationManager.requestLocationUpdates(
                    LocationManager.GPS_PROVIDER,
                    MIN_TIME_BW_UPDATES,
                    MIN_DISTANCE_CHANGE_FOR_UPDATES, new AltF4_LocationListener());

            String gpsind = isGPS_Location?"GPS":"NO GPS";
            String netind = isNetwork_Location?"Network":"NO Network";
            Log.d(DebugTag,gpsind);
            Log.d(DebugTag,netind);

            currentLocation = locationManager.getLastKnownLocation(LocationManager.GPS_PROVIDER);
            if(currentLocation==null){
                Log.d(DebugTag,"Null location on start");
            }else{
                longitude = currentLocation.getLongitude();
                latitude = currentLocation.getLatitude();
            }
        }
        //-------------------------------------------------------------------------------------------------
        //Button Listener attach
        //-------------------------------------------------------------------------------------------------
        final Button logout_button = findViewById(R.id.btnLogOut);
        final Button send = findViewById(R.id.btnSend);
        final Button stop = findViewById(R.id.btnStop);

        //set click listeners for buttons
        send.setOnClickListener(this);
        stop.setOnClickListener(this);
        logout_button.setOnClickListener(this);

        Log.d(DebugTag, "Interface creation complete");
    }

    //return to previous screen (log out)
    public void open_logout() {
        Intent intent = new Intent(this, login.class);
        startActivity(intent);
    }

    //triggered when a button is clicked
    @Override
    public void onClick(View v) {
        switch (v.getId()){
            case R.id.btnLogOut:
                //if log out button is clicked
                LogOut();
                break;
            case R.id.btnSend:
                //if send button is clicked
                Log.d(DebugTag, "starting location sender");

                //send location repeatedly with fixed duration until stop button is clicked
                handler = new Handler();
                runnableCode = new Runnable() {
                    @Override
                    public void run() {
                        Log.d(DebugTag, "Repeating, count = " + count++);
                        SendLocation();
                        // Repeat this the same runnable code block every 3s
                        handler.postDelayed(runnableCode, period);
                    }
                };
                // Start the initial runnable task by posting through the handler
                handler.post(runnableCode);
                break;
            case R.id.btnStop:
                //if stop button is clicked, stop location update
                Log.d(DebugTag, "stopping location sender");
                handler.removeCallbacks(runnableCode);
        }
    }

    public void LogOut(){

        final TextView status = findViewById(R.id.lblOutputStatus);

        status.setText("Logging out...");
        Log.d(DebugTag, "log out button pressed");

        //go to log in screen
        open_logout();
    }

    public void onRequestPermissionsResult(int requestCode, String permissions[], int[] grantResults) {
        switch (requestCode) {
            case 1: {
                // If request is cancelled, the result arrays are empty.
                if (grantResults.length > 0
                        && grantResults[0] == PackageManager.PERMISSION_GRANTED) {

                } else {
                    // permission denied, boo! Disable the
                    // functionality that depends on this permission.
                }
                return;
            }
            // other 'case' lines to check for other
            // permissions this app might request
        }
    }

    public boolean checkLocationPermission() {
        String permission1 = "android.permission.ACCESS_FINE_LOCATION";
        String permission2 = "android.permission.INTERNET";
        int res1 = this.checkCallingOrSelfPermission(permission1);
        int res2 = this.checkCallingOrSelfPermission(permission2);
        return (res1 == PackageManager.PERMISSION_GRANTED && res2 == PackageManager.PERMISSION_GRANTED);
    }

    public class AltF4_LocationListener implements LocationListener{
        @Override
        public void onLocationChanged(Location location) {
            Log.d(DebugTag,"Location change : Latitude :" +location.getLatitude() + " Longitude :"+location.getLongitude());
        }


        @Override
        public void onProviderDisabled(String provider) {
        }


        @Override
        public void onProviderEnabled(String provider) {
        }


        @Override
        public void onStatusChanged(String provider, int status, Bundle extras) {
        }
    }

    private Location getLastKnownLocation() {

        //-------------------------------------------------------------------------------------------------
        //PERMISSION CHECKING -----------------------------------------------------------------------------
        //-------------------------------------------------------------------------------------------------
        if(!checkLocationPermission()) {
            if (ContextCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION)
                    != PackageManager.PERMISSION_GRANTED) {
                Log.d(DebugTag, "No permission on Fine location");
                ActivityCompat.requestPermissions(this,
                        new String[]{Manifest.permission.ACCESS_FINE_LOCATION},
                        1);
            }

            if (ContextCompat.checkSelfPermission(this, Manifest.permission.INTERNET)
                    != PackageManager.PERMISSION_GRANTED) {
                Log.d(DebugTag, "No permission on Internet");
                ActivityCompat.requestPermissions(this,
                        new String[]{Manifest.permission.INTERNET},
                        1);
            }
        }else{
            Log.d(DebugTag,"Android persistent permission check");
        }

        locationManager = (LocationManager)getApplicationContext().getSystemService(LOCATION_SERVICE);
        List<String> providers = locationManager.getProviders(true);
        Location bestLocation = null;
        for (String provider : providers) {
            Location l = locationManager.getLastKnownLocation(provider);
            if (l == null) {
                continue;
            }
            if (bestLocation == null || l.getAccuracy() < bestLocation.getAccuracy()) {
                // Found best last known location: %s", l);
                bestLocation = l;
            }
        }
        return bestLocation;
    }

    //send latest location to web server
    private void SendLocation(){
        currentLocation = getLastKnownLocation();

        if(currentLocation == null){
            Log.d(DebugTag,"currentLocation is NULL on starting send");
        }else{
            longitude = currentLocation.getLongitude();
            latitude = currentLocation.getLatitude();
            status.setText("Your Location is - \nLat: " +
                    latitude + "\nLong: " + longitude);
            String startURL = "http://10.100.19.76/server.php";
            String testURL = startURL + "?push=1&lat=" + Double.toString(latitude) +
                    "&lng=" + Double.toString(longitude) + "&bus_id=A" + bus_number + "&driver_id=" + driver_id;
            new NetworkManager().execute(testURL); //THIS IS THE PUSH LINE
        }
    }

    //HTTP GET
    class NetworkManager extends AsyncTask<String,Void,String>{
        protected String doInBackground(String ...strings){
            String get_result = "";
            String urlString = strings[0];
            URL url;
            HttpURLConnection connection = null;
            try{
                url = new URL(urlString);
                connection = (HttpURLConnection)url.openConnection();
                connection.setRequestMethod("GET");
                connection.setDoInput(true);
                connection.connect();

                InputStream in = connection.getInputStream();
                InputStreamReader isw = new InputStreamReader(in);

                int data = isw.read();

                while (data != -1) {
                    char current = (char) data;
                    data = isw.read();
                    System.out.print(current);
                }

            }
            catch (Exception e) {
                // Writing exception to log
                e.printStackTrace();
                Log.d(DebugTag, "Error in pushing data:   " + e.toString());
            }
            finally {
                if (connection != null) {
                    connection.disconnect();
                }
            }
            return get_result;
        }
    }

}
