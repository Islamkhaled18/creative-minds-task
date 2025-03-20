<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FCM Notification Test</title>
</head>

<body>
    <h1>Test FCM Notifications in Laravel</h1>
    <button id="enableNotifications">Enable Notifications</button>
    <div id="status"></div>

    <!-- Firebase SDK -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/firebase/10.11.0/firebase-app-compat.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/firebase/10.11.0/firebase-messaging-compat.js"></script>

    <script>
        // Update status function
        function updateStatus(message) {
            document.getElementById("status").innerHTML += `<p>${message}</p>`;
            console.log(message);
        }

        // Firebase Configuration
        const firebaseConfig = {
            apiKey: "AIzaSyCyENOTLhdwCfvAYrfIWYPUxFq4FGPqt10",
            authDomain: "creative-minds-ce72f.firebaseapp.com",
            projectId: "creative-minds-ce72f",
            storageBucket: "creative-minds-ce72f.firebasestorage.app",
            messagingSenderId: "432087042749",
            appId: "1:432087042749:web:bd31913a9077daa838c5d4",
            measurementId: "G-5W64T4PER9"
        };

        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
        updateStatus("Firebase initialized");

        // Initialize Messaging
        let messaging;
        try {
            messaging = firebase.messaging();
            updateStatus("Firebase Messaging initialized");
        } catch (error) {
            updateStatus(`Error initializing messaging: ${error.message}`);
        }

        // Request Permission and Get Token
        async function requestPermission() {
            updateStatus("Requesting permission...");

            try {
                const permission = await Notification.requestPermission();
                updateStatus(`Permission ${permission}`);

                if (permission === "granted") {
                    // Replace with your actual VAPID key from Firebase Console
                    const vapidKey = "BFVzAoM1CBAPIX3OxE9UUZsI54rVm6dV9jI6RfI8a6g10mDh8f4ljlQVfgvVRgkvgOq-yb6HMigG9Hco0cbYbLM";

                    if (!vapidKey || vapidKey === "YOUR_ACTUAL_VAPID_KEY_HERE") {
                        updateStatus("ERROR: You need to set your actual VAPID key");
                        return;
                    }

                    try {
                        // Using the correct method for the compat version
                        messaging.getToken({ vapidKey: vapidKey })
                            .then((currentToken) => {
                                if (currentToken) {
                                    updateStatus("Token received:");
                                    updateStatus(currentToken);

                                    // Send the token to your Laravel backend for storage
                                    fetch('/store-device-token', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: JSON.stringify({ token: currentToken })
                                    })
                                    .then(response => {
                                        if (!response.ok) {
                                            throw new Error(`HTTP error! Status: ${response.status}`);
                                        }
                                        return response.text(); // First, get the response as text to debug
                                    })
                                    .then(text => {
                                        console.log('Raw response:', text); // Log the raw response
                                        return JSON.parse(text); // Then parse it as JSON
                                    })
                                    .then(data => {
                                        updateStatus("Token saved to backend");
                                    })
                                    .catch(err => {
                                        updateStatus(`Error saving token: ${err.message}`);
                                        console.error('Fetch error:', err);
                                    });
                                } else {
                                    updateStatus("No token received. You may need to check your Firebase configuration.");
                                }
                            })
                            .catch((err) => {
                                updateStatus(`Error getting token: ${err.message}`);
                            });
                    } catch (err) {
                        updateStatus(`Token request error: ${err.message}`);
                    }
                } else {
                    updateStatus("Notification permission denied");
                }
            } catch (error) {
                updateStatus(`Error in permission request: ${error.message}`);
            }
        }

        // Set up event listeners when the page loads
        document.addEventListener("DOMContentLoaded", () => {
            // Button click handler
            document.getElementById("enableNotifications").addEventListener("click", requestPermission);

            // Listen for incoming messages
            if (messaging) {
                messaging.onMessage((payload) => {
                    updateStatus(`Message received: ${JSON.stringify(payload)}`);
                    alert(`New notification: ${payload.notification.title} - ${payload.notification.body}`);
                });
            }

            updateStatus("Event listeners set up");
        });

        // Register the service worker for background notifications
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/firebase-messaging-sw.js')
                .then(registration => {
                    updateStatus("Service worker registered");
                    console.log('Service Worker registered with scope:', registration.scope);
                })
                .catch(err => {
                    updateStatus(`Service worker error: ${err.message}`);
                    console.error('Service Worker registration failed:', err);
                });
        }
    </script>
</body>

</html>
