package altf4.bustalk;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.text.Editable;
import android.text.TextWatcher;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;

//custom imports


public class login extends AppCompatActivity {
    public static final String DebugTag = "DEV_LOGIN_DEBUG_MSG";
    private boolean flag1 = false;
    private boolean flag2 = false;

    private EditText id_input;
    private EditText bus_number_input;

    private String driver_id;
    private String bus_number;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        id_input = findViewById(R.id.txtDriverId);
        bus_number_input = findViewById(R.id.txtBusNumber);
        final Button login_button = findViewById(R.id.btnLogIn);
        final TextView status_text =findViewById(R.id.lblLogInStatus);

        id_input.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {
            }

            @Override
            public void onTextChanged(CharSequence charSequence, int i, int i1, int i2) {
            }

            @Override
            public void afterTextChanged(Editable editable) {
                int n = editable.toString().length();
                if (n < 10 ) {
                    id_input.setError("Invalid driver ID");
                    flag1 = false;
                } else{
                    flag1 = true;
                }
            }
        });
        bus_number_input.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) { }

            @Override
            public void onTextChanged(CharSequence charSequence, int i, int i1, int i2) { }

            @Override
            public void afterTextChanged(Editable editable) {
                int n = editable.toString().length();
                if (n < 3 ) {
                    bus_number_input.setError("Invalid bus number");
                    flag2 = false;
                } else{
                    flag2 = true;
                }
            }
        });

        login_button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                status_text.setText("Attempt to log in");
                if (flag1 && flag2){
                    status_text.setText("Log in successful");

                    //obtain valid inputs and pass them to next activity
                    driver_id = id_input.getText().toString();
                    bus_number = bus_number_input.getText().toString();
                    sendValuesToNextActivity();

                    login2push();
                }
                Log.d(DebugTag, "log in button pressed");
            }
        });
        Log.d(DebugTag, "on create completed");
    }

    public void login2push() {
        Intent intent = new Intent(this, push.class);
        startActivity(intent);
    }

    public void sendValuesToNextActivity(){
        Intent passIntent = new Intent(login.this, push.class);
        //String name = getIntent().getStringExtra("name");
        passIntent.putExtra("driver_id", driver_id);
        passIntent.putExtra("bus_number", bus_number);
        startActivity(passIntent);
    }

}

