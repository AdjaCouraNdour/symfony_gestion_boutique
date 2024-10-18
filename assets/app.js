// import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';


console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

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
    const phoneRegex = /^[0-9]{9}$/; 
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

    const prenom = document.getElementById('prenom').value;
    const prenomError = document.getElementById('prenomError');
    if (prenom.trim() === '') {
        prenomError.textContent = 'Le prénom est obligatoire.';
        isValid = false;
    } else {
        prenomError.textContent = '';
    }

    const nom = document.getElementById('nom').value;
    const nomError = document.getElementById('nomError');
    if (nom.trim() === '') {
        nomError.textContent = 'Le nom est obligatoire.';
        isValid = false;
    } else {
        nomError.textContent = '';
    }

    const login = document.getElementById('login').value;
    const loginError = document.getElementById('loginError');
    if (login.trim() === '') {
        loginError.textContent = 'Le login est obligatoire.';
        isValid = false;
    } else {
        loginError.textContent = '';
    }

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

        newRow.insertCell(0).textContent = libelle; 
        newRow.insertCell(1).textContent = 1; 
        newRow.insertCell(2).textContent = prix.toFixed(2); 
        newRow.insertCell(3).textContent = prix.toFixed(2);

    selectedArticles.push({ libelle, prix, id });

            // Action pour retirer l'article
        const actionCell = newRow.insertCell(4);
        const removeButton = document.createElement('button');
        removeButton.textContent = 'Retirer';
        removeButton.classList.add('bg-red-500', 'text-white', 'px-2', 'py-1', 'rounded', 'hover:bg-red-700');
        removeButton.onclick = () => {
        selectedArticles = selectedArticles.filter(article => article.id !== id); 
        tableBody.deleteRow(newRow.rowIndex - 1); 
        };
        actionCell.appendChild(removeButton);
        }
