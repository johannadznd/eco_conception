document.addEventListener("DOMContentLoaded", function () {
    // Initialiser le compteur à 0
    let counterValue = 0;
  
    // Mettre à jour le contenu du compteur dans l'élément avec l'ID "counter"
    function updateCounter() {
      document.getElementById("counter").innerText = counterValue;
    }
  
    // Gérer le clic sur le bouton d'incrémentation
    document
      .getElementById("incrementBtn")
      .addEventListener("click", function () {
        // Incrémenter la valeur du compteur
        counterValue++;
        // Mettre à jour l'affichage
        updateCounter();
      });
  
    // Appel initial pour afficher la valeur initiale
    updateCounter();
  });
  