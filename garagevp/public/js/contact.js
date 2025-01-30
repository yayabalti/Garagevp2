// Écouteur d'événements principal, qui s'exécute lorsque le DOM est complètement chargé
document.addEventListener('DOMContentLoaded', () => {
  console.log("Script de contact chargé");

  // Récupération de l'élément du formulaire avec l'ID "contact-form"
  const form = document.getElementById("contact-form");

  // Vérifie si le formulaire existe dans la page
  if (!form) {
      console.error("Formulaire non trouvé");
      return; // Si le formulaire n'existe pas, arrête l'exécution du script
  }

  console.log("Formulaire trouvé");

  // Ajout d'un écouteur d'événement pour l'envoi du formulaire
  form.addEventListener("submit", async (e) => {
      e.preventDefault(); // Empêche le rechargement de la page lors de la soumission
      console.log("Formulaire soumis");

      // Désactivation du bouton de soumission pour éviter les envois multiples
      const submitBtn = form.querySelector("button[type='submit']");
      submitBtn.disabled = true;
      submitBtn.textContent = "Envoi en cours...";

      try {
          // Récupération et nettoyage des données du formulaire
          const formData = {
              nom: form.querySelector("[name='nom']").value.trim(),       
              prenom: form.querySelector("[name='prenom']").value.trim(), 
              email: form.querySelector("[name='email']").value.trim(),   
              objet: form.querySelector("[name='objet']").value.trim(),   
              message: form.querySelector("[name='message']").value.trim(),
              createdAt: firebase.firestore.Timestamp.now() // Horodatage de l'envoi
          };

          console.log("Tentative d'envoi des données:", formData);

          // Envoi des données à Firestore
          const docRef = await db.collection("messages").add(formData);
          console.log("Message envoyé avec succès - ID:", docRef.id);

          // Affiche un message de confirmation et réinitialise le formulaire
          alert("Message envoyé avec succès !");
          form.reset();

      } catch (error) {
          // Gestion des erreurs en cas d'échec de l'envoi
          console.error("Erreur détaillée:", error);
          alert("Erreur lors de l'envoi: " + error.message);
      } finally {
          // Réactivation du bouton de soumission et réinitialisation du texte
          submitBtn.disabled = false;
          submitBtn.textContent = "Envoyer";
      }
  });
});
