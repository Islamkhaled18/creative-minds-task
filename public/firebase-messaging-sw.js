// firebase-messaging-sw.js

importScripts('https://cdnjs.cloudflare.com/ajax/libs/firebase/10.11.0/firebase-app-compat.js');
importScripts('https://cdnjs.cloudflare.com/ajax/libs/firebase/10.11.0/firebase-messaging-compat.js');

// Initialize Firebase
const firebaseConfig = {
    apiKey: "AIzaSyCyENOTLhdwCfvAYrfIWYPUxFq4FGPqt10",
    authDomain: "creative-minds-ce72f.firebaseapp.com",
    projectId: "creative-minds-ce72f",
    storageBucket: "creative-minds-ce72f.firebasestorage.app",
    messagingSenderId: "432087042749",
    appId: "1:432087042749:web:bd31913a9077daa838c5d4",
    measurementId: "G-5W64T4PER9"
};

firebase.initializeApp(firebaseConfig);

// Retrieve an instance of Firebase Messaging
const messaging = firebase.messaging();

// Handle background messages
messaging.onBackgroundMessage((payload) => {
    console.log('[firebase-messaging-sw.js] Received background message: ', payload);

    // Customize notification here
    const notificationTitle = payload.notification.title;
    const notificationOptions = {
        body: payload.notification.body,
        icon: payload.notification.icon || '/icon.png', // Add a default icon if not provided
    };

    self.registration.showNotification(notificationTitle, notificationOptions);
});
