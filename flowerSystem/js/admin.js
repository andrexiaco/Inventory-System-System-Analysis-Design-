
function openAddModal() {
    var addModal = document.getElementById('addModal');
    if (addModal) {
        addModal.style.display = 'flex';
    }
}

function openEditModal(admin_id, fullname, username, role_id, password) {
    var editModal = document.getElementById('editModal');
    if (editModal) {
        editModal.style.display = 'flex';

        document.getElementById('edit_admin_id').value = admin_id;
        document.getElementById('edit_fullname').value = fullname;
        document.getElementById('edit_username').value = username;
        document.getElementById('edit_role_id').value = role_id;
        document.getElementById('edit_password').value = password;
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


// add error timeout
setTimeout(function () {
    document.getElementById('fname').style.display = 'none';
    document.getElementById('uname').style.display = 'none';
    document.getElementById('pass').style.display = 'none';
    document.getElementById('efname').style.display = 'none';
    document.getElementById('euname').style.display = 'none';
    document.getElementById('epass').style.display = 'none';
}, 5000);


