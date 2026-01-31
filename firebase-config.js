// firebase-config.js
import { initializeApp } from "https://www.gstatic.com/firebasejs/12.8.0/firebase-app.js";
// Added Authentication Imports:
import { getAuth, signInWithEmailAndPassword, signOut, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/12.8.0/firebase-auth.js";
import { getFirestore, collection, addDoc, onSnapshot, query, where, updateDoc, doc, getDocs, getDoc, orderBy, limit, deleteDoc } from "https://www.gstatic.com/firebasejs/12.8.0/firebase-firestore.js";

const firebaseConfig = {
    apiKey: "AIzaSyC9mnlOhuHjdzaIqNW27xZAidw4PgbK_oo",
    authDomain: "eventcheckin-28b06.firebaseapp.com",
    projectId: "eventcheckin-28b06",
    storageBucket: "eventcheckin-28b06.firebasestorage.app",
    messagingSenderId: "1002821588370",
    appId: "1:1002821588370:web:456620a71216b927f0dd4b"
};

const app = initializeApp(firebaseConfig);
const db = getFirestore(app);
const auth = getAuth(app); // Initialize Auth

// Export everything
export { 
    app, db, auth, 
    collection, addDoc, onSnapshot, query, where, updateDoc, doc, getDocs, getDoc, orderBy, limit, deleteDoc,
    signInWithEmailAndPassword, signOut, onAuthStateChanged 
};