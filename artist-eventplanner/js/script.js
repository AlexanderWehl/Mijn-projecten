function confirmDelete(id) {
    if (confirm("Weet je zeker dat je dit event wilt verwijderen?")) {
        window.location.href = "delete_event.php?id=" + id;
    }
}