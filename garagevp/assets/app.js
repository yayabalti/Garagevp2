
import { initializeApp } from "firebase/app";
import { getFirestore, collection, addDoc } from "firebase/firestore"; 

// Ta configuration Firebase
const firebaseConfig = {
    apiKey: "AIzaSyCqordhBwAWQuDzdq_9GIRy9c5y4xkJ3xw",
    authDomain: "garage-vp-eaa79.firebaseapp.com",
    projectId: "garage-vp-eaa79",
    storageBucket: "garage-vp-eaa79.appspot.com",
    messagingSenderId: "1017437277555",
    appId: "1:1017437277555:web:533cde0fc25e969b270906"
};

// Initialiser Firebase
const app = initializeApp(firebaseConfig);
const db = getFirestore(app);

console.log("Firebase initialized successfully");

// Fonction pour ajouter un avis
async function addReview(review) {
    try {
        const docRef = await addDoc(collection(db, "reviews"), review);
        console.log("Document written with ID: ", docRef.id);
    } catch (e) {
        console.error("Error adding document: ", e);
    }
}

// Exemple d'utilisation
addReview({ name: "John Doe", feedback: "Great service!", validated: false });
