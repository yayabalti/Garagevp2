// Importez les fonctions nécessaires depuis le SDK Firebase
import { initializeApp } from "firebase/app";
import { getFirestore, collection, addDoc } from "firebase/firestore"; // Ajout des importations manquantes

// Configuration de votre application Firebase
const firebaseConfig = {
  apiKey: "AIzaSyDQTUEQrcfGrrmScFOKrDEjcKnnqLuTLa4",
  authDomain: "garagevp-a5ae3.firebaseapp.com",
  projectId: "garagevp-a5ae3",
  storageBucket: "garagevp-a5ae3.firebasestorage.app",
  messagingSenderId: "533150300008",
  appId: "1:533150300008:web:18ef9a3665738d0ebb48dd"
};

// Initialisation de Firebase
const app = initializeApp(firebaseConfig);

// Initialisation de Firestore
const db = getFirestore(app);

// Fonction pour envoyer le message à Firestore
const sendMessage = async (formData) => {
  try {
    // Envoi des données à Firestore dans la collection "messages"
    const docRef = await addDoc(collection(db, "messages"), formData);
    console.log("Message envoyé avec succès ! ID du document :", docRef.id);
    
    // Affichage du message de succès
    const messageStatus = document.getElementById('message-status');
    messageStatus.textContent = "Votre message a été envoyé avec succès !";
    messageStatus.className = 'message-status success';  // Ajout de la classe success
    
    // Réinitialiser le formulaire après envoi
    document.getElementById("contact-form").reset();

  } catch (error) {
    console.error("Erreur lors de l'envoi du message :", error);
    
    // Affichage du message d'erreur
    const messageStatus = document.getElementById('message-status');
    messageStatus.textContent = "Erreur lors de l'envoi du message. Veuillez réessayer.";
    messageStatus.className = 'message-status error';  // Ajout de la classe error
  }
};

// Récupérer le formulaire et ajouter l'événement pour la soumission
const form = document.getElementById("contact-form");
form.addEventListener("submit", (event) => {
  event.preventDefault();

  // Collecte des données du formulaire
  const formData = {
    nom: form.querySelector("[name='nom']").value,
    prenom: form.querySelector("[name='prenom']").value,
    email: form.querySelector("[name='email']").value,
    objet: form.querySelector("[name='objet']").value,
    message: form.querySelector("[name='message']").value,
    createdAt: new Date().toISOString(),  // Ajouter la date du message
  };

  // Envoyer les données du formulaire à Firestore
  sendMessage(formData);
});

