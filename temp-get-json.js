const createBtn = document.getElementById('createBtn')
const create_container = document.getElementById('create-container');
const product_page = document.getElementById('product-page');
const openCreateBtn = document.getElementById('openCreateBtn');
const closeCreateBtn = document.getElementById('closeCreateBtn');
const createWindow = document.getElementById('createWindow');
const overlay = document.getElementById('overlay');

createBtn.onclick = async function () {
    let url = 'http://demo.amall.ps/admin/catalog/product/create';
    fetch(url).then(response => {
        if (response.ok) {
            return response.text();
        }
        throw new Error('Network response was not ok.');
    }).then(html => {
        overlay.style.display = 'block';
        composeWindow.style.display = 'block';
        create_container.innerHTML = html;
    })
}
// Get references to buttons, the floating window, and the overlay

// Open the floating window and show the overlay when "Compose" button is clicked
openCreateBtn.addEventListener('click', () => {
    overlay.style.display = 'block';
    createWindow.style.display = 'block';
});

// Close the floating window and hide the overlay when "Close" button is clicked
closeCreateBtn.addEventListener('click', () => {
    overlay.style.display = 'none';
    createWindow.style.display = 'none';
});

