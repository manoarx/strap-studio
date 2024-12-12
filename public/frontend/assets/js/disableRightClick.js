document.addEventListener('contextmenu', function(e) {
    // Check if the right-click event target is an image
    if (e.target.tagName.toLowerCase() === 'img') {
        e.preventDefault(); // Prevent the default right-click behavior
    }
});
