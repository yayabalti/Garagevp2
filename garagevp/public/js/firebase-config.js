const firebaseConfig = {
  apiKey: "AIzaSyDQTUEQrcfGrrmScFOKrDEjcKnnqLuTLa4",
  authDomain: "garagevp-a5ae3.firebaseapp.com",
  projectId: "garagevp-a5ae3",
  storageBucket: "garagevp-a5ae3.appspot.com",
  messagingSenderId: "533150300008",
  appId: "1:533150300008:web:18ef9a3665738d0ebb48dd"
};

// Initialisation de Firebase avec vérification
try {
  firebase.initializeApp(firebaseConfig);
  const db = firebase.firestore();
  console.log("Firebase initialisé avec succès");
  
  // Test de connexion à Firestore
  db.collection('messages').get()
    .then(() => console.log("Connexion à Firestore réussie"))
    .catch(error => console.error("Erreur de connexion à Firestore:", error));

  window.db = db;
} catch (error) {
  console.error("Erreur d'initialisation:", error);
}

