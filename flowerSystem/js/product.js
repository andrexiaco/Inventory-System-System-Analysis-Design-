function openAddModal() {
    var addModal = document.getElementById('addModal');
    if (addModal) {
        addModal.style.display = 'flex';
    }
}

function openEditModal(product_id, product_name, quantity, category_id, price) {
    var editModal = document.getElementById('editModal');
    if (editModal) {
        editModal.style.display = 'flex';
        // Set the values of the fields based on the selected product
        document.getElementById('edit_product_id').value = product_id;
        document.getElementById('edit_product_name').value = product_name;
        document.getElementById('edit_quantity').value = quantity;
        document.getElementById('edit_category_id').value = category_id;
        document.getElementById('edit_price').value = price;
    }
}

// Function to close the modal
function closeModal(modalId) {
    var modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
    }
}

// Close modal when clicking outside
window.onclick = function (event) {

    var addModal = document.getElementById('addModal');
    var editModal = document.getElementById('editModal');

    if (event.target == editModal) {
        closeModal('editModal');
    }

    if (event.target == addModal) {
        closeModal('addModal');
    }
}


setTimeout(function () {
    document.getElementById('errormsg1').style.display = 'none';
    document.getElementById('errormsg2').style.display = 'none';
    document.getElementById('errormsg3').style.display = 'none';
    document.getElementById('errormsg4').style.display = 'none';
    document.getElementById('error1').style.display = 'none';
    document.getElementById('error2').style.display = 'none';
    document.getElementById('error3').style.display = 'none';
}, 5000);
setTimeout(function () {
    document.getElementById('error').style.display = 'none';
}, 5000);



