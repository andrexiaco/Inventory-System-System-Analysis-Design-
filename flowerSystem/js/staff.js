function openAddModal() {
    var addModal = document.getElementById('addModal');
    if (addModal) {
        addModal.style.display = 'flex';
    }
}

function openEditModal(staff_id, firstname, lastname, contact_no, username, password) {
    var editModal = document.getElementById('editModal');
    if (editModal) {
        editModal.style.display = 'flex';

        document.getElementById('edit_staff_id').value = staff_id;
        document.getElementById('edit_firstname').value = firstname;
        document.getElementById('edit_lastname').value = lastname;
        document.getElementById('edit_contact_no').value = contact_no;
        document.getElementById('edit_username').value = username;
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
    document.getElementById('lname').style.display = 'none';
    document.getElementById('contactno').style.display = 'none';
    document.getElementById('uname').style.display = 'none';
    document.getElementById('pass').style.display = 'none';
}, 5000);

// edit error timeout
setTimeout(function () {
    document.getElementById('efname').style.display = 'none';
    document.getElementById('elname').style.display = 'none';
    document.getElementById('econtact').style.display = 'none';
    document.getElementById('euname').style.display = 'none';
}, 5000);
setTimeout(function () {
    document.getElementById('epass').style.display = 'none';
    document.getElementById('conpass').style.display = 'none';
}, 5000);