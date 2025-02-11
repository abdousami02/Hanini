
{/* <script src="https://www.gstatic.com/firebasejs/9.14.0/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.14.0/firebase-messaging-compat.js"></script> */}

// import "https://www.gstatic.com/firebasejs/9.14.0/firebase-app-compat.js";
// import "https://www.gstatic.com/firebasejs/9.14.0/firebase-messaging-compat.js";

// importScripts();


// notification
const firebaseConfig = {
    apiKey: "AIzaSyD3rsNtXTf0x9oIaNn3rsMcIIYyUPs-5eg",
    authDomain: "notificationtest-9949a.firebaseapp.com",
    projectId: "notificationtest-9949a",
    storageBucket: "notificationtest-9949a.appspot.com",
    messagingSenderId: "678357974407",
    appId: "1:678357974407:web:22a349926afb1b4703e722",
    measurementId: "G-SY3S2BLTT2"
};


// Initialize Firebase
const app = firebase.initializeApp(firebaseConfig);
const db = firebase.database();
let messaging;
    try {
        messaging = firebase.messaging.isSupported() ? firebase.messaging() : null
    } catch (err) {
        console.error('Failed to initialize Firebase Messaging', err);
    }

var vapidkey = "BAL4NbPRgnqMgxbchQG17uv-DNmvbZYNpMrBU9WhNk_ZIrl8ZT0g4b9T3Fbw6l1fNUZPuaywQEf1UlH2uormxOs";

if(messaging){
    messaging.getToken({vapidkey: vapidkey}).then((currentToken) => {
        // console.log(currentToken)
        if (currentToken) {
            // Send the token to your server and update the UI if necessary
            // document.getElementById('content').innerHTML = currentToken;
            sendTokenToServer(currentToken);
        } else {
            // Show permission request UI
            console.log('No registration token available.');
            tokenIsSend(false)
        }
    }).catch((err) => {
        console.log('An error occurred while retrieving token. ', err);
        // document.getElementById('content').innerHTML = err;
        tokenIsSend(false)
    });

    if ("serviceWorker" in navigator) {
        navigator.serviceWorker
            .register("/firebase-messaging-sw.js")
            .then(function(registration) {
            console.log("Registration successful, scope is:", registration.scope);
            })
            .catch(function(err) {
            console.log("Service worker registration failed, error:", err);
            });
    }

    navigator.serviceWorker.addEventListener("message", (message) => {
        console.log('local',message);
        placeNotification(message.data.data);
    });
        
    // messaging.onMessage((payload) => {
    //     console.log('2 onMessage',payload);

    //     const notificationTitle = payload.notification.title;
    //     const notificationOptions = {
    //       body: payload.notification.body,
    //       icon: payload.notification.icon,
    //       data: { click_action: payload.data.click_action },
    //     };
      
    //     // Show a manual notification
    //     new Notification(notificationTitle, {
    //       body: payload.notification.body,
    //       icon: payload.notification.icon,
    //     }).onclick = () => {
    //       window.open(payload.data.click_action, '_blank');
    //     };
    //     // document.getElementById('content').innerHTML = JSON.stringify(payload.data, null, 2);
    // });

}else{
    console.error('google notification not prepare')
}


// sent token to server where it is used for sending notification
function sendTokenToServer(currentToken){
    // first check if we already send it or not
    if(!isTokenSentToServer()){
        console.log('Sending Token to server...');
        // if token is successfully sent to the server
        // then set setTokenSentToServer to true
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let url = document.querySelector('meta[name="main-url"]').getAttribute('content');
        let url_send_token = url+'/send-token-notification';

        var formdata = new FormData();
        formdata.append('current_token', currentToken);

        let http = new XMLHttpRequest();
        http.open('post', url_send_token);
        http.setRequestHeader("Accept", "application/json");
        http.setRequestHeader("X-CSRF-Token", token);
        // http.timeout = 45000;
        http.send(formdata);
        http.onload = function() {
            let response = JSON.parse(this.response);
            if(response.status == 'success'){
                tokenIsSend(true)
            }
        }


    }else{
        console.log('Token already available in the server');
    }
}

function tokenIsSend(sent){
    window.localStorage.setItem('sentToServer', sent ? '1' : '0');
    console.log('set in local storage')
}

function isTokenSentToServer(){
    return window.localStorage.getItem('sentToServer') == 1;
}