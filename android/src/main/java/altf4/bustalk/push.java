package altf4.bustalk;

//util imports

import android.Manifest;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.support.v4.app.ActivityCompat;
import android.support.v4.content.ContextCompat;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;

//widget imports
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import java.util.List;


public class push extends AppCompatActivity implements View.OnClickListener{
    //declaration of variables and constants
    public static final String DebugTag = "DEV_PUSH_DEBUG_MSG";

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

    //return to log in screen
    public void open_logout() {
        Intent intent = new Intent(this, login.class);
        startActivity(intent);
    }

    //triggered when a button is clicked
    @Override
    public void onClick(View v) {

        final TextView status = findViewById(R.id.lblOutputStatus);

        switch (v.getId()){
            case R.id.btnLogOut:
                LogOut();
                break;
            case R.id.btnSend:
                Log.d(DebugTag, "starting location sender");

                currentLocation = getLastKnownLocation();
                /*currentLocation = locationManager.getLastKnownLocation(LocationManager.GPS_PROVIDER);
                longitude = currentLocation.getLongitude();
                latitude = currentLocation.getLatitude();
                status.setText("Your Location is - \nLat: " +
                        latitude + "\nLong: " + longitude);*/
                if(currentLocation == null){
                    Log.d(DebugTag,"currentLocation is NULL on starting send");
                }else{
                    longitude = currentLocation.getLongitude();
                    latitude = currentLocation.getLatitude();
                    status.setText("Your Location is - \nLat: " +
                            latitude + "\nLong: " + longitude);
                }
                break;
            case R.id.btnStop:
                Log.d(DebugTag, "stopping location sender");
        }
    }

    //log out when "LOG OUT" button is clicked
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

    public boolean checkLocationPermission()
    {
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



}
