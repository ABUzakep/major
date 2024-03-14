<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Details</title>
    <style>
        /* Your CSS styles here */
    </style>
</head>
<body>

<div id="carDetailsContainer"></div>

<script src="https://www.gstatic.com/firebasejs/9.6.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.6.0/firebase-database.js"></script>
<script>
// Firebase configuration
const firebaseConfig = {
  apiKey: "AIzaSyD8pAbnrMYuTHfQj648eUhpsJ5uqXf_8dM",
  authDomain: "major-7aea3.firebaseapp.com",
  databaseURL: "https://major-7aea3-default-rtdb.firebaseio.com",
  projectId: "major-7aea3",
  storageBucket: "major-7aea3.appspot.com",
  messagingSenderId: "252796188198",
  appId: "1:252796188198:web:798e4024c2a70498f258e7",
  measurementId: "G-8VCBSP99SD"
};

// Initialize Firebase
firebase.initializeApp(firebaseConfig);

// Get a reference to the database service
const database = firebase.database();

// Reference to the "cars" node in Firebase Realtime Database
const carsRef = database.ref("cars");

// Container to display car details
const container = document.getElementById('carDetailsContainer');

// Fetch car details from Firebase and display them
carsRef.once('value', (snapshot) => {
    snapshot.forEach((childSnapshot) => {
        const car = childSnapshot.val();

        // Create car details element
        const carDetails = document.createElement('div');
        carDetails.classList.add('car-details');

        // Construct car details HTML
        carDetails.innerHTML = `
            <span class='car-label'>Car Name:</span> ${car.car_name}<br>
            <span class='car-label'>Model:</span> ${car.model}<br>
            <span class='car-label'>Year:</span> ${car.year}<br>
            <span class='car-label'>Mileage:</span> ${car.mileage}<br>
            <span class='car-label'>Condition:</span> ${car.conditions}<br>
            <span class='car-label'>Exterior Color:</span> ${car.exterior_color}<br>
            <span class='car-label'>Interior Color:</span> ${car.interior_color}<br>
            <span class='car-label'>Engine:</span> ${car.engine}<br>
            <span class='car-label'>Transmission:</span> ${car.transmission}<br>
            <span class='car-label'>Fuel Type:</span> ${car.fuel_type}<br>
        `;

        container.appendChild(carDetails);

        // Create image container
        const imageContainer = document.createElement('div');
        imageContainer.classList.add('container');

        // Loop through image URLs and create image elements
        car.images.forEach((imageUrl) => {
            const imageElement = document.createElement('img');
            imageElement.src = imageUrl;
            imageElement.alt = 'Car Image';
            imageContainer.appendChild(imageElement);
        });

        container.appendChild(imageContainer);

        // Add separator
        const separator = document.createElement('hr');
        container.appendChild(separator);
    });
});
</script>

</body>
</html>
