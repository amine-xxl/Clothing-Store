// cart.js - Version finale avec système d'événements

const cartListeners = [];

// Notifier tous les écouteurs de changement
function notifyCartChanged() {
    const cart = getCart();
    cartListeners.forEach(callback => callback(cart));
}

// S'abonner aux changements du panier
function onCartChange(callback) {
    cartListeners.push(callback);
    // Retourne une fonction pour se désabonner
    return () => {
        const index = cartListeners.indexOf(callback);
        if (index !== -1) cartListeners.splice(index, 1);
    };
}

// Obtenir le panier actuel
function getCart() {
    return JSON.parse(localStorage.getItem('cart')) || [];
}

// Sauvegarder le panier
function saveCart(cart) {
    localStorage.setItem('cart', JSON.stringify(cart));
    notifyCartChanged();
}

// Mettre à jour le compteur dans la navbar
function updateCartCounter() {
    const cart = getCart();
    const totalItems = cart.reduce((total, item) => total + (item.quantity || 1), 0);
    
    document.querySelectorAll('#bagCounter').forEach(counter => {
        if (counter) {
            counter.textContent = totalItems;
            counter.style.display = totalItems > 0 ? 'flex' : 'none';
        }
    });
}

function getWishlist() {
    return JSON.parse(localStorage.getItem('wishlist')) || [];
}

function updateWishlistCounter() {
    const wishlist = getWishlist();
    const totalItems = wishlist.length;
    document.querySelectorAll('#wishlistCounter').forEach(counter => {
        if (counter) {
            counter.textContent = totalItems;
            counter.style.display = totalItems > 0 ? 'flex' : 'none';
            counter.style.background = '#112180'; // Always blue
        }
    });
}

// Ajouter un produit au panier
// Dans cart.js, remplacez la fonction addToCart par :
function addToCart(product) {
    const cart = getCart();
    // Cherche un produit identique (id, taille, couleur)
    const existingIndex = cart.findIndex(item =>
        item.id === product.id &&
        item.selectedSize === product.selectedSize &&
        item.selectedColor === product.selectedColor
    );
    if (existingIndex !== -1) {
        // Si trouvé, incrémente la quantité
        cart[existingIndex].quantity = (cart[existingIndex].quantity || 1) + (product.quantity || 1);
    } else {
        // Sinon, ajoute comme nouvel élément
        cart.push({
            id: product.id,
            name: product.name,
            price: product.price,
            image: product.image || product.mainImage,
            selectedSize: product.selectedSize,
            selectedColor: product.selectedColor,
            category: product.category || "Clothing",
            quantity: product.quantity || 1,
            addedAt: new Date().toISOString()
        });
    }
    saveCart(cart);
    return cart;
}

// Supprimer un article du panier
function removeFromCart(index) {
    const cart = getCart();
    if (index >= 0 && index < cart.length) {
        cart.splice(index, 1);
        saveCart(cart);
    }
    return cart;
}

// Mettre à jour la quantité d'un article
function updateCartItemQuantity(index, newQuantity) {
    const cart = getCart();
    if (index >= 0 && index < cart.length) {
        cart[index].quantity = Math.max(1, newQuantity);
        saveCart(cart);
    }
    return cart;
}

// Calculer le total du panier
function calculateCartTotal() {
    const cart = getCart();
    return cart.reduce((total, item) => total + (item.price * (item.quantity || 1)), 0);
}

// Vider le panier
function clearCart() {
    localStorage.removeItem('cart');
    notifyCartChanged();
}

// Vider la liste de souhaits
function clearWishlist() {
    localStorage.removeItem('wishlist');
    updateWishlistCounter();
}

// Déplacer un article de la liste de souhaits vers le panier
function moveWishlistItemToCart(index) {
    const wishlist = getWishlist();
    if (index >= 0 && index < wishlist.length) {
        addToCart(wishlist[index]);
        wishlist.splice(index, 1);
        localStorage.setItem('wishlist', JSON.stringify(wishlist));
        updateWishlistCounter();
        notifyCartChanged();
    }
}

// Vérifier si un article existe dans le panier
function itemExistsInCart(product) {
    const cart = getCart();
    return cart.some(item =>
        item.id === product.id &&
        item.selectedSize === product.selectedSize &&
        item.selectedColor === product.selectedColor
    );
}

// Vérifier si un article existe dans la liste de souhaits
function itemExistsInWishlist(product) {
    const wishlist = getWishlist();
    return wishlist.some(item =>
        item.id === product.id &&
        item.selectedSize === product.selectedSize &&
        item.selectedColor === product.selectedColor
    );
}

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
    updateCartCounter();
    updateWishlistCounter();
});