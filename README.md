# mymobiletracker
It is an app to track the following features from a user
 * App installs
 * App events
 * Automated push notifications
 * Custom or 3rd party login
 
 This app supports both IOS and Android system. The app also supports multiple apps to track user's activities on the apps. 
 
 ### App Installs
  When the app is called, the basic data the app collects are the following 
   * Ip Addresses
   * Country
   * Visit time
   * Device characteristics 
   
  With the data collected from user, our backend generates unique User Id and store the User Id on users' mobile to use it with any subsequent services.
  The app also offers login systems. When user logins to our login system, his mobile sends following infos:
   * User Id
   * Login Type
   * Oauth Token
   * Oauth User Id Token
   * Password
   
 ### App Events Tracking
  The app records any activities that we want to track from users when they use our app. The app also make custom reports of user events.
  The app uses the following parameters to records:
   * User Id
   * Time/Date of the event
   * Event Value
  Using the app event service, we are able to track users' behavior toward some of the features of the app (like what they do with our push notifications)
  
  ### Automated Push Notification
   Using One Signal API, the app's backend send push notifactions after creating a specific query to users upon specific events they make.
