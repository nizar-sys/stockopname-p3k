<?php
session_start();

if (!isset($_SESSION['authCheck'])) {
  header('Location: halaman-login.php');
  exit;
}

if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time'] > 900)) {
  // 900 seconds = 15 minutes
  // Expire the session
  session_unset();
  session_destroy();
  header('Location: halaman-login.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pengecekan Kotak P3K</title>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <style>
    button:disabled {
      opacity: 0.5;
      cursor: not-allowed;
    }

    button:not(:disabled):hover {
      background-color: #774a8e;
      /* Slightly lighter purple for hover */
    }

    body {
      font-family: Arial, sans-serif;
      background-color: #23242a;
      /* Dark background color */
      color: #fff;
      /* White text color */
      margin: 0;
      padding: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background-color: #333;
      /* Darker table background */
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    th,
    td {
      border: 1px solid #555;
      /* Darker border color */
      padding: 8px;
      text-align: center;
      color: #ffffff;
      /* White text color for table */
    }

    th {
      background-color: #572d64;
      /* Purple header to match buttons */
    }

    td {
      background-color: #1c1c1c;
      /* Dark cell backgrounds */
    }

    input[type="number"] {
      width: 100%;
      padding: 4px;
      box-sizing: border-box;
      border: 1px solid #555;
      border-radius: 4px;
      background-color: #333;
      color: #ffffff;
    }

    button {
      background-color: #572d64;
      /* Matching button color */
      color: white;
      border: none;
      padding: 10px 20px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      margin: 10px 2px;
      cursor: pointer;
      border-radius: 5px;
    }

    button:hover {
      background-color: #774a8e;
      /* Slightly lighter purple for hover */
    }
  </style>
</head>

<body>
  <h1>Pengecekan Kotak P3K</h1>
  <h2 id="monthIndicator"></h2>
  <button>
    <a href="./tambah-daftar-isi.php" style="color: white; text-decoration: none">Tambah Daftar Isi</a>
  </button>
  <div class="table-responsive">
    <table class="table table-bordered" id="inventoryTable">
      <thead></thead>
      <tbody></tbody>
    </table>
  </div>

  <button onclick="logout()">Logout</button>
  <button onclick="goBack()">Back</button>
  <button id="editButton" onclick="enableEditing()">Edit Table Content</button>
  <button id="saveButton" onclick="saveData()" disabled>Save Changes</button>

  <script>
    window.onload = function() {
      const urlParams = new URLSearchParams(window.location.search);
      const date = urlParams.get("date");
      const month = urlParams.get("month");
      const year = urlParams.get("year");
      const room = urlParams.get("room");
      document.getElementById(
        "monthIndicator"
      ).innerText = `Pengecekan untuk ${date} ${month} ${year} di ${room}`;
      loadItems(room);
    };

    function loadItems(room) {
      const params = new URLSearchParams(window.location.search);
      const date = params.get("date");
      const month = params.get("month");
      const year = params.get("year");

      fetch(`get_items.php?room=${room}`)
        .then((response) => response.json())
        .then((data) => {
          const table = document.getElementById("inventoryTable");
          table.innerHTML = ""; // Pastikan ini untuk mengosongkan tabel sebelum diisi lagi
          const thead = table.createTHead();
          const headerRow = thead.insertRow();
          [
            "No",
            "Daftar Isi Kotak P3K",
            "Jumlah Standar",
            "Jumlah",
            "Minus",
            "Aksi",
          ].forEach((text) => {
            const th = document.createElement("th");
            th.innerText = text;
            headerRow.appendChild(th);
          });

          const tbody = table.createTBody();
          data.forEach((item, index) => {
            const row = tbody.insertRow();
            row.insertCell().innerText = index + 1;
            row.insertCell().innerText = item.item_name;
            row.insertCell().innerText = item.standard_quantity;
            const actualCell = row.insertCell();
            const actualInput = document.createElement("input");
            actualInput.type = "number";
            actualInput.dataset.itemId = item.item_id;
            actualInput.disabled = true; // Menonaktifkan input
            actualCell.appendChild(actualInput);
            const minusCell = row.insertCell();
            const minusInput = document.createElement("input");
            minusInput.type = "number";
            minusInput.disabled = true; // Menonaktifkan input
            minusInput.attributes["data-item-id"] = item.item_id;
            minusCell.appendChild(minusInput);
            const actionCell = row.insertCell();
            const editButton = document.createElement("button");
            editButton.innerText = "Edit Item";
            editButton.onclick = function() {
              window.location.href = `edit_item.php?item_id=${item.item_id}`;
            };
            actionCell.appendChild(editButton);
            const deleteButton = document.createElement("button");
            deleteButton.innerText = "Delete Item";
            deleteButton.onclick = function() {
              if (confirm("Are you sure you want to delete this item?")) {
                $.ajax({
                  type: "POST",
                  url: "delete_item.php",
                  data: JSON.stringify({
                    item_id: item.item_id
                  }),
                  contentType: "application/json",
                  success: function(response) {
                    if (response.success) {
                      alert("Item deleted successfully");
                      window.location.reload();
                    } else {
                      alert("Error deleting item: " + response.message);
                    }
                  },
                  error: function(xhr, status, error) {
                    console.error("Error deleting item:", error);
                    alert("Error deleting item");
                  },
                });
              }
            };
            actionCell.appendChild(deleteButton);
          });

          loadChecklist(`${date}-${month}-${year}`, room);
        })
        .catch((error) => console.error("Error:", error));
    }

    function saveData() {
      const url = "save_data.php";
      const params = new URLSearchParams(window.location.search);
      const date = params.get("date");
      const month = params.get("month");
      const year = params.get("year");
      const room = params.get("room");

      const items = [
        ...document.querySelectorAll("input[type=number]"),
      ].reduce((acc, input) => {
        const itemId = input.dataset.itemId;
        if (itemId) {
          const actualQuantity = input.value;
          const minusInput =
            input.parentElement.nextElementSibling.firstElementChild;
          const missingQuantity = minusInput ? minusInput.value : 0;

          acc.push({
            item_id: itemId,
            actual_quantity: actualQuantity || 0,
            missing_quantity: missingQuantity || 0,
          });
        }
        return acc;
      }, []);

      const data = {
        date,
        month,
        year,
        room,
        items
      };

      $.ajax({
        type: "POST",
        url: url,
        data: JSON.stringify(data),
        contentType: "application/json",
        success: function(response) {
          console.log("Data saved successfully:", response);
          alert("Data saved successfully");
          window.location.reload();
        },
        error: function(error) {
          console.error("Error saving data:", error);
          alert("Error saving data");
        },
      });
    }

    function goBack() {
      window.history.back();
    }

    function logout() {
      if (confirm("Are you sure you want to logout?")) {
        window.location.href = "logout.php";
      }
    }

    function enableEditing() {
      const inputs = document.querySelectorAll("input[type=number]");
      const isEditing =
        document.getElementById("editButton").textContent === "Cancel";

      inputs.forEach((input) => {
        input.disabled = isEditing;
      });

      document.getElementById("editButton").textContent = isEditing ?
        "Edit Table Content" :
        "Cancel";
      document.getElementById("saveButton").disabled = isEditing;

      if (isEditing) {
        // Reset form to initial values if cancel is pressed
        loadItems(new URLSearchParams(window.location.search).get("room"));
      }

      console.log(isEditing ? "Editing cancelled" : "Editing enabled");
    }

    function loadChecklist(period, room) {
      $.ajax({
        type: "GET",
        url: `get_checklist.php?period=${period}&room=${room}`,
        dataType: "json",
        success: function(checklist) {
          $("input[type=number]").each((index, input) => {
            const itemId = $(input).data("item-id");
            const item = checklist.find((item) => item.item_id === itemId);
            if (item) {
              $(input).val(item.actual_quantity);
              $(input)
                .parent()
                .next()
                .find("input")
                .val(item.missing_quantity);
            }
          });
        },
        error: function(error) {
          console.error("Error loading checklist:", error);
        },
      });
    }
  </script>
</body>

</html>