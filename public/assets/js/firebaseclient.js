

// const messaging = firebase.messaging();

// messaging.usePublicVapidKey("BCI-w_lnnkMbJO0TBISAeaus-xnPe9ZJt2TJXqPsl3C3fU7IkcpeFmDM3P7RVz_fWpVy7slO-oAFh-b4IDSdgR8");

// Notification.requestPermission().then((permission) => {
//   if (permission === 'granted') {
//     console.log('Notification permission granted.');
//     // TODO(developer): Retrieve an Instance ID token for use with FCM.
//     // ...
//   } else {
//     console.log('Unable to get permission to notify.');
//   }
// });

// messaging.getToken().then((currentToken) => {
//   if (currentToken) {
//     console.log("token", currentToken);
//     sendTokenToServer(currentToken);
//     updateUIForPushEnabled(currentToken);
//   } else {
//     // Show permission request.
//     console.log('No Instance ID token available. Request permission to generate one.');
//     // Show permission UI.
//     updateUIForPushPermissionRequired();
//     setTokenSentToServer(false);
//   }
// }).catch((err) => {
//   console.log('An error occurred while retrieving token. ', err);
//   showToken('Error retrieving Instance ID token. ', err);
//   setTokenSentToServer(false);
// });

// messaging.onTokenRefresh(() => {
//   messaging.getToken().then((refreshedToken) => {
//     console.log('Token refreshed.');
//     // Indicate that the new Instance ID token has not yet been sent to the
//     // app server.
//     setTokenSentToServer(false);
//     // Send Instance ID token to app server.
//     sendTokenToServer(refreshedToken);
//     // ...
//   }).catch((err) => {
//     console.log('Unable to retrieve refreshed token ', err);
//     showToken('Unable to retrieve refreshed token ', err);
//   });
// });

// messaging.setBackgroundMessageHandler(function(payload) {
//   console.log('[firebase-messaging-sw.js] Received background message ', payload);
//   // Customize notification here
//   const notificationTitle = 'Background Message Title';
//   const notificationOptions = {
//     body: 'Background Message body.',
//     icon: '/firebase-logo.png'
//   };

//   return self.registration.showNotification(notificationTitle,
//     notificationOptions);
// });

// messaging.onMessage((payload) => {
//     console.log('Message received. ', payload);
//     // ...
//   });