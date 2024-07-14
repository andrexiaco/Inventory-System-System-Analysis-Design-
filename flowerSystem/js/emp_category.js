function openEditModal(category_id, category_name) {
    var editModal = document.getElementById('editModal');
    if (editModal) {
        editModal.style.display = 'flex';
        // Set the values of the fields based on the selected product
        document.getElementById('edit_category_id').value = category_id;
        document.getElementById('edit_category_name').value = category_name;
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
    document.getElementById('catmsg').style.display = 'none';
}, 5000);