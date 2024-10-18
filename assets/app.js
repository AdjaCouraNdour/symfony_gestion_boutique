// import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';


console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
// console.log(document.getElementById('surname'));
// console.log(document.getElementById('telephone'));
// document.addEventListener('DOMContentLoaded', () => {
//     const form = document.getElementById('clientForm');

//     form.addEventListener('submit', function(event) {
//         event.preventDefault(); // Empêche l'envoi par défaut

//         // Réinitialiser les messages d'erreur
//         document.getElementById('surnameError').innerText = '';
//         document.getElementById('telephoneError').innerText = '';

//         let isValid = true;

//         // Validation du champ "surname"
//         const surname = document.getElementById('surname').value.trim();
//         if (!surname) {
//             document.getElementById('surnameError').innerText = 'Le champ "surname" ne doit pas être vide.';
//             isValid = false;
//         }

//         // Validation du champ "telephone"
//         const telephone = document.getElementById('telephone').value.trim();
//         const phonePattern = /^(77|78|76)[0-9]{7}$/; // Regex pour le format de numéro de téléphone
//         if (!telephone) {
//             document.getElementById('telephoneError').innerText = 'Le champ "telephone" ne doit pas être vide.';
//             isValid = false;
//         } else if (!phonePattern.test(telephone)) {
//             document.getElementById('telephoneError').innerText = 'Entrer un numéro valide (77-XXX-XX-XX, 78-XXX-XX-XX, 76-XXX-XX-XX).';
//             isValid = false;
//         }

//         // Si le formulaire est valide, on le soumet
//         if (isValid) {
//             form.submit(); // Envoi du formulaire
//         }
//     });
// });



function validateClientForm() {

    let isValid = true;
    const surname = document.getElementById('surname').value;
    const surnameError = document.getElementById('surnameError');
    if (surname.trim() === '') {
        surnameError.textContent = 'Le nom est obligatoire.';
        isValid = false;
    } else {
        surnameError.textContent = '';
    }


    const telephone = document.getElementById('telephone').value;
    const telephoneError = document.getElementById('telephoneError');
    const phoneRegex = /^[0-9]{9}$/; // Validation de 10 chiffres
    if (!phoneRegex.test(telephone)) {
        telephoneError.textContent = 'Le numéro de téléphone doit être composé de 9 chiffres.';
        isValid = false;
    } else {
        telephoneError.textContent = '';
    }

    return isValid; 
}


function validateUserForm() {
    let isValid = true;

    // Validation du prénom
    const prenom = document.getElementById('prenom').value;
    const prenomError = document.getElementById('prenomError');
    if (prenom.trim() === '') {
        prenomError.textContent = 'Le prénom est obligatoire.';
        isValid = false;
    } else {
        prenomError.textContent = '';
    }

    // Validation du nom
    const nom = document.getElementById('nom').value;
    const nomError = document.getElementById('nomError');
    if (nom.trim() === '') {
        nomError.textContent = 'Le nom est obligatoire.';
        isValid = false;
    } else {
        nomError.textContent = '';
    }

    // Validation du login
    const login = document.getElementById('login').value;
    const loginError = document.getElementById('loginError');
    if (login.trim() === '') {
        loginError.textContent = 'Le login est obligatoire.';
        isValid = false;
    } else {
        loginError.textContent = '';
    }

    // Validation du mot de passe
    const password = document.getElementById('mdp').value;
    const passwordError = document.getElementById('passwordError');
    if (password.length < 6) {
        passwordError.textContent = 'Le mot de passe doit contenir au moins 6 caractères.';
        isValid = false;
    } else {
        passwordError.textContent = '';
    }

    return isValid;
}

document.getElementById('addUser').addEventListener('change', function() {

    const userFields = document.getElementById('userFields');
    userFields.style.display = this.checked ? 'block' : 'none';
});




//--------------------dette


let selectedArticles = [];

function addToSelection(libelle, prix, id) {
    const tableBody = document.getElementById('selectedArticlesTable').getElementsByTagName('tbody')[0];

        if (selectedArticles.some(article => article.id === id)) {
            alert('Cet article est déjà sélectionné.');
            return;
        }

    const newRow = tableBody.insertRow();

            // Remplir les colonnes du tableau
        newRow.insertCell(0).textContent = libelle; // Libelle
        newRow.insertCell(1).textContent = 1; // Quantité initiale
        newRow.insertCell(2).textContent = prix.toFixed(2); // Prix
        newRow.insertCell(3).textContent = prix.toFixed(2); // Total initial (prix * quantité)

            // Ajouter l'article à la sélection
    selectedArticles.push({ libelle, prix, id });

            // Action pour retirer l'article
        const actionCell = newRow.insertCell(4);
        const removeButton = document.createElement('button');
        removeButton.textContent = 'Retirer';
        removeButton.classList.add('bg-red-500', 'text-white', 'px-2', 'py-1', 'rounded', 'hover:bg-red-700');
        removeButton.onclick = () => {
        selectedArticles = selectedArticles.filter(article => article.id !== id); // Retirer de la sélection
        tableBody.deleteRow(newRow.rowIndex - 1); // Supprimer la ligne du tableau
        };
        actionCell.appendChild(removeButton);
        }

        // function saveSelection() {
        //     document.getElementById('selectedArticlesInput').value = JSON.stringify(selectedArticles);
        // }
