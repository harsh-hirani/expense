<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
<?php
?>

function changeLocation() {

    let selectedCategories = [];
    document.querySelectorAll('input[name="category[]"]:checked').forEach(checkbox => {
        selectedCategories.push(encodeURIComponent(checkbox.value));
    });

    if (selectedCategories.length > 0) {
        window.location.href = "index.php?category=" + selectedCategories.join(",");
    } else {
        alert("Please select at least one category.");
    }
}
</script>